<?php
/**

* Plugin Name: Sinhala-Number-Word-Convertor

* Plugin URI: https://www.ictknowledgehub.com/557-2/

* Description: This plugins enables users to enter number and get its sinhala word representation

* Version: 1.0.1

* Author: Manoj Madushantha

* Author URI: https://www.facebook.com/manoj.madushantha.3/

*/

define( 'WP_DEBUG', true );

define( 'WP_DEBUG_LOG', true );

if ( ! defined( 'ABSPATH' ) ) exit;

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache');
header('Pragma: no-cache');

define('TUTS_REGISTRATION_INCLUDE_URL', plugin_dir_url(__FILE__).'includes/');

require_once('includes/class-number-convertor.php');


class SinhalaNumberConvertor {
	
	private static $instance = null;
	
	
	public static function get_instance() {
  
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
  
        return self::$instance;
  
    } 
	
	
	private function __construct() {
		
		//Adding frontend Styles from includes folder
		add_action('init',array($this, 'tuts_styl_incl'));
		
		add_action('init',array($this, 'tuts_script_incl'));
		
		add_action('admin_menu', array($this, 'setting_links'));
		
		add_action('admin_init', array($this , 'settings'));
		

     
    	// Register javascript
    	add_action('admin_enqueue_scripts', array( $this, 'enqueue_admin_js' ) );
		
		// THE AJAX ADD ACTIONS
		add_action( "wp_ajax_the_ajax_hook", array($this, "the_action_function") );
		add_action( "wp_ajax_nopriv_the_ajax_hook", array($this, "the_action_function")  ); // need this to serve non logged in users
	
		//Adding login shortcode
		add_shortcode( 'sinhala-number-convertor', array($this, 'num_word_shortcode') );
		
	}
	
	
	
	function settings() {
		
		add_settings_section('snc_first_section', null, null, 'sinhala-number-word-convertor');
		
		add_settings_field('snc_title', 'Title', array($this, 'titleHTML'), 'sinhala-number-word-convertor', 'snc_first_section');
		
		register_setting('sinhalanumberconvertorplugin', 'snc_title', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Sinhala Number Word Convertor') );
		
		add_settings_field('snc_title_txt_color', 'Title Text Color', array( $this, 'title_txt_settings_field' ), 'sinhala-number-word-convertor', 'snc_first_section');
		
		register_setting('sinhalanumberconvertorplugin', 'snc_title_txt_color', array('default' => '#000000') );
		
		add_settings_field('snc_btn_color', 'Button Color', array( $this, 'bg_btn_settings_field' ), 'sinhala-number-word-convertor', 'snc_first_section');
		
		register_setting('sinhalanumberconvertorplugin', 'snc_btn_color', array('default' => '#ffffff') );
		
		add_settings_field('snc_bg_color', 'BackGround Color', array( $this, 'bg_settings_field' ), 'sinhala-number-word-convertor', 'snc_first_section');
		
		register_setting('sinhalanumberconvertorplugin', 'snc_bg_color', array('default' => '#D7D1D1') );
		

	}
	
	function enqueue_admin_js() { 
     
    	// Make sure to add the wp-color-picker dependecy to js file
    	wp_enqueue_script( 'cpa_custom_js', plugins_url( 'jquery.custom.js', __FILE__ . 'includes' ), array( 'jquery', 'wp-color-picker' ), '', true  );
	}
	
	
	
	function title_txt_settings_field() {  ?>
		
		<input type="text" name="snc_title_txt_color" value="<?php echo get_option('snc_title_txt_color'); ?>" class="cpa-color-picker" >;
	
	<?php }
	
	
	function bg_btn_settings_field() {  ?>
     
    	<input type="text" name="snc_btn_color" value="<?php echo get_option('snc_btn_color'); ?>" class="cpa-color-picker" >;
     
	<?php }
	
	function bg_settings_field() {  ?>
     
    	<input type="text" name="snc_bg_color" value="<?php echo get_option('snc_bg_color'); ?>" class="cpa-color-picker" >;
     
	<?php }
	
	function titleHTML() { ?>
		
		<input type="text" name="snc_title" value="<?php echo esc_attr(get_option('snc_title')); ?>"/>
		
	<?php }
	
	
	function setting_links() {
		//add_options_page('Sinhala Word Convertor Settings', 'number to word', 'manage_options', 'sinhala-number-word-convertor', array($this, 'settings_pageHTML') );
		add_menu_page('Sinhala Word Convertor Settings', 'number to word', 1, 'sinhala-number-word-convertor', array($this, 'settings_pageHTML'), 'dashicons-sos', null );
	}

	function settings_pageHTML() { ?>
		<div class="wrap">
			<h1> Sinhala Number To Word convertor Setting Page </h1>
			<form action="options.php" method="POST">
				<?php
					settings_fields('sinhalanumberconvertorplugin');
					do_settings_sections('sinhala-number-word-convertor');
					submit_button();
				?>
			</form>
		</div>
	<?php }
	
    function tuts_styl_incl() {

        wp_register_style('conv_styl_css_and_js', plugin_dir_url(__FILE__) . 'includes/stylesconvertor.css', false);
        wp_enqueue_style('conv_styl_css_and_js');
		
		// Css rules for Color Picker
    	wp_enqueue_style( 'wp-color-picker' );

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

			<div class="tuts-login-form" style="background-color: '.get_option("snc_bg_color").' ;">

				<div class="tuts-login-heading">
					<img src="https://www.ictknowledgehub.com/wp-content/uploads/2021/10/WordPress-logotype.png" />
					<h2 style="color: '. get_option("snc_title_txt_color") .' " > ' . get_option("snc_title") . '  </h2>
				</div>

				<form method="post" action="" id="loginform" name="loginform"  method = "post">

					<div class="tuts-txt">
						<label><?php _e("Number :",""); ?> </label>
						<input type="text" tabindex="10" size="20" value="" class="input" id="user_login" placeholder="Enter Number" required name="number" />
					</div>

					<div  class="tuts-btn">
						<input name="action" type="hidden" value="the_ajax_hook" />
						<input type="button" value="Convert"  id="submit_button" class="button" style="background: '.get_option("snc_btn_color").' none repeat scroll 0 0;" name="submit_button" onClick="submit_me();" />
					</div>

				</form>


				<div id="response_area">
					<p> &#x1F920; &#9824; &#9827; &#9829; &#9830; &#8492; &#10239; &#8496; &#8460; &#8734; &#10016; &#127877; </p>	
				</div>  


			</div>';

		return $the_form;

	}

}

	SinhalaNumberConvertor::get_instance();


?>