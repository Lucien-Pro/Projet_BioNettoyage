/**
 * BioNet Traçabilité - Core Logic
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log('BioNet App Initialized');
    
    // Initialize any state or event listeners here if needed
});

/**
 * Switch between application tabs
 * @param {string} id - The ID of the tab to show
 * @param {HTMLElement} el - The tab element that was clicked
 */
function switchTab(id, el) {
    // Remove active class from all contents and tabs
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    
    // Add active class to targets
    const targetContent = document.getElementById('tab-' + id);
    if (targetContent) {
        targetContent.classList.add('active');
    }
    
    if (el) {
        el.classList.add('active');
    }
}

/**
 * Open the cleaning detail modal
 */
function openModal() {
    const modal = document.getElementById('modal');
    if (modal) {
        modal.classList.add('open');
        // Prevent body scrolling when modal is open
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Close the cleaning detail modal
 * @param {Event} e - The click event
 */
function closeModal(e) {
    const modal = document.getElementById('modal');
    if (!modal) return;

    // Close if: 
    // 1. No event (triggered by button)
    // 2. Clicked on the overlay itself (e.target === modal)
    // 3. CurrentTarget is modal and we want to close (standard button trigger)
    if (!e || e.target === modal) {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
}

/**
 * Toggle a checklist item
 * @param {HTMLElement} el - The checkbox element
 */
function toggleCheck(el) {
    const isChecked = el.classList.contains('checked');
    
    if (isChecked) {
        el.classList.remove('checked');
        el.textContent = '';
    } else {
        el.classList.add('checked');
        el.textContent = '✓';
    }
}

