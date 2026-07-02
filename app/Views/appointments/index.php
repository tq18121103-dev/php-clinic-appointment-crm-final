<h1>Appointment List</h1>

<a class="btn" href="/appointments/create">Create Appointment</a>

<br><br>

<form method="get" action="/appointments" class="search-form">
    <?= csrf_field() ?>
    <input
        type="text"
        name="keyword"
        value="<?= e($keyword ?? '') ?>"
        placeholder="Search by appointment code, patient name, status">

    <button type="submit">Search</button>
    <a href="/appointments">Reset</a>
</form>

<br>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><a href="/appointments?keyword=<?= e($keyword ?? '') ?>&sort=id&direction=DESC">ID</a></th>
            <th><a href="/appointments?keyword=<?= e($keyword ?? '') ?>&sort=appointment_code&direction=ASC">Appointment Code</a></th>
            <th>Patient</th>
            <th><a href="/appointments?keyword=<?= e($keyword ?? '') ?>&sort=fee&direction=DESC">Fee</a></th>
            <th><a href="/appointments?keyword=<?= e($keyword ?? '') ?>&sort=appointment_status&direction=ASC">Status</a></th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($appointments)): ?>
            <tr>
                <td colspan="7">No appointments found.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?= e((string) $appointment['id']) ?></td>
                <td><?= e($appointment['appointment_code']) ?></td>
                <td><?= e($appointment['patient_name'] ?? 'Unknown Patient') ?></td>
                <td><?= e(number_format((float) $appointment['fee'])) ?> VND</td>
                <td><?= e($appointment['appointment_status']) ?></td>
                <td><?= e($appointment['created_at']) ?></td>
                <td>
                    <a href="/appointments/edit?id=<?= e((string) $appointment['id']) ?>">Edit</a>

                    <form
                        method="post"
                        action="/appointments/delete"
                        style="display:inline;"
                        onsubmit="return confirm('Delete this appointment?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e((string) $appointment['id']) ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>

<?php if (($totalPages ?? 1) > 1): ?>
    <div>
        Pages:

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a
                href="/appointments?keyword=<?= e($keyword ?? '') ?>&page=<?= $i ?>"
                style="<?= ($i === ($page ?? 1)) ? 'font-weight:bold; color:red;' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>