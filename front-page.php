<?php
get_header();
?>
    <section class="container">
        <div class="row">
            <div class="col-lg-12 p-0 mb-3">
                <div id="owl-mainslider" class="owl-carousel owl-theme text-center">
                    <?php

                    $slider_images = ['slider-1.jpg', 'slider-2.jpg'];
                    foreach ($slider_images as $img) :
                        $url = get_template_directory_uri() . '/assets/img/' . $img;
                        ?>
                        <div class="item">
                            <img
                                    src="<?php echo esc_url($url); ?>"
                                    class="img-fluid radius-slide"
                                    alt="<?php esc_attr_e('Slider image', 'petyar'); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <script>
        jQuery(document).ready(function ($) {
            $('#owl-mainslider').owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                nav: true,
                dots: true,
                rtl: true,
                navText: [
                    '<span class="owl-nav-prev">&lt;</span>',
                    '<span class="owl-nav-next">&gt;</span>'
                ],
                animateOut: 'fadeOut'
            });
        });
    </script>
<?php
$page         = get_page_by_path( 'page-products' );
$products_url = $page
  ? get_permalink( $page )
  : home_url( '/page-products/' );
$categories = [
  'food'        => 'Asset2501.png',
  'accessories' => 'Asset2500.png',
  'equipment'   => 'Asset2502.png',
];
?>

