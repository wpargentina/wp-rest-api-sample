<?php
/**
 * Plugin main file.
 *
 * Plugin Name: WP REST API Sample
 * Description: Sample WP REST API implementation plugin.
 * Version:     1.0
 * Author:      WP Argentina
 * Author URI:  http://wpargentina.org
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package     WP_REST_API_Sample
 * @author      WordPress Argentina <contacto@wpargentina.org>
 * @license     GPL-2.0+
 * @link        http://www.wpargentina.org/
 * @copyright   2016 WP Argentina
 * @since       1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_REST_API_ENDPOINT', 'http://local.wordpress-trunk.dev' );

function wpa_get_response() {
	return wp_remote_get( WP_REST_API_ENDPOINT . '/wp-json/wp/v2/posts/' );
}

add_shortcode( 'wpa_api_response', 'wpa_api_response_callback' );

function wpa_api_response_callback() {
	$output = '';

	if ( $response = wpa_get_response() ) {
		$data = json_decode( $response['body'] );
		$posts = $data;

		ob_start();

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				?>
					<div class="rest-api-post">
						<h3><?php echo $post->title->rendered ?></h3>
						<div class="date"><?php echo $post->date;  ?></div>
						<div class="link"><?php echo $post->link;  ?></div>
						<div class="excerpt"><?php echo $post->excerpt->rendered;  ?></div>
					</div>
				<?php
			}
		}

		$output = ob_get_clean();
	}

	return $output;
}
