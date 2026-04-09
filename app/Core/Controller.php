<?php
/**
 * Base Controller
 * Loads Models and Views
 */

namespace App\Core;

class Controller {
    // Load Model
    public function model($model) {
        $modelClass = "App\\Models\\" . $model;
        return new $modelClass();
    }

    // Load View
    public function view($view, $data = []) {
        // Check for view file
        if (file_exists(APPROOT . '/Views/' . $view . '.php')) {
            require_once APPROOT . '/Views/' . $view . '.php';
        } else {
            die('View dose not exist');
        }
    }
}
