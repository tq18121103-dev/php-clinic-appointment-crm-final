<a href="/patients" class="link-back">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Quay lại danh sách
</a>

<div class="header-group" style="margin-bottom: 24px;">
    <div>
        <h1>Thêm Bệnh nhân Mới</h1>
        <p class="muted">Khai báo thông tin chi tiết để thêm hồ sơ bệnh nhân vào hệ thống.</p>
    </div>
</div>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 10px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        <span><?= e($errors['general']) ?></span>
    </div>
<?php endif; ?>

<form method="post" action="/patients" class="form-card" style="max-width: 600px;">
    <?= csrf_field() ?>
    
    <div class="form-group">
        <label>Mã Bệnh nhân</label>
        <input
            name="patient_code"
            value="<?= e($old['patient_code'] ?? '') ?>"
            placeholder="Ví dụ: PT011"
        >
        <?php if (!empty($errors['patient_code'])): ?>
            <small class="error-text"><?= e($errors['patient_code']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Họ và Tên</label>
        <input
            name="full_name"
            value="<?= e($old['full_name'] ?? '') ?>"
            placeholder="Ví dụ: Nguyễn Văn A"
        >
        <?php if (!empty($errors['full_name'])): ?>
            <small class="error-text"><?= e($errors['full_name']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input
            name="email"
            value="<?= e($old['email'] ?? '') ?>"
            placeholder="Ví dụ: patient@example.com"
        >
        <?php if (!empty($errors['email'])): ?>
            <small class="error-text"><?= e($errors['email']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Số Điện Thoại</label>
        <input
            name="phone"
            value="<?= e($old['phone'] ?? '') ?>"
            placeholder="Ví dụ: 0901234567"
        >
        <?php if (!empty($errors['phone'])): ?>
            <small class="error-text"><?= e($errors['phone']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Triệu Chứng Lâm Sàng</label>
        <input
            name="symptom"
            value="<?= e($old['symptom'] ?? '') ?>"
            placeholder="Ví dụ: Đau đầu, đau răng, đau lưng..."
        >
        <?php if (!empty($errors['symptom'])): ?>
            <small class="error-text"><?= e($errors['symptom']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Trạng Thái</label>
        <select name="status">
            <option value="">-- Chọn trạng thái --</option>
            <?php foreach (['treated', 'scheduled', 'contacted', 'new'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= (($old['status'] ?? '') === $status) ? 'selected' : '' ?>
                >
                    <?php
                    $statusVietnamese = [
                        'treated' => 'Đã điều trị',
                        'scheduled' => 'Đã xếp lịch',
                        'contacted' => 'Đã liên hệ',
                        'new' => 'Mới'
                    ];
                    echo e($statusVietnamese[$status] ?? ucfirst($status));
                    ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['status'])): ?>
            <small class="error-text"><?= e($errors['status']) ?></small>
        <?php endif; ?>
    </div>

    <div style="margin-top: 32px; display: flex; gap: 12px;">
        <button type="submit">Thêm Bệnh nhân</button>
        <a href="/patients" class="btn btn-secondary" style="line-height: 1.2;">Hủy bỏ</a>
    </div>
</form>
