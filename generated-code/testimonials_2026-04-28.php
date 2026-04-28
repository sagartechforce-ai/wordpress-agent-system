<?php
/**
 * Plugin Name: Techforce Testimonials
 * Description: Custom Post Type, admin meta box, and responsive shortcode grid for client testimonials.
 * Version:     1.0.0
 * Author:      Techforce
 * License:     GPL-2.0-or-later
 * Text Domain: techforce
 *
 * @package Techforce\Testimonials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the tf_testimonial custom post type.
 *
 * @return void
 */
function techforce_testimonials_register_cpt() {
	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post type general name', 'techforce' ),
		'singular_name'         => _x( 'Testimonial', 'Post type singular name', 'techforce' ),
		'menu_name'             => _x( 'Testimonials', 'Admin Menu text', 'techforce' ),
		'name_admin_bar'        => _x( 'Testimonial', 'Add New on Toolbar', 'techforce' ),
		'add_new'               => __( 'Add New', 'techforce' ),
		'add_new_item'          => __( 'Add New Testimonial', 'techforce' ),
		'new_item'              => __( 'New Testimonial', 'techforce' ),
		'edit_item'             => __( 'Edit Testimonial', 'techforce' ),
		'view_item'             => __( 'View Testimonial', 'techforce' ),
		'all_items'             => __( 'All Testimonials', 'techforce' ),
		'search_items'          => __( 'Search Testimonials', 'techforce' ),
		'not_found'             => __( 'No testimonials found.', 'techforce' ),
		'not_found_in_trash'    => __( 'No testimonials found in Trash.', 'techforce' ),
		'featured_image'        => __( 'Client Photo', 'techforce' ),
		'set_featured_image'    => __( 'Set client photo', 'techforce' ),
		'remove_featured_image' => __( 'Remove client photo', 'techforce' ),
		'use_featured_image'    => __( 'Use as client photo', 'techforce' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_position'      => 25,
		'menu_icon'          => 'dashicons-format-quote',
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
		'has_archive'        => false,
		'rewrite'            => false,
		'exclude_from_search' => true,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'tf_testimonial', $args );

	register_post_meta(
		'tf_testimonial',
		'_techforce_role_company',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => false,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => 'techforce_testimonials_meta_auth',
		)
	);

	register_post_meta(
		'tf_testimonial',
		'_techforce_rating',
		array(
			'type'              => 'integer',
			'single'            => true,
			'show_in_rest'      => false,
			'sanitize_callback' => 'absint',
			'auth_callback'     => 'techforce_testimonials_meta_auth',
		)
	);
}
add_action( 'init', 'techforce_testimonials_register_cpt' );

/**
 * Capability gate for editing testimonial meta via register_post_meta.
 *
 * @return bool True when the current user can edit posts.
 */
function techforce_testimonials_meta_auth() {
	return current_user_can( 'edit_posts' );
}

/**
 * Register the meta box for role/company and rating fields.
 *
 * @return void
 */
