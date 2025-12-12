<?php
namespace App\Providers;

class Validator {

    private $errors = [];
    private $key;
    private $value;
    private $name;

    /* 
    ============================================
    FIELD : Définir le champ actuellement validé
    ============================================
    */

    public function field($key, $value, $name = null) {
        $this->key = $key;
        $this->value = $value;
        $this->name = $name ? ucfirst($name) : ucfirst($key);
        return $this;
    }

    /*
    ====================
    RÈGLE : Champ requis
    ====================
    */

    public function required() {
        if (empty($this->value)) {
            $this->errors[$this->key] = "{$this->name} est requis.";
        }
        return $this;
    }

    /*
    ==========================
    RÈGLE : Format du courriel
    ==========================
    */

    public function email() {
        if (!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->key] = "Format de courriel invalide.";
        }
        return $this;
    }

    /*
    ============================================
    RÈGLE : Doit être identique à un autre champ
    ============================================
    */

    public function same($otherKey, $otherValue) {
        if ($this->value !== $otherValue) {
            $this->errors[$this->key] = "{$this->name} ne correspond pas.";
        }
        return $this;
    }

    /*
    ====================================
    RÈGLE : Valeur unique dans un modèle
    ====================================
    */

    public function unique($modelName) {
        $modelClass = "App\\Models\\$modelName";
        $model = new $modelClass;

        $exists = $model->unique($this->key, $this->value);

        if ($exists) {
            $this->errors[$this->key] = "{$this->name} existe déjà.";
        }

        return $this;
    }

    /*
    =======================
    Vérifier si tout est ok
    =======================
    */

    public function isSuccess() {
        return empty($this->errors);
    }

    /*
    =====================
    Récupérer les erreurs
    =====================
    */

    public function getErrors() {
        return $this->errors;
    }
}
