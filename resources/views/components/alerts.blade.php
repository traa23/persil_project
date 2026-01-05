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

@if ($message = Session::get('error'))
<div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50 animate-slide-in" role="alert">
    <i class="fas fa-exclamation-circle text-lg"></i>
    <div>
        <p class="font-semibold">Error!</p>
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

@if ($message = Session::get('warning'))
<div class="fixed top-4 right-4 bg-yellow-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50 animate-slide-in" role="alert">
    <i class="fas fa-exclamation-triangle text-lg"></i>
    <div>
        <p class="font-semibold">Perhatian!</p>
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

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slideIn 0.3s ease-out;
}
</style>
