<?php 

// Breadcrumbs
function custom_breadcrumbs() {
      
    // Settings
    $separator          = '&gt;';
	// $separator          = '';
    $breadcrums_id      = 'breadcrumb';
    $breadcrums_class   = 'breadcrumb';
    $home_title         = 'Home';
     
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
      
    // Get the query & post information
    global $post,$wp_query;
      
    // Do not display on the homepage
    if ( !is_front_page() ) {
      
        // Build the breadcrums
        echo '<ol id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
          
        // Home page
        echo '<li class="breadcrumb-item"><a href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
          
        if ( is_archive() && !is_tax() && !is_category() ) {
             
            echo '<li class="breadcrumb-item active">' . post_type_archive_title($prefix, false) . '</li>';
             
        } else if ( is_archive() && is_tax() && !is_category() ) {
             
            // If post is a custom post type
            $post_type = get_post_type();
             
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                 
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
             
                echo '<li class="breadcrumb-item item-custom-post-type-' . $post_type . '"><a href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
             
            }
             
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="breadcrumb-item active">' . $custom_tax_name . '</li>';
             
        } else if ( is_single() ) {
			 
            // If post is a custom post type
            $post_type = get_post_type();
             
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                 
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
             
                echo '<li class="breadcrumb-item item-custom-post-type-' . $post_type . '"><a href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
             
            }
			 
            // Get post category info
            $category = get_the_category();

            // Get last category post is in
            $catArr = array_values($category);

            $last_category = end( $catArr );
             
			if( not_Blank($last_category) ){
  				// Get parent any categories and create array
            	$get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
           	 	$cat_parents = explode(',',$get_cat_parents);
				
				// Loop through parent categories and store in variable $cat_display
	            $cat_display = '';
	            foreach($cat_parents as $parents) {
	                $cat_display .= '<li class="breadcrumb-item">'.$parents.'</li>';
	            }
				
			} 
			
			//get a lis tof custom taxonomies 		
			$custom_taxonomies = get_taxonomies( array( '_builtin' => false ) );
			
			// look at each custom tax and then if there are any terms applied 
			foreach ($custom_taxonomies as $ct) {
				if( count( get_the_terms( $post->ID, $ct ) ) > 0 ){
					//found terms for custom tax, set the custom tax and break out of loop
					$custom_taxonomy = $ct;
					break;
				} else {
					$custom_taxonomy = NULL;
				}
			}
			
			// If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
			
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                  
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
              
            }
             
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="breadcrumb-item active item-' . $post->ID . '">' . get_the_title() . '</li>';
                 
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                 
                echo '<li class="breadcrumb-item item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="breadcrumb-item active item-' . $post->ID . '">' . get_the_title() . '</li>';
             
            } else {
                 
                echo '<li class="breadcrumb-item active item-' . $post->ID . '">' . get_the_title() . '</li>';
                 
            }
             
        } else if ( is_category() ) {
        	
			// If post is a custom post type
            $post_type = get_post_type();
			
			//If it is a custom post type display name and link
            if($post_type != 'post') {
                 
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
             
                echo '<li class="breadcrumb-item item-custom-post-type-' . $post_type . '"><a href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
            }

            // Get post category info
            //$category = get_the_category();
			
			// Get last category post is in
            //$last_category = end(array_values($category));
			
			// Get parent any categories and create array
            //$get_cat_parents = trim(get_category_parents($last_category->term_id, true, ','),',');

            //$cat_parents = explode(',',$get_cat_parents);
			
			// $count_of_cat_parents = count( $cat_parents );
			// $counter = 0;
// 			
			// // Loop through parent categories and store in variable $cat_display
 			// foreach($cat_parents as $parents) {
 				// $counter++;
// 				
				// if( $counter != $count_of_cat_parents ){
					// echo '<li class="item-cat">'.$parents.'</li>';	
				// } else {
					// echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">'. $parents .'</strong></li>';
				// }
// 				    
            // }             

			$parent_cat = get_query_var( 'parent_cat', NULL);
			$category_name = get_query_var( 'category_name', NULL );
            
			if( $parent_cat ){
				$parent_cat = get_category_by_slug($parent_cat);	
				$parent_cat_link = get_category_link($parent_cat->term_id);
				echo '<li class="breadcrumb-item"><a href="'. $parent_cat_link .'">'. $parent_cat->name .'</a></li>'; 
			}
			
            // Category page
            $main_category = get_category_by_slug($category_name);
            echo '<li class="breadcrumb-item active">' . $main_category->name . '</li>';  
			  
        } else if ( is_page() ) {
              
            // Standard page
            if( $post->post_parent ){
                  
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                  
                // Get parents in the right order
                $anc = array_reverse($anc);
                  
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="breadcrumb-item item-parent-' . $ancestor . '"><a href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }
                  
                // Display parent pages
                echo $parents;
                  
                // Current page
                echo '<li class="breadcrumb-item active item-' . $post->ID . '">' . get_the_title() . '</li>';
                  
            } else {
                  
                // Just display current page if not parents
                echo '<li class="breadcrumb-item active item-' . $post->ID . '">' . get_the_title() . '</li>';
                  
            }
              
        } else if ( is_tag() ) {
              
            // Tag page
              
            // Get tag information
            $term_id = get_query_var('tag_id');
            $taxonomy = 'post_tag';
            $args ='include=' . $term_id;
            $terms = get_terms( $taxonomy, $args );
              
            // Display the tag name
            echo '<li class="breadcrumb-item active item-tag-' . $terms[0]->term_id . ' item-tag-' . $terms[0]->slug . '">' . $terms[0]->name . '</li>';
          
        } elseif ( is_day() ) {
              
            // Day archive
              
            // Year link
            echo '<li class="breadcrumb-item item-year-' . get_the_time('Y') . '"><a href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
              
            // Month link
            echo '<li class="breadcrumb-item item-month-' . get_the_time('m') . '"><a href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
              
            // Day display
            echo '<li class="breadcrumb-item item-' . get_the_time('j') . '">' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</li>';
              
        } else if ( is_month() ) {
              
            // Month Archive
              
            // Year link
            echo '<li class="breadcrumb-item item-year item-year-' . get_the_time('Y') . '"><a href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
              
            // Month display
            echo '<li class="breadcrumb-item item-month item-month-' . get_the_time('m') . '">' . get_the_time('M') . ' Archives</li>';
              
        } else if ( is_year() ) {
              
            // Display year archive
            echo '<li class="breadcrumb-item active item-current-' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</li>';
              
        } else if ( is_author() ) {
              
            // Auhor archive
              
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
              
            // Display author name
            echo '<li class="breadcrumb-item active item-current-' . $userdata->user_nicename . '">' . 'Author: ' . $userdata->display_name . '</li>';
          
        } else if ( get_query_var('paged') ) {
            	  
			if( is_search() ){
				$orginalSearchURL = site_url() . '?s=' . get_search_query();
					
				echo '<li class="breadcrumb-item item-parent-search"><a href="' . esc_url( $orginalSearchURL ) . '" title="Searching for: ' . get_search_query() . '">Search</a></li>';
			}
				  
            // Paginated archives
            echo '<li class="breadcrumb-item active item-current-' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</li>';
              
        } else if ( is_search() ) {
          
            // Search results page
            //echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
          	 echo '<li class="breadcrumb-item active item-current-' . get_search_query() . '">Search</li>';
        } elseif ( is_404() ) {
              
            // 404 page
            echo '<li>' . 'Page Not Found - 404' . '</li>';
        }
      
        echo '</ol>';
          
    }
      
}