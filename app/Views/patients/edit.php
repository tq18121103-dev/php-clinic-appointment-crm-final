<h1>Edit Patient</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <?= e($errors['general']) ?>
    </div>
<?php endif; ?>

<form method="post" action="/patients/update" class="card form-card">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) $patient['id']) ?>">

    <div>
        <label>Patient Code</label>
        <input
            name="patient_code"
            value="<?= e($old['patient_code'] ?? $patient['patient_code']) ?>"
        >
        <small class="error-text"><?= e($errors['patient_code'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Full Name</label>
        <input
            name="full_name"
            value="<?= e($old['full_name'] ?? $patient['full_name']) ?>"
        >
        <small class="error-text"><?= e($errors['full_name'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Email</label>
        <input
            name="email"
            value="<?= e($old['email'] ?? $patient['email']) ?>"
        >
        <small class="error-text"><?= e($errors['email'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Phone</label>
        <input
            name="phone"
            value="<?= e($old['phone'] ?? $patient['phone']) ?>"
        >
        <small class="error-text"><?= e($errors['phone'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Symptom</label>
        <input
            name="symptom"
            value="<?= e($old['symptom'] ?? $patient['symptom']) ?>"
        >
        <small class="error-text"><?= e($errors['symptom'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Status</label>
        <select name="status">
            <?php $currentStatus = $old['status'] ?? $patient['status']; ?>

            <?php foreach (['treated', 'scheduled', 'contacted', 'new'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= ($currentStatus === $status) ? 'selected' : '' ?>
                >
                    <?= e(ucfirst($status)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="error-text"><?= e($errors['status'] ?? '') ?></small>
    </div>

    <br>

    <button type="submit">Update Patient</button>
    <a href="/patients" style="margin-left: 10px;">Cancel</a>
</form>