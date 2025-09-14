<?php
/**
 * Template Name: Cart Page
 * Template Post Type: page
 *
 * File: page-cart.php
 * Path: /wp-content/themes/petsyar/page-cart.php
 */

get_header();

// جمع کل و آرایه‌ی سبد
$cart   = ! empty( $_SESSION['cart'] ) ? $_SESSION['cart'] : [];
$total  = 0;
?>

<section class="container mb-4">
  <div class="row">

    <!-- لیست کالاها -->
    <div class="col-xl-8 order-xl-0 order-0 mb-3">
      <form method="post" action="">
        <div class="card m-3 p-4">
          <?php if ( $cart ) : ?>
            <?php foreach ( $cart as $pid => $qty ) : 
              // داده‌های محصول
              $price    = (float) get_post_meta( $pid, 'product_price', true );
              $subtotal = $price * $qty;
              $total   += $subtotal;
              $title    = get_the_title( $pid );
              $img      = get_the_post_thumbnail_url( $pid, 'medium' );
            ?>
              <div class="item">
                <div class="d-flex align-items-center justify-content-between mb-cart cart-res">

                  <!-- تصویر -->
                  <div class="col-lg-3">
                    <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>">
                  </div>

                  <!-- نام محصول -->
                  <div class="col-lg-3"><?php echo esc_html( $title ); ?></div>

                  <!-- قیمت واحد -->
                  <div class="col-lg-3"><?php echo number_format( $price ); ?> تومان</div>

                  <!-- کنترل تعداد -->
                  <div class="col-lg-3">
                    <div class="input-group d-flex align-items-center justify-content-center cart-increment radius20">

                      <span class="input-group-btn">
                        <button type="button" class="quantity-left-minus btn p-3" 
                                onclick="let f=this.closest('.input-group').querySelector('input'); if(f.value>1)f.value--; ">
                          <!-- SVG منفی -->
                          <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.8692 4.74121H1.36621" stroke="#4e62af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                        </button>
                      </span>

                      <input type="text" name="quantity[<?php echo $pid; ?>]"
                             class="input-cart form-control input-number"
                             value="<?php echo esc_attr( $qty ); ?>" min="1" max="100">

                      <span class="input-group-btn">
                        <button type="button" class="quantity-right-plus btn p-3"
                                onclick="let f=this.closest('.input-group').querySelector('input'); f.value++;">
                          <!-- SVG مثبت -->
                          <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.41602 1.71582V13.8158" stroke="#4e62af" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.599 7.76782H1.25195" stroke="#4e62af" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                        </button>
                      </span>

                    </div>
                  </div>

                </div>
              </div>
            <?php endforeach; ?>

            <!-- دکمه بروزرسانی سبد -->
            <div class="text-left mt-3 ml-3">
              <input type="submit" name="update_cart" class="btn btn-primary" 
                     value="<?php _e( 'بروزرسانی سبد', 'petyar' ); ?>">
            </div>

          <?php else : ?>
            <p class="text-center"><?php _e( 'سبد خرید شما خالی است.', 'petyar' ); ?></p>
          <?php endif; ?>
        </div>
      </form>
    </div>
    <!-- خلاصه قیمت و دکمه پرداخت -->
    <div class="col-xl-4 order-xl-1 pt-3 order-1 mb-3">
      <div class="card side-category p-4 mb-3">
        <ul class="list-unstyled">
          <li class="p-3 bg-title-sidebar radius15">
            <?php _e( 'جمع قیمت کالاها', 'petyar' ); ?>
            <div class="d-flex align-items-center justify-content-center">
              <?php echo number_format( $total ); ?> تومان
            </div>
          </li>
        </ul>

        <p>
          <?php _e( 'هزینه این سفارش هنوز پرداخت نشده است و در صورت تکمیل موجودی‌ کالاها از سبد شما حذف می‌گردند.', 'petyar' ); ?>
        </p>

        <a class="a-button radius55 py-3 px-4 text-center mt-3"
           href="<?php echo esc_url( add_query_arg( 'checkout', '1', get_permalink() ) ); ?>">
          <span class="ml-2"><?php _e( 'ثبت سفارش و پرداخت', 'petyar' ); ?></span>
        </a>
      </div>
    </div>

  </div>
</section>

<?php
get_footer();