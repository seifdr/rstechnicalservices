<?php 

/*
* Code to display various Bootstrap 4 componets in a reuseable way
*/

class ModuleViews {
    public $module_id;
    public $module_class;

    public $data;
    public $options;
    public $dataCount = 0;
    public $type;
    
    function __construct( $data, $options = NULL, $module_id = "default", $module_class="default" ) {
        $this->module_id    = $module_id;
        $this->module_class = $module_class; 
        
        $this->data     = $data;
        $this->options  = $options; 

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
            //d will be shorthand for the data
            $d =& $this->data[$i];
            
            $img =& $this->data[$i]['image'][''];

            if( $i == 0 ){
                echo "<hr class='featurette-divider'>";
            }

            ?>
                
                <div class="row featurette">
                    <div class="col-md-7 <?php if( $d['image_placement'] == 'right' ){ echo 'order-md-2'; }  ?>">
                        <h2 class="featurette-heading"><?php echo $d['text']['title']; ?><!-- <span class="text-muted">See for yourself.</span> --></h2>
                        <p class="lead"><?php echo $d['text']['blurb']; ?></p>
                    </div>
                    <div class="col-md-5 <?php if( $d['image_placement'] == 'right' ){ echo 'order-md-1'; }  ?>">
                        <img class="featurette-image img-fluid mx-auto" src="<?php echo $img['sizes']['medium_large']; ?>" alt="<?php echo $img['alt']; ?>" title="<?php echo $img['title']; ?>"  ?>
                    </div>
                </div>
                <hr class='featurette-divider'>

            <?php
        } // end for loop
    }
}

class ModuleCallouts extends ModuleViews {
    public $type = 'callouts';
    private $colCnt = 0;
    
    function __construct( $data, $options, $module_id = "default", $module_class="default" ) {
        //keep parent contructor functionality / dont override it
        parent::__construct( $data, $options, $module_id = "default", $module_class="default" );

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
                <p><a class="btn btn-primary" href="<?php echo $co['button']['page_link']; ?>" role="button"><?php echo $co['button']['button_label']; ?></a></p>
            </div><!-- /.col-lg-4 -->      
        <?php                
            } //end foreach
        echo "</div>";
        
        //look( $this->data );
    }
}

class ModuleCards extends ModuleViews {
    public  $type = 'cards';
    private $colCnt = 0;
    private $rowCnt = 0;
    private $cardClass;
    
    function __construct( $data, $options, $module_id = "default", $module_class="default" ) {
        //keep parent contructor functionality / dont override it
        parent::__construct( $data, $options, $module_id = "default", $module_class="default" );
        $this->calcCardRowsAndCols();
        $this->makeCardClass();
        // look( $data );
    }

    protected function calcCardRowsAndCols(){
        //colCnt is the same as per row
        if( !isset( $this->options['per_row'] ) ){
            $this->colCnt = 3;
        } else {
            $this->colCnt = $this->options['per_row'];
        }
    }

    private function makeCardClass(){
        $ops = &$this->options;
     
        $classTxt = ' card justify-content-center ';

        if( $ops['outline'] != '1' ){
            $classTxt .= ' no-outline ';
        }

        if( $ops['alignment'] == 'center' ){
            $classTxt .= ' text-center ';
        }

        if( $ops['per_row'] == '4' ){
            $classTxt .= ' fourPerRow ';
        } elseif ( $ops['per_row'] ==  '3' ){
            $classTxt .= ' threePerRow ';
        } elseif ( $ops['per_row'] ==  '6' ) {
            $classTxt .= 'sixPerRow ';
        }

        $this->cardClass = $classTxt;

    }

    protected function display(){    
        ?>
            <div class="card-deck hp-card-deck">
        <?php
            $cardCounter = 0;
            for ($i=0; $i < $this->dataCount ; $i++) { 
            
                if( isset( $this->options['cardLink'] ) && $this->options['cardLink'] ){ 
                    echo '<a href="';
                        echo ( isset( $this->data[$i]['linkTo'] ) && !empty( $this->data[$i]['linkTo'] ) )? $this->data[$i]['linkTo'] : "#";
                    echo '" class="'. $this->cardClass .'">';
                } else {
                    echo '<div class="'. $this->cardClass .'">';
                }

                if( isset( $this->data[$i]['cardHeader'] ) ){
        ?>
                <!-- Card Header -->
                <div class="card-header">
                    <?php echo $this->data[$i]['cardHeader']; ?>
                </div>
                <!-- End Card Header -->
        <?php 
                } // end if( isset( $this->data[$i]['cardHeader'] ) )
        ?>

                <!-- Card Image -->
                <?php 

                if( isset( $this->data[$i]['image'] ) ){
                
                    $img = $this->data[$i]['image'];

                        if( isset( $img['sizes']['medium'] ) ){ ?>
                        <img class="<?php ( isset( $this->data[$i]['cardHeader'] ) )? 'card-img-top': ''; ?>" src="<?php echo $img['sizes']['medium']; ?>"
                            <?php if( isset( $img['alt'] ) ){ ?> 
                                alt="<?php echo $img['alt']; ?>"
                            <?php } ?>
                            <?php if( isset( $img['title'] ) ){ ?> 
                            title="<?php echo $img['title']; ?>" 
                            <?php } ?>
                        >
                    <?php } // end - if( isset( $img['sizes']['medium'] ) )
                } // end - if( isset( $this->data[$i]['image'] ) )
                ?>
                <!-- End Card Image  -->

                <div class="card-body">
                    <h5 class="card-title"><?php echo $this->data[$i]['title']; ?></h5>
                    <?php echo ( !empty( $this->data[$i]['blurb'] ) )? '<p class="card-text">'. $this->data[$i]['blurb'] .'</p>' : ''; ?> 
                </div>
                <?php if( $this->data[$i]['cardButton'] == '1' ){ 
                        $btn = $this->data[$i]['button'];
                ?>
                    <div class="card-footer"><a href="<?php echo $btn['button_link']; ?>" class="btn btn-primary"><?php echo $btn['button_text']; ?></a></div>   
                <?php } 
        
                if( isset( $this->options['cardLink'] ) && $this->options['cardLink'] ){ 
                    echo "</a>";
                } else {
                    echo "</div>";
                }
            } // close for 
        ?>
            </div> <!-- close card deck -->
        <?php

        //look( $this->options );
        // look( $this->data );
    }
}

class ModuleButtons extends ModuleViews {
    public $type = 'buttonRow';
    private $colNum = 12;

    protected function display(){
        if( $this->dataCount > 0 ){

            $this->colNum = 12 / $this->dataCount; 

            echo '<div class="row" >';

            for ($i=0; $i < $this->dataCount; $i++) { 
                $buttonData = $this->data[$i]['button_link'];  
                echo '<div class="col-4 text-center mb-4"><a href="'. $buttonData['url'] .'" class="btn btn-primary btn-lg btn-block" role="button" aria-pressed="true">'. $buttonData['title'] .'</a></div>';
            }   

            echo '</div>';
        }   
    }
}
