<?php
/**
 * Plugin Name:     Secure Headers
 * Plugin URI:      https://github.com/miya0001/secure-headers
 * Description:     WordPress plugin which sends HTTP security headers.
 * Author:          Takayuki Miyauchi
 * Author URI:      https://miya.io/
 * Domain Path:     /languages
 * Version:         nightly
 *
 * @package         Secure_Headers
 */

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

class Secure_Headers
{
	public function __construct()
	{
		add_action( 'send_headers', array( $this, 'send_headers' ) );
		add_action( 'init', array( $this, 'activate_autoupdate' ) );
	}

	public function activate_autoupdate()
	{
		$plugin_slug = plugin_basename( __FILE__ ); // e.g. `hello/hello.php`.
		$gh_user = 'miya0001';                      // The user name of GitHub.
		$gh_repo = 'secure-headers';       // The repository name of your plugin.

		// Activate automatic update.
		new \Miya\WP\GH_Auto_Updater( $plugin_slug, $gh_user, $gh_repo );
	}

	public function send_headers()
	{
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			return;
		}

		if ( is_admin() ) {
			return;
		}

		$x_frame_options           = 'SAMEORIGIN';
		$strict_transport_security = 'max-age=31536000; includeSubDomains; preload';
		$x_xss_protection          = '1; mode=block';
		$x_content_type_options    = 'nosniff';

		/**
		 * Filters the value of HTTP X-Frame-Options header.
		 *
		 * @param string $x_frame_options The value of HTTP X-Frame-Options header.
		 */
		$x_frame_options = apply_filters(
			'secure_header_x_frame_options',
			$x_frame_options
		);

		if ( ! empty( $x_frame_options ) ) {
			header( 'X-Frame-Options: ' . $x_frame_options );
		}

		/**
		 * Filters the value of HTTP Strict-Transport-Security header.
		 *
		 * @param string $strict_transport_security The value of HTTP Strict-Transport-Security header.
		 */
		$strict_transport_security = apply_filters(
			'secure_header_strict_transport_security',
			$strict_transport_security
		);

		if ( ! empty( $strict_transport_security ) ) {
			header( 'Strict-Transport-Security: ' . $strict_transport_security );
		}

		/**
		 * Filters the value of HTTP X-XSS-Protection header.
		 *
		 * @param string $x_xss_protection The value of HTTP X-XSS-Protection header.
		 */
		$x_xss_protection = apply_filters(
			'secure_header_x_xss_protection',
			$x_xss_protection
		);

		if ( ! empty( $x_xss_protection ) ) {
			header( 'X-XSS-Protection: ' . $x_xss_protection );
		}

		/**
		 * Filters the value of HTTP X-Content-Type-Options header.
		 *
		 * @param string $x_content_type_options The value of HTTP X-Content-Type-Options header.
		 */
		$x_content_type_options = apply_filters(
			'secure_header_x_content_type_options',
			$x_content_type_options
		);

		if ( ! empty( $x_content_type_options ) ) {
			header( 'X-Content-Type-Options: ' . $x_content_type_options );
		}
	}
}

$secure_headers = new Secure_Headers();
