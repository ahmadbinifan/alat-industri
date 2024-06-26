<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand" style="font-size: 13px">
            Bakrie Renewable Chemicals
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item  {{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Operation License</li>
            <li class="nav-item {{ request()->routeIs('equipment') ? 'active' : '' }}">
                <a href="{{ url('/equipment') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Request License Equipment</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('oldEquipment') ? 'active' : '' }}">
                <a href="{{ url('/oldEquipment') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Old License Equipment</span>
                </a>
            </li>
            @if (session('id_section') == 'HSE' || session('id_section') == 'HRD')
                <li class="nav-item {{ request()->routeIs('certificateRegulation') ? 'active' : '' }}">
                    <a href="{{ url('/certificateRegulation') }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Certificate Regulations</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
<nav class="settings-sidebar">
    <div class="sidebar-body">
        <a href="#" class="settings-sidebar-toggler">
            <i data-feather="settings"></i>
        </a>
        <h6 class="text-muted">Sidebar:</h6>
        <div class="form-group border-bottom">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight"
                        value="sidebar-light" checked>
                    Light
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark"
                        value="sidebar-dark">
                    Dark
                </label>
            </div>
        </div>
    </div>
</nav>
