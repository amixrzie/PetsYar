<?php
/**
 * Template Name: Contact Us
 * Template Post Type: page
 *
 * File: page-contact-us.php
 * Path: /wp-content/themes/petsyar/page-contact-us.php
 */

get_header();

// خواندن مقادیر سفارشی‌سازی
$address = get_theme_mod( 'petyar_contact_address', 'تهران، زعفرانیه، خیابان مقدس اردبیلی' );
$email   = get_theme_mod( 'petyar_contact_email', 'info@rtl-theme.com' );
$phone   = get_theme_mod( 'petyar_contact_phone', '09123456789' );
?>

<section class="text-lg-right text-center my-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 pl-lg-5 order-2 order-lg-1">
        <div class="d-flex align-items-center mb-1">
          <!-- محل SVG ثابت -->
          <h2 class="mr-3">تماس با ما</h2>
        </div>
        <p class="mb-3">میزبان صدای گرم شما هستیم...</p>

        <div class="pl-sm-5">
          <form class="contact-form">
            <input type="email" class="form-control mb-3" placeholder="ایمیل معتبر">
            <input type="text"  class="form-control mb-3" placeholder="موضوع پیام">
            <textarea class="form-control mb-3" cols="60" rows="9" placeholder="متن پیام"></textarea>
            <button type="submit" class="btn btn-lightorng">ارسال پیام</button>
          </form>
        </div>
      </div>

      <div class="col-lg-5 order-1 order-lg-2 mb-5">
        <img src="<?php echo esc_url( THEME_ASSETS . '/img/contact-us.png' ); ?>"
             class="img-fluid wapp"
             alt="تماس با ما">
      </div>
    </div>
  </div>
</section>

<section class="container p-md-5 p-4 mt-md-5 mt-2">
  <div class="d-flex align-items-center mb-1">
    <!-- محل SVG ثابت -->
    <h2 class="mr-3">با ما در ارتباط باشید</h2>
  </div>
  <p class="mb-3">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم برای صنعت چاپ</p>

  <div class="row mb-3 mt-5">
    <div class="col-lg-4 col-md-6">
      <div class="card contact-box mb-3">
        <div class="icon d-flex align-items-center justify-content-center">
          <!-- محل SVG آیتم اول -->
        </div>
        <h3 class="pb-2">آدرس ما:</h3>
        <p><?php echo esc_html( $address ); ?></p>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="card contact-box mb-3">
        <div class="icon d-flex align-items-center justify-content-center">
          <!-- محل SVG آیتم دوم -->
        </div>
        <h3 class="pb-2">پست الکترونیکی:</h3>
        <p><?php echo esc_html( $email ); ?></p>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card contact-box mb-3">
        <div class="icon d-flex align-items-center justify-content-center">
          <!-- محل SVG آیتم سوم -->
        </div>
        <h3 class="pb-2">تلفن تماس:</h3>
        <p><?php echo esc_html( $phone ); ?></p>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();