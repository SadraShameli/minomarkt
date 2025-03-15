<?php
/**
 * Plugin Name: Complianz Privacy Suite (GDPR/CCPA) premium
 * Plugin URI: https://complianz.io/pricing
 * Description: Plugin to help you make your website GDPR/CCPa compliant
 * Version: 7.0.8
 * Requires at least: 5.9
 * Requires PHP: 7.2
 * Text Domain: complianz-gdpr
 * Domain Path: /languages
 * Author: Really Simple Plugins
 * Author URI: https://complianz.io
 */

/*
    Copyright 2018-2023 Complianz.io (email : support@complianz.io)
    This product includes GeoLite2 data created by MaxMind, available from
    http://www.maxmind.com.
*/

defined('ABSPATH') or die("you do not have access to this page!");
if (!defined('cmplz_premium') ) define('cmplz_premium', true);

if ( ! function_exists( 'cmplz_set_activation_time_stamp' ) ) {
	/**
	 * Set an activation time stamp
	 *
	 * @param $networkwide
	 */
	function cmplz_set_activation_time_stamp( $networkwide ) {
		update_option( 'cmplz_activation_time', time() );
		update_option( 'cmplz_run_activation', true , false );
		set_transient('cmplz_redirect_to_settings_page', true, HOUR_IN_SECONDS );
	}

	register_activation_hook( __FILE__, 'cmplz_set_activation_time_stamp' );
}

//error_log(print_r($_SERVER['REQUEST_URI'], true));

/**
 * Instantiate plugin
 */
