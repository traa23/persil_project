{{--
    ========================================
    ORIGINAL CONFIRM MODAL CODE (COMMENTED OUT)
    ========================================
    <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl max-w-sm w-full mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4 rounded-t-lg">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                    <h3 class="text-xl font-bold text-white">Konfirmasi</h3>
                </div>
            </div>
            <div class="px-6 py-4">
                <p id="confirmMessage" class="text-gray-700 text-center"></p>
            </div>
            <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex gap-3 justify-end border-t">
                <button onclick="cancelConfirm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium transition">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button onclick="submitConfirm()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-medium transition">
                    <i class="fas fa-check mr-2"></i>Hapus
                </button>
            </div>
        </div>
    </div>
    ...OLD SCRIPT CODE...
--}}

{{-- ========================================
    BEAUTIFUL CONFIRMATION MODAL SYSTEM
    ======================================== --}}

<style>
/* Modal Overlay */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active {
    background: rgba(0, 0, 0, 0.6);
    opacity: 1;
    visibility: visible;
    backdrop-filter: blur(4px);
}

/* Modal Container */
.modal-container {
    background: white;
    border-radius: 24px;
    max-width: 400px;
    width: 90%;
    padding: 32px;
    transform: scale(0.8) translateY(20px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
    position: relative;
    overflow: hidden;
}

.modal-overlay.active .modal-container {
    transform: scale(1) translateY(0);
    opacity: 1;
}

/* Modal Glow Effect */
.modal-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--modal-accent-gradient);
}

/* Modal Icon */
.modal-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    position: relative;
}

.modal-icon::before {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: var(--modal-accent-gradient);
    opacity: 0.2;
    animation: iconPulse 2s ease infinite;
}

.modal-icon i {
    font-size: 36px;
    z-index: 1;
}

@keyframes iconPulse {
    0%, 100% { transform: scale(1); opacity: 0.2; }
    50% { transform: scale(1.1); opacity: 0.3; }
}

/* Modal Types */
.modal-delete {
    --modal-accent: #ef4444;
    --modal-accent-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}
.modal-delete .modal-icon {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
}
.modal-delete .modal-icon i { color: #ef4444; }

.modal-warning {
    --modal-accent: #f59e0b;
    --modal-accent-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}
.modal-warning .modal-icon {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
}
.modal-warning .modal-icon i { color: #f59e0b; }

.modal-logout {
    --modal-accent: #8b5cf6;
    --modal-accent-gradient: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}
.modal-logout .modal-icon {
    background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
}
.modal-logout .modal-icon i { color: #8b5cf6; }

.modal-info {
    --modal-accent: #3b82f6;
    --modal-accent-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}
.modal-info .modal-icon {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
}
.modal-info .modal-icon i { color: #3b82f6; }

.modal-success {
    --modal-accent: #10b981;
    --modal-accent-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
}
.modal-success .modal-icon {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
}
.modal-success .modal-icon i { color: #10b981; }

/* Modal Title & Message */
.modal-title {
    font-size: 22px;
    font-weight: 700;
    color: #1f2937;
    text-align: center;
    margin-bottom: 12px;
}

.modal-message {
    font-size: 15px;
    color: #6b7280;
    text-align: center;
    line-height: 1.6;
    margin-bottom: 28px;
}

/* Modal Buttons */
.modal-buttons {
    display: flex;
    gap: 12px;
}

.modal-btn {
    flex: 1;
    padding: 14px 20px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.modal-btn-cancel {
    background: #f3f4f6;
    color: #6b7280;
}

.modal-btn-cancel:hover {
    background: #e5e7eb;
    color: #4b5563;
    transform: translateY(-2px);
}

.modal-btn-confirm {
    background: var(--modal-accent-gradient);
    color: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.modal-btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
}

/* 2-Step Logout Verification */
.logout-step-2 {
    display: none;
}

.logout-step-2.active {
    display: block;
}

.logout-step-1.hidden {
    display: none;
}

.logout-input-group {
    margin-bottom: 24px;
}

.logout-input-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    text-align: left;
}

.logout-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 15px;
    text-align: center;
    transition: all 0.2s ease;
    letter-spacing: 4px;
    font-weight: 600;
}

.logout-input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
}

.logout-input.error {
    border-color: #ef4444;
    animation: shake 0.5s ease;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-8px); }
    75% { transform: translateX(8px); }
}

.logout-code {
    display: inline-block;
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 18px;
    letter-spacing: 3px;
}

/* Shake Animation */
.shake {
    animation: shake 0.5s ease;
}

/* Confetti for success (optional) */
@keyframes confetti {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
}
</style>

{{-- Universal Confirmation Modal --}}
<div class="modal-overlay" id="confirmModal">
    <div class="modal-container modal-delete">
        <div class="modal-icon">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h3 class="modal-title" id="confirmModalTitle">Konfirmasi Hapus</h3>
        <p class="modal-message" id="confirmModalMessage">Apakah Anda yakin ingin menghapus item ini?</p>
        <div class="modal-buttons">
            <button class="modal-btn modal-btn-cancel" onclick="closeModal('confirmModal')">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="modal-btn modal-btn-confirm" id="confirmModalAction">
                <i class="fas fa-check"></i> <span id="confirmModalActionText">Hapus</span>
            </button>
        </div>
    </div>
</div>

{{-- 2-Step Logout Modal --}}
<div class="modal-overlay" id="logoutModal">
    <div class="modal-container modal-logout">
        {{-- Step 1: Initial Confirmation --}}
        <div class="logout-step-1" id="logoutStep1">
            <div class="modal-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3 class="modal-title">Keluar dari Akun?</h3>
            <p class="modal-message">
                Anda akan keluar dari sesi saat ini. Untuk keamanan, diperlukan verifikasi tambahan.
            </p>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" onclick="closeModal('logoutModal')">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button class="modal-btn modal-btn-confirm" onclick="showLogoutStep2()">
                    <i class="fas fa-arrow-right"></i> Lanjutkan
                </button>
            </div>
        </div>

        {{-- Step 2: Verification Code --}}
        <div class="logout-step-2" id="logoutStep2">
            <div class="modal-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="modal-title">Verifikasi Keamanan</h3>
            <p class="modal-message">
                Masukkan kode berikut untuk mengkonfirmasi logout:
                <br><br>
                <span class="logout-code" id="logoutVerifyCode">----</span>
            </p>
            <div class="logout-input-group">
                <label class="logout-input-label">Masukkan Kode Verifikasi</label>
                <input type="text"
                       class="logout-input"
                       id="logoutVerifyInput"
                       maxlength="4"
                       placeholder="----"
                       autocomplete="off">
            </div>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" onclick="backToStep1()">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
                <button class="modal-btn modal-btn-confirm" onclick="verifyLogout()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentConfirmForm = null;
let logoutCode = '';

/**
 * Show confirmation modal
 * @param {string} type - 'delete', 'warning', 'info', 'success'
 * @param {string} title - Modal title
 * @param {string} message - Modal message
 * @param {string} actionText - Text for confirm button
 * @param {Function|HTMLElement} onConfirm - Callback function or form element
 */
function showConfirmModal(type, title, message, actionText, onConfirm) {
    const modal = document.getElementById('confirmModal');
    const container = modal.querySelector('.modal-container');
    const titleEl = document.getElementById('confirmModalTitle');
    const messageEl = document.getElementById('confirmModalMessage');
    const actionTextEl = document.getElementById('confirmModalActionText');
    const actionBtn = document.getElementById('confirmModalAction');
    const iconEl = container.querySelector('.modal-icon i');

    // Set type class
    container.className = 'modal-container modal-' + type;

    // Set icon based on type
    const icons = {
        delete: 'fa-trash-alt',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle',
        success: 'fa-check-circle',
        logout: 'fa-sign-out-alt'
    };
    iconEl.className = 'fas ' + (icons[type] || icons.warning);

    // Set content
    titleEl.textContent = title;
    messageEl.textContent = message;
    actionTextEl.textContent = actionText;

    // Set action
    if (typeof onConfirm === 'function') {
        actionBtn.onclick = function() {
            onConfirm();
            closeModal('confirmModal');
        };
    } else if (onConfirm instanceof HTMLFormElement) {
        currentConfirmForm = onConfirm;
        actionBtn.onclick = function() {
            currentConfirmForm.submit();
        };
    }

    modal.classList.add('active');
}

/**
 * Show delete confirmation (shorthand)
 */
function confirmDelete(message, form) {
    showConfirmModal('delete', 'Konfirmasi Hapus', message, 'Hapus', form);
}

/**
 * Legacy function for backward compatibility
 */
function showConfirm(message, form) {
    confirmDelete(message, form);
}

/**
 * Close modal by ID
 */
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('active');

    // Reset logout modal if closing
    if (modalId === 'logoutModal') {
        resetLogoutModal();
    }
}

