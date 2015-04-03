<?php
/*********************
Enqueue the proper CSS
if you use Sass.
*********************/
if( ! function_exists( 'reverie_enqueue_style' ) ) {
	function reverie_enqueue_style()
	{
		if(WP_LOCAL_DEV)  {
		// foundation stylesheet
		wp_register_style( 'reverie-foundation-stylesheet', get_stylesheet_directory_uri() . '/css/app.css', array(), '' );

		// Register the main style
		wp_register_style( 'reverie-stylesheet', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );
		// Register font awesome
		wp_register_style( 'awesome-font-stylesheet', get_template_directory_uri() . '/css/font-awesome.css', array(), '', 'all' );	
			
		wp_enqueue_style( 'reverie-foundation-stylesheet' );
		wp_enqueue_style( 'reverie-stylesheet' );
		wp_enqueue_style( 'awesome-font-stylesheet' );
		} else {
			wp_register_style( 'reverie-remote-stylesheet', get_stylesheet_directory_uri() . '/css/style.min.css', array(), '' );
			wp_enqueue_style( 'reverie-remote-stylesheet' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'reverie_enqueue_style' );
?>
