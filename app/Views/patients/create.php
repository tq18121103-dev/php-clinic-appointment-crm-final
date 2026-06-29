<h1>Create Patient</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <?= e($errors['general']) ?>
    </div>
<?php endif; ?>

<form method="post" action="/patients" class="card form-card">
    <?= csrf_field() ?>
    <div>
        <label>Patient Code</label>
        <input
            name="patient_code"
            value="<?= e($old['patient_code'] ?? '') ?>"
            placeholder="PT011"
        >
        <small class="error-text"><?= e($errors['patient_code'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Full Name</label>
        <input
            name="full_name"
            value="<?= e($old['full_name'] ?? '') ?>"
            placeholder="Nguyen Van A"
        >
        <small class="error-text"><?= e($errors['full_name'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Email</label>
        <input
            name="email"
            value="<?= e($old['email'] ?? '') ?>"
            placeholder="patient@example.com"
        >
        <small class="error-text"><?= e($errors['email'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Phone</label>
        <input
            name="phone"
            value="<?= e($old['phone'] ?? '') ?>"
            placeholder="0901234567"
        >
        <small class="error-text"><?= e($errors['phone'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Symptom</label>
        <input
            name="symptom"
            value="<?= e($old['symptom'] ?? '') ?>"
            placeholder="Back pain / Toothache / Headache"
        >
        <small class="error-text"><?= e($errors['symptom'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="">Choose status</option>

            <?php foreach (['treated', 'scheduled', 'contacted', 'new'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= (($old['status'] ?? '') === $status) ? 'selected' : '' ?>
                >
                    <?= e(ucfirst($status)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="error-text"><?= e($errors['status'] ?? '') ?></small>
    </div>

    <br>

    <button type="submit">Create Patient</button>
    <a href="/patients" style="margin-left: 10px;">Cancel</a>
</form>
