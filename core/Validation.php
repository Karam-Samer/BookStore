<?php

require_once __DIR__ . '/Database.php';

class Validation
{
    private array $errors = [];

    public function __construct(private array $data, private array $rules) {}

    public function validate(): array
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;
            foreach ($rules as $rule) {
                if (is_string($rule)) {
                    if ($rule === "required") {
                        $this->validateRequired($field, $value);
                    } else if ($rule === "email") {
                        $this->validateEmail($field, $value);
                    } else if ($rule === "egPhone") {
                        $this->validateEgPhone($field, $value);
                    } else if ($rule === "numeric") {
                        if (!is_numeric($value)) {
                            $this->addError($field, "{$field} must be a numeric value.");
                        }
                    }
                } else if (is_array($rule)) {
                    if ($rule[0] === "min") {
                        $this->validateMin($field, $value, $rule[1]);
                    } else if ($rule[0] === "exists") {
                        $this->validateExists($field, $value, $rule[1], $rule[2]);
                    } else if ($rule[0] === "unique") {
                        $this->validateUnique($field, $value, $rule[1], $rule[2] ?? null);
                    }
                }
            }
        }
        return $this->errors;
    }

    private function validateRequired(string $field, mixed $value): void
    {
        if ($value === null || trim((string)$value) === '') {
            $this->addError($field, "{$field} is required.");
        }
    }

    private function validateEmail(string $field, mixed $value): void
    {
        if (empty($value)) {
            return;
        }

        $regex = "/^[a-zA-Z_][a-zA-Z0-9_\.\-]+@(gmail|yahoo)\.(com|org)$/";
        if (!preg_match($regex, $value)) {
            $this->addError($field, "{$field} must be a valid email address.");
        }
    }

    private function validateEgPhone(string $field, mixed $value): void
    {
        if (empty($value)) {
            return;
        }

        $regex = "/^(02)?01[0125][0-9]{8}$/";
        if (!preg_match($regex, $value)) {
            $this->addError($field, "{$field} must be a valid Egyptian phone number.");
        }
    }

    private function validateUnique(string $field, mixed $value, string $table, ?int $exceptId = null): void
    {
        if (empty($value)) {
            return;
        }

        $DB = Database::getConnection();
        $subQuery = "";
        $params = ['value' => $value];
        if ($exceptId !== null) {
            $subQuery = " AND id != :exceptId";
            $params['exceptId'] = $exceptId;
        }
        $stmt = $DB->prepare("SELECT * FROM {$table} WHERE {$field} = :value {$subQuery}");
        $stmt->execute($params);
        $result = $stmt->fetch();

        if (!empty($result)) {
            $this->addError($field, "{$field} must be unique.");
        }
    }

    private function validateExists(string $field, mixed $value, string $table, string $column): void
    {
        if (empty($value)) {
            return;
        }

        $DB = Database::getConnection();
        $stmt = $DB->prepare("SELECT * FROM {$table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        $result = $stmt->fetch();

        if (empty($result)) {
            $this->addError($field, "{$field} does not exist.");
        }
    }

    private function validateMin(string $field, mixed $value, int $min): void
    {
        if (empty($value)) {
            return;
        }

        if (strlen((string)$value) < $min) {
            $this->addError($field, "{$field} must be at least {$min} characters long.");
        }
    }

    private function addError(string $field, string $msg): void
    {
        $this->errors[$field][] = $msg;
    }
}
