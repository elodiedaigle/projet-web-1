<?php
namespace App\Providers;

class Validator {

    private $errors = [];
    private $key;
    private $value;
    private $name;

    public function field($key, $value, $name = null) {
        $this->key = $key;
        $this->value = $value;
        $this->name = $name ? ucfirst($name) : ucfirst($key);
        return $this;
    }

    // Régles

    public function required() {
        if (empty($this->value)) {
            $this->errors[$this->key] = "{$this->name} est requis.";
        }
        return $this;
    }

    public function email() {
        if (!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->key] = "Format de courriel invalide.";
        }
        return $this;
    }

    public function same($otherKey, $otherValue) {
        if ($this->value !== $otherValue) {
            $this->errors[$this->key] = "{$this->name} ne correspond pas.";
        }
        return $this;
    }

    public function unique($modelName) {
        $modelClass = "App\\Models\\$modelName";
        $model = new $modelClass;

        $exists = $model->unique($this->key, $this->value);

        if ($exists) {
            $this->errors[$this->key] = "{$this->name} existe déjà.";
        }

        return $this;
    }

    // Règles fin

    public function isSuccess() {
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}
