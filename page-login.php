<?php
/**
 * Template Name: Login
 * Template Post Type: page
 *
 * مسیر: /wp-content/themes/petsyar/page-login.php
 */

// ۱) شروع سشن (در صورت استفاده از سشن برای سبد)
// اگر سشن ندارید، این خط را بردارید
if ( session_status() === PHP_SESSION_NONE ) {
    session_start();
}

// ۲) اگر کاربر لاگین است، مستقیم برود داشبورد
if ( is_user_logged_in() ) {
    wp_safe_redirect( home_url( '/dashboard/' ) );
    exit;
}

// ۳) پردازش فرم POST
$login_errors = [];
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['petyar_login_nonce'] ) ) {
    if ( ! wp_verify_nonce( $_POST['petyar_login_nonce'], 'petyar_login' ) ) {
        $login_errors[] = __( 'خطای امنیتی. دوباره تلاش کنید.', 'petyar' );
    } else {
        $creds = [
            'user_login'    => sanitize_email( $_POST['email']    ?? '' ),
            'user_password' =>            $_POST['password'] ?? '',
            'remember'      => isset( $_POST['remember'] ),
        ];
        $user = wp_signon( $creds, false );
        if ( is_wp_error( $user ) ) {
            $login_errors[] = $user->get_error_message();
        } else {
            wp_safe_redirect( home_url( '/dashboard/' ) );
            exit;
        }
    }
}

// ۴) حالا که تمام ریدایرکت‌ها و header() قبل از این انجام شد، قالب را شروع کن
get_header();
?>

<div class="clearfix"></div>

<section class="container-fluid text-lg-right text-center mt-4 p-3 mb-5">
  <div class="container">
    <div class="row d-flex align-items-center pt-lg-5">

      <!-- فرم ورود -->
      <div class="col-lg-7 pl-lg-5 text-center order-2 order-lg-1">
        <div class="d-flex align-items-center mb-3">
          <!-- محل svg -->
          <h2 class="mr-3">ورود</h2>
        </div>
        <div class="card p-5">

          <!-- نمایش خطاها -->
          <?php if ( ! empty( $login_errors ) ) : ?>
            <div class="alert alert-danger">
              <?php foreach ( $login_errors as $err ) : ?>
                <p><?php echo esc_html( $err ); ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form method="post" class="contact-form">
            <?php wp_nonce_field( 'petyar_login', 'petyar_login_nonce' ); ?>
            <div class="form-row">

              <div class="form-group col-12">
                <input
                  name="email"
                  type="email"
                  class="form-control mb-2"
                  placeholder="پست الکترونیکی"
                  value="<?php echo esc_attr( $_POST['email'] ?? '' ); ?>"
                  required
                >
              </div>

              <div class="form-group col-12">
                <input
                  name="password"
                  type="password"
                  class="form-control mb-2"
                  placeholder="رمز عبور"
                  required
                >
              </div>

              <div class="form-group col-md-6 d-flex justify-content-start align-items-center">
                <button type="submit" class="btn btn-lightorng login-btn">
                  <?php _e( 'ورود', 'petyar' ); ?>
                </button>
              </div>

              <div class="form-group col-md-6 d-flex justify-content-end">
                <a
                  href="<?php echo esc_url( home_url( '/register/' ) ); ?>"
                  class="register-btn py-3 radius55"
                >
                  <?php _e( 'ثبت نام', 'petyar' ); ?>
                </a>
              </div>

            </div>
          </form>
        </div>
      </div>

      <!-- تصویر جانبی -->
      <div class="col-lg-5 d-flex align-items-center order-1 order-lg-2">
        <img
          src="<?php echo esc_url( THEME_ASSETS . '/img/login_pic.png' ); ?>"
          class="img-fluid wapp"
          alt="<?php _e( 'ورود', 'petyar' ); ?>"
        />
      </div>

    </div>
  </div>
</section>

<?php
get_footer();