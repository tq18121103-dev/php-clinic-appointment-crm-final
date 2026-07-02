<a href="/appointments" class="link-back">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Quay lại danh sách
</a>

<div class="header-group" style="margin-bottom: 24px;">
    <div>
        <h1>Cập nhật Lịch hẹn</h1>
        <p class="muted">Chỉnh sửa chi tiết thông tin lịch khám hoặc chi phí và trạng thái lịch hẹn.</p>
    </div>
</div>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 10px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        <span><?= e($errors['general']) ?></span>
    </div>
<?php endif; ?>

<form method="post" action="/appointments/update" class="form-card" style="max-width: 600px;">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) $appointment['id']) ?>">

    <div class="form-group">
        <label>Mã Lịch Hẹn</label>
        <input
            name="appointment_code"
            value="<?= e($old['appointment_code'] ?? $appointment['appointment_code']) ?>">
        <?php if (!empty($errors['appointment_code'])): ?>
            <small class="error-text"><?= e($errors['appointment_code']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>ID Bệnh nhân</label>
        <input
            name="patient_id"
            value="<?= e($old['patient_id'] ?? (string) $appointment['patient_id']) ?>">
        <?php if (!empty($errors['patient_id'])): ?>
            <small class="error-text"><?= e($errors['patient_id']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Ngày hẹn Khám</label>
        <input
            type="date"
            name="appointment_date"
            value="<?= e($old['appointment_date'] ?? $appointment['appointment_date']) ?>"
        >
        <?php if (!empty($errors['appointment_date'])): ?>
            <small class="error-text"><?= e($errors['appointment_date']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Khoa Khám Chuyên môn</label>
        <input
            type="text"
            name="department"
            value="<?= e($old['department'] ?? $appointment['department']) ?>"
            placeholder="Dentistry / Pediatrics / Cardiology"
        >
        <?php if (!empty($errors['department'])): ?>
            <small class="error-text"><?= e($errors['department']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Chi Phí Khám (VND)</label>
        <input
            type="number"
            step="1000"
            name="fee"
            value="<?= e($old['fee'] ?? (string) $appointment['fee']) ?>">
        <?php if (!empty($errors['fee'])): ?>
            <small class="error-text"><?= e($errors['fee']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Trạng Thái</label>
        <select name="appointment_status">
            <?php $currentStatus = $old['appointment_status'] ?? $appointment['appointment_status']; ?>
            <?php foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= ($currentStatus === $status) ? 'selected' : '' ?>>
                    <?php
                    $statusVietnamese = [
                        'pending' => 'Chờ khám',
                        'confirmed' => 'Đã xác nhận',
                        'completed' => 'Hoàn thành',
                        'cancelled' => 'Đã hủy'
                    ];
                    echo e($statusVietnamese[$status] ?? ucfirst($status));
                    ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['appointment_status'])): ?>
            <small class="error-text"><?= e($errors['appointment_status']) ?></small>
        <?php endif; ?>
    </div>

    <div style="margin-top: 32px; display: flex; gap: 12px;">
        <button type="submit">Cập nhật Lịch hẹn</button>
        <a href="/appointments" class="btn btn-secondary" style="line-height: 1.2;">Hủy bỏ</a>
    </div>
</form>