if (!class_exists('COMPLIANZ')) {
    class COMPLIANZ
    {
		public static $instance;
		public static $config;
		public static $company;
		public static $review;
		public static $admin;
		public static $scan;
		public static $sync;
		public static $wizard;
		public static $onboarding;
		public static $export_settings;
		public static $rsp_upgrade_to_pro;
		public static $comments;
		public static $processing;
		public static $dataleak;
		public static $import_settings;
		public static $license;
		public static $banner_loader;
		public static $geoip;
		public static $statistics;
		public static $admin_statistics;
		public static $document;
		public static $cookie_blocker;
		public static $progress;
		public static $DNSMPD;
		public static $admin_DNSMPD;
		public static $support;
		public static $proof_of_consent;
		public static $records_of_consent;
		public static $documents_admin;

	    private function __construct()
        {
	        $this->setup_constants();
	        $this->includes();
	        $this->load_translation();
	        $this->hooks();

	        self::$config = new cmplz_config();
	        self::$company = new cmplz_company();
        	self::$DNSMPD = new cmplz_DNSMPD();

	        if ( cmplz_admin_logged_in() ) {
		        self::$admin_DNSMPD    = new cmplz_admin_DNSMPD();
		        self::$review          = new cmplz_review();
		        self::$admin           = new cmplz_admin();
		        self::$export_settings = new cmplz_export_settings();
		        self::$progress        = new cmplz_progress();
		        self::$documents_admin = new cmplz_documents_admin();
		        self::$wizard          = new cmplz_wizard();
		        self::$onboarding      = new cmplz_onboarding();
		        self::$sync            = new cmplz_sync();

		        /* pro instances */
		        self::$comments        = new cmplz_comments();
		        self::$import_settings = new cmplz_import_settings();
		        self::$support         = new cmplz_support();
		        self::$processing      = new cmplz_processing();
		        self::$dataleak        = new cmplz_dataleak();
		        self::$admin_statistics= new cmplz_admin_statistics();
	        }
	        if (cmplz_admin_logged_in() || cmplz_scan_in_progress() ) {
	            self::$scan               = new cmplz_scan();
	        }
	        if ( cmplz_admin_logged_in() ) {
		        self::$license         = new cmplz_license();
	        }
	        self::$records_of_consent = new cmplz_records_of_consent();
	        self::$proof_of_consent   = new cmplz_proof_of_consent();
	        self::$cookie_blocker = new cmplz_cookie_blocker();
	        self::$banner_loader       = new cmplz_banner_loader();

			self::$geoip              = new cmplz_geoip();
	        self::$statistics         = new cmplz_statistics();
	        self::$document           = new cmplz_document();
        }

	    /**
	     * Instantiate the class.
	     *
	     * @since 1.0.0
	     *
	     * @return COMPLIANZ
	     */

	    public static function get_instance() {
		    if ( ! isset( self::$instance ) && ! ( self::$instance instanceof COMPLIANZ ) ) {
			    self::$instance = new self();
		    }

		    return self::$instance;
	    }

        private function setup_constants()
        {
	        define('CMPLZ_COOKIEDATABASE_URL', 'https://cookiedatabase.org/wp-json/cookiedatabase/');
            define('CMPLZ_MAIN_MENU_POSITION', 40);

            //default region code
            if (!defined('CMPLZ_DEFAULT_REGION')) {
            	define('CMPLZ_DEFAULT_REGION',  'us');
            }

            /*statistics*/
            if (!defined('CMPLZ_AB_TESTING_DURATION')) {
            	define('CMPLZ_AB_TESTING_DURATION', 30); //Days
            }

            define('cmplz_url', plugin_dir_url(__FILE__));
            define('cmplz_path', plugin_dir_path(__FILE__) );
            define('cmplz_plugin', plugin_basename(__FILE__));
            define('cmplz_plugin_file', __FILE__);
            $debug = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '#'.time() : '';
            define('cmplz_version', '7.0.8' . $debug);
            define('cmplz_product_name', 'Complianz GDPR/CCPA Premium');
	        define('CMPLZ_ITEM_ID', 994);
        }
        private function includes()
        {
            require_once(cmplz_path . 'documents/class-document.php');
            require_once(cmplz_path . 'cookie/class-cookie.php');
            require_once(cmplz_path . 'cookie/class-service.php');
            require_once(cmplz_path . 'integrations/integrations.php');
	        require_once(cmplz_path . 'cron/cron.php');

	        /* Gutenberg block */
            if (cmplz_uses_gutenberg()) {
                require_once plugin_dir_path(__FILE__) . 'gutenberg/block.php';
            }
            require_once plugin_dir_path( __FILE__ ) . 'rest-api/rest-api.php';
	        require_once( cmplz_path . '/pro/includes.php' );

	        if ( cmplz_admin_logged_in() ) {
		        require_once( cmplz_path . 'config/warnings.php' );
		        require_once( cmplz_path . 'settings/settings.php' );
                require_once( cmplz_path . 'class-admin.php');
                require_once( cmplz_path . 'class-review.php');
                require_once( cmplz_path . 'progress/class-progress.php');
                require_once( cmplz_path . 'cookiebanner/admin/cookiebanner.php');
                require_once( cmplz_path . 'class-export.php');
	            require_once( cmplz_path . 'documents/admin-class-documents.php' );
	            require_once( cmplz_path . 'settings/wizard.php' );
	            require_once( cmplz_path . 'onboarding/class-onboarding.php' );
		        require_once( cmplz_path . 'mailer/class-mail.php');

		        if ( isset($_GET['install_pro'])) {
			        require_once( cmplz_path . 'upgrade/upgrade-to-pro.php' );
		        }
		        require_once( cmplz_path . 'upgrade.php' );
		        require_once(cmplz_path . 'DNSMPD/class-admin-DNSMPD.php');
		        require_once(cmplz_path . 'cookie/class-sync.php');
	        }

			if (cmplz_admin_logged_in() || cmplz_scan_in_progress() ) {
				require_once(cmplz_path . 'cookie/class-scan.php');
			}

	        if ( cmplz_admin_logged_in() ) {
		        require_once( cmplz_path . 'pro/class-licensing.php' );

	        }
	        require_once( cmplz_path . 'pro/records-of-consent/class-records-of-consent.php' );
	        require_once( cmplz_path . 'proof-of-consent/class-proof-of-consent.php' );
            require_once(cmplz_path . 'cookiebanner/class-cookiebanner.php');
            require_once(cmplz_path . 'cookiebanner/class-banner-loader.php');

            require_once(cmplz_path . 'class-company.php');
            require_once(cmplz_path . 'DNSMPD/class-DNSMPD.php');
            require_once(cmplz_path . 'config/class-config.php');
            require_once(cmplz_path . 'class-cookie-blocker.php');
        }

	    /**
	     * Load plugin translations.
	     *
	     * @since 1.0.0
	     *
	     * @return void
	     */
	    private function load_translation() {
		    load_plugin_textdomain('complianz-gdpr', FALSE, dirname(cmplz_plugin) . '/languages/');
	    }

        private function hooks()
        {
	        if ( wp_doing_ajax() ) {
				//using init on ajax calls, as wp is not running.
		        add_action('init', 'cmplz_init_cookie_blocker');
	        } else {
		        //has to be wp for all non ajax calls, because of AMP plugin
		        add_action('wp', 'cmplz_init_cookie_blocker');
	        }
	        load_plugin_textdomain( 'complianz-gdpr' );
        }
    }

	/**
	 * Load the plugins main class.
	 */
	add_action(
		'plugins_loaded',
		function() {
			COMPLIANZ::get_instance();
		},
		9
	);
}

