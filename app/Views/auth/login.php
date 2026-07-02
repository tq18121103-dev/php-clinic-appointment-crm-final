<div class="auth-card">
    <div class="auth-header">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 12px; display: inline-block;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        <h1>Đăng nhập Clinic CRM</h1>
        <p>Hệ thống quản lý thông tin phòng khám</p>
    </div>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert error" style="margin-bottom: 20px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 10px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <span><?= e($errors['general']) ?></span>
        </div>
    <?php endif; ?>

    <form method="post" action="/login">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label>Tên đăng nhập</label>
            <input
                name="username"
                value="<?= e($old['username'] ?? '') ?>"
                placeholder="admin hoặc staff1"
            >
            <?php if (!empty($errors['username'])): ?>
                <small class="error-text"><?= e($errors['username']) ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Mật khẩu</label>
            <input
                type="password"
                name="password"
                placeholder="Nhập mật khẩu..."
            >
            <?php if (!empty($errors['password'])): ?>
                <small class="error-text"><?= e($errors['password']) ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 8px; margin-top: 12px;">
            <input type="checkbox" name="remember" value="1" style="width: auto; margin: 0; box-shadow: none; cursor: pointer;">
            <span class="muted" style="font-size: 14px; user-select: none;">Ghi nhớ đăng nhập</span>
        </div>

        <button type="submit" style="width: 100%; margin-top: 12px; margin-bottom: 20px;">Đăng Nhập</button>

        <div class="muted" style="text-align: center; font-size: 13px; border-top: 1px solid var(--border); padding-top: 16px;">
            Tài khoản demo: <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: var(--text);">admin</code> / <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: var(--text);">123456</code>
        </div>
    </form>
</div>