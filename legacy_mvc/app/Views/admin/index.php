<?php require APPROOT . '/Views/layout/header.php'; ?>

<div class="admin-container">
    <div class="admin-header">
        <h2 class="section-label">Espace Gestion</h2>
        <p class="admin-sub">Gérez votre personnel, vos locaux et vos protocoles.</p>
    </div>

    <!-- Admin Tabs -->
    <nav class="admin-tabs">
        <a href="<?php echo URLROOT; ?>/admin/agents" class="admin-tab <?php echo ($data['active_tab'] == 'agents') ? 'active' : ''; ?>">
            Agents
        </a>
        <div class="admin-tab disabled">Locaux (Bientôt)</div>
        <div class="admin-tab disabled">Protocoles (Bientôt)</div>
    </nav>

    <div class="admin-content">
        <?php if($data['active_tab'] == 'agents') : ?>
            <div class="table-header">
                <h3>Liste des Agents</h3>
                <button class="action-btn mini" onclick="openAdminModal('addAgentModal')">
                    + Ajouter un agent
                </button>
            </div>

            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Initiales</th>
                            <th>Nom & Prénom</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['agents'] as $agent) : ?>
                            <tr>
                                <td><span class="agent-avatar mini"><?php echo $agent->initiales; ?></span></td>
                                <td>
                                    <strong><?php echo $agent->nom . ' ' . $agent->prenom; ?></strong><br>
                                    <small><?php echo $agent->email; ?></small>
                                </td>
                                <td>
                                    <span class="badge <?php echo ($agent->statut == 'actif') ? 'done' : 'late'; ?>">
                                        <?php echo ucfirst($agent->statut); ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <button class="edit-btn" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($agent)); ?>)">
                                        ✏️
                                    </button>
                                    <form action="<?php echo URLROOT; ?>/admin/delete_agent/<?php echo $agent->id; ?>" method="POST" onsubmit="return confirm('Supprimer cet agent ?')">
                                        <button type="submit" class="delete-btn">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Ajouter un Agent -->
<div class="modal-overlay" id="addAgentModal" onclick="closeAdminModal(event, 'addAgentModal')">
    <div class="modal admin-modal">
        <div class="modal-handle"></div>
        <div class="modal-header">
            <h3>Nouveau Agent</h3>
            <button class="back-btn" onclick="closeAdminModal(null, 'addAgentModal')">Fermer</button>
        </div>
        
        <form action="<?php echo URLROOT; ?>/admin/add_agent" method="POST" class="admin-form">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" required>
            </div>
            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" required>
            </div>
            <div class="form-group">
                <label>Initiales</label>
                <input type="text" name="initiales" maxlength="3" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email">
            </div>
            <div class="form-group">
                <label>Statut</label>
                <select name="statut">
                    <option value="actif">Actif</option>
                    <option value="inactif">Inactif</option>
                </select>
            </div>
            <button type="submit" class="action-btn">Enregistrer</button>
        </form>
    </div>
</div>

<!-- Modal: Modifier un Agent -->
<div class="modal-overlay" id="editAgentModal" onclick="closeAdminModal(event, 'editAgentModal')">
    <div class="modal admin-modal">
        <div class="modal-handle"></div>
        <div class="modal-header">
            <h3>Modifier l'Agent</h3>
            <button class="back-btn" onclick="closeAdminModal(null, 'editAgentModal')">Fermer</button>
        </div>
        
        <form id="editForm" action="" method="POST" class="admin-form">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" id="edit_nom" required>
            </div>
            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" id="edit_prenom" required>
            </div>
            <div class="form-group">
                <label>Initiales</label>
                <input type="text" name="initiales" id="edit_initiales" maxlength="3" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="edit_email">
            </div>
            <div class="form-group">
                <label>Statut</label>
                <select name="statut" id="edit_statut">
                    <option value="actif">Actif</option>
                    <option value="inactif">Inactif</option>
                </select>
            </div>
            <button type="submit" class="action-btn">Mettre à jour</button>
        </form>
    </div>
</div>

<script>
function openAdminModal(id) {
    document.getElementById(id).classList.add('open');
}

function closeAdminModal(e, id) {
    if (!e || e.target === document.getElementById(id)) {
        document.getElementById(id).classList.remove('open');
    }
}

function openEditModal(agent) {
    document.getElementById('editForm').action = '<?php echo URLROOT; ?>/admin/edit_agent/' + agent.id;
    document.getElementById('edit_nom').value = agent.nom;
    document.getElementById('edit_prenom').value = agent.prenom;
    document.getElementById('edit_initiales').value = agent.initiales;
    document.getElementById('edit_email').value = agent.email;
    document.getElementById('edit_statut').value = agent.statut;
    openAdminModal('editAgentModal');
}
</script>

<?php require APPROOT . '/Views/layout/footer.php'; ?>
