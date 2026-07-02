<div class="header-group">
    <div>
        <h1>Bảng Điều Khiển</h1>
        <p class="muted">Chào mừng quay trở lại, <strong style="color: var(--text); font-weight: 600;"><?= e($_SESSION['username'] ?? 'User') ?></strong>. Chúc bạn có một ngày làm việc hiệu quả!</p>
    </div>
</div>

<div class="cards" style="margin-top: 8px;">
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 220px;">
        <div>
            <div style="background: var(--primary-light); width: 48px; height: 48px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: var(--primary);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h2 style="margin-bottom: 8px;">Hồ sơ Bệnh nhân</h2>
            <p class="muted" style="font-size: 14px;">Quản lý hồ sơ bệnh án, triệu chứng lâm sàng, tìm kiếm nâng cao, phân trang và cập nhật thông tin bệnh nhân.</p>
        </div>
        <div style="margin-top: 24px;">
            <a href="/patients" class="btn btn-primary" style="font-size: 13px; width: 100%;">Truy cập ngay &rarr;</a>
        </div>
    </div>

    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 220px;">
        <div>
            <div style="background: var(--info-bg); width: 48px; height: 48px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: var(--info);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <h2 style="margin-bottom: 8px;">Lịch hẹn Khám</h2>
            <p class="muted" style="font-size: 14px;">Điều phối lịch khám bệnh theo khoa chuyên môn, quản lý mã lịch hẹn, chi phí khám và theo dõi trạng thái lịch hẹn.</p>
        </div>
        <div style="margin-top: 24px;">
            <a href="/appointments" class="btn btn-primary" style="font-size: 13px; width: 100%; background: var(--info); hover: background: var(--info-text);">Truy cập ngay &rarr;</a>
        </div>
    </div>

    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 220px;">
        <div>
            <div style="background: var(--success-bg); width: 48px; height: 48px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: var(--success);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h2 style="margin-bottom: 8px;">Hệ thống Bảo mật</h2>
            <p class="muted" style="font-size: 14px;">Bảo vệ phiên đăng nhập an toàn, cơ chế tự động làm mới Session ID, chống tấn công CSRF và tự động hết hạn phiên rảnh.</p>
        </div>
        <div style="margin-top: 24px; padding: 10px 0; text-align: center; border-radius: var(--radius-sm); background: var(--success-bg); color: var(--success-text); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">
            Đang được bảo vệ
        </div>
    </div>
</div>