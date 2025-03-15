<?php
defined('ABSPATH') or die("you do not have access to this page!");

if (!class_exists("cmplz_support")) {
	class cmplz_support
	{
		private static $_this;

		function __construct()
		{
			if (isset(self::$_this))
				wp_die(sprintf('%s is a singleton class and you cannot create a second instance.', get_class($this)));

			self::$_this = $this;
			add_filter('cmplz_do_action', array($this, 'support_data'), 10, 3);
			add_filter( 'allowed_redirect_hosts' , array($this, 'allow_complianz_redirect') , 10 );
		}

		static function this()
		{
			return self::$_this;
		}

		/**
		 * @param array           $data
		 * @param string          $action
		 * @param WP_REST_Request $request
		 *
		 * @return array
		 */
		public function support_data( array $data, string $action, WP_REST_Request $request): array {
			if ( $action !== 'supportdata' ) {
				return $data;
			}

			if ( !cmplz_user_can_manage() ) {
				return $data;
			}

			$user_info = get_userdata(get_current_user_id());
			$email = urlencode($user_info->user_email);
			$name = urlencode($user_info->display_name);
			$domain = site_url();

			$user_id = get_current_user_id();
			$license_key = COMPLIANZ::$license->license_key();
			$license_key = COMPLIANZ::$license->maybe_decode( $license_key );
			$license_key = $license_key ?: '';
			//get system status file
			//set a variable so the system status file knows it's called from the support page
			$_GET['support_form'] = true;
			require_once(trailingslashit(cmplz_path).'system-status.php');
			$system_status = cmplz_get_system_status();
			$system_status = str_replace("\n", '--br--', $system_status );
			$system_status = urlencode(strip_tags( $system_status ) );

			$output = [
				'customer_name' => $name,
				'email' => $email,
				'domain' => $domain,
				'license_key' => $license_key,
				'system_status' => $system_status,
			];
			return $output;
		}

		/**
		 * @param array $allowed_hosts
		 *
		 * @return mixed
		 */
		public function allow_complianz_redirect($allowed_hosts){
			$allowed_hosts[] = 'complianz.io';
			return $allowed_hosts;
		}
	}
} //class closure
