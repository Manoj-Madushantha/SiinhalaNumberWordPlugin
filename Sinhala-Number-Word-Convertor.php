<?php
/**

* Plugin Name: Sinhala-Number-Word-Convertor

* Plugin URI: https://www.ictknowledgehub.com/557-2/

* Description: This plugins enables users to enter number and get its sinhala word representation

* Version: 1.0.0

* Author: Manoj Madushantha

* Author URI: https://www.facebook.com/manoj.madushantha.3/

*/

define( 'WP_DEBUG', true );

define( 'WP_DEBUG_LOG', true );

if ( ! defined( 'ABSPATH' ) ) exit;

header('Content-Type: text/html; charset=utf-8');

define('TUTS_REGISTRATION_INCLUDE_URL', plugin_dir_url(__FILE__).'includes/');

require_once('includes/class-number-convertor.php');


class SinhalaNumberConvertor {
	
	function __construct() {
		
		//Adding frontend Styles from includes folder
		add_action('init',array($this, 'tuts_styl_incl'));
		
		add_action('init',array($this, 'tuts_script_incl'));
		
		// THE AJAX ADD ACTIONS
		add_action( "wp_ajax_the_ajax_hook", array($this, "the_action_function") );
		add_action( "wp_ajax_nopriv_the_ajax_hook", array($this, "the_action_function")  ); // need this to serve non logged in users
	
		//Adding login shortcode
		add_shortcode( 'sinhala-number-convertor', array($this, 'num_word_shortcode') );
	}
	

    function tuts_styl_incl() {

        wp_register_style('conv_styl_css_and_js', plugin_dir_url(__FILE__) . 'includes/stylesconvertor.css', false);
        wp_enqueue_style('conv_styl_css_and_js');

    }
	
 	function tuts_script_incl() {
			//Adding frontend ajax from includes folder
       	wp_enqueue_script( "my-ajax-handle", TUTS_REGISTRATION_INCLUDE_URL . "ajax.js", array("jquery" ) );
		wp_localize_script( "my-ajax-handle", "the_ajax_script", array( "ajaxurl" => admin_url( "admin-ajax.php" ) ) );
	}
	
	// THE FUNCTION
	function the_action_function() {

	/* this area is very simple but being serverside it affords the possibility of retreiving data from the server and passing it back to the javascript function */
		global $wpdb; // this is how you get access to the database

		if (intval($_POST["number"]) > 1000000) {

			 echo "Currently support till 1 million. <br /> මෙම මෙවලම දැනට සහය දක්වනුයේ මිලියනය දක්වා පමණි.";

			 exit;

		}

		$num = intval($_POST["number"]);
		$strobj = Convertor::Convertword($num);
		echo  $strobj;

		//die();  // wordpress may print out a spurious zero without this - can be particularly bad if using json
		wp_die(); // this is required to terminate immediately and return a proper response
	}



	// function to login Shortcode

	function num_word_shortcode( $attr ) {

		$the_form = '

			<div class="tuts-login-form">

				<div class="tuts-login-heading">
					<img src="https://www.ictknowledgehub.com/wp-content/uploads/2021/10/WordPress-logotype.png" />
					<h2>Sinhala Number Word Convertor</h2>
				</div>

				<form method="post" action="" id="loginform" name="loginform"  method = "post">

					<div class="tuts-txt">
						<label><?php _e("Number :",""); ?> </label>
						<input type="text" tabindex="10" size="20" value="" class="input" id="user_login" placeholder="Enter Number" required name="number" />
					</div>

					<div  class="">
						<input name="action" type="hidden" value="the_ajax_hook" />
						<input type="button" value="Convert"  id="submit_button" class="button" name="submit_button" onClick="submit_me();" />
					</div>

				</form>


				<div id="response_area">
					This is where we\'ll get the response
				</div>  


			</div>';

		return $the_form;

	}

}

$sinhalaNumberConvertor = new SinhalaNumberConvertor();

?>