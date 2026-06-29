<h1>Patient List</h1>
<a class="btn" href="/patients/create">Create Patient</a>
<br><br>

<form method="get" action="/patients" class="search-form">
    <input
        type="text"
        name="keyword"
        value="<?= e($keyword ?? '') ?>"
        placeholder="Search by code, name, email, phone, symptom, status"
    >

    <button type="submit">Search</button>
    <a href="/patients">Reset</a>
</form>

<br>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th><a href="/patients?keyword=<?= e($keyword ?? '') ?>&sort=id&direction=DESC">ID</a></th>
        <th><a href="/patients?keyword=<?= e($keyword ?? '') ?>&sort=patient_code&direction=ASC">Patient Code</a></th>
        <th><a href="/patients?keyword=<?= e($keyword ?? '') ?>&sort=full_name&direction=ASC">Name</a></th>
        <th>Email</th>
        <th>Phone</th>
        <th>Symptom</th>
        <th><a href="/patients?keyword=<?= e($keyword ?? '') ?>&sort=status&direction=ASC">Status</a></th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    <?php if (empty($patients)): ?>
        <tr>
            <td colspan="9">No patients found.</td>
        </tr>
    <?php endif; ?>

    <?php foreach ($patients as $patient): ?>
        <tr>
        <td><?= e((string) $patient['id']) ?></td>
        <td><?= e($patient['patient_code']) ?></td>
        <td><?= e($patient['full_name']) ?></td>
        <td><?= e($patient['email']) ?></td>
        <td><?= e($patient['phone']) ?></td>
        <td><?= e($patient['symptom']) ?></td>
        <td><?= e($patient['status']) ?></td>
        <td><?= e($patient['created_at']) ?></td>
        <td>
                <a href="/patients/edit?id=<?= e((string) $patient['id']) ?>">Edit</a>

                <form
                    method="post"
                    action="/patients/delete"
                    style="display:inline;"
                    onsubmit="return confirm('Delete this patient?');"
                >
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= e((string) $patient['id']) ?>">
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
                href="/patients?keyword=<?= e($keyword ?? '') ?>&page=<?= $i ?>"
                style="<?= ($i === ($page ?? 1)) ? 'font-weight:bold; color:red;' : '' ?>"
            >
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>