<div class="header-group">
    <div>
        <h1>Danh sách Bệnh nhân</h1>
        <p class="muted">Quản lý và theo dõi thông tin hồ sơ của toàn bộ bệnh nhân trong phòng khám.</p>
    </div>
    <a class="btn btn-primary" href="/patients/create">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        Thêm Bệnh nhân
    </a>
</div>

<div class="nav-wrapper">
    <form method="get" action="/patients" class="search-box">
        <input
            type="text"
            name="keyword"
            value="<?= e($keyword ?? '') ?>"
            placeholder="Tìm kiếm mã, tên, email, sđt...">
        <button type="submit" class="btn btn-primary">Tìm</button>
        <?php if (!empty($keyword)): ?>
            <a href="/patients" class="btn btn-secondary" style="line-height: 1.2;">Hủy</a>
        <?php endif; ?>
    </form>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th style="width: 80px;"><a href="/patients?keyword=<?= e($keyword ?? '') ?>&sort=id&direction=DESC" class="btn-link" style="text-decoration:none;">ID</a></th>
                <th><a href="/patients?keyword=<?= e($keyword ?? '') ?>&sort=patient_code&direction=ASC" class="btn-link" style="text-decoration:none;">Mã BN</a></th>
                <th><a href="/patients?keyword=<?= e($keyword ?? '') ?>&sort=full_name&direction=ASC" class="btn-link" style="text-decoration:none;">Họ và Tên</a></th>
                <th>Email</th>
                <th>Số Điện Thoại</th>
                <th>Triệu Chứng</th>
                <th><a href="/patients?keyword=<?= e($keyword ?? '') ?>&sort=status&direction=ASC" class="btn-link" style="text-decoration:none;">Trạng Thái</a></th>
                <th>Ngày Tạo</th>
                <th style="width: 140px; text-align: center;">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($patients)): ?>
                <tr>
                    <td colspan="9" style="text-align: center;" class="muted">Không tìm thấy bệnh nhân nào.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td class="muted">#<?= e((string) $patient['id']) ?></td>
                    <td style="font-weight: 600; color: var(--primary);"><?= e($patient['patient_code']) ?></td>
                    <td style="font-weight: 500;"><?= e($patient['full_name']) ?></td>
                    <td><?= e($patient['email']) ?></td>
                    <td><?= e($patient['phone']) ?></td>
                    <td class="muted"><?= e($patient['symptom']) ?></td>
                    <td>
                        <?php
                        $statusClass = 'badge-new';
                        $statusLabel = 'Mới';
                        if ($patient['status'] === 'contacted') {
                            $statusClass = 'badge-active';
                            $statusLabel = 'Đã liên hệ';
                        } elseif ($patient['status'] === 'scheduled') {
                            $statusClass = 'badge-confirmed';
                            $statusLabel = 'Đã xếp lịch';
                        } elseif ($patient['status'] === 'treated') {
                            $statusClass = 'badge-completed';
                            $statusLabel = 'Đã điều trị';
                        } elseif ($patient['status'] === 'cancelled') {
                            $statusClass = 'badge-cancelled';
                            $statusLabel = 'Đã hủy';
                        }
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                    </td>
                    <td class="muted" style="font-size: 13px;"><?= e(date('d/m/Y H:i', strtotime($patient['created_at']))) ?></td>
                    <td style="text-align: center;">
                        <a href="/patients/edit?id=<?= e((string) $patient['id']) ?>" class="btn-link" style="margin-right: 12px; font-weight: 600; text-decoration: none;">Sửa</a>

                        <form
                            method="post"
                            action="/patients/delete"
                            style="display:inline;"
                            onsubmit="return confirm('Bạn chắc chắn muốn xóa bệnh nhân này?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= e((string) $patient['id']) ?>">
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
                href="/patients?keyword=<?= e($keyword ?? '') ?>&page=<?= $i ?>"
                class="pagination-link <?= ($i === ($page ?? 1)) ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>