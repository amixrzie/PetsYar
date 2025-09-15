<?php

get_header();


$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    wp_safe_redirect(get_permalink(get_page_by_path('cart')));
    exit;
}


$total = 0;
?>

    <section class="text-lg-right text-center my-4">
        <div class="container">
            <div class="card p-5 p-checkout">
                <div class="row">
                    <form method="post" action="" class="contact-form d-flex justify-content-between form-checkout">


                        <div class="col-lg-8">
                            <p class="mb-3">جزئیات صورتحساب:</p>
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label><?php _e('نام:', 'petyar'); ?></label>
                                    <input name="billing_first_name" type="text" class="form-control mb-1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('نام خانوادگی:', 'petyar'); ?></label>
                                    <input name="billing_last_name" type="text" class="form-control mb-1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('نام شرکت (اختیاری):', 'petyar'); ?></label>
                                    <input name="billing_company" type="text" class="form-control mb-1">
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('کشور | منطقه:', 'petyar'); ?></label>
                                    <input name="billing_country" type="text" class="form-control mb-1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('استان:', 'petyar'); ?></label>
                                    <input name="billing_state" type="text" class="form-control mb-1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('شهر:', 'petyar'); ?></label>
                                    <input name="billing_city" type="text" class="form-control mb-1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('آدرس خیابان:', 'petyar'); ?></label>
                                    <input name="billing_address1" type="text" class="form-control mb-1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('آپارتمان، واحد… (اختیاری):', 'petyar'); ?></label>
                                    <input name="billing_address2" type="text" class="form-control mb-1">
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('کدپستی:', 'petyar'); ?></label>
                                    <input name="billing_postcode" type="text" class="form-control mb-1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('تلفن:', 'petyar'); ?></label>
                                    <input name="billing_phone" type="text" class="form-control mb-1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php _e('ایمیل:', 'petyar'); ?></label>
                                    <input name="billing_email" type="email" class="form-control mb-1" required>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4">
                            <p class="mb-3"><?php _e('سفارش شما:', 'petyar'); ?></p>
                            <div class="bg-title-sidebar radius20 side-category p-4 mb-2">
                                <ul class="list-unstyled">

                                    <?php foreach ($cart as $pid => $qty):
                                        $price = floatval(get_post_meta($pid, 'product_price', true));
                                        $subtotal = $price * $qty;
                                        $total += $subtotal;
                                        $title = get_the_title($pid);
                                        ?>
                                        <li>
                                            <?php echo esc_html($title); ?>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <?php echo number_format($subtotal); ?> تومان
                                            </div>
                                        </li>
                                    <?php endforeach; ?>

                                    <hr>

                                    <li>
                                        <?php _e('جمع جزء:', 'petyar'); ?>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <?php echo number_format($total); ?> تومان
                                        </div>
                                    </li>
                                    <li>
                                        <?php _e('حمل و نقل:', 'petyar'); ?>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <?php _e('رایگان', 'petyar'); ?>
                                        </div>
                                    </li>
                                    <li>
                                        <?php _e('مجموع:', 'petyar'); ?>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <?php echo number_format($total); ?> تومان
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <button type="submit" name="place_order" class="btn btn-lightorng btn-checkout">
                                <?php _e('ثبت سفارش و پرداخت', 'petyar'); ?>
                                <a href="<?php echo $home_url; ?>"></a>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

<?php
get_footer();