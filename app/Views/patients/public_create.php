<div class="auth-card" style="max-width: 540px;">
    <div class="auth-header">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 12px; display: inline-block;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        <h1>Đăng Ký Khám Bệnh</h1>
        <p>Vui lòng khai báo thông tin để được xếp lịch khám sớm nhất</p>
    </div>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert error" style="margin-bottom: 20px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 10px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <span><?= e($errors['general']) ?></span>
        </div>
    <?php endif; ?>

    <form method="post" action="/public-patients">
        <?= csrf_field() ?>

        <!-- Honeypot Field (Chống Spam) -->
        <div style="display:none;">
            <label>Website URL (Vui lòng để trống)</label>
            <input type="text" name="website_url" value="">
        </div>

        <!-- Mặc định trạng thái bệnh nhân đăng ký công khai là 'new' -->
        <input type="hidden" name="status" value="new">

        <div class="form-group">
            <label>Mã Bệnh nhân (Yêu cầu duy nhất)</label>
            <input
                name="patient_code"
                value="<?= e($old['patient_code'] ?? '') ?>"
                placeholder="Ví dụ: PT088"
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
            <label>Email liên hệ</label>
            <input
                name="email"
                value="<?= e($old['email'] ?? '') ?>"
                placeholder="Ví dụ: benhnhan@gmail.com"
            >
            <?php if (!empty($errors['email'])): ?>
                <small class="error-text"><?= e($errors['email']) ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Số điện thoại di động</label>
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
            <label>Triệu chứng bệnh lý</label>
            <input
                name="symptom"
                value="<?= e($old['symptom'] ?? '') ?>"
                placeholder="Ví dụ: Đau đầu, sốt cao..."
            >
            <?php if (!empty($errors['symptom'])): ?>
                <small class="error-text"><?= e($errors['symptom']) ?></small>
            <?php endif; ?>
        </div>

        <button type="submit" style="width: 100%; margin-top: 16px;">Gửi thông tin Đăng ký</button>
    </form>
</div>
