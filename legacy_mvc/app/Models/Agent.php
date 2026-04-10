<?php
/**
 * Agent Model
 */

namespace App\Models;

use App\Core\Database;

class Agent {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all agents
    public function getAgents() {
        $this->db->query("SELECT * FROM agents ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    // Add agent
    public function addAgent($data) {
        $this->db->query("INSERT INTO agents (nom, prenom, initiales, email, statut) VALUES (:nom, :prenom, :initiales, :email, :statut)");
        // Bind values
        $this->db->bind(':nom', $data['nom']);
        $this->db->bind(':prenom', $data['prenom']);
        $this->db->bind(':initiales', $data['initiales']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':statut', $data['statut']);

        // Execute
        return $this->db->execute();
    }

    // Update agent
    public function updateAgent($id, $data) {
        $this->db->query("UPDATE agents SET nom = :nom, prenom = :prenom, initiales = :initiales, email = :email, statut = :statut WHERE id = :id");
        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':nom', $data['nom']);
        $this->db->bind(':prenom', $data['prenom']);
        $this->db->bind(':initiales', $data['initiales']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':statut', $data['statut']);

        // Execute
        return $this->db->execute();
    }

    // Get agent by ID
    public function getAgentById($id) {
        $this->db->query("SELECT * FROM agents WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Delete agent
    public function deleteAgent($id) {
        $this->db->query("DELETE FROM agents WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
