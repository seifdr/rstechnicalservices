<?php 
        if( function_exists( 'get_field' ) ){

           // $images = get_field('home_gallery');
  		   $images = get_field('feature');
           $images_count = count( $images );
           //look( $images );

           if( !empty( $images_count ) && $images_count > 0 ){
?>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php 
                    
                        for ($i=0; $i < $images_count; $i++) { 
                            
                            echo '<li data-target="#myCarousel" data-slide-to="'. $i .'" ';
                            
                            if( $i == 0 ){
                                echo ' class="active" ';
                            }
                            
                            echo "></li>";
                            
                        }
                        
                    ?>
                </ol>
                <div class="carousel-inner">
                    <?php
                        for ($i=0; $i < $images_count; $i++) { 
                    ?>
                            <div class="carousel-item <?php if( $i == 0 ){ echo ' active '; } ?>">
                                <!-- src placeholder can delete later - data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" -->
                                <img class="<?php echo $i; ?>-slide" src="<?php echo $images[$i]['image']['url'];  ?>" alt="<?php echo $images[$i]['image']['alt']; ?>">
                                <div class="container">
                                    <!-- <div class="carousel-caption text-right"> right text -->
                                    <!-- <div class="carousel-caption"> centered text -->
                                    <div class="carousel-caption text-left">
                                        <h1><?php echo $images[$i]['Headline']; ?></h1>
                                        <p><?php echo $images[$i]['sub_headline']; ?></p>
                                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn More</a></p>
                                    </div>
                                </div>
                            </div>
                    <?php        
                        }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
                </a>
            </div>
<?php
           } // close images count check 

        } // close acf check
?>