<?php 

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

function ddopenstreetmap_func( $atts ) {
	$atts = shortcode_atts(
        array(
            'id' => '', // Default value for the ID parameter
        ),
        $atts,
        'dilatemap' // Replace with your actual shortcode tag
    );

    // Access the ID parameter
    $dmap_id = $atts['id'];
    $postmap = get_post($dmap_id, ARRAY_A);
    if ($postmap && $postmap['post_type'] === 'ddopenstreetmap') {
        // return $postmap;
        // var_dump($postmap);

        $locations  = carbon_get_post_meta($postmap['ID'], 'locations');
        $zoom_level = carbon_get_post_meta($postmap['ID'], 'zoom_level');
        $set_view_lat = carbon_get_post_meta($postmap['ID'], 'set_view_lat');
        $set_view_long = carbon_get_post_meta($postmap['ID'], 'set_view_long');

        $frame_width = carbon_get_post_meta($postmap['ID'], 'frame_width')??'';
        $frame_height = carbon_get_post_meta($postmap['ID'], 'frame_height')??'';
        $location_label = carbon_get_post_meta($postmap['ID'], 'locaation_label')??'';

    } else {
        $postmap = null;
    }


    ob_start();
    ?>
        <div id="dilate-map-<?=$dmap_id?>" class="ddopenstreetmap" style="width:<?=$frame_width?>;height:<?=$frame_height?>"></div>    
    <?php

    if($locations){
        foreach($locations as $key => $value){
            $outLocations[] = [
                'lat'   =>  $value['latitude'],
                'lon'   =>  $value['longitude'],
                'icon'  => $value['pin'],
                'icon_width' => $value['icon_width'],
                'icon_height' => $value['icon_height'],
                'location_label' => $value['location_label'],
            ];      
        }
    }
    echo '<script>';
    echo 'var locations = ' . json_encode($outLocations).'; ';
    echo "var map = L.map('dilate-map-".$dmap_id."').setView(['".$set_view_lat."', '".$set_view_long."'], ".$zoom_level.");";
    echo 'locations.forEach(function(location) {
        if(location.icon){
            var customIcon = L.icon({
            iconUrl: location.icon,
            iconSize: [location.icon_width, location.icon_height],
            iconAnchor: [22, 94],
            popupAnchor: [-3, -76]
            });
        }

        var _marker = null;
        if(location.icon){
            _marker = L.marker([location.lat, location.lon], { icon: customIcon }).addTo(map);
        }
        else{
            _marker = L.marker([location.lat, location.lon]).addTo(map);
        }

        
        if(location.location_label){
            _marker.bindPopup(location.location_label);
        }

      });';
    echo "L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: \"© <a href='https://www.openstreetmap.org/copyright'>OpenStreetMap</a> contributors\"
      }).addTo(map);";

    echo "map.on('load', function() {
        setTimeout(function() {
          console.log('map load');
          addMapTileAttr('.leaflet-tile-container img');
        }, 500);
      });";
    
    echo "setTimeout(function() {
            window.dispatchEvent(new Event('resize'));
        }, 500);";

    echo '</script>';

    return ob_get_clean();
}
add_shortcode( 'dilatemap', 'ddopenstreetmap_func' );