<div class="container p-0 my-2">
  <div class="row">
    <?php foreach ( $categories as $slug => $icon ) :
      $term = get_term_by( 'slug', $slug, 'product_category' );
      if ( ! $term ) {
        continue;
      }
      $term_url = add_query_arg( 'cat', $term->slug, home_url('/products/') );
    ?>
      <div class="col-md-4 p-3">    
        <div class="py-4 p-3 d-flex align-items-center justify-content-around text-lg-right text-md-center mb-3 service_style category-style radius30">
          <img
            src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/' . $icon ); ?>"
            alt="<?php echo esc_attr( $term->name ); ?>">
          <h3 class="YekanBakhFaNum-Bold fa1-2">
            <?php echo esc_html( $term->name ); ?>
          </h3>
          <a href="<?php echo esc_url( $term_url ); ?>">
            <div class="arrow-box d-flex align-items-center justify-content-center">
              <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.8019 6.17453H2.56566C2.00285 6.17453 1.53613 5.70782 1.53613 5.14501C1.53613 4.5822 2.00285 4.11548 2.56566 4.11548H10.8019C11.3647 4.11548 11.8314 4.5822 11.8314 5.14501C11.8314 5.70782 11.3647 6.17453 10.8019 6.17453Z" fill="#292D32"/>
                <path d="M5.31096 10.2918C5.05014 10.2918 4.78933 10.1958 4.58342 9.98985L0.465311 5.87174C0.067227 5.47366 0.067227 4.81476 0.465311 4.41667L4.58342 0.298563C4.98151 -0.099521 5.64041 -0.099521 6.03849 0.298563C6.43657 0.696647 6.43657 1.35554 6.03849 1.75363L2.64791 5.14421L6.03849 8.53479C6.43657 8.93287 6.43657 9.59177 6.03849 9.98985C5.83258 10.1958 5.57177 10.2918 5.31096 10.2918Z" fill="#292D32"/>
              </svg>
            </div>
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

    <section class="bg-gray pb-4">
        <div class="container p-4 radius20 mt-5">
            <div class="d-flex align-items-center justify-content-between mt-4">
                <h2><?php _e('محصولات جدید', 'petyar'); ?></h2>
                <a class="d-flex align-items-center a-button radius55 py-2 px-4"
                   href="<?php echo home_url('/products/'); ?>">
                    <span class="ml-2"><?php _e('محصولات', 'petyar'); ?></span>
                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.8019 6.17453H2.56566C2.00285 6.17453 1.53613 5.70782 1.53613 5.14501C1.53613 4.5822 2.00285 4.11548 2.56566 4.11548H10.8019C11.3647 4.11548 11.8314 4.5822 11.8314 5.14501C11.8314 5.70782 11.3647 6.17453 10.8019 6.17453Z"
                              fill="#292D32"></path>
                        <path d="M5.31096 10.2918C5.05014 10.2918 4.78933 10.1958 4.58342 9.98985L0.465311 5.87174C0.067227 5.47366 0.067227 4.81476 0.465311 4.41667L4.58342 0.298563C4.98151 -0.099521 5.64041 -0.099521 6.03849 0.298563C6.43657 0.696647 6.43657 1.35554 6.03849 1.75363L2.64791 5.14421L6.03849 8.53479C6.43657 8.93287 6.43657 9.59177 6.03849 9.98985C5.83258 10.1958 5.57177 10.2918 5.31096 10.2918Z"
                              fill="#292D32"></path>
                    </svg>
                </a>
            </div>

            <p class="mb-5"><?php _e('انواع محصولات باکیفیت برای پت های دوست داشتنی شما', 'petyar'); ?></p>

            <div class="owl-product owl-carousel">
                <?php
                $new_products = new WP_Query([
                    'post_type' => 'product',
                    'posts_per_page' => 5,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                ]);

                if ($new_products->have_posts()) :
                    while ($new_products->have_posts()) : $new_products->the_post(); ?>
                        <div class="item">
                            <div class="card-body mb-3 text-center">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'img-fluid']); ?>
                                </a>
                                <div>
                                    <h5 class="my-2 YekanBakhFaNum-SemiBold">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h5>
                                    <span class="color-orange YekanBakhFaNum-Bold fa18">
                                    <?php echo esc_html(get_post_meta(get_the_ID(), 'product_price', true)); ?>
                                </span>
                                    <span class="color-orange YekanBakhFaNum-Regular fa14">
                                    <?php _e('تومان', 'petyar'); ?>
                                </span>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="add-to-cart hoverable outlined">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M2 2H3.74C4.82 2 5.67 2.93 5.58 4L4.75 13.96C4.61 15.59 5.9 16.99 7.54 16.99H18.19C19.63 16.99 20.89 15.81 21 14.38L21.54 6.88C21.66 5.22 20.4 3.87 18.73 3.87H5.82"
                                                      stroke="#222221" stroke-width="1.5" stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <circle cx="16.25" cy="20.75" r="1.25" stroke="#222221"
                                                        stroke-width="1.5"></circle>
                                                <circle cx="8.25" cy="20.75" r="1.25" stroke="#222221"
                                                        stroke-width="1.5"></circle>
                                            </svg>
                                            <a href="<?php echo esc_url(add_query_arg('add-to-cart', get_the_ID())); ?>">
                                                <span><?php _e('افزودن به سبد خرید', 'petyar'); ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p class="text-center"><?php _e('فعلاً محصول جدیدی وجود ندارد.', 'petyar'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script>
        jQuery(document).ready(function ($) {
            $('.owl-product').owlCarousel({
                loop: true,
                margin: 15,
                nav: true,
                dots: false,
                rtl: true,
                responsive: {
                    0: {items: 1},
                    576: {items: 2},
                    992: {items: 3},
                }
            });
        });
    </script>

    <section class="container-fluid text-lg-right text-center my-4">
        <div class="container py-2">
            <div class="row">
                <div class="col-lg-7 pl-lg-5">
                    <h2 class="mt-5"><?php _e('درباره ما', 'petyar'); ?></h2>
                    <p class="mb-3">
                        <?php _e('پت یار، سرزمین حیوانات خانگی با محصولات باکیفیت برای پت های شما', 'petyar'); ?>
                    </p>
                    <h3 class="mt-4 color-orange"><?php _e('petyar', 'petyar'); ?></h3>
                    <p class="my-4">
                        <?php _e('پت یار، سرزمین حیوانات خانگی با محصولات باکیفیت برای پت های شما', 'petyar'); ?>
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/Img/amixrzi.jpg'); ?>"
                                    class="img-fluid rounded-circle ml-3 pic55"
                                    alt="">
                            <div class="py-2">
                                <p class="text-dark bottom_p YekanBakhFaNum-Bold">
                                    <?php _e('امیرحسین رضایی', 'petyar'); ?>
                                </p>
                                <span class="color-orange"><?php _e('مدیریت Pet Home', 'petyar'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-flex align-items-center mt-5">
                    <img
                            src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/about-us.png'); ?>"
                            class="img-fluid wapp"
                            alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center justify-content-between mt-4">
                    <h2><?php _e('گم/پیدا شده', 'petyar'); ?></h2>
                    <a
                            class="d-flex align-items-center a-button radius55 py-2 px-4"
                            href="<?php echo esc_url(home_url('/lost_found/')); ?>">
                        <span class="ml-2"><?php _e('همه آگهی ها', 'petyar'); ?></span>
                        <svg width="21" height="22" viewbox="0 0 21 22" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 21.25C15.9665 21.25 16.75 20.4665 16.75 19.5C16.75 18.5335 15.9665 17.75 15 17.75C14.0335 17.75 13.25 18.5335 13.25 19.5C13.25 20.4665 14.0335 21.25 15 21.25Z"
                                  fill="#4e62af"></path>
                            <path d="M7 21.25C7.9665 21.25 8.75 20.4665 8.75 19.5C8.75 18.5335 7.9665 17.75 7 17.75C6.0335 17.75 5.25 18.5335 5.25 19.5C5.25 20.4665 6.0335 21.25 7 21.25Z"
                                  fill="#4e62af"></path>
                            <path d="M3.59 2.69L3.39 5.14C3.35 5.61 3.72 6 4.19 6H19.5C19.92 6 20.27 5.68 20.3 5.26C20.43 3.49 19.08 2.05 17.31 2.05H5.02C4.92 1.61 4.72 1.19 4.41 0.84C3.91 0.31 3.21 0 2.49 0H0.75C0.34 0 0 0.34 0 0.75C0 1.16 0.34 1.5 0.75 1.5H2.49C2.8 1.5 3.09 1.63 3.3 1.85C3.51 2.08 3.61 2.38 3.59 2.69Z"
                                  fill="#4e62af"></path>
                            <path d="M19.2601 7.5H3.92005C3.50005 7.5 3.16005 7.82 3.12005 8.23L2.76005 12.58C2.62005 14.29 3.96005 15.75 5.67005 15.75H16.7901C18.2901 15.75 19.6101 14.52 19.7201 13.02L20.0501 8.35C20.0901 7.89 19.7301 7.5 19.2601 7.5Z"
                                  fill="#4e62af"></path>
                        </svg>
                    </a>
                </div>
                <p class="mb-5">
                    <?php _e('آکهی های حیوانات گم شده و پیدا شده', 'petyar'); ?>
                </p>
                <div class="row">
                    <?php
                    $lost_posts = new WP_Query([
                        'post_type' => 'lost_found',
                        'posts_per_page' => 3,
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ]);
                    if ($lost_posts->have_posts()) :
                        while ($lost_posts->have_posts()) : $lost_posts->the_post(); ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card p-3 mb-3 carding-blog overlyblog">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', ['class' => 'img-fluid']); ?>
                                    </a>
                                    <div class="p_relative">
                                        <h5 class="mt-5 YekanBakhFaNum-Bold">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h5>
                                        <div class="d-flex justify-content-center">
                                            <a
                                                    class="cateblog d-flex justify-content-center align-items-center"
                                                    href="<?php
                                                    $status_terms = wp_get_post_terms(get_the_ID(), 'lf_status', ['fields' => 'ids']);
                                                    echo $status_terms
                                                        ? esc_url(get_term_link($status_terms[0], 'lf_status'))
                                                        : '#';
                                                    ?>">
                                                <svg width="12" height="11" viewbox="0 0 12 11" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.8019 6.17453H2.56566C2.00285 6.17453 1.53613 5.70782 1.53613 5.14501C1.53613 4.5822 2.00285 4.11548 2.56566 4.11548H10.8019C11.3647 4.11548 11.8314 4.5822 11.8314 5.14501C11.8314 5.70782 11.3647 6.17453 10.8019 6.17453Z"
                                                          fill="#fff"></path>
                                                    <path d="M5.31096 10.2918C5.05014 10.2918 4.78933 10.1958 4.58342 9.98985L0.465311 5.87174C0.067227 5.47366 0.067227 4.81476 0.465311 4.41667L4.58342 0.298563C4.98151 -0.099521 5.64041 -0.099521 6.03849 0.298563C6.43657 0.696647 6.43657 1.35554 6.03849 1.75363L2.64791 5.14421L6.03849 8.53479C6.43657 8.93287 6.43657 9.59177 6.03849 9.98985C5.83258 10.1958 5.57177 10.2918 5.31096 10.2918Z"
                                                          fill="#fff"></path>
                                                </svg>
                                                <span class="mr-2 YekanBakhFaNum-SemiBold">
                        <?php
                        $status_names = wp_get_post_terms(get_the_ID(), 'lf_status', ['fields' => 'names']);
                        echo esc_html($status_names[0] ?? '');
                        ?>
                      </span>
                                            </a>
                                        </div>
                                        <p><?php echo esc_html(wp_trim_words(get_the_content(), 15, '…')); ?></p>
                                        <div class="d-flex align-items-center justify-content-end mt-3 px-2">
                                            <a class="d-flex justify-content-center align-items-center"
                                               href="<?php the_permalink(); ?>">
                                                <span class="ml-2 show-more"><?php _e('ادامه مطلب', 'petyar'); ?></span>
                                                <svg width="12" height="11" viewbox="0 0 12 11" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.8019 6.17453H2.56566C2.00285 6.17453 1.53613 5.70782 1.53613 5.14501C1.53613 4.5822 2.00285 4.11548 2.56566 4.11548H10.8019C11.3647 4.11548 11.8314 4.5822 11.8314 5.14501C11.8314 5.70782 11.3647 6.17453 10.8019 6.17453Z"
                                                          fill="#fff"></path>
                                                    <path d="M5.31096 10.2918C5.05014 10.2918 4.78933 10.1958 4.58342 9.98985L0.465311 5.87174C0.067227 5.47366 0.067227 4.81476 0.465311 4.41667L4.58342 0.298563C4.98151 -0.099521 5.64041 -0.099521 6.03849 0.298563C6.43657 0.696647 6.43657 1.35554 6.03849 1.75363L2.64791 5.14421L6.03849 8.53479C6.43657 8.93287 6.43657 9.59177 6.03849 9.98985C5.83258 10.1958 5.57177 10.2918 5.31096 10.2918Z"
                                                          fill="#fff"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    else: ?>
                        <p class="text-center"><?php _e('فعلاً آگهی جدیدی وجود ندارد.', 'petyar'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>


<?php
get_footer();
