<?php
/*
Plugin Name: Transparenzgesetz.at
Version: 1.1
Plugin URI: https://www.transparenzgesetz.at
Description: "Transparenzgesetz statt Amtsgeheimnis" - adds a sticky image to support the online petition for an Austrian Freedom of Information act
Author: Robert Harm
Author URI: https://www.harm.co.at
*/
//info prevent file from being accessed directly
if (basename($_SERVER['SCRIPT_FILENAME']) == 'transparenzgesetz-at.php') { die ("Please do not access this file directly. Thanks!<br/><a href='https://www.transparenzgesetz.at'>www.transparenzgesetz.at</a>"); }
//info: define necessary paths and urls
if ( ! defined( 'TPG_WP_ADMIN_URL' ) )
	define( 'TPG_WP_ADMIN_URL', get_admin_url() );
if ( ! defined( 'TPG_PLUGIN_URL' ) )
define ("TPG_PLUGIN_URL", plugin_dir_url(__FILE__));
if ( ! defined( 'TPG_PLUGIN_DIR' ) )
define ("TPG_PLUGIN_DIR", plugin_dir_path(__FILE__));

class Transparenzgesetz
{
function __construct() {
	$tpg_status = get_option('tpg_status');
	if ( isset($tpg_status) && ($tpg_status == 'enabled') ){
		add_action('wp_print_styles', array(&$this, 'tpg_frontend_enqueue_stylesheets'),4);
		add_action('wp_footer', array(&$this, 'tpg_footer_code'));
	}
	add_action('admin_menu', array(&$this, 'tpg_admin_menu'),5);
	if ( ($tpg_status == NULL) || ($tpg_status == 'disabled') ){
		add_action('admin_notices', array(&$this, 'tpg_admin_notices'),6);
	}
	//add_action('widgets_init', create_function('', 'return register_widget("Class_tpg_widget");'));
  }
  function tpg_admin_notices() {
	 echo '<div class="error" style="padding:10px;"><strong>Transparenzgesetz.at - Installation unvollständig!</strong><br/>Bitte noch zu <a href="' . TPG_WP_ADMIN_URL . 'options-general.php?page=tpg_settings_page">Einstellungen</a> navigieren, Checkbox anhacken und speichern!</div>';
  }
  function tpg_admin_menu() {
	$page = add_options_page('Transparenzgesetz.at', 'Transparenzgesetz.at', 'activate_plugins', 'tpg_settings_page', array(&$this, 'tpg_settings_page') );
  }
  function tpg_settings_page() {
	include('tpg-settings.php');
  }
  function tpg_frontend_enqueue_stylesheets() {
		global $wp_styles;
		wp_enqueue_style('transparenzgesetz', TPG_PLUGIN_URL . 'css/tpg.css', array());
		wp_enqueue_style('transparenzgesetz-ie-only', TPG_PLUGIN_URL . 'css/tpg-ie.css', array());
		$wp_styles->add_data('transparenzgesetz-ie-only', 'conditional', 'lt IE 7');
  }
  function tpg_footer_code() {
		echo '<!-- transparenzgesetz.at begin --><div id="akct"><a id="akpeel" href="https://www.transparenzgesetz.at/?ref=ohr" target="_blank" title="Transparenzgesetz.at - Online-Petition für ein Informationsfreiheitsgesetz in Österreich - jetzt unterzeichnen!"><img src="' . TPG_PLUGIN_URL . 'img/tpg-blank.gif" alt="Transparenzgesetz.at" /></a>
<a id="akpreload" href="https://www.transparenzgesetz.at/banner?ref=ohr" target="_blank" title="Anleitungen zum Einbau dieses Banners auf der eigenen Webseite gibt es auf www.transparenzgesetz.at/banner"><img src="' . TPG_PLUGIN_URL . 'img/tpg-info.gif" alt="Info-Logo" /></a></div>
<!-- transparenzgesetz.at ende-->';  
  }
}  //info: end class
$run_transparenzgesetz = new Transparenzgesetz();
//require_once( plugin_dir_path( __FILE__ ) . 'class-tpg-widget.php' );
unset($run_transparenzgesetz);
?>