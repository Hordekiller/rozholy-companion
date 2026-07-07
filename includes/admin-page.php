<?php

add_action('admin_menu', 'rozholy_companion_admin_menu');
function rozholy_companion_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=rz_booking',
        esc_html__('مدیریت رزروها', 'rozholy-companion'),
        esc_html__('مدیریت رزروها', 'rozholy-companion'),
        'manage_options',
        'rz-booking-manager',
        'rozholy_companion_booking_page'
    );

    add_menu_page(
        esc_html__('Rozholy', 'rozholy-companion'),
        esc_html__('Rozholy', 'rozholy-companion'),
        'manage_options',
        'rozholy-dashboard',
        'rozholy_companion_dashboard_page',
        'dashicons-pets',
        3
    );
}

add_action('admin_enqueue_scripts', 'rozholy_companion_admin_assets');
function rozholy_companion_admin_assets($hook) {
    $admin_pages = ['toplevel_page_rozholy-dashboard', 'rz_booking_page_rz-booking-manager'];
    if (!in_array($hook, $admin_pages, true)) return;

    wp_enqueue_style('wp-components');
    wp_enqueue_style('rozholy-companion-admin', ROZHOLY_COMPANION_URI . 'build/admin.css', ['wp-components'], ROZHOLY_COMPANION_VERSION);

    $asset_file = ROZHOLY_COMPANION_DIR . 'build/admin.asset.php';
    $deps = ['wp-components', 'wp-element', 'wp-i18n', 'wp-api-fetch', 'wp-data', 'wp-notices', 'wp-hooks'];
    $version = ROZHOLY_COMPANION_VERSION;
    if (file_exists($asset_file)) {
        $asset = include $asset_file;
        $deps = array_merge($deps, $asset['dependencies'] ?? []);
        $version = $asset['version'] ?? $version;
    }

    wp_enqueue_script('rozholy-companion-admin', ROZHOLY_COMPANION_URI . 'build/admin.js', $deps, $version, true);

    wp_localize_script('rozholy-companion-admin', 'rozholyCompanion', [
        'restUrl'  => rest_url('rozholy-companion/v1/'),
        'nonce'    => wp_create_nonce('wp_rest'),
        'adminUrl' => admin_url(),
        'i18n'     => [
            'title'             => esc_html__('مدیریت رزروها', 'rozholy-companion'),
            'noBookings'        => esc_html__('هیچ رزروی یافت نشد', 'rozholy-companion'),
            'loading'           => esc_html__('در حال بارگذاری...', 'rozholy-companion'),
            'errorLoad'         => esc_html__('خطا در بارگذاری رزروها', 'rozholy-companion'),
            'confirmDelete'     => esc_html__('آیا از حذف این رزرو اطمینان دارید؟', 'rozholy-companion'),
            'deleted'           => esc_html__('رزرو حذف شد', 'rozholy-companion'),
            'updated'           => esc_html__('وضعیت به‌روزرسانی شد', 'rozholy-companion'),
            'name'              => esc_html__('نام', 'rozholy-companion'),
            'phone'             => esc_html__('شماره تماس', 'rozholy-companion'),
            'service'           => esc_html__('خدمت', 'rozholy-companion'),
            'bookingDate'       => esc_html__('تاریخ رزرو', 'rozholy-companion'),
            'message'           => esc_html__('پیام', 'rozholy-companion'),
            'status'            => esc_html__('وضعیت', 'rozholy-companion'),
            'actions'           => esc_html__('عملیات', 'rozholy-companion'),
            'filterAll'         => esc_html__('همه', 'rozholy-companion'),
            'filterPending'     => esc_html__('در انتظار', 'rozholy-companion'),
            'filterConfirmed'   => esc_html__('تایید شده', 'rozholy-companion'),
            'filterCompleted'   => esc_html__('انجام شده', 'rozholy-companion'),
            'filterCancelled'   => esc_html__('لغو شده', 'rozholy-companion'),
            'markConfirmed'     => esc_html__('تایید', 'rozholy-companion'),
            'markCompleted'     => esc_html__('انجام شده', 'rozholy-companion'),
            'markCancelled'     => esc_html__('لغو', 'rozholy-companion'),
            'delete'            => esc_html__('حذف', 'rozholy-companion'),
            'viewDetails'       => esc_html__('جزئیات', 'rozholy-companion'),
        ],
    ]);
}

function rozholy_companion_booking_page() {
    echo '<div id="rz-booking-root" class="rz-admin-wrap"></div>';
}

function rozholy_companion_dashboard_page() {
    ?>
    <div class="wrap rz-dashboard-wrap">
        <h1><?php esc_html_e('داشبورد Rozholy', 'rozholy-companion'); ?></h1>
        <div class="rz-dashboard-grid">
            <div class="rz-dashboard-card">
                <h3><?php esc_html_e('رزروها', 'rozholy-companion'); ?></h3>
                <p class="rz-dashboard-stat"><?php echo wp_count_posts('rz_booking')->publish ?? 0; ?></p>
                <a href="<?php echo admin_url('edit.php?post_type=rz_booking&page=rz-booking-manager'); ?>" class="button button-primary">
                    <?php esc_html_e('مدیریت رزروها', 'rozholy-companion'); ?>
                </a>
            </div>
            <div class="rz-dashboard-card">
                <h3><?php esc_html_e('بلاک‌های سفارشی', 'rozholy-companion'); ?></h3>
                <p><?php esc_html_e('از بلاک‌های Rozholy در ویرایشگر استفاده کنید.', 'rozholy-companion'); ?></p>
                <a href="<?php echo admin_url('post-new.php?post_type=page'); ?>" class="button">
                    <?php esc_html_e('ساخت صفحه جدید', 'rozholy-companion'); ?>
                </a>
            </div>
        </div>
    </div>
    <style>
        .rz-dashboard-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:24px; margin-top:24px; }
        .rz-dashboard-card { background:#fff; border:1px solid #e2e4e7; border-radius:8px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.04); }
        .rz-dashboard-card h3 { margin:0 0 8px; font-size:1.1rem; }
        .rz-dashboard-stat { font-size:2.5rem; font-weight:700; color:#d4a0a0; margin:8px 0 16px; }
        .rz-admin-wrap { margin:20px 0; }
    </style>
    <?php
}
