<?php 

/*
* Code to display various Bootstrap 4 componets in a reuseable way
*/

class ModuleViews {
    public $module_id;
    public $module_class;

    public $data;
    public $dataCount = 0;
    public $type;
    
    function __construct( $data, $module_id = "default", $module_class="default" ) {
        $this->module_id    = $module_id;
        $this->module_class = $module_class; 
        
        $this->data = $data;

        $this->countData();
    }

    /*
    * public function acts as getting to call private display function, and a gate to prevent running display without data.
    */
    public function getDisplay(){

        if( $this->dataCount > 0 ){
            $this->display();
        }

    }

    protected function display(){
        // this will be modified by sub classes
    }

    private function countData(){
        $this->dataCount = count( $this->data );
    }

    protected function hashFromID(){
        return "#" . $this->module_id;
    }

}

class ModuleCarousel extends ModuleViews {
    public $type = 'carousel';



    protected function display(){
    
        ?>

        <div id="<?php echo $this->module_id; ?>" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php 
                    
                        for ($i=0; $i < $this->dataCount; $i++) { 
                            
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
                        for ($i=0; $i < $this->dataCount; $i++) { 
                    ?>
                            <div class="carousel-item <?php if( $i == 0 ){ echo ' active '; } ?>">
                                <!-- src placeholder can delete later - data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" -->
                                <img class="<?php echo $i; ?>-slide" src="<?php echo $this->data[$i]['image']['url'];  ?>" alt="<?php echo $this->data[$i]['image']['alt']; ?>">
                                <div class="container">
                                    <!-- <div class="carousel-caption text-right"> right text -->
                                    <!-- <div class="carousel-caption"> centered text -->
                                    <div class="carousel-caption text-left">
                                        <h1><?php echo $this->data[$i]['Headline']; ?></h1>
                                        <p><?php echo $this->data[$i]['sub_headline']; ?></p>
                                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn More</a></p>
                                    </div>
                                </div>
                            </div>
                    <?php        
                        }
                    ?>
                </div>
                <a class="carousel-control-prev" href="<?php echo $this->hashFromID(); ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="<?php echo $this->hashFromID(); ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
                </a>
            </div>


        <?php
    }
}

class ModuleFeaturette extends ModuleViews {
    public $type = 'featurette';

    protected function display(){

        for ($i=0; $i < $this->dataCount ; $i++) {     

            if( $i == 0 ){
                echo "<hr class='featurette-divider'>";
            }

            ?>
                
                <div class="row featurette">
                    <div class="col-md-7 order-md-2">
                        <h2 class="featurette-heading">Field Service <!-- <span class="text-muted">See for yourself.</span> --></h2>
                        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                    </div>
                    <div class="col-md-5 order-md-1">
                        <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
                    </div>
                </div>
                <hr class='featurette-divider'>

            <?php

           
        } // end for loop

        look( $this->data );
    }
}

class ModuleCallouts extends ModuleViews {
    public $type = 'callouts';
    private $colCnt = 0;
    
    function __construct( $data, $module_id = "default", $module_class="default" ) {
        //keep parent contructor functionality / dont override it
        parent::__construct( $data, $module_id = "default", $module_class="default" );

        $this->colCnt = 12 / $this->dataCount;
    }


    protected function display(){
        echo "<div class='row'>";
            foreach ($this->data as $co ) {
        ?>
            <div class="col-lg-<?php echo $this->colCnt; ?>">
                <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
                <h2><?php echo $co['title']; ?></h2>
                <p><?php echo $co['brief_blurb']; ?></p>
                <p><a class="btn btn-secondary" href="<?php echo $co['button']['page_link']; ?>" role="button"><?php echo $co['button']['button_label']; ?></a></p>
            </div><!-- /.col-lg-4 -->      
        <?php                
            } //end foreach
        echo "</div>";
        //look( $this->data );
    }
}

class ModuleCards extends ModuleViews {
    public $type = 'cards';

    protected function display(){
        ?>
            <p>Hello there. I'm a cards module.</p>
        <?php
    }
}
