<?php
namespace HelloPlus\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * class Utils
 **/
class Utils {

	private static ?bool $elementor_installed = null;

	private static ?bool $elementor_active = null;

	public static function elementor(): \Elementor\Plugin {
		return \Elementor\Plugin::$instance;
	}

	public static function has_pro(): bool {
		return defined( 'ELEMENTOR_PRO_VERSION' );
	}

	public static function are_we_on_elementor_domains(): bool {
		$current_domain = filter_input( INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL );
		$allowed_domains = [
			'elementor.com',
			'elementor.red',
		];

		foreach ( $allowed_domains as $domain ) {
			if ( str_ends_with( $current_domain, $domain ) ) {
				return true;
			}
		}
		return false;
	}

	public static function has_hello_biz(): bool {
		if ( defined( 'WP_TESTS_DOMAIN' ) ) {
			return true;
		}

		if ( self::are_we_on_elementor_domains() ) {
			return true;
		}

		return defined( 'EHP_THEME_SLUG' );
	}

	public static function has_hello_elementor_theme(): bool {
		return defined( 'EHP_THEME_SLUG' ) && ( 'hello-elementor' === EHP_THEME_SLUG );
	}

	public static function is_elementor_active(): bool {
		if ( null === self::$elementor_active ) {
			self::$elementor_active = defined( 'ELEMENTOR_VERSION' );
		}

		return self::$elementor_active;
	}

	public static function is_elementor_installed(): bool {
		if ( null === self::$elementor_installed ) {
			self::$elementor_installed = file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' );
		}

		return self::$elementor_installed;
	}

	public static function get_current_post_id(): int {
		if ( isset( self::elementor()->documents ) && self::elementor()->documents->get_current() ) {
			return self::elementor()->documents->get_current()->get_main_id();
		}

		return get_the_ID();
	}

	public static function get_update_elementor_message(): string {
		return sprintf(
		/* translators: %s: Elementor version number. */
			__( 'Elementor plugin version needs to be at least %s for Hello Plus to Work. Please update.', 'hello-plus' ),
			HELLOPLUS_MIN_ELEMENTOR_VERSION,
		);
	}

	public static function get_client_ip(): string {
		$server_ip_keys = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
		];

		foreach ( $server_ip_keys as $key ) {
			$value = filter_input( INPUT_SERVER, $key, FILTER_VALIDATE_IP );

			if ( $value ) {
				return $value;
			}
		}

		return '127.0.0.1';
	}

	public static function ends_with( $full_string, $end_string ): bool {
		$len = strlen( $end_string );
		if ( 0 === $len ) {
			return true;
		}

		return ( substr( $full_string, -$len ) === $end_string );
	}

	public static function get_theme_slug(): string {
		if ( defined( 'EHP_THEME_SLUG' ) ) {
			return EHP_THEME_SLUG;
		}

		return 'hello-plus';
	}

	public static function get_theme_admin_home(): string {
		if ( defined( 'EHP_THEME_SLUG' ) ) {
			return add_query_arg( [ 'page' => EHP_THEME_SLUG ], self_admin_url( 'edit.php' ) );
		}

		return self_admin_url();
	}

	public static function is_preview_for_document( $post_id ): bool {
		$preview_id = filter_input( INPUT_GET, 'preview_id', FILTER_VALIDATE_INT );
		$preview = filter_input( INPUT_GET, 'preview', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		return 'true' === $preview && (int) $post_id === (int) $preview_id;
	}

	public static function is_installed_elementor_version_supported(): bool {
		$plugin_file = WP_PLUGIN_DIR . '/elementor/elementor.php';

		if ( ! file_exists( $plugin_file ) ) {
			return true;
		}

		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		$plugin_data = get_plugin_data( $plugin_file );
		$plugin_version = $plugin_data['Version'];

		return self::is_elementor_version_supported( $plugin_version );
	}

	public static function is_active_elementor_version_supported(): bool {
		return self::is_elementor_version_supported( ELEMENTOR_VERSION );
	}

	public static function is_elementor_version_supported( string $version ): bool {
		return version_compare( $version, HELLOPLUS_MIN_ELEMENTOR_VERSION, 'ge' );
	}

	public static function plugin_title(): string {
		return __( 'Hello+', 'hello-plus' );
	}

	public static function are_submissions_enabled(): bool {
		return static::has_pro() &&
			class_exists( '\ElementorPro\Modules\Forms\Submissions\Actions\Save_To_Database' ) &&
			class_exists( '\ElementorPro\License\API' ) &&
			class_exists( '\ElementorPro\Modules\Forms\Submissions\Component' ) &&
			\ElementorPro\License\API::is_licence_has_feature(
				\ElementorPro\Modules\Forms\Submissions\Component::NAME,
				\ElementorPro\License\APi::BC_VALIDATION_CALLBACK
			);
	}

	public static function get_widgets_depends(): array {
		return [ 'helloplus-button', 'helloplus-image', 'helloplus-shapes' ];
	}
}
