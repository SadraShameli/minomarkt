<?php
defined( 'ABSPATH' ) or die( "you do not have access to this page!" );
require_once(cmplz_path . 'pro/tcf/tcf.php');
require_once(cmplz_path . 'pro/class-geoip.php' );
require_once(cmplz_path . 'pro/statistics/class-statistics.php');
require_once(cmplz_path . 'pro/functions.php');
require_once(cmplz_path . 'pro/filters-actions.php');
require_once(cmplz_path . 'pro/upgrade.php');

if ( cmplz_admin_logged_in() ) {
	require_once( cmplz_path . 'pro/cron.php');
	require_once( cmplz_path . 'pro/tcf/tcf-admin.php' );
	require_once( cmplz_path . 'pro/statistics/class-admin-statistics.php' );
	require_once( cmplz_path . 'pro/settings/fields-notices.php' );
	require_once( cmplz_path . 'pro/class-comments.php' );
	require_once( cmplz_path . 'pro/class-import.php' );
	require_once( cmplz_path . 'pro/class-support.php' );
	require_once( cmplz_path . 'pro/processing-agreements/class-processing.php' );
	require_once( cmplz_path . 'pro/dataleak/class-dataleak.php' );
	if ( is_multisite() ){
		require_once(cmplz_path . 'pro/multisite/copy-settings-multisite.php');
	}
}
require_once( cmplz_path . 'pro/datarequests/class-datarequests.php' );


