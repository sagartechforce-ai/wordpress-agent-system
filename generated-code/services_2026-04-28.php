<?php
/**
 * Plugin Name: Techforce Services Page
 * Description: Registers the [techforce_services] shortcode rendering the demo Services page (4 detailed service cards, 4-step process, CTA). Part of the Techforce 3-page starter scaffold.
 * Version:     1.0.0
 * Author:      Techforce
 * License:     GPL-2.0-or-later
 * Text Domain: techforce
 *
 * @package Techforce\Services
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
 * Page-specific CSS for the services page only.
 *
 * @return string CSS rules without surrounding <style> tags.
 */
function techforce_services_get_css() {
	return "
.techforce-service-card{padding:1.75rem;}
.techforce-service-features{list-style:none;padding:0;margin:1rem 0;}
.techforce-service-features li{padding:.25rem 0 .25rem 1.5rem;position:relative;color:var(--tf-muted);font-size:.95rem;}
.techforce-service-features li::before{content:'\\2713';color:var(--tf-primary);font-weight:700;position:absolute;left:0;top:.25rem;}
.techforce-process{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;counter-reset:tf-step;}
@media (max-width:1024px){.techforce-process{grid-template-columns:repeat(2,1fr);}}
@media (max-width:640px){.techforce-process{grid-template-columns:1fr;}}
.techforce-process-step{text-align:center;padding:1.5rem;background:var(--tf-surface);border:1px solid var(--tf-border);border-radius:12px;counter-increment:tf-step;}
.techforce-process-step::before{content:counter(tf-step);display:flex;align-items:center;justify-content:center;width:48px;height:48px;border-radius:50%;background:var(--tf-primary);color:#fff;font-weight:700;font-size:1.25rem;margin:0 auto 1rem;}
.techforce-process-step h3{margin:0 0 .5rem;}
.techforce-process-step p{color:var(--tf-muted);font-size:.9rem;margin:0;}
";
}

/**
 * Enqueue shared and page-specific styles for the services page.
 *
 * Gated on has_shortcode() so the inline CSS only ships on pages that
 * actually use [techforce_services].
 *
 * @return void
 */
function techforce_services_enqueue_styles() {
	$post = get_post();
	if ( ! $post || ! has_shortcode( $post->post_content, 'techforce_services' ) ) {
		return;
	}
	wp_enqueue_style( 'dashicons' );
	techforce_site_register_shared_styles();
	wp_enqueue_style( 'techforce-site' );
	wp_add_inline_style( 'techforce-site', techforce_services_get_css() );
}
add_action( 'wp_enqueue_scripts', 'techforce_services_enqueue_styles' );

/**
 * Render the [techforce_services] shortcode.
 *
 * @param array|string $atts Shortcode attributes (none currently supported).
 * @return string Rendered HTML.
 */
function techforce_services_shortcode( $atts ) {
	unset( $atts );

	$services = array(
		array(
			'icon'     => 'dashicons-cloud',
			'title'    => __( 'Cloud Infrastructure', 'techforce' ),
			'desc'     => __( 'Design, migrate, and operate cloud platforms that scale with your business and stay within budget.', 'techforce' ),
			'features' => array(
				__( 'Multi-cloud architecture (AWS, Azure, GCP)', 'techforce' ),
				__( 'Migration planning and execution', 'techforce' ),
				__( 'Cost optimization and right-sizing', 'techforce' ),
				__( '24/7 monitoring and alerting', 'techforce' ),
			),
		),
		array(
			'icon'     => 'dashicons-shield',
			'title'    => __( 'Cybersecurity', 'techforce' ),
			'desc'     => __( 'End-to-end security programs that protect your data, your customers, and your reputation.', 'techforce' ),
			'features' => array(
				__( 'Threat detection and response', 'techforce' ),
				__( 'Compliance audits (SOC 2, ISO 27001, HIPAA)', 'techforce' ),
				__( 'Penetration testing', 'techforce' ),
				__( 'Employee security training', 'techforce' ),
			),
		),
		array(
			'icon'     => 'dashicons-admin-tools',
			'title'    => __( 'Managed IT Support', 'techforce' ),
			'desc'     => __( 'Outsource the IT helpdesk and infrastructure ops so your team can focus on what they do best.', 'techforce' ),
			'features' => array(
				__( 'Round-the-clock helpdesk', 'techforce' ),
				__( 'Endpoint management', 'techforce' ),
				__( 'Backup and disaster recovery', 'techforce' ),
				__( 'Vendor coordination', 'techforce' ),
			),
		),
		array(
			'icon'     => 'dashicons-editor-code',
			'title'    => __( 'Custom Software & Integration', 'techforce' ),
			'desc'     => __( 'Internal tools, custom dashboards, and integrations that connect the systems you already use.', 'techforce' ),
			'features' => array(
				__( 'API integrations and middleware', 'techforce' ),
				__( 'Custom dashboards and reporting', 'techforce' ),
				__( 'Workflow automation', 'techforce' ),
				__( 'Legacy system modernization', 'techforce' ),
			),
		),
	);

	$process = array(
		array(
			'title' => __( 'Discovery', 'techforce' ),
			'desc'  => __( 'We map your goals, constraints, and current stack. No assumptions.', 'techforce' ),
		),
		array(
			'title' => __( 'Design', 'techforce' ),
			'desc'  => __( 'A technical plan with clear phases, costs, and timelines you can sign off on.', 'techforce' ),
		),
		array(
			'title' => __( 'Build', 'techforce' ),
			'desc'  => __( 'Hands-on engineering with weekly check-ins and a working preview at each milestone.', 'techforce' ),
		),
		array(
			'title' => __( 'Launch', 'techforce' ),
			'desc'  => __( 'Production rollout with monitoring, documentation, and support handoff.', 'techforce' ),
		),
	);

	$contact_url = home_url( '/contact' );

	ob_start();
	?>
	<div class="techforce-site">

		<section class="techforce-page-header">
			<div class="techforce-container">
				<h1><?php esc_html_e( 'Services Built for Modern IT', 'techforce' ); ?></h1>
				<p class="techforce-lead"><?php esc_html_e( 'Cloud, security, support, and software — engineered together so the seams do not show.', 'techforce' ); ?></p>
			</div>
		</section>

		<section class="techforce-section">
			<div class="techforce-container">
				<h2><?php esc_html_e( 'What we offer', 'techforce' ); ?></h2>
				<div class="techforce-grid techforce-grid--4">
					<?php foreach ( $services as $service ) : ?>
						<article class="techforce-card techforce-service-card">
							<span class="dashicons <?php echo esc_attr( $service['icon'] ); ?> techforce-icon" aria-hidden="true"></span>
							<h3><?php echo esc_html( $service['title'] ); ?></h3>
							<p><?php echo esc_html( $service['desc'] ); ?></p>
							<ul class="techforce-service-features">
								<?php foreach ( $service['features'] as $feature ) : ?>
									<li><?php echo esc_html( $feature ); ?></li>
								<?php endforeach; ?>
							</ul>
							<a href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Get started →', 'techforce' ); ?></a>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="techforce-section techforce-section--alt">
			<div class="techforce-container">
				<h2><?php esc_html_e( 'Our process', 'techforce' ); ?></h2>
				<p class="techforce-lead"><?php esc_html_e( 'A simple four-step engagement model — predictable from kickoff to launch.', 'techforce' ); ?></p>
				<div class="techforce-process">
					<?php foreach ( $process as $step ) : ?>
						<article class="techforce-process-step">
							<h3><?php echo esc_html( $step['title'] ); ?></h3>
							<p><?php echo esc_html( $step['desc'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="techforce-section">
			<div class="techforce-container">
				<div class="techforce-cta-banner">
					<h2><?php esc_html_e( 'Have a project in mind?', 'techforce' ); ?></h2>
					<p><?php esc_html_e( 'Share the details and we will come back with a tailored plan within two business days.', 'techforce' ); ?></p>
					<a href="<?php echo esc_url( $contact_url ); ?>" class="techforce-btn techforce-btn--primary"><?php esc_html_e( 'Get a Quote', 'techforce' ); ?></a>
				</div>
			</div>
		</section>

	</div>
	<?php
	return (string) ob_get_clean();
}
add_shortcode( 'techforce_services', 'techforce_services_shortcode' );
