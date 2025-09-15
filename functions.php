<?php
if (!defined('ABSPATH')) exit;

add_action('after_setup_theme', 'petyar_theme_setup');

function petyar_flush_rewrites()
{
    flush_rewrite_rules();
}

add_action('after_switch_theme', 'petyar_flush_rewrites');

if (!defined('THEME_ASSETS')) {
    define('THEME_ASSETS', get_template_directory_uri() . '/assets');
}

function petyar_enqueue_assets()
{
    wp_enqueue_style('petyar-main', THEME_ASSETS . '/css/Main.css', [], null);
    wp_enqueue_style('petyar-menu', THEME_ASSETS . '/css/Menu.css', [], null);
    wp_enqueue_style('petyar-style', THEME_ASSETS . '/css/Style.css', [], null);
    wp_enqueue_style('petyar-owl-css', THEME_ASSETS . '/css/owl.carousel.min.css', [], null);
    wp_enqueue_style('petyar-owl-theme', THEME_ASSETS . '/css/owl.theme.min.css', [], null);
    wp_enqueue_script('jquery');
    wp_enqueue_script('petyar-bootstrap', THEME_ASSETS . '/js/bootstrap.min.js', ['jquery'], null, true);
    wp_enqueue_script('petyar-main-js', THEME_ASSETS . '/js/my-script.js', ['jquery'], null, true);
    wp_enqueue_script('petyar-owl-js', THEME_ASSETS . '/js/owl.carousel.js', ['jquery'], null, true);
    wp_enqueue_script('petyar-custom-js', THEME_ASSETS . '/js/custom.js', ['jquery'], null, true);
}

add_action('wp_enqueue_scripts', 'petyar_enqueue_assets');

add_theme_support('custom-logo');
function petyar_register_product_cpt()
{
    register_post_type('product', [
        'labels' => [
            'name' => __('محصولات', 'petyar'),
            'singular_name' => __('محصول', 'petyar'),
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'shop', 'with_front' => false],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true,
    ]);

    register_taxonomy('product_category', 'product', [
        'labels' => [
            'name' => __('دسته‌بندی محصولات', 'petyar'),
            'singular_name' => __('دسته‌بندی محصول', 'petyar'),
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'rewrite' => ['slug' => 'shop', 'with_front' => false],
        'show_in_rest' => true,
    ]);
}

add_action('init', 'petyar_register_product_cpt');

add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails', ['product']);
});
add_action('add_meta_boxes', function () {
    add_meta_box(
        'petyar_product_meta',
        __('جزئیات محصول', 'petyar'),
        'petyar_render_product_meta',
        'product',
        'normal',
        'high'
    );
});

function petyar_render_product_meta($post)
{
    wp_nonce_field('petyar_save_product_meta', 'petyar_product_meta_nonce');

    $price    = get_post_meta($post->ID, 'product_price', true);
    $quantity = get_post_meta($post->ID, 'product_quantity', true);

    $thumb_id  = get_post_thumbnail_id($post->ID);
    $thumb_src = $thumb_id
        ? wp_get_attachment_image_src($thumb_id, 'thumbnail')[0]
        : '';
?>
    <p>
        <label for="product_price"><?php _e('قیمت (تومان):', 'petyar'); ?></label>
        <input type="text" id="product_price" name="product_price"
            value="<?php echo esc_attr($price); ?>" class="widefat">
    </p>

    <p>
        <label for="product_quantity"><?php _e('تعداد موجود:', 'petyar'); ?></label>
        <input type="number" id="product_quantity" name="product_quantity"
            value="<?php echo esc_attr($quantity); ?>" class="widefat">
    </p>

    <p>
        <label><?php _e('تصویر شاخص:', 'petyar'); ?></label>
    </p>
    <div id="petyar-preview-image" style="margin-bottom:10px;">
        <?php if ($thumb_src): ?>
            <img src="<?php echo esc_url($thumb_src); ?>"
                style="max-width:100%; height:auto;">
        <?php endif; ?>
    </div>
    <input type="hidden" id="petyar_product_image"
        name="petyar_product_image"
        value="<?php echo esc_attr($thumb_id); ?>">

    <button type="button" class="button" id="petyar_upload_image_button">
        <?php esc_html_e('انتخاب تصویر شاخص', 'petyar'); ?>
    </button>
    <button type="button" class="button" id="petyar_remove_image_button">
        <?php esc_html_e('حذف تصویر شاخص', 'petyar'); ?>
    </button>

    <script>
        jQuery(function($) {
            var frame;
            $('#petyar_upload_image_button').on('click', function(e) {
                e.preventDefault();
                if (frame) {
                    frame.open();
                    return;
                }
                frame = wp.media({
                    title: '<?php esc_js('انتخاب تصویر شاخص', 'petyar'); ?>',
                    button: {
                        text: '<?php esc_js('انتخاب شود', 'petyar'); ?>'
                    },
                    multiple: false
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection')
                        .first().toJSON();
                    $('#petyar_product_image').val(attachment.id);
                    $('#petyar-preview-image').html(
                        '<img src="' + attachment.sizes.thumbnail.url +
                        '" style="max-width:100%;height:auto;">'
                    );
                });
                frame.open();
            });

            $('#petyar_remove_image_button').on('click', function() {
                $('#petyar_product_image').val('');
                $('#petyar-preview-image').html('');
            });
        });
    </script>
<?php
}

