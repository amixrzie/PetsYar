
<?php
// جلوگیری از دسترسی مستقیم
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 1. فعال‌سازی قابلیت‌های قالب، منوها و ترجمه
 */
// function petyar_theme_setup() {
//     add_theme_support( 'title-tag' );
//     add_theme_support( 'post-thumbnails' );
//     load_theme_textdomain( 'petyar', get_template_directory() . '/languages' );
//     register_nav_menus( [
//         'main_menu'   => __( 'منوی اصلی', 'petyar' ),
//         'footer_menu' => __( 'منوی فوتر',  'petyar' ),
//     ] );
// }
add_action( 'after_setup_theme', 'petyar_theme_setup' );

/**
 * 2. فلش کردن بازنویسی پرمالینک‌ها پس از فعال‌سازی قالب
 */
function petyar_flush_rewrites() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'petyar_flush_rewrites' );

/**
 * 3. تعریف مسیر ثابت برای assets
 */
if ( ! defined( 'THEME_ASSETS' ) ) {
    define( 'THEME_ASSETS', get_template_directory_uri() . '/assets' );
}

/**
 * 4. بارگذاری استایل‌ها و اسکریپت‌ها
 */
function petyar_enqueue_assets() {
    // CSS
    wp_enqueue_style( 'petyar-main',      THEME_ASSETS . '/css/Main.css',           [], null );
    wp_enqueue_style( 'petyar-menu',      THEME_ASSETS . '/css/Menu.css',           [], null );
    wp_enqueue_style( 'petyar-style',     THEME_ASSETS . '/css/Style.css',          [], null );
    wp_enqueue_style( 'petyar-owl-css',   THEME_ASSETS . '/css/owl.carousel.min.css',[], null );
    wp_enqueue_style( 'petyar-owl-theme', THEME_ASSETS . '/css/owl.theme.min.css',   [], null );

    // JS
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'petyar-bootstrap', THEME_ASSETS . '/js/bootstrap.min.js', ['jquery'], null, true );
    wp_enqueue_script( 'petyar-main-js',   THEME_ASSETS . '/js/my-script.js',      ['jquery'], null, true );
    wp_enqueue_script( 'petyar-owl-js',    THEME_ASSETS . '/js/owl.carousel.js',   ['jquery'], null, true );
    wp_enqueue_script( 'petyar-custom-js', THEME_ASSETS . '/js/custom.js',         ['jquery'], null, true );
}
add_action( 'wp_enqueue_scripts', 'petyar_enqueue_assets' );

/**
 * 5. ثبت CPT «محصول» و تکسونومی دسته‌بندی محصول
 */
