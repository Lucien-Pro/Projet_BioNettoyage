        </main>

        <!-- Modal Overlay -->
        <div class="modal-overlay" id="modal" onclick="closeModal(event)" role="dialog" aria-labelledby="modal-title">
            <div class="modal">
                <div class="modal-handle"></div>
                <div class="modal-header">
                    <button class="back-btn" onclick="closeModal()" aria-label="Retour à la liste">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        <span>Retour</span>
                    </button>
                </div>
                <h2 class="modal-title" id="modal-title">Salle de soins 2B</h2>
                <p class="modal-sub">Priorité haute · Protocole P3 Bloc opératoire</p>
                
                <h3 class="section-label">Étapes de nettoyage</h3>
                <ul class="checklist">
                    <li onclick="toggleCheck(this.querySelector('.check-box'))">
                        <div class="check-box checked">✓</div>
                        <span>Désinfection surfaces hautes</span>
                    </li>
                    <li onclick="toggleCheck(this.querySelector('.check-box'))">
                        <div class="check-box checked">✓</div>
                        <span>Nettoyage sol — produit biodégradable</span>
                    </li>
                    <li onclick="toggleCheck(this.querySelector('.check-box'))">
                        <div class="check-box"></div>
                        <span>Désinfection équipements médicaux</span>
                    </li>
                    <li onclick="toggleCheck(this.querySelector('.check-box'))">
                        <div class="check-box"></div>
                        <span>Vidage et désinfection poubelles</span>
                    </li>
                    <li onclick="toggleCheck(this.querySelector('.check-box'))">
                        <div class="check-box"></div>
                        <span>Vérification finale + aération</span>
                    </li>
                </ul>


                <h3 class="section-label">Signature</h3>
                <div class="signature-box" role="button">✍ Signature ou visa agent</div>

                <div class="modal-actions">
                    <button class="action-btn" onclick="closeModal()">Valider le nettoyage</button>
                    <button class="action-btn secondary" onclick="closeModal()">Signaler un problème</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-info">
        Appuyez sur un local pour voir la fiche de nettoyage
    </footer>
</div>

<!-- Scripts -->
<script src="<?php echo URLROOT; ?>/js/script.js"></script>

</body>
</html>
