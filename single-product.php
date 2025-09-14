<?php
/**
 * single-product.php
 * قالب جزئیات محصول (CPT: product)
 */
get_header();
?>

<section class="container mb-4">
  <div class="row">

    <!-- سایدبار: محصولات مرتبط -->
    <div class="col-xl-3 order-xl-1 pt-3 order-1">
      <div class="mb-3">
        <div class="owl-product-page owl-carousel">
          <?php
          // دریافت ترم‌های دسته‌بندی محصول جاری
          $current_id = get_the_ID();
          $terms      = wp_get_post_terms( $current_id, 'product_category', [ 'fields' => 'ids' ] );
          // کوئری محصولات مرتبط (همان دسته، به غیر از خودِ این محصول)
          $related_args = [
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'post__not_in'   => [ $current_id ],
            'tax_query'      => [
              [
                'taxonomy' => 'product_category',
                'field'    => 'term_id',
                'terms'    => $terms,
              ],
            ],
          ];
          $related = new WP_Query( $related_args );
          if ( $related->have_posts() ) :
            while ( $related->have_posts() ) : $related->the_post(); ?>
              <div class="item">
                <div class="card-body mb-3 text-center">
                  <a href="<?php the_permalink(); ?>">
                    <?php
                    if ( has_post_thumbnail() ) {
                      the_post_thumbnail( 'medium', [ 'class' => 'img-fluid' ] );
                    } else {
                      echo '<img class="img-fluid" src="' . esc_url( get_template_directory_uri() . '/assets/img/no-image.png' ) . '">';
                    }
                    ?>
                  </a>
                  <div>
                    <h5 class="my-2 YekanBakhFaNum-SemiBold">
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h5>
                    <?php
                    $price = get_post_meta( get_the_ID(), 'product_price', true );
                    echo '<span class="color-orange YekanBakhFaNum-Bold fa18">' . number_format_i18n( $price ) . '</span>';
                    echo '<span class="color-orange YekanBakhFaNum-Regular fa14">تومان</span>';
                    ?>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="d-flex">
                        <a href="<?php echo esc_url( add_query_arg( 'add-to-cart', get_the_ID() ) ); ?>"
                           class="add-to-cart hoverable outlined">
                          <span class="text-center"><?php esc_html_e( 'افزودن به سبد خرید', 'petyar' ); ?></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            endwhile;
            wp_reset_postdata();
          else :
            echo '<p class="text-center">' . esc_html__( 'محصول مرتبطی یافت نشد.', 'petyar' ) . '</p>';
          endif;
          ?>
        </div>
      </div>
    </div><!-- /.col-xl-3 -->

    <!-- محتوای اصلی محصول -->
    <div class="col-xl-9 order-xl-0 order-0">
      <?php while ( have_posts() ) : the_post(); ?>
        <div class="card m-3 p-4">
          <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-6 d-flex align-items-center pic-product">
              <div class="white-box text-center">
                <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail( 'full', [ 'class' => 'img-responsive', 'alt' => get_the_title() ] );
                } else {
                  echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/img/no-image.png' ) . '" '
                     . 'class="img-responsive" alt="' . esc_attr( get_the_title() ) . '">';
                     }
                ?>
              </div>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-6">
              <h4 class="box-title"><?php the_title(); ?></h4>
              <hr>
              <div class="rating">
                <!-- اگر متا یا تابع امتیاز دارید اینجا قرار دهید -->
              </div>
              <ul class="list-unstyled">
                <?php
                $qty = get_post_meta( get_the_ID(), 'product_quantity', true );
                $qty = $qty ? absint( $qty ) : 0;
                ?>
                <li class="color-gray">
                  <?php esc_html_e( 'موجودی:', 'petyar' ); ?>
                  <span class="color-dark"><?php echo esc_html( number_format_i18n( $qty ) ); ?> <?php esc_html_e( 'عدد در انبار', 'petyar' ); ?></span>
                </li>
                <li class="color-gray">
                  <?php esc_html_e( 'توضیحات محصول:', 'petyar' ); ?>
                  <p class="color-dark"><?php the_content(); ?></p>
                </li>
              </ul>
              <div class="d-flex align-items-center justify-content-between my-4">
                <a href="<?php echo esc_url( add_query_arg( 'add-to-cart', get_the_ID() ) ); ?>"
                   class="btn btn-lightorng btn-rounded mr-1">
                  <?php esc_html_e( 'افزودن به سبد خرید', 'petyar' ); ?>
                </a>
                <?php
                $price = get_post_meta( get_the_ID(), 'product_price', true );
                ?>
                <h3 class="color-orange YekanBakhFaNum-Bold fa18">
                  <?php echo esc_html( number_format_i18n( $price ) ); ?>
                  <span class="YekanBakhFaNum-Regular fa14"><?php esc_html_e( 'تومان', 'petyar' ); ?></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div><!-- /.col-xl-9 -->
  </div><!-- /.row -->
</section>

<?php
get_footer();