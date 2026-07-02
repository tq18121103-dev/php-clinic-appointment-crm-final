<aside class="sidebar">
    <div class="sidebar-logo">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        <span>Clinic CRM</span>
    </div>

    <nav class="sidebar-nav">
        <a href="/dashboard" class="sidebar-link <?= $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="10" rx="1"/><rect width="7" height="5" x="3" y="15" rx="1"/></svg>
            Dashboard
        </a>
        
        <a href="/patients" class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], '/patients') === 0 && strpos($_SERVER['REQUEST_URI'], '/public-') === false) ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Bệnh nhân
        </a>
        
        <a href="/appointments" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], '/appointments') === 0 ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            Lịch hẹn
        </a>
        
        <a href="/public-patients/create" class="sidebar-link" target="_blank">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
            Form công khai
        </a>

        <a href="/health" class="sidebar-link <?= $_SERVER['REQUEST_URI'] === '/health' ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            Health Check
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div style="display: flex; flex-direction: column; gap: 2px;">
                <span class="sidebar-username"><?= e($_SESSION['username'] ?? 'User') ?></span>
                <span class="sidebar-role"><?= e($_SESSION['role'] ?? 'guest') ?></span>
            </div>
            <form method="post" action="/logout" style="margin: 0; display: inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px; border-radius: 4px;">Đăng xuất</button>
            </form>
        </div>
    </div>
</aside>