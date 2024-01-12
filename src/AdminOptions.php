<?php 

namespace DDOpenstreetmap;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class AdminOptions {

  private static $instance;
    
  private $plugin;


  private function __construct() {
      $this->plugin = \DDOpenstreetmap\Plugin::instance();
  }
  

  public static function instance()
  {
      if (!self::$instance) {
          self::$instance = new self();
      }
      
      return self::$instance;
  }

  public static function init() {
    $instance = self::instance();

    \add_action( 'carbon_fields_register_fields', function(){

      $locationLabels = array(
        'plural_name' => 'Locations',
        'singular_name' => 'location',
      );

      $map_posttype = Container::make('post_meta', 'Map Details')
        ->where('post_type', '=', 'ddopenstreetmap') // Replace 'your_post_type' with your actual post type
        ->add_fields(array(
            Field::make('text', 'frame_width', 'Frame Width')->set_width( 50 )->set_default_value( '100%' ),
            Field::make('text', 'frame_height', 'Frame Height')->set_width( 50 )->set_default_value( '450px' ),
            Field::make('text', 'zoom_level', 'Zoom Level')->set_width( 20 ),
            Field::make('text', 'set_view_lat', 'Set View Latitude')->set_width( 40 ),
            Field::make('text', 'set_view_long', 'Set View Longitude')->set_width( 40 ),
            Field::make('complex', 'locations', 'Locations')
                ->setup_labels( $locationLabels )
                ->add_fields('location','Location Set',array(
                    Field::make('image', 'pin', 'Pin')              ->set_width( 20 )->set_value_type( 'url' ),
                    Field::make('text', 'latitude', 'Latitude')     ->set_width( 40 ),
                    Field::make('text', 'longitude', 'Longitude')   ->set_width( 40 ),
                    Field::make('text', 'icon_width', 'Map Marker Icon Width')     ->set_width( 30 )->set_default_value( 35 ),
                    Field::make('text', 'icon_height', 'Map Marker Icon Height')   ->set_width( 30 )->set_default_value( 44 ),
                    Field::make( 'textarea', 'location_label', 'Location Label' )
                ))
        ));
    });
  }
}