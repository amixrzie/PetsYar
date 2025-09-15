<?php
get_header();
?>

    <section class="container-fluid text-lg-right text-center my-4 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 pl-lg-5">

                    <div class="d-flex align-items-center mb-1">
                        <h2 class="mr-3">درباره ما</h2>
                    </div>
                    <p class="mb-3">پت یار، سرزمین حیوانات خانگی با محصولات باکیفیت برای پت‌های شما</p>
                    <h3 class="mt-4 color-orange">سرزمین حیوانات خانگی</h3>
                    <p class="my-4 text-justify">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ …
                    </p>


                </div>

                <div class="col-lg-5 d-flex align-items-center">
                    <img src="<?php echo esc_url(THEME_ASSETS . '/img/about-us.png'); ?>"
                         class="img-fluid wapp"
                         alt="درباره ما">
                </div>
            </div>
        </div>
    </section>

    <section class="text-lg-right text-center my-4">
        <div class="container py-3 p-lg-5">
            <div class="row">

                <div class="col-lg-5 d-lg-block d-none">
                    <img src="<?php echo esc_url(THEME_ASSETS . '/img/dog-b2.png'); ?>"
                         class="img-fluid wapp"
                         alt="سوالات متداول">
                </div>

                <div class="col-lg-7 pr-lg-5">
                    <div class="d-flex align-items-center mb-1">
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

                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="d-flex align-items-center mb-1">

                    <h2 class="mr-3">سوالات متداول</h2>
                </div>
                <p class="mb-3">دلایلی که می‌توانید با خیال راحت به ما اعتماد کنید.</p>

                <div class="row my-5">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card profile p-3 overlyblog">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/Img/amixrzi.jpg'); ?>"
                                 alt="امیرحسین ">
                            <h3 class="YekanBakhFaNum-Bold"> امیرحسین رضایی</h3>
                            <p class="YekanBakhFaNum-SemiBold color-orange">برنامه نویس</p>
                            <p class="my-2 fa14">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم …</p>
                            <ul>

                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card profile p-3 overlyblog">
                            <img src="<?php echo esc_url(THEME_ASSETS . ''); ?>" alt=" احسان">
                            <h3 class="YekanBakhFaNum-Bold">احسان صفدری</h3>
                            <p class="YekanBakhFaNum-SemiBold color-orange">برنامه نویس</p>
                            <p class="my-2 fa14">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم …</p>
                            <ul>
                            
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php
get_footer();