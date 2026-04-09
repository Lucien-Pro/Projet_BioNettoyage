<?php
/**
 * Admin Controller
 * Handles the management dashboard and module CRUD
 */

namespace App\Controllers;

use App\Core\Controller;

class AdminController extends Controller {
    private $agentModel;

    public function __construct() {
        // Load the Agent Model
        $this->agentModel = $this->model('Agent');
    }

    // Default admin page (Home of management)
    public function index() {
        // Default tab is 'agents' for now
        $this->agents();
    }

    // Agents Management Tab
    public function agents() {
        $agents = $this->agentModel->getAgents();
        
        $data = [
            'active_tab' => 'agents',
            'agents' => $agents
        ];

        $this->view('admin/index', $data);
    }

    // Add Agent action (POST)
    public function add_agent() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'initiales' => trim($_POST['initiales']),
                'email' => trim($_POST['email']),
                'statut' => trim($_POST['statut'])
            ];

            // Validation (simplified for now)
            if (!empty($data['nom']) && !empty($data['prenom'])) {
                if ($this->agentModel->addAgent($data)) {
                    // Redirect to agents list
                    header('Location: ' . URLROOT . '/admin/agents');
                } else {
                    die('Something went wrong');
                }
            }
        }
    }

    // Edit Agent action (POST)
    public function edit_agent($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'initiales' => trim($_POST['initiales']),
                'email' => trim($_POST['email']),
                'statut' => trim($_POST['statut'])
            ];

            if ($this->agentModel->updateAgent($id, $data)) {
                header('Location: ' . URLROOT . '/admin/agents');
            } else {
                die('Something went wrong');
            }
        }
    }

    // Delete Agent action
    public function delete_agent($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->agentModel->deleteAgent($id)) {
                header('Location: ' . URLROOT . '/admin/agents');
            } else {
                die('Something went wrong');
            }
        }
    }
}
