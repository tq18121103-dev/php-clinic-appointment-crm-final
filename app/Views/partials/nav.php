<header class="topbar">
    <strong>Clinic Appointment CRM</strong>

    <nav>
        <a href="/">Home</a>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="/dashboard">Dashboard</a>
            <a href="/patients">Patients</a>
            <a href="/appointments">Appointments</a>

            <form method="post" action="/logout" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="link-button">Logout</button>
            </form>
        <?php else: ?>
            <a href="/login">Login</a>
        <?php endif; ?>

        <a href="/health">Health</a>
    </nav>
</header>