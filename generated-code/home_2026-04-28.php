<?php
/**
 * Plugin Name: Techforce Home Page
 * Description: Registers the [techforce_home] shortcode rendering the demo home page (hero, services preview, why-choose-us, testimonials, final CTA). Part of the Techforce 3-page starter scaffold.
 * Version:     1.0.0
 * Author:      Techforce
 * License:     GPL-2.0-or-later
 * Text Domain: techforce
 *
 * @package Techforce\Home
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared site CSS used by every Techforce page plugin (home, about, services).
 *
 * Defined behind function_exists so any one of the three plugins can be the
 * first to load and own this definition; the others reuse it.
 *
 * @return string CSS rules without surrounding <style> tags.
 */
if ( ! function_exists( 'techforce_site_get_shared_css' ) ) {
	function techforce_site_get_shared_css() {
		return "
:root{--tf-primary:#2563eb;--tf-primary-dark:#1d4ed8;--tf-accent:#0ea5e9;--tf-text:#111827;--tf-muted:#4b5563;--tf-surface:#ffffff;--tf-bg:#f9fafb;--tf-border:#e5e7eb;}
.techforce-site,.techforce-site *{box-sizing:border-box;}
.techforce-site{font-family:'Inter',system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;color:var(--tf-text);line-height:1.6;}
.techforce-container{max-width:1200px;margin-inline:auto;padding:0 1.5rem;}
.techforce-section{padding:4rem 0;}
.techforce-section--alt{background:var(--tf-bg);}
.techforce-section h1{font-size:clamp(2rem,4vw,3rem);line-height:1.15;margin:0 0 1rem;color:var(--tf-text);}
.techforce-section h2{font-size:clamp(1.5rem,3vw,2.25rem);line-height:1.2;margin:0 0 1rem;color:var(--tf-text);}
.techforce-section h3{font-size:1.15rem;line-height:1.3;margin:0 0 .5rem;color:var(--tf-text);}
.techforce-lead{font-size:1.15rem;color:var(--tf-muted);margin:0 0 2rem;}
.techforce-btn{display:inline-block;padding:.85rem 1.5rem;border-radius:8px;font-weight:600;text-decoration:none;transition:background .15s ease,color .15s ease;font-family:inherit;font-size:1rem;}
.techforce-btn--primary{background:var(--tf-primary);color:#fff;}
.techforce-btn--primary:hover,.techforce-btn--primary:focus{background:var(--tf-primary-dark);color:#fff;}
.techforce-btn--secondary{background:transparent;color:var(--tf-primary);border:2px solid var(--tf-primary);padding:calc(.85rem - 2px) calc(1.5rem - 2px);}
.techforce-btn--secondary:hover,.techforce-btn--secondary:focus{background:var(--tf-primary);color:#fff;}
.techforce-grid{display:grid;gap:1.5rem;}
.techforce-grid--3{grid-template-columns:repeat(3,1fr);}
.techforce-grid--4{grid-template-columns:repeat(4,1fr);}
@media (max-width:1024px){.techforce-grid--4,.techforce-grid--3{grid-template-columns:repeat(2,1fr);}}
@media (max-width:640px){.techforce-grid--3,.techforce-grid--4{grid-template-columns:1fr;}}
.techforce-card{background:var(--tf-surface);border:1px solid var(--tf-border);border-radius:12px;padding:1.5rem;display:flex;flex-direction:column;}
.techforce-card h3{margin-top:0;}
.techforce-card p{color:var(--tf-muted);margin:0 0 .75rem;}
.techforce-card a{color:var(--tf-primary);text-decoration:none;font-weight:600;margin-top:auto;}
.techforce-card a:hover,.techforce-card a:focus{text-decoration:underline;}
.techforce-page-header{padding:4rem 0 2rem;text-align:center;}
.techforce-page-header h1{margin:0 0 1rem;}
.techforce-page-header .techforce-lead{max-width:680px;margin-inline:auto;}
.techforce-cta-banner{background:var(--tf-primary);color:#fff;padding:3rem 1.5rem;border-radius:12px;text-align:center;}
.techforce-cta-banner h2{color:#fff;margin:0 0 .75rem;}
.techforce-cta-banner p{color:#e0ecff;margin:0 0 1.5rem;font-size:1.05rem;}
.techforce-cta-banner .techforce-btn--primary{background:#fff;color:var(--tf-primary);}
.techforce-cta-banner .techforce-btn--primary:hover,.techforce-cta-banner .techforce-btn--primary:focus{background:var(--tf-bg);color:var(--tf-primary-dark);}
.techforce-icon{color:var(--tf-primary);font-size:2rem;width:2rem;height:2rem;margin-bottom:.75rem;display:inline-block;}
.techforce-icon::before{font-size:2rem;width:2rem;height:2rem;line-height:1;}
";
	}
}

/**
 * Register the shared techforce-site stylesheet handle and attach the shared
 * CSS exactly once, regardless of which Techforce page plugin calls first.
 *
 * @return void
 */
if ( ! function_exists( 'techforce_site_register_shared_styles' ) ) {
	function techforce_site_register_shared_styles() {
		if ( wp_style_is( 'techforce-site', 'registered' ) ) {
			return;
		}
		wp_register_style( 'techforce-site', false, array(), '1.0.0' );
		wp_add_inline_style( 'techforce-site', techforce_site_get_shared_css() );
	}
}

/**
 * Page-specific CSS for the home page only.
 *
 * @return string CSS rules without surrounding <style> tags.
 */
function techforce_home_get_css() {
	return "
.techforce-home-hero{padding:5rem 0 4rem;text-align:center;background:linear-gradient(180deg,#ffffff 0%,var(--tf-bg) 100%);}
.techforce-home-hero h1{max-width:760px;margin:0 auto 1rem;}
.techforce-home-hero .techforce-lead{max-width:680px;margin:0 auto 2rem;}
.techforce-home-hero-ctas{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;}
.techforce-home-empty-testimonials{text-align:center;color:var(--tf-muted);font-style:italic;padding:2rem;border:1px dashed var(--tf-border);border-radius:12px;margin:0;}
";
}

/**
 * Enqueue shared and page-specific styles for the home page.
 *
 * Gated on has_shortcode() so the inline CSS only ships on pages that
 * actually use [techforce_home].
 *
 * @return void
 */
function techforce_home_enqueue_styles() {
	$post = get_post();
	if ( ! $post || ! has_shortcode( $post->post_content, 'techforce_home' ) ) {
		return;
	}
	wp_enqueue_style( 'dashicons' );
	techforce_site_register_shared_styles();
	wp_enqueue_style( 'techforce-site' );
	wp_add_inline_style( 'techforce-site', techforce_home_get_css() );
}
add_action( 'wp_enqueue_scripts', 'techforce_home_enqueue_styles' );

/**
 * Render the [techforce_home] shortcode.
 *
 * @param array|string $atts Shortcode attributes (none currently supported).
 * @return string Rendered HTML.
 */
function techforce_home_shortcode( $atts ) {
	unset( $atts );

	$services = array(
		array(
			'icon'  => 'dashicons-cloud',
			'title' => __( 'Cloud Infrastructure', 'techforce' ),
			'desc'  => __( 'Scalable, resilient cloud architecture across AWS, Azure, and Google Cloud.', 'techforce' ),
		),
		array(
			'icon'  => 'dashicons-shield',
			'title' => __( 'Cybersecurity', 'techforce' ),
			'desc'  => __( 'Proactive defense, monitoring, and compliance to protect your business.', 'techforce' ),
		),
		array(
			'icon'  => 'dashicons-admin-tools',
			'title' => __( 'Managed IT Support', 'techforce' ),
			'desc'  => __( 'Round-the-clock helpdesk and infrastructure management for your team.', 'techforce' ),
		),
	);

	$reasons = array(
		array(
			'icon'  => 'dashicons-clock',
			'title' => __( '24/7 Response', 'techforce' ),
			'desc'  => __( 'A real engineer on the line whenever something goes wrong — nights, weekends, holidays.', 'techforce' ),
		),
		array(
			'icon'  => 'dashicons-awards',
			'title' => __( 'Certified Expertise', 'techforce' ),
			'desc'  => __( 'Engineers certified across the major cloud and security platforms your stack depends on.', 'techforce' ),
		),
		array(
			'icon'  => 'dashicons-admin-customizer',
			'title' => __( 'Tailored Solutions', 'techforce' ),
			'desc'  => __( 'No cookie-cutter packages — we design what fits your team, your budget, and your roadmap.', 'techforce' ),
		),
	);

	$services_url = home_url( '/services' );
	$contact_url  = home_url( '/contact' );

	ob_start();
	?>
	<div class="techforce-site">

		<section class="techforce-home-hero">
			<div class="techforce-container">
				<h1><?php esc_html_e( 'Modern IT Services for Growing Businesses', 'techforce' ); ?></h1>
				<p class="techforce-lead"><?php esc_html_e( 'Cloud, security, and support engineered around your business — not the other way around.', 'techforce' ); ?></p>
				<div class="techforce-home-hero-ctas">
					<a href="<?php echo esc_url( $contact_url ); ?>" class="techforce-btn techforce-btn--primary"><?php esc_html_e( 'Get a Quote', 'techforce' ); ?></a>
					<a href="<?php echo esc_url( $services_url ); ?>" class="techforce-btn techforce-btn--secondary"><?php esc_html_e( 'Our Services', 'techforce' ); ?></a>
				</div>
			</div>
		</section>

		<section class="techforce-section">
			<div class="techforce-container">
				<h2><?php esc_html_e( 'What we do', 'techforce' ); ?></h2>
				<p class="techforce-lead"><?php esc_html_e( 'Three core practices, all under one roof.', 'techforce' ); ?></p>
				<div class="techforce-grid techforce-grid--3">
					<?php foreach ( $services as $service ) : ?>
						<article class="techforce-card">
							<span class="dashicons <?php echo esc_attr( $service['icon'] ); ?> techforce-icon" aria-hidden="true"></span>
							<h3><?php echo esc_html( $service['title'] ); ?></h3>
							<p><?php echo esc_html( $service['desc'] ); ?></p>
							<a href="<?php echo esc_url( $services_url ); ?>"><?php esc_html_e( 'Learn more →', 'techforce' ); ?></a>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="techforce-section techforce-section--alt">
			<div class="techforce-container">
				<h2><?php esc_html_e( 'Why choose us', 'techforce' ); ?></h2>
				<div class="techforce-grid techforce-grid--3">
					<?php foreach ( $reasons as $reason ) : ?>
						<article class="techforce-card">
							<span class="dashicons <?php echo esc_attr( $reason['icon'] ); ?> techforce-icon" aria-hidden="true"></span>
							<h3><?php echo esc_html( $reason['title'] ); ?></h3>
							<p><?php echo esc_html( $reason['desc'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="techforce-section">
			<div class="techforce-container">
				<h2><?php esc_html_e( 'What our clients say', 'techforce' ); ?></h2>
				<?php
				$testimonials_html = do_shortcode( '[techforce_testimonials limit="3"]' );
				if ( '' === trim( $testimonials_html ) ) {
					echo '<p class="techforce-home-empty-testimonials">' . esc_html__( 'Testimonials coming soon.', 'techforce' ) . '</p>';
				} else {
					// Output of techforce_testimonials is already escaped by that plugin.
					echo $testimonials_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</section>

		<section class="techforce-section techforce-section--alt">
			<div class="techforce-container">
				<div class="techforce-cta-banner">
					<h2><?php esc_html_e( 'Ready to modernize your IT?', 'techforce' ); ?></h2>
					<p><?php esc_html_e( 'Tell us what you need. We\'ll come back with a plan within two business days.', 'techforce' ); ?></p>
					<a href="<?php echo esc_url( $contact_url ); ?>" class="techforce-btn techforce-btn--primary"><?php esc_html_e( 'Get a Quote', 'techforce' ); ?></a>
				</div>
			</div>
		</section>

	</div>
	<?php
	return (string) ob_get_clean();
}
add_shortcode( 'techforce_home', 'techforce_home_shortcode' );
