<?php
// ===================================================
// Load database info and local development parameters
// ===================================================
if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
	define( 'WP_LOCAL_DEV', true );
	include( dirname( __FILE__ ) . '/local-config.php' );
} else { // staging infos
	define( 'WP_LOCAL_DEV', false );
	define( 'DB_NAME', '%%DB_NAME%%' );
	define( 'DB_USER', '%%DB_USER%%' );
	define( 'DB_PASSWORD', '%%DB_PASSWORD%%' );
	define( 'DB_HOST', '%%DB_HOST%%' ); // Probably 'localhost'
}

// ========================
// Custom Content Directory
// ========================
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define('AUTH_KEY',         'cx=,r}<klCu|G`5x7?!L^0mL|u,-(|.~%A3l[7G.`8zlv!nzG_Gi]]`|p_pf_|NG');
define('SECURE_AUTH_KEY',  'DSY:]-w{T?$YD<;<D#v{nHGfU+~FVs-,x%uN.YDuuSwWLXhzT1ui?%gG2R,Ao^}r');
define('LOGGED_IN_KEY',    'q3viT[$_c?}ECO&TP:W[?V+Eg*LKTIwlfzHNeiOD``g{vHI{-Q8m|DE|,LTAJd3S');
define('NONCE_KEY',        '!#qhT!5Gfw3U;oh&<c&aOaQYr5>4.dsSMFuBnW4!@[ R+)E8=|lPmJZ>c5VwW`p7');
define('AUTH_SALT',        '^cR3AQgJ=:JY6;=|A6cF`~~;H%2(-Ke/}kCH*uycR[Bc~hev3JH4uT--@cML~KXV');
define('SECURE_AUTH_SALT', 'ygSpd]i?UFbs&I?fIPc({Oq<HN{|,M.;t%.^5YyhO M^Dz+Pl+|B]PBrNvUc{H`,');
define('LOGGED_IN_SALT',   'XzSI1DncB5PUe+V#y-xi|n{ |zcAJ$t~WXARIkhJ[&Mbd]T2AljbG&7H))Cf`Chw');
define('NONCE_SALT',       'bWUdhhw]<iZG@9W7Vn*-`p:Z{BO)>hUZ|k9*8[SbV|`~e ~dP-)N+FMsNsPse^>i');

// ==============================================================
// Table prefix
// Change this if you have multiple installs in the same database
// ==============================================================
$table_prefix  = 'wp_';

// ================================
// Language
// Leave blank for American English
// ================================
define( 'WPLANG', 'fr' );

// ===========
// Show errors & debug on local dev
// ===========
if(WP_LOCAL_DEV) {
	ini_set( 'display_errors', 1 );
	define( 'WP_DEBUG_DISPLAY', true );	
	define( 'SAVEQUERIES', true );
	define( 'WP_DEBUG', true );
} else {
	ini_set( 'display_errors', 0 );
	define( 'WP_DEBUG_DISPLAY', false );	
}

// =================================================================
// Debug mode
// Debugging? Enable these. Can also enable them in local-config.php
// =================================================================
// define( 'SAVEQUERIES', true );
// define( 'WP_DEBUG', true );

// ======================================
// Load a Memcached config if we have one
// ======================================
if ( file_exists( dirname( __FILE__ ) . '/memcached.php' ) )
	$memcached_servers = include( dirname( __FILE__ ) . '/memcached.php' );

// ===========================================================================================
// This can be used to programatically set the stage when deploying (e.g. production, staging)
// ===========================================================================================
//define( 'WP_STAGE', '%%WP_STAGE%%' );
//define( 'STAGING_DOMAIN', '%%WP_STAGING_DOMAIN%%' ); // Does magic in WP Stack to handle staging domain rewriting

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
require_once( ABSPATH . 'wp-settings.php' );
