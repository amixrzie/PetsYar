<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>

  <!-- CSS ها از پوشه assets -->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Main.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Menu.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Style.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.theme.min.css">

  <?php wp_head(); ?>
</head>

<body <?php body_class('rtl'); ?>>
<div class="main_wrap">
  <div class="of-site-mask"></div>

  <header class="main_header wide_header">
    <div class="header_container">
      <div class="menu_wrapper menu_sticky header-btop">
        <div class="container p_relative h86">

          <!-- لوگو دسکتاپ -->
          <div class="logo-desktop d-none d-lg-block">
            <?php
              $logo_id  = get_theme_mod('custom_logo');
              if ( $logo_id ) {
                $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                printf(
                  '<a href="%1$s"><img src="%2$s" alt="%3$s" style="width:40;height:40px;"></a>',
                  esc_url( home_url('/') ),
                  esc_url( $logo_url ),
                  esc_attr( get_bloginfo('name') )
                );
              } else {
                printf(
                  '<a href="%1$s"><img src="%2$s" alt="%3$s" style="width:200px;height:80px;"></a>',
                  esc_url( home_url('/') ),
                  esc_url( get_template_directory_uri() . '/assets/img/logo.svg' ),
                  esc_attr( get_bloginfo('name') )
                );
              }
            ?>
          </div>

          <!-- منوی استاتیک -->
          <div id="navigation" class="of-drop-down of-main-menu" role="navigation">
            <!-- <?php
              // آدرس صفحات برگه‌ای
              $home_url     = esc_url( home_url('/') );
              $shop_page    = get_page_by_path( 'shop' );
              $shop_url     = $shop_page   ? get_permalink( $shop_page->ID )   : home_url('/products/');
              $lost_page    = get_page_by_path( 'lost-found' );
              $lost_url     = $lost_page   ? get_permalink( $lost_page->ID )   : home_url('/lost_found/');
              $about_page   = get_page_by_path( 'about' );
              $about_url    = $about_page  ? get_permalink( $about_page->ID )  : home_url('/about/');
              $contact_page = get_page_by_path( 'contact' );
              $contact_url  = $contact_page? get_permalink( $contact_page->ID ) : home_url('/contact-us/');
            ?> -->
            <ul class="menu">
              <li style="" class="menu-item"><a href="">خانه</a></li>
              <li class="menu-item"><a href="<?php echo esc_url($shop_url); ?>">محصولات</a></li>
              <li class="menu-item"><a href="<?php echo esc_url($lost_url); ?>">گم/پیدا شده</a></li>
              <li class="menu-item"><a href="<?php echo esc_url($about_url); ?>">درباره ما</a></li>
              <li class="menu-item"><a href="<?php echo esc_url($contact_url); ?>">ارتباط با ما</a></li>
            </ul>
          </div>

          <?php
            $is_user       = is_user_logged_in();
            $cart_url      = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#';
            $login_url     = home_url('/login/');
            $register_url  = home_url('/register/');
            $dashboard_url = home_url('/dashboard/');
          ?>
          <div class="m_login d-flex">
            <!-- سبد خرید -->
            <div class="shoping-cart radius30">
              <a href="<?php echo home_url('/cart/'); ?>">
                                                <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 2H3.74001C4.82001 2 5.67 2.93 5.58 4L4.75 13.96C4.61 15.59 5.89999 16.99 7.53999 16.99H18.19C19.63 16.99 20.89 15.81 21 14.38L21.54 6.88C21.66 5.22 20.4 3.87 18.73 3.87H5.82001"
                                          stroke="#222221" stroke-width="1.5" stroke-miterlimit="10"
                                          stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16.25 22C16.9404 22 17.5 21.4404 17.5 20.75C17.5 20.0596 16.9404 19.5 16.25 19.5C15.5596 19.5 15 20.0596 15 20.75C15 21.4404 15.5596 22 16.25 22Z"
                                          stroke="#222221" stroke-width="1.5" stroke-miterlimit="10"
                                          stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M8.25 22C8.94036 22 9.5 21.4404 9.5 20.75C9.5 20.0596 8.94036 19.5 8.25 19.5C7.55964 19.5 7 20.0596 7 20.75C7 21.4404 7.55964 22 8.25 22Z"
                                          stroke="#222221" stroke-width="1.5" stroke-miterlimit="10"
                                          stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M9 8H21" stroke="#222221" stroke-width="1.5" stroke-miterlimit="10"
                                          stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <!-- paths… -->
                </svg>
              </a>
            </div>

            <!-- ورود / ثبت‌نام / پیشخوان -->
            <div class="login px-4 py-2 radius55 d-flex align-items-center">
              <!-- SVG آیکون کاربر -->
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                <!-- paths… -->
              </svg>

              <?php if ( $is_user ) : ?>
                <a class="mr-2" href="<?php echo home_url('/login/'); ?>">
                  <?php _e('پیشخوان','petyar'); ?>
                </a>
              <?php else : ?>
                <a class="mr-2" href="<?php echo esc_url($login_url); ?>">
                  <?php _e('ورود','petyar'); ?>
                </a>
                <span class="px-1">|</span>
                <a class="ml-2" href="<?php echo esc_url($register_url); ?>">
                  <?php _e('ثبت‌نام','petyar'); ?>
                </a>
              <?php endif; ?>

            </div>
          </div>

          <!-- دکمه موبایل -->
          <div class="is-show mobile-nav-button">
            <a id="of-trigger" class="icon-wrap" href="#">
              <!-- SVG منو -->
            </a>
          </div>

          <!-- لوگو موبایل -->
          <div class="logo-mobile d-none">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="current py-2">
              <?php
                if ( isset($logo_url) ) {
                  printf(
                    '<img src="%1$s" alt="%2$s" style="width:150px;height:60px;">',
                    esc_url( $logo_url ),
                    esc_attr( get_bloginfo('name') )
                  );
                } else {
                  printf(
                    '<img src="%1$s" alt="%2$s" style="width:150px;height:60px;">',
                    esc_url( get_template_directory_uri() . '/assets/img/logo.svg' ),
                    esc_attr( get_bloginfo('name') )
                  );
                }
              ?>
            </a>
          </div>

        </div>
      </div>
    </div>
  </header>

  <div class="clearfix"></div>