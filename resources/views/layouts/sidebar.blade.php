<div class="sidebar p-3" style="min-width:230px; min-height:100vh; background: linear-gradient(160deg, #0d47a1 0%, #212121 100%); color: #fff;">
    <div class="text-center mb-4">
        <img src="https://avatars.githubusercontent.com/u/9919?s=200&v=4" alt="Logo" width="60" class="rounded-circle shadow border border-3 border-light">
        <h5 class="mt-2 mb-0">VNCS Admin</h5>
        <small class="text-light">Dashboard</small>
    </div>
    <hr class="border-secondary">
    <div class="mb-2 text-uppercase text-light fw-bold small">Management</div>
    <ul class="nav flex-column mb-3">
       
        <li class="nav-item mb-1">
            <a class="nav-link d-flex align-items-center sidebar-link" href="/admin/users/">
                <i class="bi bi-file-earmark-text me-2"></i> Users
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link d-flex align-items-center sidebar-link" href="/admin/telephones">
                <i class="bi bi-file-earmark-text me-2"></i> Telephones
            </a>
        </li>
        
    </ul>

    <hr class="border-secondary">
    <div class="text-center">
        <small class="text-light">&copy; {{ date('Y') }} VNCS Global</small>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
.sidebar-link {
    color: #e3e3e3;
    border-radius: 8px;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
}
.sidebar-link i {
    color: #90caf9;
    font-size: 1.2em;
}
.sidebar-link:hover, .sidebar-link.active {
    background: rgba(33, 150, 243, 0.18);
    color: #fff;
    box-shadow: 0 2px 8px rgba(33,150,243,0.12);
    text-decoration: none;
}
.sidebar {
    box-shadow: 2px 0 12px rgba(13,71,161,0.08);
}
hr.border-secondary {
    border-color: #37474f !important;
}
</style>
@endpush 