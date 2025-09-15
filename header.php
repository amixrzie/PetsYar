<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?php wp_title('|', true, 'right');
        bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Main.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Menu.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/Style.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.theme.min.css">
    <?php wp_head(); ?>
</head>

<body <?php body_class('rtl'); ?>>
<div class="main_wrap">

    <?php
    $home_url = esc_url(home_url('/'));
    $shop_page = get_page_by_path('shop');
    $shop_url = $shop_page ? get_permalink($shop_page->ID) : home_url('/shop/');
    $lost_page = get_page_by_path('lost-found');
    $lost_url = $lost_page ? get_permalink($lost_page->ID) : home_url('/lost-found/');
    $about_page = get_page_by_path('about');
    $about_url = $about_page ? get_permalink($about_page->ID) : home_url('/about/');
    $contact_page = get_page_by_path('contact');
    $contact_url = $contact_page ? get_permalink($contact_page->ID) : home_url('/contact/');

    $logo_id = get_theme_mod('custom_logo');
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : get_template_directory_uri() . '/assets/img/logo.svg';
    ?>

    <header class="main_header wide_header">
        <div class="header_container">
            <div class="menu_wrapper menu_sticky header-btop">
                <div class="container d-flex justify-content-between align-items-center p_relative h86">

                    <div class="logo-desktop d-none d-lg-block">
                        <a href="<?php echo esc_url($home_url); ?>">
                            <img src="<?php echo esc_url($logo_url); ?>"
                                 alt="<?php echo esc_attr(get_bloginfo('name')); ?>" style="height:60px; width:auto;">
                        </a>
                    </div>

                    <nav class="main-menu d-none d-lg-block mx-4">
                        <ul class="menu d-flex" style="gap:2rem;">
<li class="menu-item">
  <a href="<?php echo esc_url( $home_url ); ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    خانه
  </a>
</li>
<li class="menu-item">
<li class="menu-item"><a href="<?php echo home_url('/products/'); ?>">محصولات</a></li>
</li>
<li class="menu-item">
  <a href="<?php echo home_url('/lost_found/'); ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    گم/پیدا شده
  </a>
</li>
<li class="menu-item">
  <a href="<?php echo home_url('/about/') ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    درباره ما
  </a>
</li>
<li class="menu-item">
  <a href="<?php echo home_url('/contact-us/'); ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    ارتباط با ما
  </a>
</li>
                        </ul>
                    </nav>

                    <div class="d-flex align-items-center">
                        <div class="shoping-cart mr-3 radius30">
                            <a href="<?php echo home_url('/cart/'); ?>">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M2 2H3.74C4.82 2 5.67 2.93 5.58 4L4.75 13.96C4.61 15.59 5.9 16.99 7.54 16.99H18.19C19.63 16.99 20.89 15.81 21 14.38L21.54 6.88C21.66 5.22 20.4 3.87 18.73 3.87H5.82"
                                          stroke="#222221" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <circle cx="16.25" cy="20.75" r="1.25" stroke="#222221" stroke-width="1.5"></circle>
                                    <circle cx="8.25" cy="20.75" r="1.25" stroke="#222221" stroke-width="1.5"></circle>
                                </svg>
                            </a>
                        </div>


                        <div class="login d-flex align-items-center radius30">
                            <?php if (is_user_logged_in()) : ?>
                                <a href="<?php echo home_url('/dashboard/'); ?>"
                                   class="px-2 radius30"><?php _e('پیشخوان', 'petyar'); ?>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4399 19.05L15.9599 20.57L18.9999 17.53" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12.1601 10.87C12.0601 10.86 11.9401 10.86 11.8301 10.87C9.4501 10.79 7.5601 8.84 7.5601 6.44C7.5501 3.99 9.5401 2 11.9901 2C14.4401 2 16.4301 3.99 16.4301 6.44C16.4301 8.84 14.5301 10.79 12.1601 10.87Z"
                                              stroke="white" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                        <path d="M11.99 21.8099C10.17 21.8099 8.36004 21.3499 6.98004 20.4299C4.56004 18.8099 4.56004 16.1699 6.98004 14.5599C9.73004 12.7199 14.24 12.7199 16.99 14.5599"
                                              stroke="white" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo home_url('/login/'); ?>"
                                   class="px-2 radius30"><?php _e('ورود', 'petyar'); ?>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4399 19.05L15.9599 20.57L18.9999 17.53" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12.1601 10.87C12.0601 10.86 11.9401 10.86 11.8301 10.87C9.4501 10.79 7.5601 8.84 7.5601 6.44C7.5501 3.99 9.5401 2 11.9901 2C14.4401 2 16.4301 3.99 16.4301 6.44C16.4301 8.84 14.5301 10.79 12.1601 10.87Z"
                                              stroke="white" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                        <path d="M11.99 21.8099C10.17 21.8099 8.36004 21.3499 6.98004 20.4299C4.56004 18.8099 4.56004 16.1699 6.98004 14.5599C9.73004 12.7199 14.24 12.7199 16.99 14.5599"
                                              stroke="white" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                                <span class="px-1 radius30">|</span>
                                <a href="<?php echo home_url('/register/'); ?>"
                                   class="px-2 radius30"><?php _e('ثبت‌نام', 'petyar'); ?>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4399 19.05L15.9599 20.57L18.9999 17.53" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12.1601 10.87C12.0601 10.86 11.9401 10.86 11.8301 10.87C9.4501 10.79 7.5601 8.84 7.5601 6.44C7.5501 3.99 9.5401 2 11.9901 2C14.4401 2 16.4301 3.99 16.4301 6.44C16.4301 8.84 14.5301 10.79 12.1601 10.87Z"
                                              stroke="white" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                        <path d="M11.99 21.8099C10.17 21.8099 8.36004 21.3499 6.98004 20.4299C4.56004 18.8099 4.56004 16.1699 6.98004 14.5599C9.73004 12.7199 14.24 12.7199 16.99 14.5599"
                                              stroke="white" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mobile-nav-button d-lg-none">
                        <button id="mobileMenuToggle" class="btn btn-outline-secondary">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>

                    <div class="logo-mobile d-lg-none d-flex justify-content-center py-2">
                        <a href="<?php echo esc_url($home_url); ?>">
                            <img src="<?php echo esc_url($logo_url); ?>"
                                 alt="<?php echo esc_attr(get_bloginfo('name')); ?>" style="height:50px; width:auto;">
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div id="mobileMenu" class="mobile-menu d-lg-none"
             style="display:none; padding:15px; background:#fff; gap:2vh;">
                        <ul class="menu d-flex" style="gap:2rem;">
<li class="menu-item">
  <a href="<?php echo esc_url( $home_url ); ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    خانه
  </a>
</li>
<li class="menu-item">
  <a href="<?php home_url('/products/'); ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    محصولات
  </a>
</li>
<li class="menu-item">
  <a href="<?php echo home_url('/lost_fuond/'); ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    گم/پیدا شده
  </a>
</li>
<li class="menu-item">
  <a href="<?php echo home_url('/about/') ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    درباره ما
  </a>
</li>
<li class="menu-item">
  <a href="<?php echo home_url('/contact-us/'); ?>"
     onmouseover="this.style.color='#4e62af';"
     onmouseout="this.style.color='';">
    ارتباط با ما
  </a>
</li>
                        </ul>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                mobileMenu.style.display = (mobileMenu.style.display === 'none') ? 'block' : 'none';
            });
        });
    </script>

