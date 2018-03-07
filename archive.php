<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package StrapPress
 */

get_header(); ?>

	<div class="container marketing">
				<?php
				if ( have_posts() ) : ?>

					<header class="page-header">
						<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header><!-- .page-header -->

					<?php

							
					$productDataPackage = [];


					/* Start the Loop */
					while ( have_posts() ) : the_post();
						
						//assemble data package from post for 
						if ( has_post_thumbnail() ){
							$thumbArr 	= wp_get_attachment_image_src( get_post_thumbnail_id() );
							$mediumArr 	= wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
							// $imgTitle	= get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true)
							$imgAlt		= get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
						
							$x = array(
								'image' => array(
									'ID' => get_post_thumbnail_id(),
									'id' => get_post_thumbnail_id(),
									'sizes' => array(
										'thumbnail' => $thumbArr[0],
										'thumbnail-width' => $thumbArr[1],
										'thumbnail-height' => $thumbArr[2],
										'medium' => $mediumArr[0],
										'medium-width' => $mediumArr[1],
										'medium-height' => $mediumArr[2],
									)
								),
								'title' => get_the_title(),
								'blurb' => '',
								'linkTo' => esc_url( get_permalink() ),
								'button' => array(
									'button_text' => 'Click Here',
									'button_link' => '//localhost:3000/rstechnicalservices/2016/04/07/hello-2/'
								)

							);

							// if( isset( $imgTitle ) ){ $x['image']['title'] = $imgTitle; } 
							if( isset( $imgAlt ) ){ $x['image']['alt'] = $imgAlt; } 

							array_push( $productDataPackage, $x);
		
						}

					endwhile;

					// look( $productDataPackage );

					$layout_options = [
						'per_row' => 6,
						'alignment' => 'center',
						'outline' => 0,
						'cardLink' => 1, 
						'cardButton' => 0
					];

					$hp_mod = new ModuleCards( $productDataPackage, $layout_options, NULL, 'test' );
					$hp_mod->getDisplay();


					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

	</div> <!-- Close container marketing -->

<?php
get_sidebar();
get_footer();
