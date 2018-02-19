<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package StrapPress
 */

get_header(); ?>
      
      <!-- HOMEPAGE IMAGE CAROUSEL -->
      <?php get_template_part( 'template-parts/homepage/carousel'); ?>

      <?php // look( get_fields() ); ?>

      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">


        <?php 
          if( function_exists( 'get_field' ) ){
          
            $modules = get_field('module_item');
            $modules_counter = 0;


            foreach ($modules as $module_array ) {
              
              $mr = &$module_array;
              $modules_counter++;

              //look( $mr );

              // look( $mr['callout'] );

              $layout_name  = $mr['acf_fc_layout'];
              $layout_id    = $layout_name . $modules_counter;

              $moduleKey = array(
                "callouts"    => "ModuleCallouts",
                "featurettes" => "ModuleFeaturette",
                "cards"       => "ModuleCards"
              );

              $hp_mod = new $moduleKey[$layout_name]( $mr['module_content'], $layout_id, 'test' );
              $hp_mod->getDisplay();

              // module types - right now 
              // callouts
              // featurettes
              // cards

            }

          }


        ?>

        <!-- Three columns of text below the carousel -->
        <?php // get_template_part( 'template-parts/homepage/three-cols'); ?>


        <!-- START THE FEATURETTES -->
        <?php // get_template_part( 'template-parts/homepage/featurettes'); ?>


        <!-- PRODUCT CATGORIES -->
        <?php // get_template_part( 'template-parts/homepage/cards' ); ?>


      </div><!-- /.container -->
	
	<?php

$imgC = get_field('image_carousel');
look( $imgC );

get_sidebar();
get_footer();

