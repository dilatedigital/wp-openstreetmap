<?php 

namespace DDOpenstreetmap;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class Plugin {

    private $config;
  
    private static $instance;
  
    private $settings = null;
    
  
    private function __construct() {
      $this->config = array();
    }
    
  
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new Plugin();
            self::$instance->loadTextdomain();
            self::$instance->hooks();
            self::$instance->loadAdminOptions();

            self::$instance->loadPostType();
            self::$instance->loadCssJs();
        }
  
        return self::$instance;
    }

    public function loadCssJs(){
        \add_action('wp_head', function(){
            echo '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />' . PHP_EOL;
        });  
        \add_action('wp_head', function(){
            echo '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>' . PHP_EOL;
        },1); 
        \add_action('wp_enqueue_scripts', function(){
            //ddmap main script
            \wp_register_script( 
                'ddopenstreetmap-js', 
                \plugin_dir_url( DDMAP_PLUGIN )."/assets/public/js/ddopenstreetmap.js",
                [],
                DDMAP_VERSION
            );
        
            \wp_enqueue_script(
                "ddopenstreetmap-js",
                \plugin_dir_url( DDMAP_PLUGIN )."/assets/public/js/ddopenstreetmap.js",
                [],
                DDMAP_VERSION
            );

            \wp_enqueue_style(
                'ddopenstreetmap-css', 
                \plugin_dir_url( DDMAP_PLUGIN )."/assets/public/css/ddopenstreetmap.css", [], DDMAP_VERSION, 'all' );

        });

    }

    public function loadPostType(){
        \add_action('init', function(){
            $labels = array(
                'name'               => 'Dilate Map',
                'singular_name'      => 'Dilate Map',
                'menu_name'          => 'Dilate Maps',
                'add_new'            => 'Add Map',
                'add_new_item'       => 'Add New Map',
                'edit_item'          => 'Edit Map',
                'new_item'           => 'New Map',
                'all_items'          => 'All Map',
                'view_item'          => 'View Map',
                'search_items'       => 'Search Map',
                'not_found'          => 'No maps found',
                'not_found_in_trash' => 'No maps found in Trash',
                'parent_item_colon'  => '',
                'public'             => true,
                'has_archive'        => true,
                'rewrite'            => array('slug' => 'ddopenstreetmap'),
            );
        
            $args = array(
                'labels'        => $labels,
                'description'   => 'Map information',
                'public'        => true,
                'menu_icon'     => 'dashicons-location-alt',
                'menu_position' => 5,
                'supports'      => array('title'),
                'has_archive'   => true,
            );
            \register_post_type('ddopenstreetmap', $args);

            \add_filter('manage_ddopenstreetmap_posts_columns', function($columns){
                $columns['ddopenstreetmap'] = 'Map Shortcode';
                return $columns;
            });

            \add_action('manage_ddopenstreetmap_posts_custom_column', function( $column, $post_id ){
                if ($column == 'ddopenstreetmap') {
                    echo do_shortcode("[dilatemap id=\"$post_id\"]");
                }
            }, 10, 2);

        });
        
    }
  
    
    public static function load() {
      return Plugin::instance();
    } 
  
  
    public function loadTextdomain() {
      \load_plugin_textdomain( 'wp-openstreetmap', false, dirname( \plugin_basename( __FILE__  ) ) . '/languages/' );
    }
  
  
    public function configure(array $config) {
      $this->config = array_merge($this->config, $config);
    }
  
  
    private function hooks() {
      \register_activation_hook( __FILE__, array($this, 'activate_ddopenstreetmap') );
      \register_deactivation_hook( __FILE__, array($this, 'deactivate_ddopenstreetmap') );
  
      \add_filter('setup_theme',function(){
        \Carbon_Fields\Carbon_Fields::boot();
      });
  
    }

    
    private function loadAdminOptions(){
      AdminOptions::init();
    }
  
     
    private function activate_ddopenstreetmap(){
      global $wp_rewrite; 
          $wp_rewrite->flush_rules( true );
    }
  
  
    private function deactivate_ddopenstreetmap(){
      
    }


}