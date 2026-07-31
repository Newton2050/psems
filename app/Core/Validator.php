<?php
namespace App\Core;
class Validator
{
    protected array $data;
    protected array $errors = [];
    protected array $validated = [];
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function validate(array $rules): bool
    {
        foreach ($rules as $field => $ruleString) {
            $value = $this->data[$field] ?? null;
            $rulesList = explode('|', $ruleString);
            if (!in_array('required', $rulesList) && ($value === null || $value === '')) continue;
            foreach ($rulesList as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }
        $this->validated = array_intersect_key($this->data, $rules);
        return empty($this->errors);
    }
    
    protected function applyRule(string $field, $value, string $rule): void
    {
        $ruleParts = explode(':', $rule, 2);
        $ruleName = $ruleParts[0];
        $parameters = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];
        if ($ruleName === 'required' && ($value === null || $value === '')) {
            $this->addError($field, 'required');
            return;
        }
        if ($value === null || $value === '') return;
        $method = 'validate' . ucfirst($ruleName);
        if (method_exists($this, $method)) {
            $this->$method($field, $value, $parameters);
        }
    }
    
    protected function validateRequired(string $field, $value, array $params): void
    {
        if ($value === null || $value === '' || $value === []) {
            $this->addError($field, 'required');
        }
    }
    
    protected function validateEmail(string $field, $value, array $params): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'email');
        }
    }
    
    protected function validateMin(string $field, $value, array $params): void
    {
        $min = (int)($params[0] ?? 0);
        if (strlen((string)$value) < $min) {
            $this->addError($field, 'min', ['min' => $min]);
        }
    }
    
    protected function validateMax(string $field, $value, array $params): void
    {
        $max = (int)($params[0] ?? 0);
        if (strlen((string)$value) > $max) {
            $this->addError($field, 'max', ['max' => $max]);
        }
    }
    
    protected function validateNumeric(string $field, $value, array $params): void
    {
        if (!is_numeric($value)) {
            $this->addError($field, 'numeric');
        }
    }
    
    protected function validateIn(string $field, $value, array $params): void
    {
        if (!in_array($value, $params, true)) {
            $this->addError($field, 'in', ['values' => implode(', ', $params)]);
        }
    }
    
    protected function validateUnique(string $field, $value, array $params): void
    {
        $table = $params[0] ?? null;
        $column = $params[1] ?? $field;
        $except = $params[2] ?? null;
        if (!$table) return;
        $db = Database::getInstance();
        $sql = "SELECT COUNT(*) FROM {$table} WHERE {$column} = ?";
        $params = [$value];
        if ($except !== null) {
            $idColumn = $params[3] ?? 'id';
            $sql .= " AND {$idColumn} != ?";
            $params[] = $except;
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            $this->addError($field, 'unique', ['field' => $field]);
        }
    }
    
    protected function validateExists(string $field, $value, array $params): void
    {
        $table = $params[0] ?? null;
        $column = $params[1] ?? $field;
        if (!$table) return;
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            $this->addError($field, 'exists');
        }
    }
    
    protected function validateConfirmed(string $field, $value, array $params): void
    {
        $confirmation = $this->data[$field . '_confirmation'] ?? null;
        if ($value !== $confirmation) {
            $this->addError($field, 'confirmed');
        }
    }
    
    protected function addError(string $field, string $rule, array $params = []): void
    {
        $messages = [
            'required' => '{field} is required.',
            'email' => '{field} must be a valid email address.',
            'min' => '{field} must be at least {min} characters.',
            'max' => '{field} must not exceed {max} characters.',
            'numeric' => '{field} must be a number.',
            'in' => '{field} must be one of: {values}.',
            'unique' => '{field} already exists in the system.',
            'exists' => 'The selected {field} is invalid.',
            'confirmed' => 'The {field} confirmation does not match.',
        ];
        $message = $messages[$rule] ?? 'Invalid {field}.';
        $replace = array_merge(['field' => $field], $params);
        foreach ($replace as $key => $value) {
            $message = str_replace('{' . $key . '}', $value, $message);
        }
        $this->errors[$field][] = $message;
    }
    
    public function errors(): array
    {
        return $this->errors;
    }
    
    public function passes(): bool
    {
        return empty($this->errors);
    }
    
    public function validated(): array
    {
        return $this->validated;
    }
}
