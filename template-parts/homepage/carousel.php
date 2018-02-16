<?php 
        if( function_exists( 'get_field' ) ){

           // $images = get_field('home_gallery');
  		   $images = get_field('feature');
           $images_count = count( $images );
           //look( $images );

           $hp_carousel = new ModuleCarousel( get_field('feature'), 'hp-carasousel', 'hp-carasousel' );
           $hp_carousel->getDisplay();

        }
?>