<?php
    //initial setting variables for quotize online app
    $preset_time = 3000;
    $text_formatting = "Montserrat";
    $quote_config_path = "./assets/txt/config.csv";

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
    //get only quote that categories exists in config.csv
    function getQuote($index) {
        global $quote_config_path;
        global $quotes;
        
        $categories = [];
        $config_categories = [];
        //get categories of quote
        $categories = array_slice($quotes[$index], 5);
        $CSVfp = fopen($quote_config_path, "r");
        if($CSVfp != FALSE) {
            if(!feof($CSVfp)) {
                $data = fgetcsv($CSVfp, 1000, ";");
                if(!empty($data)) $config_categories = $data;
            }
        };
        //check if config has categories of quote
        foreach($categories as $key => $category) {
            if($category && in_array($category, $config_categories)) {
                return $quotes[$index][4];
            }
        };
        return $quotes[$index][4];
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'>
  <link rel="stylesheet" href="./assets/Custom-audio-player/audio.css">
  <link rel="stylesheet" href="./assets/css/icono.min.css">
  <link href="./assets/css/landing_babel.css" rel="stylesheet" />
  <link href="./assets/css/audio_player.css" rel="stylesheet" />
  <link rel="shortcut icon" href="#" />
  <style>
        .carousel-content {
            position: absolute;
            bottom: 15%;
            left: 15%;
            color: white;
            z-index: 20;
            text-shadow: 0 1px 2px rgba(0,0,0,.6);
            font-size: 5vw;
            font-weight: bold;
            font-family: <?php echo $text_formatting; ?>;
            -webkit-text-stroke-width: 1px;
            -webkit-text-stroke-color: black;
        }
        .bi-play-circle-fill{
            position: absolute;
            z-index: 9999999;
            border-radius: 170px;
            padding: 0px;
            cursor: pointer;
            display: none;
        }
        .bi-play-circle-fill:hover {

        }
        @media screen and (min-width: 400px) {
            .bi-play-circle-fill {
                font-size: 6rem;
                top: 27%;
                left: 42%;
            }
        }
        @media  screen and (min-width: 767px) {
            .carousel-content {
                bottom: 20%;
                font-size: 4vw;
            }
            .bi-play-circle-fill {
                font-size: 8rem;
                top: 25%;
                left: 40%;
            }
        }
        @media only screen and (min-width: 992px) {
            .carousel-content {
                bottom: 20%;
                font-size: 4vw;
            }
            .bi-play-circle-fill {
                font-size: 10rem;
                top: 30%;
                left: calc(40% + 20px);
            }
        }
        @media only screen and (min-width: 1400px) {
            .carousel-content {
                bottom: calc(20%-20px);
                font-size: 4vw;
            }
            .bi-play-circle-fill {
                font-size: 10rem;
                top: calc(40%+2%);
                left: 45%;
            }
        }
        @media only screen and (min-width: 2100px) {
            .carousel-content {
                bottom: 20%;
                font-size: 4vw;
            }
            .bi-play-circle-fill {
                font-size: 12rem;
                top: 40%;
                left: 45%;
            }
        }
        @media only screen and (min-width: 2600px) {
            .carousel-content {
                bottom: 20%;
                font-size: 4vw;
            }
            .bi-play-circle-fill {
                font-size: 14rem;
                top: 35%;
                left: 45%;
            }
        }
  </style>
</head>
<body>
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
                <?php
                    foreach ($images as $index => $image) {
                        $active = !$index ? "active" : "";
                        echo "<div class='carousel-item {$active}'>
                            <img src='{$image}' class='d-block w-100' alt='failed to find image'>
                            <div class='carousel-content'>".getQuote($index)."</div>
                        </div>";
                    }         
                ?>
                <span id="boot-icon" class="bi bi-play-circle-fill" style="color: rgb(255, 255, 255);"></span>
            </div>
            
        </div>
           
    </div>
    <!-- <div class="player">   
        <audio crossorigin autoplay id="musicplayer">
            <source src="<?php echo $audios[array_rand($audios)]; ?>" type="audio/mpeg">
        </audio>
    </div>     -->
    <div class="audio-player-custom">
        <div style="width: 50px; height: 50px;"></div>
        <div class="audio-player">
        <div class="timeline">
            <div class="progress"></div>
        </div>
        <div class="controls">
            <div class="play-container">
            <div class="toggle-play play">
            </div>
            </div>
            <div class="time">
            <div class="current">0:00</div>
            <div class="divider">/</div>
            <div class="length"></div>
            </div>
            <div class="name">Music Song</div>
        <!--     credit for icon to https://saeedalipoor.github.io/icono/ -->
            <span class="icono-volumnHigh"></span>
            <div class="volume-container">
            <div class="volume-button">
                <div class="volume icono-volumeMedium"></div>
            </div>         
            <div class="volume-slider">
                <div class="volume-percentage"></div>
            </div>
            </div>
        </div>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./assets/js/particles.min.js"></script>
<script src="./assets/js/audio_player.js" type="text/javascript"></script>
<script src="./assets/js/babel.min.js"></script>
<script src="./assets/js/landing_babel.js" type="text/babel"></script>
<script src="./assets/Custom-audio-player/audio.js" type="text/javascript"></script>
<script>

    var preset_time = <?php echo $preset_time; ?>;
    //initialize quotize onlien app
    $("#carousel").hide();
    setTimeout(() => {
        $(".landing").hide();
        $("canvas").hide();
        $(".ball").hide();
        $("#carousel").show();
        $("#carousel").carousel({
            interval: preset_time,
            pause: false,
            wrap: true
        });
        $("#carousel").carousel("cycle");
    }, preset_time);
    //add click event to show play circle button on carousel
    $("#carousel").on("click", (event) => {
       $(".bi-play-circle-fill").toggle();
       if($(".bi-play-circle-fill").css("display") === "block") {
            $("#carousel").carousel("pause");
       } else {
            $("#carousel").carousel("cycle");
       }
    });
</script>
</html>

