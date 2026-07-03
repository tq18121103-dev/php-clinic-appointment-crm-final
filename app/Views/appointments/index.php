<div class="header-group">
    <div>
        <h1>Danh sách Lịch hẹn Khám</h1>
        <p class="muted">Theo dõi và sắp xếp lịch khám chuyên khoa của các bệnh nhân.</p>
    </div>
    <a class="btn btn-primary" href="/appointments/create">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
            <line x1="12" x2="12" y1="5" y2="19" />
            <line x1="5" x2="19" y1="12" y2="12" />
        </svg>
        Tạo Lịch hẹn
    </a>
</div>

<div class="nav-wrapper">
    <form method="get" action="/appointments" class="search-box">
        <input
            type="text"
            name="keyword"
            value="<?= e($keyword ?? '') ?>"
            placeholder="Tìm mã lịch hẹn, tên bệnh nhân...">
        <button type="submit" class="btn btn-primary">Tìm</button>
        <?php if (!empty($keyword)): ?>
            <a href="/appointments" class="btn btn-secondary" style="line-height: 1.2;">Hủy</a>
        <?php endif; ?>
    </form>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th style="width: 80px;"><a href="/appointments?keyword=<?= e($keyword ?? '') ?>&sort=id&direction=DESC" class="btn-link" style="text-decoration:none;">ID</a></th>
                <th><a href="/appointments?keyword=<?= e($keyword ?? '') ?>&sort=appointment_code&direction=ASC" class="btn-link" style="text-decoration:none;">Mã Lịch Hẹn</a></th>
                <th>Bệnh Nhân</th>
                <th>Khoa Khám</th>
                <th>Ngày Hẹn Khám</th>
                <th><a href="/appointments?keyword=<?= e($keyword ?? '') ?>&sort=fee&direction=DESC" class="btn-link" style="text-decoration:none;">Chi Phí</a></th>
                <th><a href="/appointments?keyword=<?= e($keyword ?? '') ?>&sort=appointment_status&direction=ASC" class="btn-link" style="text-decoration:none;">Trạng Thái</a></th>
                <th>Ngày Tạo</th>
                <th style="width: 140px; text-align: center;">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($appointments)): ?>
                <tr>
                    <td colspan="9" style="text-align: center;" class="muted">Không tìm thấy lịch hẹn nào.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td class="muted">#<?= e((string) $appointment['id']) ?></td>
                    <td style="font-weight: 600; color: var(--primary);"><?= e($appointment['appointment_code']) ?></td>
                    <td style="font-weight: 500;"><?= e($appointment['patient_name'] ?? 'Bệnh nhân ẩn danh') ?></td>
                    <td style="font-weight: 500; color: var(--info-text);"><?= e($appointment['department'] ?? '-') ?></td>
                    <td style="font-weight: 500;"><?= e(!empty($appointment['appointment_date']) ? date('d/m/Y', strtotime($appointment['appointment_date'])) : '-') ?></td>
                    <td style="font-weight: 600; color: #059669;"><?= e(number_format((float) $appointment['fee'])) ?>đ</td>
                    <td>
                        <?php
                        $statusClass = 'badge-pending';
                        $statusLabel = 'Chờ khám';
                        if ($appointment['appointment_status'] === 'confirmed') {
                            $statusClass = 'badge-confirmed';
                            $statusLabel = 'Đã xác nhận';
                        } elseif ($appointment['appointment_status'] === 'completed') {
                            $statusClass = 'badge-completed';
                            $statusLabel = 'Hoàn thành';
                        } elseif ($appointment['appointment_status'] === 'cancelled') {
                            $statusClass = 'badge-cancelled';
                            $statusLabel = 'Đã hủy';
                        }
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                    </td>
                    <td class="muted" style="font-size: 13px;"><?= e(date('d/m/Y H:i', strtotime($appointment['created_at']))) ?></td>
                    <td style="text-align: center;">
                        <a href="/appointments/edit?id=<?= e((string) $appointment['id']) ?>" class="btn-link" style="margin-right: 12px; font-weight: 600; text-decoration: none;">Sửa</a>

                        <form
                            method="post"
                            action="/appointments/delete"
                            style="display:inline;"
                            onsubmit="return confirm('Bạn chắc chắn muốn xóa lịch hẹn này?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= e((string) $appointment['id']) ?>">
                            <button type="submit" class="link-button" style="font-weight: 600;">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (($totalPages ?? 1) > 1): ?>
    <div class="pagination">
        <span class="muted" style="margin-right: 8px;">Trang:</span>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a
                href="/appointments?keyword=<?= e($keyword ?? '') ?>&page=<?= $i ?>"
                class="pagination-link <?= ($i === ($page ?? 1)) ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>