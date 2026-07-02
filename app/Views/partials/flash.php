<?php if ($message = get_flash('success')): ?>
    <div class="alert success">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 10px; flex-shrink: 0;"><polyline points="20 6 9 17 4 12"/></svg>
        <span><?= e($message) ?></span>
    </div>
<?php endif; ?>

<?php if ($message = get_flash('error')): ?>
    <div class="alert error">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 10px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        <span><?= e($message) ?></span>
    </div>
<?php endif; ?>