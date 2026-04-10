<?php require APPROOT . '/Views/layout/header.php'; ?>

<!-- Tab: Mes Locaux -->
<section class="tab-content active" id="tab-mes-locaux">
    <div class="stats">
        <div class="stat"><div class="stat-num green">31</div><div class="stat-label">Faits</div></div>
        <div class="stat"><div class="stat-num amber">4</div><div class="stat-label">En attente</div></div>
        <div class="stat"><div class="stat-num red">1</div><div class="stat-label">En retard</div></div>
    </div>
    
    <div class="progress-row">
        <div class="progress-bar"><div class="progress-fill" style="width: 86%;"></div></div>
        <div class="progress-label">86% — 36/36</div>
    </div>

    <h2 class="section-label">Locaux assignés</h2>
    <input class="search" type="text" placeholder="Rechercher un local..." aria-label="Rechercher un local">

    <!-- Room Cards -->
    <div class="local-card" onclick="openModal()" role="button" tabindex="0">
        <div class="local-icon late" aria-hidden="true">🏥</div>
        <div class="local-info">
            <div class="local-name">Salle de soins 2B</div>
            <div class="local-meta">Priorité haute · Prévu 08h30</div>
        </div>
        <div class="badge late">En retard</div>
    </div>

    <div class="local-card" onclick="openModal()" role="button" tabindex="0">
        <div class="local-icon pending" aria-hidden="true">🚪</div>
        <div class="local-info">
            <div class="local-name">Couloir Est — Étage 3</div>
            <div class="local-meta">Standard · Prévu 10h00</div>
        </div>
        <div class="badge pending">À faire</div>
    </div>

    <div class="local-card" onclick="openModal()" role="button" tabindex="0">
        <div class="local-icon done" aria-hidden="true">🚿</div>
        <div class="local-info">
            <div class="local-name">Sanitaires bloc C</div>
            <div class="local-meta">Fait à 09h12 · M. Dupont</div>
        </div>
        <div class="badge done">Validé</div>
    </div>

    <div class="local-card" onclick="openModal()" role="button" tabindex="0">
        <div class="local-icon done" aria-hidden="true">🏢</div>
        <div class="local-info">
            <div class="local-name">Salle d'attente RDC</div>
            <div class="local-meta">Fait à 08h55 · conforme</div>
        </div>
        <div class="badge done">Validé</div>
    </div>
</section>

<!-- Tab: Équipe -->
<section class="tab-content" id="tab-equipe">
    <h2 class="section-label">Avancement de l'équipe</h2>
    <div style="margin-bottom: 20px;">
        <div class="progress-row" style="margin-bottom: 8px;">
            <div class="progress-bar"><div class="progress-fill" style="width: 74%;"></div></div>
            <div class="progress-label">74% équipe</div>
        </div>
        <div style="font-size:12px; color: var(--color-text-secondary);">183 / 250 locaux traités aujourd'hui</div>
    </div>

    <h2 class="section-label">Agents</h2>
    
    <div class="agent-row">
        <div class="agent-avatar">MD</div>
        <div class="agent-info">
            <div class="agent-name">Marie Dupont</div>
            <div class="agent-prog">36/36 <span class="mini-bar"><span class="mini-fill" style="width:100%"></span></span></div>
        </div>
        <div class="badge done">100%</div>
    </div>

    <div class="agent-row">
        <div class="agent-avatar">JL</div>
        <div class="agent-info">
            <div class="agent-name">Jean Lefebvre</div>
            <div class="agent-prog">29/36 <span class="mini-bar"><span class="mini-fill" style="width:80%"></span></span></div>
        </div>
        <div class="badge pending">80%</div>
    </div>

    <div class="agent-row">
        <div class="agent-avatar">SB</div>
        <div class="agent-info">
            <div class="agent-name">Sophie Bernard</div>
            <div class="agent-prog">31/36 <span class="mini-bar"><span class="mini-fill" style="width:86%"></span></span></div>
        </div>
        <div class="badge pending">86%</div>
    </div>

    <div class="agent-row">
        <div class="agent-avatar">KA</div>
        <div class="agent-info">
            <div class="agent-name">Karim Amrani</div>
            <div class="agent-prog">24/36 <span class="mini-bar"><span class="mini-fill" style="width:67%"></span></span></div>
        </div>
        <div class="badge late">67%</div>
    </div>
    
    <div class="agent-row">
        <div class="agent-avatar">PN</div>
        <div class="agent-info">
            <div class="agent-name">Pauline Nguyen</div>
            <div class="agent-prog">34/36 <span class="mini-bar"><span class="mini-fill" style="width:94%"></span></span></div>
        </div>
        <div class="badge done">94%</div>
    </div>
</section>

<!-- Tab: Alertes -->
<section class="tab-content" id="tab-alertes">
    <h2 class="section-label">Alertes du jour</h2>
    
    <div class="alert-row">
        <div class="alert-dot"></div>
        <div>
            <div class="alert-text">Salle de soins 2B — Nettoyage non effectué</div>
            <div class="alert-time">Prévu à 08h30 · Retard de 1h45</div>
        </div>
    </div>

    <div class="alert-row">
        <div class="alert-dot"></div>
        <div>
            <div class="alert-text">Thomas Martin — Avancement faible (50%)</div>
            <div class="alert-time">Dernière action il y a 42 min</div>
        </div>
    </div>

    <div class="alert-row" style="background: #fffbeb; border-color: #fef3c7;">
        <div class="alert-dot" style="background:#EF9F27;"></div>
        <div>
            <div class="alert-text" style="color:#854F0B;">Produit P3 — Stock bas signalé</div>
            <div class="alert-time" style="color:#BA7517;">Mis à jour il y a 20 min</div>
        </div>
    </div>
</section>

<?php require APPROOT . '/Views/layout/footer.php'; ?>
