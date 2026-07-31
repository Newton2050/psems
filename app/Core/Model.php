<?php
namespace App\Core;
use PDO;
class Model
{
    protected static ?PDO $db = null;
    protected string $table = '';
    protected string $primaryKey = 'id';
    
    public function __construct()
    {
        if (self::$db === null) {
            self::$db = Database::getInstance();
        }
    }
    
    protected function getDB(): PDO
    {
        if (self::$db === null) {
            self::$db = Database::getInstance();
        }
        return self::$db;
    }
    
    public function all(): array
    {
        $stmt = self::$db->query("SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC");
        return $stmt->fetchAll();
    }
    
    public function find($id): ?array
    {
        $stmt = self::$db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    
    public function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute(array_values($data));
    }
    
    public function update($id, array $data): bool
    {
        $fields = '';
        foreach (array_keys($data) as $column) {
            $fields .= "{$column} = ?, ";
        }
        $fields = rtrim($fields, ', ');
        $values = array_values($data);
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET {$fields} WHERE {$this->primaryKey} = ?";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute($values);
    }
    
    public function delete($id): bool
    {
        $stmt = self::$db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }
    
    public function countAll(): int
    {
        $stmt = self::$db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }
}
