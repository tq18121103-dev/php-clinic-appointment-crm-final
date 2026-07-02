<h1>Create Appointment</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <?= e($errors['general']) ?>
    </div>
<?php endif; ?>

<form method="post" action="/appointments" class="card form-card">
    <?= csrf_field() ?>
    <div>
        <label>Appointment Code</label>
        <input
            name="appointment_code"
            value="<?= e($old['appointment_code'] ?? '') ?>"
            placeholder="AP011"
        >
        <small class="error-text"><?= e($errors['appointment_code'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Patient ID</label>
        <input
            name="patient_id"
            value="<?= e($old['patient_id'] ?? '') ?>"
            placeholder="1"
        >
        <small class="error-text"><?= e($errors['patient_id'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Appointment Date</label>
        <input
            type="date"
            name="appointment_date"
            value="<?= e($old['appointment_date'] ?? '') ?>"
        >
        <small class="error-text"><?= e($errors['appointment_date'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Department</label>
        <input
            type="text"
            name="department"
            value="<?= e($old['department'] ?? '') ?>"
            placeholder="Dentistry / Pediatrics / Cardiology"
        >
        <small class="error-text"><?= e($errors['department'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Fee</label>
        <input
            type="number"
            step="1000"
            name="fee"
            value="<?= e($old['fee'] ?? '') ?>"
            placeholder="1500000"
        >
        <small class="error-text"><?= e($errors['fee'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Status</label>
        <select name="appointment_status">
            <option value="">Choose status</option>

            <?php foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= (($old['appointment_status'] ?? '') === $status) ? 'selected' : '' ?>
                >
                    <?= e(ucfirst($status)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="error-text"><?= e($errors['appointment_status'] ?? '') ?></small>
    </div>

    <br>

    <button type="submit">Create Appointment</button>
    <a href="/appointments" style="margin-left: 10px;">Cancel</a>
</form>