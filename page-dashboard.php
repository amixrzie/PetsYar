<?php
/**
 * Template Name: Dashboard
 * Template Post Type: page
 *
 * File: page-dashboard.php
 * Path: /wp-content/themes/petsyar/page-dashboard.php
 */

// قبل از هر خروجی، دسترسی را بررسی و ریدایرکت کنید
if ( ! is_user_logged_in() || ! current_user_can( 'edit_lost_found' ) ) {
    wp_safe_redirect( home_url( '/login/' ) );
    exit;
}

get_header();

// پردازش فرم ارسال آگهی جدید
$errors  = [];
$success = false;
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset( $_POST['petyar_lostfound_nonce'] )
) {
    if ( ! wp_verify_nonce( $_POST['petyar_lostfound_nonce'], 'petyar_save_lostfound' ) ) {
        $errors[] = __( 'خطای امنیتی.', 'petyar' );
    } else {
        $title   = sanitize_text_field( $_POST['title']   ?? '' );
        $content = sanitize_textarea_field( $_POST['content'] ?? '' );
        $status  = sanitize_text_field( $_POST['lf_status']  ?? '' );
        $species = sanitize_text_field( $_POST['lf_species'] ?? '' );

        if ( ! $title || ! $content || ! $status || ! $species ) {
            $errors[] = __( 'لطفاً همه‌ی فیلدها را پر کنید.', 'petyar' );
        } else {
            $post_id = wp_insert_post([
                'post_type'    => 'lost_found',
                'post_title'   => $title,
                'post_content' => $content,
                'post_status'  => 'pending',
                'post_author'  => get_current_user_id(),
            ]);

            if ( is_wp_error( $post_id ) ) {
                $errors[] = $post_id->get_error_message();
            } else {
                wp_set_post_terms( $post_id, [ $status ],  'lf_status' );
                wp_set_post_terms( $post_id, [ $species ], 'lf_species' );

                // پردازش تصویر شاخص (اختیاری)
                if ( ! empty( $_FILES['featured_image']['name'] ) ) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';
                    require_once ABSPATH . 'wp-admin/includes/image.php';

                    $attach_id = media_handle_upload( 'featured_image', $post_id );
                    if ( is_wp_error( $attach_id ) ) {
                        $errors[] = __( 'آپلود تصویر با خطا مواجه شد.', 'petyar' );
                    } else {
                        set_post_thumbnail( $post_id, $attach_id );
                    }
                }

                if ( empty( $errors ) ) {
                    $success = true;
                }
            }
        }
    }
}

// گرفتن آگهی‌های کاربر
$user_ads = get_posts([
    'post_type'   => 'lost_found',
    'author'      => get_current_user_id(),
    'post_status' => ['pending','draft','publish'],
    'orderby'     => 'date',
    'order'       => 'DESC',
]);

// ترم‌های وضعیت و نوع
$status_terms  = get_terms([ 'taxonomy'=>'lf_status',  'hide_empty'=>false ]);
$species_terms = get_terms([ 'taxonomy'=>'lf_species', 'hide_empty'=>false ]);
?>

<section class="container my-4">
  <?php if ( $success ) : ?>
    <div class="alert alert-success">
      <?php _e( 'آگهی شما ثبت شد و پس از تأیید منتشر می‌شود.', 'petyar' ); ?>
    </div>
  <?php endif; ?>

  <?php if ( $errors ) : ?>
    <div class="alert alert-danger">
      <?php foreach ( $errors as $err ) : ?>
        <p><?php echo esc_html( $err ); ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- فرم ثبت آگهی جدید -->
  <h2><?php _e( 'ثبت آگهی جدید', 'petyar' ); ?></h2>
  <form method="post" enctype="multipart/form-data">
    <?php wp_nonce_field( 'petyar_save_lostfound', 'petyar_lostfound_nonce' ); ?>

    <div class="form-group">
      <label><?php _e( 'عنوان آگهی', 'petyar' ); ?></label>
      <input name="title" class="form-control"
             value="<?php echo esc_attr( $_POST['title'] ?? '' ); ?>"
             required>
    </div>

    <div class="form-group">
      <label><?php _e( 'توضیحات', 'petyar' ); ?></label>
      <textarea name="content" class="form-control" rows="4" required><?php
        echo esc_textarea( $_POST['content'] ?? '' );
      ?></textarea>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label><?php _e( 'وضعیت', 'petyar' ); ?></label>
        <select name="lf_status" class="form-control" required>
          <option value=""><?php _e( 'انتخاب کنید…', 'petyar' ); ?></option>
          <?php foreach ( $status_terms as $term ) : ?>
            <option value="<?php echo esc_attr( $term->slug ); ?>"
              <?php selected( $term->slug, $_POST['lf_status'] ?? '' ); ?>>
              <?php echo esc_html( $term->name ); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group col-md-6">
        <label><?php _e( 'نوع حیوان', 'petyar' ); ?></label>
        <select name="lf_species" class="form-control" required>
          <option value=""><?php _e( 'انتخاب کنید…', 'petyar' ); ?></option>
          <?php foreach ( $species_terms as $term ) : ?>
            <option value="<?php echo esc_attr( $term->slug ); ?>"
              <?php selected( $term->slug, $_POST['lf_species'] ?? '' ); ?>>
              <?php echo esc_html( $term->name ); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label><?php _e( 'تصویر شاخص (اختیاری)', 'petyar' ); ?></label>
      <input type="file" name="featured_image" class="form-control-file">
    </div>

    <button type="submit" class="btn btn-primary">
      <?php _e( 'ارسال آگهی', 'petyar' ); ?>
    </button>
  </form>

  <!-- جدول آگهی‌های کاربر -->
  <h3 class="mt-5"><?php _e( 'آگهی‌های من', 'petyar' ); ?></h3>
  <?php if ( $user_ads ) : ?>
    <table class="table table-bordered mt-2">
      <thead>
        <tr>
          <th><?php _e( 'عنوان', 'petyar' ); ?></th>
          <th><?php _e( 'وضعیت', 'petyar' ); ?></th>
          <th><?php _e( 'تاریخ', 'petyar' ); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ( $user_ads as $ad ) : 
          $st = wp_get_post_terms( $ad->ID, 'lf_status', ['fields'=>'names'] )[0] ?? '';
        ?>
          <tr>
            <td><?php echo esc_html( $ad->post_title ); ?></td>
            <td><?php echo esc_html( $st ); ?></td>
            <td><?php echo esc_html( date_i18n( 'Y/m/d', strtotime( $ad->post_date ) ) ); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else : ?>
    <p><?php _e( 'شما هنوز آگهی‌ای ثبت نکرده‌اید.', 'petyar' ); ?></p>
  <?php endif; ?>

</section>

<?php
get_footer();