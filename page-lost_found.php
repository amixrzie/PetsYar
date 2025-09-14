<?php
/**
 * Archive Template for Lost & Found
 * File:    archive-lost_found.php
 * Path:    /wp-content/themes/petyar/archive-lost_found.php
 */
get_header();
?>

<section class="container mb-4">
  <div class="row">

    <!-- سایدبار -->
    <div class="col-xl-3 order-xl-1 pt-3 order-1 mb-3">
      <div class="d-flex align-items-center justify-content-center mb-3 bg-title-sidebar p-2 radius15">
        <!-- محل SVG ثابت -->
        <h3 class="mr-3">دسته بندی</h3>
      </div>
      <div class="card side-category p-4 mb-3">
        <ul class="list-unstyled">
          <?php
          $species_terms = get_terms([
            'taxonomy'   => 'lf_species',
            'hide_empty' => false,
          ]);
          foreach ( $species_terms as $term ) {
            $term_link = get_term_link( $term );
            echo '<li>';
              echo '<a href="'. esc_url( $term_link ) .'"><span>'. esc_html( $term->name ) .'</span></a>';
              echo '<a href="'. esc_url( $term_link ) .'">';
                echo '<div class="arrow-cat d-flex align-items-center justify-content-center">';
                  // محل SVG آیکون فلش
                echo '</div>';
              echo '</a>';
            echo '</li>';
            
          }
          ?>
        </ul>
      </div>
    </div>
    <!-- /سایدبار -->

    <!-- لیست آگهی‌ها -->
    <div class="col-xl-9 order-xl-0 pl-4 order-0 mb-3 p-3">
            <div class="row">
                <?php
                $lost_posts = new WP_Query([
                    'post_type'      => 'lost_found',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ]);
                if ( $lost_posts->have_posts() ) :
                while ( $lost_posts->have_posts() ) : $lost_posts->the_post(); ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card p-3 mb-3 carding-blog overlyblog">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', ['class'=>'img-fluid']); ?>
                            </a>
                            <div class="p_relative">
                                <h5 class="mt-5 YekanBakhFaNum-Bold">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h5>
                                <div class="d-flex justify-content-center">
                                    <a
                                            class="cateblog d-flex justify-content-center align-items-center"
                                            href="<?php
                                            $status_terms = wp_get_post_terms(get_the_ID(), 'lf_status', ['fields'=>'ids']);
                                            echo $status_terms
                                                ? esc_url( get_term_link( $status_terms[0], 'lf_status' ) )
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
                        $status_names = wp_get_post_terms(get_the_ID(), 'lf_status', ['fields'=>'names']);
                        echo esc_html( $status_names[0] ?? '' );
                        ?>
                      </span>
                                    </a>
                                </div>
                                <p><?php echo esc_html( wp_trim_words( get_the_content(), 15, '…' ) ); ?></p>
                                <div class="d-flex align-items-center justify-content-end mt-3 px-2">
                                    <a class="d-flex justify-content-center align-items-center" href="<?php the_permalink(); ?>">
                                        <span class="ml-2 show-more"><?php _e('ادامه مطلب', 'petyar'); ?></span>
                                        <svg width="12" height="11" viewbox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
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

      <!-- صفحه‌بندی -->
      <div class="row mt-3">
        <div class="col-12 text-center mx-auto">
          <ul class="pagination justify-content-center">
            <?php
            echo paginate_links([
              'type'      => 'list',
              'prev_text' => '&laquo;',
              'next_text' => '&raquo;',
              'mid_size'  => 1,
            ]);
            ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- /لیست آگهی‌ها -->

  </div>
</section>

<?php get_footer(); ?>