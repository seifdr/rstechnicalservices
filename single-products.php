<?php
/**
 * The template for displaying all single product pages 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package StrapPress
 */

get_header(); ?>

<?php 

/* Setup additonal field variables */

if( function_exists( 'get_field' ) ){
	$additional_photos = get_field('additional_photos');

	if( isset( $additional_photos ) && !empty( $additional_photos ) ){
		$addPhotos = '<div class="row">';

		foreach( $additional_photos as $p ) {
			$addPhotos .= '<div class="col">
				<a class="relatedImages" href="'. $p['sizes']['large'] .'" data-lightbox="relatedImages">
					<img src="'. $p['sizes']['thumbnail'] .'" />
				</a>
			</div>';
		}

		$addPhotos .= '</div>';

		$add_imgs[0] = array(
			'title' => '',
			'altContent' => $addPhotos,
			'linkTo' => '',
			'cardButton' => 0,
			'cardHeader' 	 => 'Addtional Photos',
			'cardHeaderIcon' => 'fa fa-camera'
		);
		
		$add_imgs_layout_options = [
			'per_row' => 1,
			'alignment' => 'center',
			'outline' => 1,
			'cardLink' => 0, 
			'cardButton' => 0,
		];
	}
}
/* End Setup additonal field variables */


/* Setup documentation field variables */
if( function_exists( 'get_field' ) ){
	$docs = get_field('documentation');
	
	if( isset( $docs ) && !empty( $docs ) ){
		
		$documentation = '<ul class="list-group list-group-flush" >';

		foreach ( $docs as $d ) { 
			$title 		= $d['title'];
			$seoTitle	= $d['attachement']['title'];
			$url 		= $d['attachement']['url'];

			$documentation .= "<li class='list-group-item'><a target='_blank' href='{$url}' title='{$seoTitle}'>{$title}</a></li>";
		}

		$documentation .= '</ul>';
	
		$documents[0] = array(
			'title' => '',
			'altContent' => $documentation,
			'linkTo' => '',
			'cardButton' => 0,
			'cardHeader' 	 => 'Documentation',
			'cardHeaderIcon' => 'fas fa-book'
		);
		
		$documents_layout_options = [
			'per_row' => 1,
			'alignment' => 'center',
			'outline' => 1,
			'cardLink' => 0, 
			'cardButton' => 0,
		];
	} // close if( isset( $docs ) && !empty( $docs ) )
} // close if( function_exists( 'get_field' ) )

/* End documentation field variables */

?>

	<div class="container marketing">		
		<?php
				while ( have_posts() ){ the_post();

					?>
						<section class="row">
							<div class="col-12 mt-3 mb-3">
								[Breadcrumbs Here]
							</div>
						</section>
						<article class="row">
							<section class="col-md-12 col-lg-4 bRed">
								<?php 
									if ( has_post_thumbnail() ){
										the_post_thumbnail('medium_large', array( 'class' => 'product-single-thumbnail img-fluid', 'data-full' => get_the_post_thumbnail_url() ));
									}

									if( !empty( $addPhotos ) ){
										$hp_mod = new ModuleCards( $add_imgs, $add_imgs_layout_options, NULL, 'test' );
										$hp_mod->getDisplay();
									}

									if( !empty( $documentation ) ){
										$doc_mod = new ModuleCards( $documents, $documents_layout_options, NULL, 'test' );
										$doc_mod->getDisplay();
									}
								?>
							</section>
							<section class="col-md-12 col-lg-8 bBlue">
								<h1><?php the_title(); ?></h1>
								<p>Brand: [Brand Name Here]</p>
								<div><?php the_content(); ?></div>
							</section>
						</article>

						<!-- For development purposes only -->
						<div>
							<?php 
								
							?>

						</div>
						<!-- End for development purposes only -->
					<?php

					//get_template_part( 'template-parts/content', get_post_format() );

					// If comments are open or we have at least one comment, load up the comment template.
					// if ( comments_open() || get_comments_number() ) :
					// 	comments_template();
					// endif;

				} // End of the loop.
		
		?>

	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