add_action('save_post_product', function ($post_id) {
    if (
        ! isset($_POST['petyar_product_meta_nonce']) ||
        ! wp_verify_nonce($_POST['petyar_product_meta_nonce'], 'petyar_save_product_meta') ||
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
        ! current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    if (isset($_POST['product_price'])) {
        update_post_meta(
            $post_id,
            'product_price',
            sanitize_text_field($_POST['product_price'])
        );
    }
    if (isset($_POST['product_quantity'])) {
        update_post_meta(
            $post_id,
            'product_quantity',
            intval($_POST['product_quantity'])
        );
    }

    if (isset($_POST['petyar_product_image'])) {
        $thumb_id = intval($_POST['petyar_product_image']);
        if ($thumb_id) {
            set_post_thumbnail($post_id, $thumb_id);
        } else {
            delete_post_thumbnail($post_id);
        }
    }
});

add_action('after_setup_theme', 'petyar_setup_lost_found_thumbnails');
function petyar_setup_lost_found_thumbnails()
{
    add_theme_support('post-thumbnails', ['lost_found']);
}

add_action('init', 'petyar_register_lost_found_cpt');
function petyar_register_lost_found_cpt()
{
    register_post_type('lost_found', [
        'labels'       => [
            'name'          => __('آگهی گم/پیدا شده', 'petyar'),
            'singular_name' => __('آگهی', 'petyar'),
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'lost-found', 'with_front' => false],

        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true,
    ]);

    register_taxonomy('lf_status', 'lost_found', [
        'labels'            => [
            'name'          => __('وضعیت', 'petyar'),
            'singular_name' => __('وضعیت آگهی', 'petyar'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'status', 'with_front' => false],
        'show_in_rest'      => true,
    ]);

    register_taxonomy('lf_species', 'lost_found', [
        'labels'            => [
            'name'          => __('نوع حیوان', 'petyar'),
            'singular_name' => __('نوع حیوان', 'petyar'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'species', 'with_front' => false],
        'show_in_rest'      => true,
    ]);
}

add_action('customize_register', 'petyar_customize_contact_info');
function petyar_customize_contact_info($wp_customize)
{
    $wp_customize->add_section('petyar_contact_section', [
        'title' => __('اطلاعات تماس', 'petyar'),
        'priority' => 160,
    ]);
    $wp_customize->add_setting('petyar_contact_address', [
        'default' => 'تهران، زعفرانیه، خیابان مقدس اردبیلی',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('petyar_contact_address', [
        'label' => __('آدرس:', 'petyar'),
        'section' => 'petyar_contact_section',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('petyar_contact_email', [
        'default' => 'amixrzie@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ]);
    $wp_customize->add_control('petyar_contact_email', [
        'label' => __('ایمیل:', 'petyar'),
        'section' => 'petyar_contact_section',
        'type' => 'email',
    ]);

    $wp_customize->add_setting('petyar_contact_phone', [
        'default' => '09035686251',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('petyar_contact_phone', [
        'label' => __('تلفن تماس:', 'petyar'),
        'section' => 'petyar_contact_section',
        'type' => 'text',
    ]);
}

add_action('init', 'petyar_cart_session_handler');
function petyar_cart_session_handler()
{
    if (!session_id()) {
        session_start();
    }
    if (isset($_GET['add-to-cart'])) {
        $pid = absint($_GET['add-to-cart']);
        if ($pid > 0) {
            if (empty($_SESSION['cart'][$pid])) {
                $_SESSION['cart'][$pid] = 1;
            } else {
                $_SESSION['cart'][$pid]++;
            }
        }
        wp_safe_redirect(remove_query_arg('add-to-cart'));
        exit;
    }

    if (isset($_GET['remove-from-cart'])) {
        $pid = absint($_GET['remove-from-cart']);
        if (isset($_SESSION['cart'][$pid])) {
            unset($_SESSION['cart'][$pid]);
        }
        wp_safe_redirect(remove_query_arg('remove-from-cart'));
        exit;
    }

    if (isset($_POST['update_cart'], $_POST['quantity']) && is_array($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $pid => $qty) {
            $pid = absint($pid);
            $qty = absint($qty);
            if ($qty < 1) {
                unset($_SESSION['cart'][$pid]);
            } else {
                $_SESSION['cart'][$pid] = $qty;
            }
        }
        wp_safe_redirect($_SERVER['REQUEST_URI']);
        exit;
    }
}

add_action('init', function () {
    if (!session_id()) {
        session_start();
    }
});

add_action('init', 'petyar_handle_place_order');
function petyar_handle_place_order()
{
    if (isset($_POST['place_order'])) {
        $billing = [
            'first_name' => sanitize_text_field($_POST['billing_first_name'] ?? ''),
            'last_name' => sanitize_text_field($_POST['billing_last_name'] ?? ''),
            'company' => sanitize_text_field($_POST['billing_company'] ?? ''),
            'country' => sanitize_text_field($_POST['billing_country'] ?? ''),
            'state' => sanitize_text_field($_POST['billing_state'] ?? ''),
            'city' => sanitize_text_field($_POST['billing_city'] ?? ''),
            'address1' => sanitize_text_field($_POST['billing_address1'] ?? ''),
            'address2' => sanitize_text_field($_POST['billing_address2'] ?? ''),
            'postcode' => sanitize_text_field($_POST['billing_postcode'] ?? ''),
            'phone' => sanitize_text_field($_POST['billing_phone'] ?? ''),
            'email' => sanitize_email($_POST['billing_email'] ?? ''),
        ];

        $_SESSION['last_order'] = [
            'billing' => $billing,
            'cart' => $_SESSION['cart'] ?? [],
            'date' => current_time('mysql'),
        ];

        unset($_SESSION['cart']);

        wp_safe_redirect(get_permalink(get_page_by_path('thank-you')));
        exit;
    }
}


add_action('after_switch_theme', 'petyar_add_custom_roles');
function petyar_add_custom_roles()
{
    add_role(
        'lf_submitter',
        __('آگهی‌دهنده', 'petyar'),
        [
            'read' => true,
            'edit_lost_found' => true,
            'edit_others_lost_found' => false,
            'publish_lost_found' => false,
            'upload_files' => true,
        ]
    );
}

add_filter('login_redirect', 'petyar_login_redirect', 10, 3);
function petyar_login_redirect($redirect_to, $request, $user)
{
    if (isset($user->roles) && is_array($user->roles)) {
        return home_url('/dashboard/');
    }
    return $redirect_to;
}


add_action('template_redirect', 'petyar_handle_registration');
function petyar_handle_registration()
{
    if (!is_page('register')) {
        return;
    }

    if (is_user_logged_in()) {
        wp_safe_redirect(home_url('/dashboard/'));
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['petyar_register_nonce'])) {
    }
}


add_action('template_redirect', 'petyar_dashboard_protection');
function petyar_dashboard_protection()
{
    if (is_page_template('page-dashboard.php')) {
        if (!is_user_logged_in() || !current_user_can('edit_lost_found')) {
            wp_safe_redirect(home_url('/login/'));
            exit;
        }
    }
}


add_action('after_setup_theme', 'petyar_theme_setup');
function petyar_theme_setup()
{
    add_theme_support('custom-logo', [
        'height' => 40,
        'width' => 80,
        'flex-width' => false,
        'flex-height' => false,
    ]);
    register_nav_menus([
        'main_menu' => __('منوی اصلی', 'petyar'),
    ]);
}

add_action('customize_register', 'petyar_customize_header');
function petyar_customize_header($wp_customize)
{
    $wp_customize->add_section('petyar_header_section', [
        'title' => __('تنظیمات هدر', 'petyar'),
        'priority' => 30,
    ]);

    $pages = [
        'home' => __('صفحهٔ اصلی', 'petyar'),
        'shop' => __('صفحهٔ محصولات', 'petyar'),
        'lostfound' => __('صفحهٔ گم/پیدا شده', 'petyar'),
        'about' => __('صفحهٔ درباره ما', 'petyar'),
        'contact' => __('صفحهٔ ارتباط با ما', 'petyar'),
    ];

    foreach ($pages as $key => $label) {
        $setting_id = "petyar_{$key}_page";

        $wp_customize->add_setting($setting_id, [
            'default' => 0,
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            $setting_id . '_control',
            [
                'label' => $label,
                'section' => 'petyar_header_section',
                'settings' => $setting_id,
                'type' => 'dropdown-pages',
            ]
        ));
    }
}
