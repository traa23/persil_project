<!-- Confirmation Modal -->
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-2xl max-w-sm w-full mx-4 transform transition-all">
        <!-- Header -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4 rounded-t-lg">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                <h3 class="text-xl font-bold text-white">Konfirmasi</h3>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-4">
            <p id="confirmMessage" class="text-gray-700 text-center"></p>
        </div>

        <!-- Footer -->
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

<script>
let confirmForm = null;

function showConfirm(message, form) {
    document.getElementById('confirmMessage').textContent = message;
    document.getElementById('confirmModal').classList.remove('hidden');
    confirmForm = form;
}

function cancelConfirm() {
    document.getElementById('confirmModal').classList.add('hidden');
    confirmForm = null;
}

function submitConfirm() {
    if (confirmForm) {
        confirmForm.submit();
    }
    document.getElementById('confirmModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('confirmModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cancelConfirm();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cancelConfirm();
    }
});
</script>
