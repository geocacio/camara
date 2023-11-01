<div class="toast {{ session('error') ? 'error show' : '' }} {{ session('success') ? 'success show' : '' }}">
    <div class="progress-close">
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        <i class="fa-solid fa-check"></i>
        <span class="message">{{ session('success') ? session('success') : session('error') }}</span>
    </div>
</div>