/**
 * Show 2-Step Logout Modal
 */
function confirmLogout() {
    // Generate random 4-digit code
    logoutCode = Math.floor(1000 + Math.random() * 9000).toString();
    document.getElementById('logoutVerifyCode').textContent = logoutCode;
    document.getElementById('logoutVerifyInput').value = '';

    // Show modal
    document.getElementById('logoutModal').classList.add('active');
}

/**
 * Show Step 2 of Logout
 */
function showLogoutStep2() {
    document.getElementById('logoutStep1').classList.add('hidden');
    document.getElementById('logoutStep2').classList.add('active');

    // Focus on input
    setTimeout(() => {
        document.getElementById('logoutVerifyInput').focus();
    }, 300);
}

/**
 * Back to Step 1
 */
function backToStep1() {
    document.getElementById('logoutStep2').classList.remove('active');
    document.getElementById('logoutStep1').classList.remove('hidden');
}

/**
 * Reset Logout Modal
 */
function resetLogoutModal() {
    document.getElementById('logoutStep2').classList.remove('active');
    document.getElementById('logoutStep1').classList.remove('hidden');
    document.getElementById('logoutVerifyInput').value = '';
    document.getElementById('logoutVerifyInput').classList.remove('error');
}

/**
 * Verify Logout Code
 */
function verifyLogout() {
    const input = document.getElementById('logoutVerifyInput');
    const enteredCode = input.value;

    if (enteredCode === logoutCode) {
        // Success - submit logout form
        const logoutForm = document.getElementById('logoutForm');
        if (logoutForm) {
            logoutForm.submit();
        }
    } else {
        // Error - shake input
        input.classList.add('error');
        setTimeout(() => {
            input.classList.remove('error');
        }, 500);
        input.value = '';
        input.focus();
    }
}

// Handle Enter key on verification input
document.addEventListener('DOMContentLoaded', function() {
    const verifyInput = document.getElementById('logoutVerifyInput');
    if (verifyInput) {
        verifyInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                verifyLogout();
            }
        });
    }
});

// Close modal when clicking overlay
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(modal => {
            closeModal(modal.id);
        });
    }
});

// Legacy functions for backward compatibility
function cancelConfirm() {
    closeModal('confirmModal');
}

function submitConfirm() {
    if (currentConfirmForm) {
        currentConfirmForm.submit();
    }
}
</script>
