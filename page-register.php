<?php
if (is_user_logged_in()) {
    wp_safe_redirect(home_url('/dashboard/'));
    exit;
}

$reg_errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_nonce'])) {
    if (!wp_verify_nonce($_POST['register_nonce'], 'register_action')) {
        $reg_errors[] = __('خطای امنیتی. دوباره تلاش کنید.', 'petyar');
    } else {
        $first = sanitize_text_field($_POST['first_name'] ?? '');
        $last = sanitize_text_field($_POST['last_name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password_confirm'] ?? '';

        if (!$first || !$last || !$email || !$password || $password !== $password2) {
            $reg_errors[] = __('لطفاً همهٔ فیلدها را پر کنید و رمزها یکسان باشند.', 'petyar');
        } elseif (email_exists($email)) {
            $reg_errors[] = __('این ایمیل قبلاً ثبت شده است.', 'petyar');
        } else {
        
            $user_id = wp_create_user($email, $password, $email);
            if (is_wp_error($user_id)) {
                $reg_errors[] = $user_id->get_error_message();
            } else {
    
                $u = new WP_User($user_id);
                $u->set_role('subscriber');  
                update_user_meta($user_id, 'first_name', $first);
                update_user_meta($user_id, 'last_name', $last);
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);
                wp_safe_redirect(home_url('/dashboard/'));
                exit;
            }
        }
    }
}

get_header();
?>
    <section class="container-fluid text-lg-right text-center mt-4 p-3 mb-5">
        <div class="container">
            <div class="row d-flex align-items-center pt-lg-5">

                <div class="col-lg-7 pl-lg-5 text-center order-2 order-lg-1">
                    <div class="d-flex align-items-center mb-3">

                        <h2 class="mr-3">ثبت‌نام</h2>
                    </div>
                    <div class="card p-5">

                        <?php if (!empty($reg_errors)) : ?>
                            <div class="alert alert-danger">
                                <?php foreach ($reg_errors as $err) : ?>
                                    <p><?php echo esc_html($err); ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" class="contact-form">
                            <?php wp_nonce_field('register_action', 'register_nonce'); ?>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input
                                            name="first_name"
                                            type="text"
                                            class="form-control mb-2"
                                            placeholder="نام"
                                            value="<?php echo esc_attr($_POST['first_name'] ?? ''); ?>"
                                            required
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <input
                                            name="last_name"
                                            type="text"
                                            class="form-control mb-2"
                                            placeholder="نام خانوادگی"
                                            value="<?php echo esc_attr($_POST['last_name'] ?? ''); ?>"
                                            required
                                    >
                                </div>
                                <div class="form-group col-md-12">
                                    <input
                                            name="email"
                                            type="email"
                                            class="form-control mb-2"
                                            placeholder="پست الکترونیکی"
                                            value="<?php echo esc_attr($_POST['email'] ?? ''); ?>"
                                            required
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <input
                                            name="password"
                                            type="password"
                                            class="form-control mb-2"
                                            placeholder="رمز عبور"
                                            required
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <input
                                            name="password_confirm"
                                            type="password"
                                            class="form-control mb-2"
                                            placeholder="تکرار رمز عبور"
                                            required
                                    >
                                </div>
                                <div class="form-group col-md-6 d-flex justify-content-start">
                                    <button type="submit" class="btn btn-lightorng login-btn">ثبت‌نام</button>
                                </div>
                                <div class="form-group col-md-6 d-flex justify-content-end">
                                    <a href="<?php echo esc_url(home_url('/login/')); ?>" class="register-btn radius55">
                                        ورود
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="col-lg-5 d-flex align-items-center order-1 order-lg-2">
                    <img
                            src="<?php echo esc_url(THEME_ASSETS . '/img/login_pic.png'); ?>"
                            class="img-fluid wapp"
                            alt="ثبت‌نام"
                    />
                </div>

            </div>
        </div>
    </section>
<?php get_footer(); ?>