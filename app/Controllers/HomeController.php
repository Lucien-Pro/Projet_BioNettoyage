<?php
/**
 * Home Controller
 */

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function __construct() {
        // You can load models here
        // $this->userModel = $this->model('User');
    }

    public function index() {
        $data = [
            'title' => 'BioNet Traçabilité'
        ];

        $this->view('home', $data);
    }
}
