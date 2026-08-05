<?php
namespace App\Core;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;
    private static array $config = [];
    
    public static function init(array $config): void
    {
        self::$config = $config;
    }
    
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::connect();
        }
        return self::$instance;
    }
    
    private static function connect(): void
    {
        $config = self::$config;
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'] ?? 'localhost',
            (int)($config['port'] ?? 3306),
            $config['database'] ?? ($config['dbname'] ?? ''),
            $config['charset'] ?? 'utf8mb4'
        );
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5
        ];
        try {
            self::$instance = new PDO(
                $dsn,
                $config['username'] ?? ($config['user'] ?? 'root'),
                $config['password'] ?? ($config['pass'] ?? ''),
                $options
            );
        } catch (PDOException $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }
    
    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public static function fetchOne(string $sql, array $params = []): ?array
    {
        return self::query($sql, $params)->fetch() ?: null;
    }
    
    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }
    
    public static function insert(string $table, array $data): int
    {
        $columns = array_keys($data);
        $quotedColumns = array_map(function($c){ return "`" . str_replace("`", "``", $c) . "`"; }, $columns);
        $placeholders = array_fill(0, count($data), '?');
        $sql = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", str_replace("`", "``", $table), implode(', ', $quotedColumns), implode(', ', $placeholders));
        self::query($sql, array_values($data));
        return (int)self::getInstance()->lastInsertId();
    }
    
    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $sets = [];
        foreach (array_keys($data) as $column) {
            $sets[] = "`" . str_replace("`", "``", $column) . "` = ?";
        }
        $sql = sprintf("UPDATE `%s` SET %s WHERE %s", str_replace("`", "``", $table), implode(', ', $sets), $where);
        $params = array_merge(array_values($data), $whereParams);
        return self::query($sql, $params)->rowCount();
    }
    
    public static function delete(string $table, string $where, array $params = []): int
    {
        $sql = sprintf("DELETE FROM `%s` WHERE %s", str_replace("`", "``", $table), $where);
        return self::query($sql, $params)->rowCount();
    }
    
    public static function beginTransaction(): bool
    {
        return self::getInstance()->beginTransaction();
    }
    
    public static function commit(): bool
    {
        return self::getInstance()->commit();
    }
    
    public static function rollback(): bool
    {
        return self::getInstance()->rollBack();
    }
    
    public static function lastInsertId(): int
    {
        return (int)self::getInstance()->lastInsertId();
    }
}