function techforce_testimonials_add_meta_box() {
	add_meta_box(
		'techforce_testimonial_details',
		__( 'Testimonial Details', 'techforce' ),
		'techforce_testimonials_render_meta_box',
		'tf_testimonial',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'techforce_testimonials_add_meta_box' );

/**
 * Render the meta box markup for role/company and rating.
 *
 * @param WP_Post $post Current post object.
 * @return void
 */
function techforce_testimonials_render_meta_box( $post ) {
	wp_nonce_field( 'techforce_testimonial_meta_nonce_action', 'techforce_testimonial_meta_nonce' );

	$role   = get_post_meta( $post->ID, '_techforce_role_company', true );
	$rating = (int) get_post_meta( $post->ID, '_techforce_rating', true );
	?>
	<p>
		<label for="techforce_role_company"><strong><?php esc_html_e( 'Role / Company', 'techforce' ); ?></strong></label><br />
		<input
			type="text"
			id="techforce_role_company"
			name="techforce_role_company"
			value="<?php echo esc_attr( $role ); ?>"
			class="widefat"
			maxlength="200"
		/>
		<span class="description"><?php esc_html_e( 'Example: CTO, Acme Inc.', 'techforce' ); ?></span>
	</p>
	<p>
		<label for="techforce_rating"><strong><?php esc_html_e( 'Rating', 'techforce' ); ?></strong></label><br />
		<select id="techforce_rating" name="techforce_rating" class="widefat">
			<option value="0" <?php selected( $rating, 0 ); ?>><?php esc_html_e( '— No rating —', 'techforce' ); ?></option>
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
				<option value="<?php echo esc_attr( (string) $i ); ?>" <?php selected( $rating, $i ); ?>>
					<?php
					echo esc_html(
						sprintf(
							/* translators: %d: rating value 1-5 */
							_n( '%d star', '%d stars', $i, 'techforce' ),
							$i
						)
					);
					?>
				</option>
			<?php endfor; ?>
		</select>
	</p>
	<?php
}

/**
 * Save the meta box fields for the testimonial CPT.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function techforce_testimonials_save_meta( $post_id ) {
	if ( ! isset( $_POST['techforce_testimonial_meta_nonce'] ) ) {
		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['techforce_testimonial_meta_nonce'] ) );
	if ( ! wp_verify_nonce( $nonce, 'techforce_testimonial_meta_nonce_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['techforce_role_company'] ) ) {
		$role = sanitize_text_field( wp_unslash( $_POST['techforce_role_company'] ) );
		if ( '' === $role ) {
			delete_post_meta( $post_id, '_techforce_role_company' );
		} else {
			update_post_meta( $post_id, '_techforce_role_company', $role );
		}
	}

	if ( isset( $_POST['techforce_rating'] ) ) {
		$rating = absint( wp_unslash( $_POST['techforce_rating'] ) );
		if ( $rating < 1 || $rating > 5 ) {
			delete_post_meta( $post_id, '_techforce_rating' );
		} else {
			update_post_meta( $post_id, '_techforce_rating', $rating );
		}
	}
}
add_action( 'save_post_tf_testimonial', 'techforce_testimonials_save_meta' );

/**
 * Return the inline CSS for the testimonials grid.
 *
 * @return string CSS rules without surrounding <style> tags.
 */
function techforce_testimonials_get_css() {
	return '
.techforce-testimonials-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin:2rem 0;}
@media (max-width:1024px){.techforce-testimonials-grid{grid-template-columns:repeat(2,1fr);}}
@media (max-width:640px){.techforce-testimonials-grid{grid-template-columns:1fr;}}
.techforce-testimonial-card{padding:1.5rem;border:1px solid #e0e0e0;border-radius:8px;background:#fff;display:flex;flex-direction:column;box-sizing:border-box;}
.techforce-testimonial-photo{margin-bottom:1rem;}
.techforce-testimonial-photo img{width:96px;height:96px;border-radius:50%;object-fit:cover;display:block;}
.techforce-testimonial-name{margin:0 0 .25rem;font-size:1.1rem;line-height:1.3;}
.techforce-testimonial-role{margin:0 0 .75rem;color:#666;font-size:.9rem;}
.techforce-testimonial-rating{margin:0 0 .75rem;color:#f5a623;letter-spacing:2px;font-size:1rem;}
.techforce-testimonial-quote{color:#333;line-height:1.6;}
.techforce-testimonial-quote p:last-child{margin-bottom:0;}
';
}

/**
 * Register and enqueue the inline stylesheet for the shortcode grid.
 *
 * @return void
 */
function techforce_testimonials_enqueue_styles() {
	wp_register_style( 'techforce-testimonials', false, array(), '1.0.0' );
	wp_enqueue_style( 'techforce-testimonials' );
	wp_add_inline_style( 'techforce-testimonials', techforce_testimonials_get_css() );
}
add_action( 'wp_enqueue_scripts', 'techforce_testimonials_enqueue_styles' );

/**
 * Render the [techforce_testimonials] shortcode.
 *
 * @param array|string $atts Shortcode attributes. Supported: limit (int, default -1 = all).
 * @return string Rendered HTML, or empty string when no testimonials exist.
 */
function techforce_testimonials_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'limit' => -1,
		),
		$atts,
		'techforce_testimonials'
	);

	$limit = (int) $atts['limit'];
	if ( 0 === $limit ) {
		$limit = -1;
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'tf_testimonial',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		)
	);

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return '';
	}

	ob_start();
	echo '<div class="techforce-testimonials-grid">';

	while ( $query->have_posts() ) {
		$query->the_post();
		$post_id = get_the_ID();
		$role    = (string) get_post_meta( $post_id, '_techforce_role_company', true );
		$rating  = (int) get_post_meta( $post_id, '_techforce_rating', true );
		if ( $rating < 0 || $rating > 5 ) {
			$rating = 0;
		}
		$name    = get_the_title();
		$content = get_the_content();
		?>
		<article class="techforce-testimonial-card">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="techforce-testimonial-photo">
					<?php
					the_post_thumbnail(
						'medium',
						array(
							'alt'     => esc_attr( $name ),
							'loading' => 'lazy',
						)
					);
					?>
				</div>
			<?php endif; ?>
			<h3 class="techforce-testimonial-name"><?php echo esc_html( $name ); ?></h3>
			<?php if ( '' !== $role ) : ?>
				<p class="techforce-testimonial-role"><?php echo esc_html( $role ); ?></p>
			<?php endif; ?>
			<?php if ( $rating >= 1 && $rating <= 5 ) : ?>
				<p
					class="techforce-testimonial-rating"
					aria-label="<?php echo esc_attr( sprintf( /* translators: %d: rating 1-5 */ _n( '%d out of 5 stars', '%d out of 5 stars', $rating, 'techforce' ), $rating ) ); ?>"
				>
					<span aria-hidden="true"><?php echo esc_html( str_repeat( "\xE2\x98\x85", $rating ) . str_repeat( "\xE2\x98\x86", 5 - $rating ) ); ?></span>
				</p>
			<?php endif; ?>
			<div class="techforce-testimonial-quote"><?php echo wp_kses_post( wpautop( $content ) ); ?></div>
		</article>
		<?php
	}

	echo '</div>';
	wp_reset_postdata();

	return (string) ob_get_clean();
}
add_shortcode( 'techforce_testimonials', 'techforce_testimonials_shortcode' );
