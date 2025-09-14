<?php
/**
 * Template Name: About Us
 * Template Post Type: page
 *
 * File: page-about-us.php
 * Path: /wp-content/themes/petsyar/page-about-us.php
 */

get_header();
?>

<section class="container-fluid text-lg-right text-center my-4 mb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 pl-lg-5">

        <div class="d-flex align-items-center mb-1">
          <!-- محل SVG -->
          <h2 class="mr-3">درباره ما</h2>
        </div>
        <p class="mb-3">پت هوم، سرزمین حیوانات خانگی با محصولات باکیفیت برای پت‌های شما</p>
        <h3 class="mt-4 color-orange">سرزمین حیوانات خانگی</h3>
        <p class="my-4 text-justify">
          لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ …
        </p>

        <div class="d-flex align-items-center justify-content-between mb-5 d-xs-block">
          <div class="d-flex flex-row align-items-center">
            <img src="<?php echo esc_url( THEME_ASSETS . '' ); ?>"
                 class="img-fluid rounded-circle ml-3 pic55"
                 alt="امین محمدی">
            <div class="py-2">
              <p class="text-dark bottom_p YekanBakhFaNum-Bold">امین محمدی</p>
              <span class="color-orange">مدیریت Pet Home</span>
            </div>
          </div>
          <a class="d-flex align-items-center a-button radius55 py-2 px-4" href="#">
            <!-- محل SVG دکمه -->
          </a>
        </div>

      </div><!-- /.col-lg-7 -->

      <div class="col-lg-5 d-flex align-items-center">
        <img src="<?php echo esc_url( THEME_ASSETS . '/img/about-us.png' ); ?>"
             class="img-fluid wapp"
             alt="درباره ما">
      </div>
    </div><!-- /.row -->
  </div><!-- /.container -->
</section>

<section class="text-lg-right text-center my-4">
  <div class="container py-3 p-lg-5">
    <div class="row">

      <div class="col-lg-5 d-lg-block d-none">
        <img src="<?php echo esc_url( THEME_ASSETS . '/img/dog-b2.png' ); ?>"
             class="img-fluid wapp"
             alt="سوالات متداول">
      </div>

      <div class="col-lg-7 pr-lg-5">
        <div class="d-flex align-items-center mb-1">
          <!-- محل SVG -->
          <h2 class="mr-3">سوالات متداول</h2>
        </div>
        <p class="mb-3">دلایلی که می‌توانید با خیال راحت به ما اعتماد کنید.</p>

        <div id="cstm_collapsible" class="custon_shadw">
          <button class="collapsible">اصالت و کیفیت غذای پت رو از کجا تشخیص بدم؟</button>
          <div class="content">
            <p class="p-2">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم …</p>
          </div>

          <button class="collapsible">اصالت و کیفیت غذای پت رو از کجا تشخیص بدم؟</button>
          <div class="content">
            <p class="p-2">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم …</p>
          </div>

          <button class="collapsible">اصالت و کیفیت غذای پت رو از کجا تشخیص بدم؟</button>
          <div class="content">
            <p class="p-2">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم …</p>
          </div>

          <button class="collapsible">اصالت و کیفیت غذای پت رو از کجا تشخیص بدم؟</button>
          <div class="content">
            <p class="p-2">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم …</p>
          </div>
        </div>

      </div><!-- /.col-lg-7 -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</section>

<section class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="d-flex align-items-center mb-1">
        <!-- محل SVG -->
        <h2 class="mr-3">سوالات متداول</h2>
      </div>
      <p class="mb-3">دلایلی که می‌توانید با خیال راحت به ما اعتماد کنید.</p>

      <div class="row my-5">
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card profile p-3 overlyblog">
            <img src="<?php echo esc_url( THEME_ASSETS . '/assets/img/amixrzi' ); ?>" alt="امیرحسین ">
            <h3 class="YekanBakhFaNum-Bold"> امیرحسین رضایی</h3>
            <p class="YekanBakhFaNum-SemiBold color-orange">برنامه نویس</p>
            <p class="my-2 fa14">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم …</p>
            <ul>
              <!-- محل SVG شبکه‌های اجتماعی -->
            </ul>
          </div>
        </div><!-- /.col -->

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card profile p-3 overlyblog">
            <img src="<?php echo esc_url( THEME_ASSETS . '' ); ?>" alt=" احسان">
            <h3 class="YekanBakhFaNum-Bold">احسان صفدری</h3>
            <p class="YekanBakhFaNum-SemiBold color-orange">برنامه نویس</p>
            <p class="my-2 fa14">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم …</p>
            <ul>
              <!-- محل SVG شبکه‌های اجتماعی -->
            </ul>
          </div>
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
</section>

<?php
get_footer();