function petyar_register_product_cpt() {
    register_post_type( 'product', [
        'labels'       => [
            'name'          => __( 'محصولات', 'petyar' ),
            'singular_name' => __( 'محصول',  'petyar' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'shop', 'with_front' => false ],
        'supports'     => [ 'title','editor','thumbnail','excerpt' ],
        'show_in_rest' => true,
    ] );

    register_taxonomy( 'product_category', 'product', [
        'labels'            => [
            'name'          => __( 'دسته‌بندی محصولات', 'petyar' ),
            'singular_name' => __( 'دسته‌بندی محصول',  'petyar' ),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'shop', 'with_front' => false ],
        'show_in_rest'      => true,
    ] );
}
add_action( 'init', 'petyar_register_product_cpt' );

/**
 * 6. متاباکس جزئیات محصول (قیمت و تعداد)
 */
function petyar_add_product_meta_boxes() {
    add_meta_box(
        'petyar_product_meta',
        __( 'جزئیات محصول', 'petyar' ),
        'petyar_render_product_meta',
        'product',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'petyar_add_product_meta_boxes' );

function petyar_render_product_meta( $post ) {
    wp_nonce_field( 'petyar_save_product_meta', 'petyar_product_meta_nonce' );
    $price    = get_post_meta( $post->ID, 'product_price',    true );
    $quantity = get_post_meta( $post->ID, 'product_quantity', true );
    ?>
    <p>
      <label for="product_price"><?php _e( 'قیمت (تومان):', 'petyar' ); ?></label>
      <input type="text" id="product_price" name="product_price"

ልጠፗዩ.ዘ.ዐ. 2024, [9/14/2025 3:36 PM]
value="<?php echo esc_attr( $price ); ?>" class="widefat">
    </p>
    <p>
      <label for="product_quantity"><?php _e( 'تعداد موجود:', 'petyar' ); ?></label>
      <input type="number" id="product_quantity" name="product_quantity"
             value="<?php echo esc_attr( $quantity ); ?>" class="widefat">
    </p>
    <?php
}

function petyar_save_product_meta( $post_id ) {
    if (
        ! isset( $_POST['petyar_product_meta_nonce'] ) ||
        ! wp_verify_nonce( $_POST['petyar_product_meta_nonce'], 'petyar_save_product_meta' ) ||
        ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
        ! current_user_can( 'edit_post', $post_id )
    ) {
        return;
    }

    if ( isset( $_POST['product_price'] ) ) {
        update_post_meta( $post_id, 'product_price', sanitize_text_field( $_POST['product_price'] ) );
    }
    if ( isset( $_POST['product_quantity'] ) ) {
        update_post_meta( $post_id, 'product_quantity', intval( $_POST['product_quantity'] ) );
    }
}
add_action( 'save_post_product', 'petyar_save_product_meta' );

/**
 * 7. ثبت CPT «آگهی گم/پیدا شده» و تکسونومی‌های وضعیت و نوع حیوان
 */
function petyar_register_lost_found_cpt() {
    register_post_type( 'lost_found', [
        'labels'       => [
            'name'          => __( 'آگهی گم/پیدا شده', 'petyar' ),
            'singular_name' => __( 'آگهی',             'petyar' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'lost-found', 'with_front' => false ],
        'supports'     => [ 'title','editor','thumbnail','excerpt' ],
        'show_in_rest' => true,
    ] );

    register_taxonomy( 'lf_status', 'lost_found', [
        'labels'            => [
            'name'          => __( 'وضعیت',       'petyar' ),
            'singular_name' => __( 'وضعیت آگهی', 'petyar' ),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'status', 'with_front' => false ],
        'show_in_rest'      => true,
    ] );

    register_taxonomy( 'lf_species', 'lost_found', [
        'labels'            => [
            'name'          => __( 'نوع حیوان', 'petyar' ),
            'singular_name' => __( 'نوع حیوان', 'petyar' ),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'species', 'with_front' => false ],
        'show_in_rest'      => true,
    ] );
}
add_action( 'init', 'petyar_register_lost_found_cpt' );



/**
 * ثبت بخش اطلاعات تماس در Customizer
 */
add_action( 'customize_register', 'petyar_customize_contact_info' );
function petyar_customize_contact_info( $wp_customize ) {
    // ایجاد یک Section جدید
    $wp_customize->add_section( 'petyar_contact_section', [
        'title'    => __( 'اطلاعات تماس', 'petyar' ),
        'priority' => 160,
    ] );

    // آدرس
    $wp_customize->add_setting( 'petyar_contact_address', [
        'default'           => 'تهران، زعفرانیه، خیابان مقدس اردبیلی',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'petyar_contact_address', [
        'label'   => __( 'آدرس:', 'petyar' ),
        'section' => 'petyar_contact_section',
        'type'    => 'text',
    ] );

    // ایمیل
    $wp_customize->add_setting( 'petyar_contact_email', [
        'default'           => 'amixrzie@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ] );
    $wp_customize->add_control( 'petyar_contact_email', [
        'label'   => __( 'ایمیل:', 'petyar' ),
        'section' => 'petyar_contact_section',
        'type'    => 'email',
    ] );

    // تلفن
    $wp_customize->add_setting( 'petyar_contact_phone', [
        'default'           => '09035686251',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'petyar_contact_phone', [
        'label'   => __( 'تلفن تماس:', 'petyar' ),
        'section' => 'petyar_contact_section',
        'type'    => 'text',
    ] );
}


// -----------------------------
//  سشن و منطق افزودن/حذف/بروزرسانی کالا
// -----------------------------
add_action( 'init', 'petyar_cart_session_handler' );
function petyar_cart_session_handler() {
    if ( ! session_id() ) {
        session_start();
    }

    // ۱. افزودن کالای جدید از طریق GET ?add-to-cart=<ID>
    if ( isset( $_GET['add-to-cart'] ) ) {
        $pid = absint( $_GET['add-to-cart'] );
        if ( $pid > 0 ) {
            if ( empty( $_SESSION['cart'][ $pid ] ) ) {
                $_SESSION['cart'][ $pid ] = 1;
            } else {
                $_SESSION['cart'][ $pid ]++;
            }
        }
        wp_safe_redirect( remove_query_arg( 'add-to-cart' ) );
        exit;
    }

    // ۲. حذف کالا از طریق GET ?remove-from-cart=<ID>
    if ( isset( $_GET['remove-from-cart'] ) ) {
        $pid = absint( $_GET['remove-from-cart'] );
        if ( isset( $_SESSION['cart'][ $pid ] ) ) {
            unset( $_SESSION['cart'][ $pid ] );
        }
        wp_safe_redirect( remove_query_arg( 'remove-from-cart' ) );
        exit;
    }

    // ۳. بروزرسانی تعداد از طریق فرم POST
    if ( isset( $_POST['update_cart'], $_POST['quantity'] ) && is_array( $_POST['quantity'] ) ) {
        foreach ( $_POST['quantity'] as $pid => $qty ) {
            $pid = absint( $pid );
            $qty = absint( $qty );
            if ( $qty < 1 ) {
                unset( $_SESSION['cart'][ $pid ] );
            } else {
                $_SESSION['cart'][ $pid ] = $qty;
            }
        }
        wp_safe_redirect( $_SERVER['REQUEST_URI'] );
        exit;
    }
}

// ۱. شروع سشن
add_action( 'init', function(){
    if ( ! session_id() ) {
        session_start();
    }
});

// ۲. پردازش فرم ثبت سفارش
add_action( 'init', 'petyar_handle_place_order' );
function petyar_handle_place_order() {
    if ( isset( $_POST['place_order'] ) ) {
        // نمونه‌ی ساده‌سازی: دریافت و sanitize فیلدها
        $billing = [
            'first_name' => sanitize_text_field( $_POST['billing_first_name'] ?? '' ),
            'last_name'  => sanitize_text_field( $_POST['billing_last_name']  ?? '' ),
            'company'    => sanitize_text_field( $_POST['billing_company']    ?? '' ),
            'country'    => sanitize_text_field( $_POST['billing_country']    ?? '' ),
            'state'      => sanitize_text_field( $_POST['billing_state']      ?? '' ),
            'city'       => sanitize_text_field( $_POST['billing_city']       ?? '' ),
            'address1'   => sanitize_text_field( $_POST['billing_address1']   ?? '' ),
            'address2'   => sanitize_text_field( $_POST['billing_address2']   ?? '' ),
            'postcode'   => sanitize_text_field( $_POST['billing_postcode']   ?? '' ),
            'phone'      => sanitize_text_field( $_POST['billing_phone']      ?? '' ),
            'email'      => sanitize_email(     $_POST['billing_email']      ?? '' ),
        ];

        // اگر لازم دارید این داده‌ها را ذخیره کنید (پست‌تایپ order)، اینجا بنویسید.
        // نمونه: ذخیره در سشن برای نمایش در thank-you
        $_SESSION['last_order'] = [
            'billing' => $billing,
            'cart'    => $_SESSION['cart'] ?? [],
            'date'    => current_time( 'mysql' ),
        ];

        // خالی کردن سبد
        unset( $_SESSION['cart'] );

        // ریدایرکت به صفحه تشکر (برگه‌ای با اسلاگ thank-you)
        wp_safe_redirect( get_permalink( get_page_by_path( 'thank-you' ) ) );
        exit;
    }
}


/**
 * 1. ثبت نقش «آگهی‌دهنده» با دسترسی به CPT lost_found
 */
add_action( 'after_switch_theme', 'petyar_add_custom_roles' );
function petyar_add_custom_roles() {
    add_role(
        'lf_submitter',
        __( 'آگهی‌دهنده', 'petyar' ),
        [
            'read'                   => true,
            'edit_lost_found'        => true,
            'edit_others_lost_found' => false,
            'publish_lost_found'     => false,
            'upload_files'           => true,
        ]
    );
}

/**
 * 2. تغییر مسیر پس از ورود و ثبت نام به داشبورد کاربر
 */
add_filter( 'login_redirect', 'petyar_login_redirect', 10, 3 );
function petyar_login_redirect( $redirect_to, $request, $user ) {
    // اگر کاربر موفق وارد شده
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        return home_url( '/dashboard/' );
    }
    return $redirect_to;
}


// در functions.php
add_action( 'template_redirect', 'petyar_handle_registration' );
function petyar_handle_registration() {
    if ( ! is_page('register') ) {
        return;
    }

    if ( is_user_logged_in() ) {
        wp_safe_redirect( home_url('/dashboard/') );
        exit;
    }

    if ( $_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['petyar_register_nonce']) ) {
        // ... (تمام منطق sanitize و wp_create_user و ریدایرکت مثل بالا)
    }
}



add_action( 'template_redirect', 'petyar_dashboard_protection' );
function petyar_dashboard_protection(){
    if ( is_page_template( 'page-dashboard.php' ) ) {
        if ( ! is_user_logged_in() || ! current_user_can( 'edit_lost_found' ) ) {
            wp_safe_redirect( home_url( '/login/' ) );
            exit;
        }
    }
}




// ۱. فعال‌سازی Custom Logo و منوی اصلی
add_action( 'after_setup_theme', 'petyar_theme_setup' );
function petyar_theme_setup() {
    add_theme_support( 'custom-logo', [
        'height'      => 40,
        'width'       => 80,
        'flex-width'  => false,
        'flex-height' => false,
    ]);
    register_nav_menus([
        'main_menu' => __( 'منوی اصلی', 'petyar' ),
    ]);
}

add_action( 'customize_register', 'petyar_customize_header' );
function petyar_customize_header( $wp_customize ) {

    // ۱) بخش جدید هدر
    $wp_customize->add_section( 'petyar_header_section', [
        'title'    => __( 'تنظیمات هدر', 'petyar' ),
        'priority' => 30,
    ] );

    // آرایه‌ای از صفحه‌ها برای تکرار
    $pages = [
        'home'      => __( 'صفحهٔ اصلی',         'petyar' ),
        'shop'      => __( 'صفحهٔ محصولات',      'petyar' ),
        'lostfound' => __( 'صفحهٔ گم/پیدا شده',  'petyar' ),
        'about'     => __( 'صفحهٔ درباره ما',    'petyar' ),
        'contact'   => __( 'صفحهٔ ارتباط با ما', 'petyar' ),
    ];

    foreach ( $pages as $key => $label ) {
        // ساخت شناسهٔ تنظیم
        $setting_id = "petyar_{$key}_page";

        // ۲) register setting
        $wp_customize->add_setting( $setting_id, [
            'default'           => 0,
            'sanitize_callback' => 'absint',
        ] );

        // ۳) register control
        $wp_customize->add_control( new WP_Customize_Control(
            $wp_customize,
            $setting_id . '_control',
            [
                'label'    => $label,
                'section'  => 'petyar_header_section',
                'settings' => $setting_id,
                'type'     => 'dropdown-pages',
            ]
        ) );
    }
}