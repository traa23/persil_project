{{--
    ========================================
    ORIGINAL ALERTS CODE (COMMENTED OUT)
    ========================================
    @if ($message = Session::get('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50 animate-slide-in" role="alert">
        <i class="fas fa-check-circle text-lg"></i>
        <div>
            <p class="font-semibold">Sukses!</p>
            <p class="text-sm">{{ $message }}</p>
        </div>
        <button onclick="this.parentElement.style.display='none'" class="text-white hover:text-gray-200">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.querySelector('[role="alert"]');
            if (alert) alert.style.display = 'none';
        }, 4000);
    </script>
    @endif
    ...OLD CODE ABOVE...
--}}

{{-- ========================================
    BEAUTIFUL TOAST NOTIFICATION SYSTEM
    ======================================== --}}

<style>
/* Toast Container */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    pointer-events: none;
}

/* Toast Base */
.toast {
    pointer-events: auto;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 16px 20px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 8px 25px rgba(0, 0, 0, 0.1);
    max-width: 420px;
    min-width: 320px;
    transform: translateX(120%);
    opacity: 0;
    animation: toastSlideIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
    border-left: 4px solid;
    position: relative;
    overflow: hidden;
}

.toast.toast-out {
    animation: toastSlideOut 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
}

/* Toast Types */
.toast-success {
    border-left-color: #10b981;
}
.toast-success .toast-icon-wrapper {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}
.toast-success .toast-progress {
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
}

.toast-error {
    border-left-color: #ef4444;
}
.toast-error .toast-icon-wrapper {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}
.toast-error .toast-progress {
    background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
}

.toast-warning {
    border-left-color: #f59e0b;
}
.toast-warning .toast-icon-wrapper {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}
.toast-warning .toast-progress {
    background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
}

.toast-info {
    border-left-color: #3b82f6;
}
.toast-info .toast-icon-wrapper {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}
.toast-info .toast-progress {
    background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
}

/* Toast Icon */
.toast-icon-wrapper {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.toast-icon-wrapper i {
    color: white;
    font-size: 20px;
}

/* Toast Content */
.toast-content {
    flex: 1;
    padding-right: 20px;
}

.toast-title {
    font-weight: 700;
    font-size: 15px;
    color: #1f2937;
    margin-bottom: 4px;
}

.toast-message {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.5;
}

/* Toast Close Button */
.toast-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    border: none;
    background: #f3f4f6;
    color: #9ca3af;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.toast-close:hover {
    background: #e5e7eb;
    color: #6b7280;
    transform: scale(1.1);
}

/* Toast Progress Bar */
.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    border-radius: 0 0 0 12px;
    animation: toastProgress 5s linear forwards;
}

/* Animations */
@keyframes toastSlideIn {
    from {
        transform: translateX(120%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes toastSlideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(120%);
        opacity: 0;
    }
}

@keyframes toastProgress {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}

/* Bounce Animation for Icon */
@keyframes iconBounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-8px);
    }
    60% {
        transform: translateY(-4px);
    }
}

.toast-icon-wrapper {
    animation: iconBounce 0.6s ease 0.3s;
}

/* Mobile Responsive */
@media (max-width: 480px) {
    .toast-container {
        left: 10px;
        right: 10px;
        top: 10px;
    }
    .toast {
        min-width: auto;
        max-width: none;
    }
}
</style>

{{-- Toast Container --}}
<div class="toast-container" id="toastContainer"></div>

{{-- Display Session Alerts --}}
@if ($message = Session::get('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('success', 'Berhasil!', '{{ $message }}');
    });
</script>
@endif

@if ($message = Session::get('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('error', 'Error!', '{{ $message }}');
    });
</script>
@endif

@if ($message = Session::get('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('warning', 'Perhatian!', '{{ $message }}');
    });
</script>
@endif

@if ($message = Session::get('info'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('info', 'Informasi', '{{ $message }}');
    });
</script>
@endif

<script>
/**
 * Beautiful Toast Notification System
 * @param {string} type - 'success', 'error', 'warning', 'info'
 * @param {string} title - Toast title
 * @param {string} message - Toast message
 * @param {number} duration - Duration in milliseconds (default: 5000)
 */
function showToast(type, title, message, duration = 5000) {
    const container = document.getElementById('toastContainer');

    const icons = {
        success: 'fa-check',
        error: 'fa-times',
        warning: 'fa-exclamation',
        info: 'fa-info'
    };

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-icon-wrapper">
            <i class="fas ${icons[type]}"></i>
        </div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close" onclick="closeToast(this.parentElement)">
            <i class="fas fa-times"></i>
        </button>
        <div class="toast-progress" style="animation-duration: ${duration}ms;"></div>
    `;

    container.appendChild(toast);

    // Auto remove after duration
    setTimeout(() => {
        closeToast(toast);
    }, duration);

    return toast;
}

/**
 * Close toast with animation
 * @param {HTMLElement} toast - Toast element to close
 */
function closeToast(toast) {
    if (!toast || toast.classList.contains('toast-out')) return;

    toast.classList.add('toast-out');
    setTimeout(() => {
        toast.remove();
    }, 400);
}
</script>
