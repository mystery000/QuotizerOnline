<?php
    //initial setting variables for quotize online app
    $preset_time = 3000;
    $text_formatting = 'arial';

    //get all images(jpg, png) from assets
    function getImages($dir) {
        $images = glob($dir.'*.{jpg,JPG,png,PNG}', GLOB_BRACE);
        return $images;
    }
    //get all audios(mp3) from assets
    function getAudios($dir){
        $audios = glob($dir.'*.{mp3, MP3}', GLOB_BRACE);
        return $audios;
    }
    //get quotes from csv in assets folder
    function getQuotes($dir) {
        $quotes = [];
        $CSVfp = fopen($dir, "r");
        if($CSVfp != FALSE) {
            while(!feof($CSVfp)) {
                $data = fgetcsv($CSVfp, 1000, ";");
                if(!empty($data)) array_push($quotes, $data);
            }
        }
        fclose($CSVfp);
        return $quotes;
    }
    // get all resources form assets
    $quotes = getQuotes("./assets/txt/DKM.csv");
    $audios = getAudios("./assets/mp3/");
    $images = getImages("./assets/pix/");
    // shuffles(randomizes the order of elements in) an array 
    shuffle($images);
    shuffle($audios);
    shuffle($quotes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Quotizer online</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link href="./assets/css/loader_particles.css" rel="stylesheet" /> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/landing_babel.css" rel="stylesheet" />
  <link href="./assets/css/audio_player.css" rel="stylesheet" />
  <link rel="shortcut icon" href="#" />
  <style>
        audio {
            position: -webkit-sticky;
            position: fixed;
            z-index: 99999;
            bottom:0;
            width: 100%;
        }
        .carousel-content {
            position: absolute;
            bottom: 15%;
            left: 15%;
            color: white;
            z-index: 20;
            text-shadow: 0 1px 2px rgba(0,0,0,.6);
            font-size: 200%;
        }
  </style>
</head>
<body>
    
    <!-- <div class="loader">
        <div class="e-loadholder">
            <div class="m-loader">
                <span class="e-text">Loading</span>
            </div>
        </div>
        <div id="particleCanvas-Blue"></div>
        <div id="particleCanvas-White"></div>
    </div> -->
    
    <div class="landing">
        <div class="title">
            <h3>Olek - 2022</h3>
            <h1>Quotizer Online</h1>
            <h3>Truly unique experience</h3>
        </div>
        <div class="more-pens">
            <a target="_blank" href="#" class="white-mode">Extend Plots1</a>
            <a target="_blank" href="#" class="white-mode">Extend Plots2</a>
        </div>
    </div>
    <div class="slideshow">
        <div id="carousel" class="carousel carousel-fade">
        <div class="carousel-inner">
            <!-- <div class="carousel-item active">
                <div class="carousel-content">Default overlay</div>
                <img src="./assets/pix/img_001.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/pix/img_002.jpg" class="d-block w-100" alt="...">
                <div class="carousel-content">Default overlay</div>
            </div>
            <div class="carousel-item">
                <img src="./assets/pix/img_003.jpg" class="d-block w-100" alt="...">
                <div class="carousel-content">Default overlay</div>
            </div> -->
            <?php
                foreach ($images as $index => $image) {
                    $active = !$index ? "active" : "";
                    echo "<div class='carousel-item {$active}'>
                        <img src='{$image}' class='d-block w-100' alt='failed to find image'>
                        <div class='carousel-content'>{$quotes[$index][4]}</div>
                    </div>";
                }         
            ?>
        </div>
        </div>
    </div>
    <div class="player">
        <audio id="musicplayer" controls autoplay>
            <source src="http://media.w3.org/2010/07/bunny/04-Death_Becomes_Fur.mp4" type="audio/mpeg">
        </audio>
    </div>
</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./assets/js/particles.min.js"></script>
<!-- <script src="./assets/js/loader_particles.js" type="text/javascript"></script> -->
<script src="./assets/js/audio_player.js" type="text/javascript"></script>
<script src="./assets/js/babel.min.js"></script>
<script src="./assets/js/landing_babel.js" type="text/babel"></script>
<script>
    var preset_time = <?php echo $preset_time; ?>;
    $("#carousel").hide();
    setTimeout(() => {
        $(".landing").hide();
        $("canvas").remove();
        $(".ball").remove();
        $("#carousel").show();
        var carousel = new bootstrap.Carousel($("#carousel"), {
            interval: preset_time,
            ride: "carousel",
            wrap: true,
        });
        
    }, preset_time);
    
</script>
</html>

