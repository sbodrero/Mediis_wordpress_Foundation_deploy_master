<?php
/*
 * Settings page definition for the Mandrill Emailer plugin
 */

add_action( 'admin_menu', 'mandrill_emailer_settings_init' );

/**
 * The action funtion for initializing the settings page.
 */
function mandrill_emailer_settings_init() {
	add_options_page( __( 'Mandrill Emailer Settings', 'mandrill_emailer' ), 
		__( 'Mandrill Emailer', 'mandrill_emailer' ),
		'manage_options', 
		'mandrill-emailer',
		'mandrill_emailer_settings_page'
	);

	// Settings sections:
	// - General 
	// - Templates
	
	add_settings_section(
		'mandrill_emailer_setting_section_general',
		__( 'General Settings', 'mandrill_emailer' ),
		'mandrill_emailer_settings_section_callback_general',
		'mandrill-emailer'
	);

	add_settings_section(
		'mandrill_emailer_setting_section_templates',
		__( 'Templates', 'mandrill_emailer' ),
		'mandrill_emailer_settings_section_callback_templates',
		'mandrill-emailer'
	);

	// Settings fields
	
 	add_settings_field(
		'mandrill_emailer_use_mandrill',
		__( 'Use Mandrill for email', 'mandrill_emailer' ),
		'mandrill_emailer_setting_callback_use_mandrill',
		'mandrill-emailer',
		'mandrill_emailer_setting_section_general'
	); 	
 	register_setting( 'mandrill-emailer', 'mandrill_emailer_use_mandrill' );

 	add_settings_field(
		'mandrill_emailer_username',
		__( 'Mandrill user name', 'mandrill_emailer' ),
		'mandrill_emailer_setting_callback_username',
		'mandrill-emailer',
		'mandrill_emailer_setting_section_general'
	); 	
 	register_setting( 'mandrill-emailer', 'mandrill_emailer_username' );

 	add_settings_field(
		'mandrill_emailer_api_key',
		__( 'Mandrill API key', 'mandrill_emailer' ),
		'mandrill_emailer_setting_callback_api_key',
		'mandrill-emailer',
		'mandrill_emailer_setting_section_general'
	); 	
 	register_setting( 'mandrill-emailer', 'mandrill_emailer_api_key' );

 	add_settings_field(
		'mandrill_emailer_from_name',
		__( 'Mandrill "From" name', 'mandrill_emailer' ),
		'mandrill_emailer_setting_callback_from_name',
		'mandrill-emailer',
		'mandrill_emailer_setting_section_general'
	); 	
 	register_setting( 'mandrill-emailer', 'mandrill_emailer_from_name' );

	add_settings_field(
		'mandrill_emailer_from_email',
		__( 'Mandrill "From" email', 'mandrill_emailer' ),
		'mandrill_emailer_setting_callback_from_email',
		'mandrill-emailer',
		'mandrill_emailer_setting_section_general'
	); 	
 	register_setting( 'mandrill-emailer', 'mandrill_emailer_from_email' );

 	add_settings_field(
		'mandrill_emailer_new_user_template',
		__( 'New user welcome', 'mandrill_emailer' ),
		'mandrill_emailer_setting_callback_new_user_template',
		'mandrill-emailer',
		'mandrill_emailer_setting_section_templates'
	); 	
 	register_setting( 'mandrill-emailer', 'mandrill_emailer_new_user_template' );
}

/*
 * Callback functions for rendering the elements on the settings page
 */

function mandrill_emailer_settings_page() {
?>
   	<div class="wrap">
	    <div id="icon-themes" class="icon32"></div>
		<h2>Mandrill Emailer Settings</h2>

        <?php settings_errors(); ?>
 
        <!-- Create the form that will be used to render our options -->
        <form method="post" action="options.php">
            <?php settings_fields( 'mandrill-emailer' ); ?>
            <?php do_settings_sections( 'mandrill-emailer' ); ?>
            <?php submit_button(); ?>
        </form>
	</div>
<?php
}
 
function mandrill_emailer_settings_section_callback_general() {
	echo '<p>Mandrill API configuration.</p>';
}

function mandrill_emailer_settings_section_callback_templates() {
	echo '<p>Copy template names from Mandrill template definition page.</p>';
}
   
function mandrill_emailer_setting_callback_use_mandrill() {
	echo '<input name="mandrill_emailer_use_mandrill" id="mandrill_emailer_use_mandrill" '
	   . 'type="checkbox" value="1" class="code" '
	   . checked( 1, get_option( 'mandrill_emailer_use_mandrill' ), false ) . ' />';
}

function mandrill_emailer_setting_callback_username() {
	echo '<input name="mandrill_emailer_username" id="mandrill_emailer_username" '
	   . 'class="regular-text" type="text" value="' . get_option( 'mandrill_emailer_username' ) . '" />';
}

function mandrill_emailer_setting_callback_api_key() {
	echo '<input name="mandrill_emailer_api_key" id="mandrill_emailer_api_key" '
	   . 'class="regular-text" type="text" value="' . get_option( 'mandrill_emailer_api_key' ) . '" />';
}

function mandrill_emailer_setting_callback_from_name() {
	echo '<input name="mandrill_emailer_from_name" id="mandrill_emailer_from_name" '
	   . 'class="regular-text" type="text" value="' . get_option( 'mandrill_emailer_from_name' ) . '" />';
}

function mandrill_emailer_setting_callback_from_email() {
	echo '<input name="mandrill_emailer_from_email" id="mandrill_emailer_from_email" '
	   . 'class="regular-text" type="text" value="' . get_option( 'mandrill_emailer_from_email' ) . '" />';
}

function mandrill_emailer_setting_callback_new_user_template() {
	echo '<input name="mandrill_emailer_new_user_template" id="mandrill_emailer_new_user_template" '
	   . 'class="regular-text" type="text" value="' . get_option( 'mandrill_emailer_new_user_template' ) . '" />';
}
