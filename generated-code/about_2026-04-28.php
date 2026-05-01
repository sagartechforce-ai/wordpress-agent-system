<?php
/**
 * Plugin Name: Techforce About Page
 * Description: Registers the [techforce_about] shortcode rendering the demo About page (story, values, team, CTA). Part of the Techforce 3-page starter scaffold.
 * Version:     1.0.0
 * Author:      Techforce
 * License:     GPL-2.0-or-later
 * Text Domain: techforce
 *
 * @package Techforce\About
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
 * Page-specific CSS for the about page only.
 *
 * @return string CSS rules without surrounding <style> tags.
 */
function techforce_about_get_css() {
	return "
.techforce-about-story p{margin:0 0 1rem;color:var(--tf-text);}
.techforce-about-story{max-width:760px;}
.techforce-team-card{text-align:center;padding:1.5rem;align-items:center;}
.techforce-team-avatar{width:96px;height:96px;border-radius:50%;margin:0 auto 1rem;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1.75rem;letter-spacing:.05em;}
.techforce-team-card h3{margin:0 0 .25rem;font-size:1.05rem;}
.techforce-team-card p{margin:0;color:var(--tf-muted);font-size:.9rem;}
.techforce-value-card{padding:1.5rem;}
";
}

/**
 * Enqueue shared and page-specific styles for the about page.
 *
 * Gated on has_shortcode() so the inline CSS only ships on pages that
 * actually use [techforce_about].
 *
 * @return void
 */
function techforce_about_enqueue_styles() {
	$post = get_post();
	if ( ! $post || ! has_shortcode( $post->post_content, 'techforce_about' ) ) {
		return;
	}
	wp_enqueue_style( 'dashicons' );
	techforce_site_register_shared_styles();
	wp_enqueue_style( 'techforce-site' );
	wp_add_inline_style( 'techforce-site', techforce_about_get_css() );
}
add_action( 'wp_enqueue_scripts', 'techforce_about_enqueue_styles' );

/**
 * Render the [techforce_about] shortcode.
 *
 * @param array|string $atts Shortcode attributes (none currently supported).
 * @return string Rendered HTML.
 */
function techforce_about_shortcode( $atts ) {
	unset( $atts );

	$values = array(
		array(
			'icon'  => 'dashicons-yes-alt',
			'title' => __( 'Reliability', 'techforce' ),
			'desc'  => __( 'We measure our work in uptime, not promises. If we said we would ship it, it ships.', 'techforce' ),
		),
		array(
			'icon'  => 'dashicons-visibility',
			'title' => __( 'Transparency', 'techforce' ),
			'desc'  => __( 'You see what we see. Open dashboards, plain-English reports, no hidden retainers.', 'techforce' ),
		),
		array(
			'icon'  => 'dashicons-shield-alt',
			'title' => __( 'Security First', 'techforce' ),
			'desc'  => __( 'Every system we touch is hardened by default. Convenience never trumps protection.', 'techforce' ),
		),
		array(
			'icon'  => 'dashicons-book-alt',
			'title' => __( 'Continuous Learning', 'techforce' ),
			'desc'  => __( 'The threat landscape changes weekly. So does our training.', 'techforce' ),
		),
	);

	$team = array(
		array(
			'name'     => __( 'Alex Carter', 'techforce' ),
			'title'    => __( 'Founder & CEO', 'techforce' ),
			'initials' => 'AC',
			'color'    => '#2563eb',
		),
		array(
			'name'     => __( 'Jordan Lee', 'techforce' ),
			'title'    => __( 'Chief Technology Officer', 'techforce' ),
			'initials' => 'JL',
			'color'    => '#0ea5e9',
		),
		array(
			'name'     => __( 'Morgan Avery', 'techforce' ),
			'title'    => __( 'Head of Cybersecurity', 'techforce' ),
			'initials' => 'MA',
			'color'    => '#1d4ed8',
		),
		array(
			'name'     => __( 'Sam Rivera', 'techforce' ),
			'title'    => __( 'Lead Cloud Engineer', 'techforce' ),
			'initials' => 'SR',
			'color'    => '#0284c7',
		),
	);

	$contact_url = home_url( '/contact' );

	ob_start();
	?>
	<div class="techforce-site">

		<section class="techforce-page-header">
			<div class="techforce-container">
				<h1><?php esc_html_e( 'About Techforce', 'techforce' ); ?></h1>
				<p class="techforce-lead"><?php esc_html_e( 'A small senior team building secure, scalable IT systems for businesses that care about both.', 'techforce' ); ?></p>
			</div>
		</section>

		<section class="techforce-section">
			<div class="techforce-container techforce-about-story">
				<h2><?php esc_html_e( 'Our story', 'techforce' ); ?></h2>
				<p><?php esc_html_e( 'Techforce was founded on a simple idea: businesses should not have to choose between secure infrastructure and the speed to ship. Too many teams were stuck picking between cheap-and-fragile or enterprise-and-glacial. We wanted a third option.', 'techforce' ); ?></p>
				<p><?php esc_html_e( 'Today our engineers support teams across industries — from solo founders standing up their first cloud account to mid-market companies modernizing decades-old systems. Cloud, security, and managed IT, delivered by people who have run production at scale.', 'techforce' ); ?></p>
				<p><?php esc_html_e( 'We are deliberately a small senior team. Every engagement is led by someone who has done the work before, and every system we deploy is one we would be comfortable supporting at three in the morning.', 'techforce' ); ?></p>
			</div>
		</section>

		<section class="techforce-section techforce-section--alt">
			<div class="techforce-container">
				<h2><?php esc_html_e( 'Our values', 'techforce' ); ?></h2>
				<div class="techforce-grid techforce-grid--4">
					<?php foreach ( $values as $value ) : ?>
						<article class="techforce-card techforce-value-card">
							<span class="dashicons <?php echo esc_attr( $value['icon'] ); ?> techforce-icon" aria-hidden="true"></span>
							<h3><?php echo esc_html( $value['title'] ); ?></h3>
							<p><?php echo esc_html( $value['desc'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="techforce-section">
			<div class="techforce-container">
				<h2><?php esc_html_e( 'Our team', 'techforce' ); ?></h2>
				<div class="techforce-grid techforce-grid--4">
					<?php foreach ( $team as $member ) : ?>
						<article class="techforce-card techforce-team-card">
							<div
								class="techforce-team-avatar"
								style="background:<?php echo esc_attr( $member['color'] ); ?>;"
								aria-hidden="true"
							><?php echo esc_html( $member['initials'] ); ?></div>
							<h3><?php echo esc_html( $member['name'] ); ?></h3>
							<p><?php echo esc_html( $member['title'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="techforce-section techforce-section--alt">
			<div class="techforce-container">
				<div class="techforce-cta-banner">
					<h2><?php esc_html_e( 'Want to work with us?', 'techforce' ); ?></h2>
					<p><?php esc_html_e( 'Tell us about your project and we will be in touch within two business days.', 'techforce' ); ?></p>
					<a href="<?php echo esc_url( $contact_url ); ?>" class="techforce-btn techforce-btn--primary"><?php esc_html_e( 'Get in touch →', 'techforce' ); ?></a>
				</div>
			</div>
		</section>

	</div>
	<?php
	return (string) ob_get_clean();
}
add_shortcode( 'techforce_about', 'techforce_about_shortcode' );
