<?php 
  /**
   * Plugin Name:     Dilate WP OpenstreetMap
   * Plugin URI:      https://www.dilate.com.au
   * Description:     Use openstreetmap on your site
   * Version:         0.0.5
   * Author:          William Donayre Jr. - Dilate Digital LLC
   * Author URI:      https://www.dilate.com.au
   * Text Domain:     wp-openstreetmap
   * Tested up to:    6.4.2
   *
   * @package         DilateOpenStreetMap
   * @author          william.donayre
   * @copyright       2023..
  */

  namespace Dilate;

  // use Dilate\scOpenstreetmap;


  // Exit if accessed directly
  if( !defined( 'ABSPATH' ) ) exit;
        
  define( 'DDMAP_VERSION', '1.0.0' );

  define( 'DDMAP_PLUGIN', __FILE__ );

  define( 'DDMAP_PLUGIN_BASENAME', plugin_basename( DDMAP_PLUGIN ) );

  define( 'DDMAP_PLUGIN_NAME', trim( dirname( DDMAP_PLUGIN_BASENAME ), '/' ) );

  require 'puc/plugin-update-checker.php';
  use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

  $myUpdateChecker = PucFactory::buildUpdateChecker(
      'https://github.com/dilatedigital/wp-openstreetmap',
      __FILE__,
      'wp-openstreetmap'
  );

  //Set the branch that contains the stable release.
  $myUpdateChecker->setBranch('main');

    //$myUpdateChecker->setAuthentication('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');

    if( !class_exists('DDOpenstreetmap') ) {
      require_once \plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
    }

    require_once 'src/shortcodes/shortcodes.php';

    \DDOpenstreetmap\Plugin::load();


