<?php get_header(); ?>

<section class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <h2><?php _e('گم/پیدا شده', 'petyar'); ?></h2>

            <div class="row">
                <?php
                $lost_posts = new WP_Query([
                    'post_type' => 'lost-found',
                    'posts_per_page' => 10,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'tax_query' => [
                        [
                            'taxonomy' => 'lf_status',
                            'field' => 'slug',
                            'terms' => 'approved',
                        ],
                    ],
                ]);

                if ($lost_posts->have_posts()) :
                    while ($lost_posts->have_posts()) : $lost_posts->the_post();
                        $status_terms = wp_get_post_terms(get_the_ID(), 'lf_status');
                        $status_name = !empty($status_terms) ? $status_terms[0]->name : __('بدون وضعیت', 'petyar');
                        $status_link = !empty($status_terms) ? get_term_link($status_terms[0]) : '#';
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card p-3 mb-3 carding-blog overlyblog">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'img-fluid']); ?>
                                </a>
                                <div class="p_relative">
                                    <h5 class="mt-3 YekanBakhFaNum-Bold">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h5>
                                    <div class="d-flex justify-content-center mb-2">
                                        <a class="cateblog d-flex justify-content-center align-items-center"
                                           href="<?php echo esc_url($status_link); ?>">
                                            <span class="mr-2 YekanBakhFaNum-SemiBold">
                                                <?php echo esc_html($status_name); ?>
                                            </span>
                                        </a>
                                    </div>
                                    <p><?php echo esc_html(wp_trim_words(get_the_content(), 15, '…')); ?></p>
                                    <div class="d-flex align-items-center justify-content-end mt-3 px-2">
                                        <a class="d-flex justify-content-center align-items-center"
                                           href="<?php the_permalink(); ?>">
                                            <span class="ml-2 show-more"><?php _e('ادامه مطلب', 'petyar'); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else: ?>
                    <p class="text-center"><?php _e('فعلاً آگهی جدیدی وجود ندارد.', 'petyar'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
