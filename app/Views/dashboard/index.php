<h1>Dashboard</h1>

<p>
    Welcome, <strong><?= e($_SESSION['username'] ?? 'User') ?></strong>.
</p>

<div class="cards">
    <div class="card">
        <h2>Patients</h2>
        <p>Manage patient list, search, pagination, create, update, delete.</p>
    </div>

    <div class="card">
        <h2>Appointments</h2>
        <p>Manage appointments, unique appointment code, schedule and status.
</p>
    </div>

    <div class="card">
        <h2>Security</h2>
        <p>Session login, regenerate ID, timeout, CSRF, safe logout.</p>
    </div>
</div>