require_once(plugin_dir_path(__FILE__) . 'functions.php');

/**
 * Handle some initializations when plugin is activated
 */
if (!function_exists('cmplz_activation')) {
	function cmplz_activation(){
		//only run once
		if ( !get_option('cmplz_run_premium_install') ) {
			update_option('cmplz_run_premium_install', 'start', false );
		}
		//run always
		set_transient('cmplz_redirect_to_settings_page', true, HOUR_IN_SECONDS );
		update_option('cmplz_run_activation', true, false );
		update_option('cmplz_run_premium_upgrade', true, false );
		do_action('cmplz_activation');
	}
	register_activation_hook( __FILE__, 'cmplz_activation' );
}

if ( !function_exists('cmplz_is_logged_in_rest')) {
	function cmplz_is_logged_in_rest() {
		$is_settings_page_request = isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/complianz/v1/' ) !== false;
		if ( ! $is_settings_page_request ) {
			return false;
		}

		return is_user_logged_in();
	}
}
if ( !function_exists('cmplz_admin_logged_in')){
	function cmplz_admin_logged_in(){
		$wpcli = defined( 'WP_CLI' ) && WP_CLI;
		return ( is_admin() && cmplz_user_can_manage()) || cmplz_is_logged_in_rest() ||  wp_doing_cron() || $wpcli || defined('CMPLZ_DOING_SYSTEM_STATUS');
	}
}

if ( ! function_exists('cmplz_add_manage_privacy_capability')){
	/**
	 * Add a user capability to WordPress and add to admin and editor role
	 */
	function cmplz_add_manage_privacy_capability($handle_subsites = true ){
		$capability = 'manage_privacy';
		$role = get_role( 'administrator' );
		if( $role && !$role->has_cap( $capability ) ){
			$role->add_cap( $capability );
		}

		//we need to add this role across subsites as well.
		if ( $handle_subsites && is_multisite() ) {
			$sites = get_sites();
			if (count($sites)>0) {
				foreach ($sites as $site) {
					switch_to_blog($site->blog_id);
					cmplz_add_manage_privacy_capability(false);
					restore_current_blog();
				}
			}
		}
	}
	register_activation_hook( __FILE__, 'cmplz_add_manage_privacy_capability' );

	/**
	 * When a new site is added, add our capability
	 * @param $site
	 *
	 * @return void
	 */
	function cmplz_add_role_to_subsite($site) {
		switch_to_blog($site->blog_id);
		cmplz_add_manage_privacy_capability(false);
		restore_current_blog();
	}
	add_action('wp_initialize_site', 'cmplz_add_role_to_subsite', 10, 1);

}
