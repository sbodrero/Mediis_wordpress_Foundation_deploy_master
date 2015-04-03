<?php
/*
Plugin Name: Mandrill Emailer
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Routes all outgoing email through Mandrill.
Author: Jarkko Laine
Version: 1.0
Author URI: http://jarkkolaine.com
*/

require_once 'Mandrill.php';
require_once "mandrill_settings.php";

/*
 This plugin allows sending email from WordPress to subscribers using the Mandrill 
 email delivery platform. 
 
 To do this, the plugin:

 * routes wp_mail through Mandrill using the Mandrill SMTP server

 * provides a function (mandrill_send_mail) that anyone can call to send email 
   through the Mandrill API

 * replaces the WordPress pluggable function wp_new_user_notification with one that
   uses mandrill_send_mail instead of wp_mail.
   
   Other functions that could be replaced in the same way are: 
 		- wp_notify_postauthor
		- wp_notify_moderator
		- wp_password_change_notification
  
 */
 
if ( "1" == get_option("mandrill_emailer_use_mandrill") ) :

/** 
 * SMTP configuration to pass all emails (even non-templated ones) 
 * through Mandrill.
 */
add_action( 'phpmailer_init', 'mandrill_emailer_phpmailer_init' );

function mandrill_emailer_phpmailer_init( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->SMTPAuth = true;
	$phpmailer->SMTPSecure = "tls";
		
	$phpmailer->Host = "smtp.mandrillapp.com";
	$phpmailer->Port = "587";
 
	// Credentials for SMTP authentication
	$phpmailer->Username = get_option("mandrill_emailer_username");
	$phpmailer->Password = get_option("mandrill_emailer_api_key");
 
	// From email and name
	$from_name = get_option("mandrill_emailer_from_name");
	if ( !isset( $from_name ) ) {
		$from_name = 'WordPress';
	}

	$from_email = get_option("mandrill_emailer_from_email");		
	if ( !isset( $from_email ) ) {
		// Get the site domain and get rid of www.
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}

		$from_email = 'wordpress@' . $sitename;
	}
		
	$phpmailer->From = $from_email;
	$phpmailer->FromName = $from_name;
}
	
/**
 * Function for sending templated email messages through Mandrill API.
 *
 * @param string	$to			The recipient's e-mail address
 * @param string	$to_name	The recipient's name
 * @param string	$template	The name of the HTML template to use
 * @param string	$subject	The subject of the e-mail message
 * @param array		$data		The data for the template fields
 */
function mandrill_send_mail( $to, $to_name, $template, $subject, $data ) {
	try {	
		// Init Mandrill API
		$mandrill = new Mandrill( get_option( 'mandrill_emailer_api_key' ) );

		// From email and name		
		$from_name = get_option( 'mandrill_emailer_from_name' );
		if ( !isset( $from_name ) ) {
			$from_name = 'WordPress';
		}
		
		$from_email = get_option( 'mandrill_emailer_from_email' );		
		if ( !isset( $from_email ) ) {
			// Get the site domain and get rid of www.
			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}

			$from_email = 'wordpress@' . $sitename;
		}
	
		// Message recipient and contents 
		$mandrill_to = array( array( 'email' => $to, 'name' => $to_name, 'type' => 'to' ) );
	        
    	$message = array(
	        'subject' => $subject,
    	    'from_email' => apply_filters( 'wp_mail_from', $from_email ),
        	'from_name' => apply_filters( 'wp_mail_from_name', $from_name ),
	        'to' => $mandrill_to,
        
	        // Pass the same parameters for merge vars and template params
    	    // to make them available in both variable passing methods
	        'global_merge_vars' => $data        
    	);
        
	    $result = $mandrill->messages->sendTemplate( $template, $data, $message );

		return true;
	} catch(Mandrill_Error $e) {
		echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
		return false;
	}
}
    
    
/**
 * Replace email actions if templates defined. Otherwise use regular email
 */
	
if ( get_option("mandrill_emailer_new_user_template" ) ) :
			
/**
 * Email login credentials to a newly registered user.
 *
 * A new user registration notification is also sent to admin email.
 *
 * @since 2.0.0
 *
 * @param int    $user_id        User ID.
 * @param string $plaintext_pass Optional. The user's plaintext password. Default empty.	 
 */
function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
	$user = get_userdata( $user_id );

	// The blogname option is escaped with esc_html on the way into 
	// the database in sanitize_option we want to reverse this for the plain 
	// text arena of emails.
	$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

	// To keep things simple, we still send the admin notification 
	// through wp_mail just as in the default version
	$message  = sprintf( __( 'New user registration on your site %s:' ), $blogname ) . "\r\n\r\n";
	$message .= sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n\r\n";
	$message .= sprintf( __( 'E-mail: %s' ), $user->user_email ) . "\r\n";

	@wp_mail( get_option( 'admin_email' ), sprintf( __( '[%s] New User Registration' ), $blogname ), $message );

	// Send welcome e-mail to new user
	$email_params = array(
		array( 'name' => 'BLOGNAME', 'content' => $blogname ),
		array( 'name' => 'USER_NAME', 'content' => $user->user_login ),
		array( 'name' => 'EMAIL', 'content' => $user->user_email ),
		array( 'name' => 'FIRST_NAME', 'content' => $user->first_name ),
		array( 'name' => 'LAST_NAME', 'content' => $user->last_name ),
		array( 'name' => 'PASSWORD', 'content' => $plaintext_pass ),
		array( 'name' => 'LOGIN_URL', 'content' => wp_login_url() ),
	);
			
	$template = get_option( 'mandrill_emailer_new_user_template' );
	$subject = sprintf( __( '[%s] Your username and password' ), $blogname );
			
	$to_name = $user->first_name . " " . $user->last_name;
	mandrill_send_mail( $user->user_email, $to_name, $template, $subject, $email_params );
}
	
endif; // if ( get_option("mandrill_emailer_new_user_template" ) )

endif; // if ( "1" == get_option("mandrill_emailer_use_mandrill") )
