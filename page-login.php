<?php
if (is_user_logged_in() && is_page('login')) {
    wp_safe_redirect(home_url('/dashboard/'));
    exit;
}

$login_errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['petyar_login_nonce'])) {
    if (!wp_verify_nonce($_POST['petyar_login_nonce'], 'petyar_login')) {
        $login_errors[] = __('خطای امنیتی. دوباره تلاش کنید.', 'petyar');
    } else {
        $login_input = sanitize_text_field($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = !empty($_POST['remember']);

        if (is_email($login_input)) {
            $user_obj = get_user_by('email', $login_input);
            if ($user_obj) {
                $login_input = $user_obj->user_login;
            }
        }

        $creds = [
            'user_login' => $login_input,
            'user_password' => $password,
            'remember' => $remember,
        ];

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            $login_errors[] = $user->get_error_message();
        } else {
            wp_safe_redirect(home_url('/dashboard/'));
            exit;
        }
    }
}

get_header();
?>

<div class="clearfix"></div>

<section class="container-fluid text-lg-right text-center mt-4 p-3 mb-5">
    <div class="container">
        <div class="row d-flex align-items-center pt-lg-5">

            <div class="col-lg-7 pl-lg-5 text-center order-2 order-lg-1">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="mr-3"><?php _e('ورود', 'petyar'); ?></h2>
                </div>
                <div class="card p-5">

                    <?php if (!empty($login_errors)) : ?>
                        <div class="alert alert-danger">
                            <?php foreach ($login_errors as $err) : ?>
                                <p><?php echo esc_html($err); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="contact-form">
                        <?php wp_nonce_field('petyar_login', 'petyar_login_nonce'); ?>
                        <div class="form-row">

                            <div class="form-group col-12">
                                <input
                                        name="email"
                                        type="text"
                                        class="form-control mb-2"
                                        placeholder="<?php esc_attr_e('ایمیل یا نام کاربری', 'petyar'); ?>"
                                        value="<?php echo esc_attr($_POST['email'] ?? ''); ?>"
                                        required
                                >
                            </div>

                            <div class="form-group col-12">
                                <input
                                        name="password"
                                        type="password"
                                        class="form-control mb-2"
                                        placeholder="<?php esc_attr_e('رمز عبور', 'petyar'); ?>"
                                        required
                                >
                            </div>

                            <div class="form-group col-12 text-right">
                                <label>
                                    <input type="checkbox"
                                           name="remember" <?php checked(!empty($_POST['remember'])); ?>>
                                    <?php _e('مرا به خاطر بسپار', 'petyar'); ?>
                                </label>
                            </div>

                            <div class="form-group col-md-6 d-flex justify-content-start align-items-center">
                                <button type="submit" class="btn btn-lightorng login-btn">
                                    <?php _e('ورود', 'petyar'); ?>
                                </button>
                            </div>

                            <div class="form-group col-md-6 d-flex justify-content-end">
                                <a
                                        href="<?php echo esc_url(home_url('/register/')); ?>"
                                        class="register-btn py-3 radius55"
                                >
                                    <?php _e('ثبت نام', 'petyar'); ?>
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
                        alt="<?php esc_attr_e('ورود', 'petyar'); ?>"
                />
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
