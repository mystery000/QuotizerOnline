<?php
    $preset_time = 3000;
    $text_formatting = 'arial'
?>
<html lang="en">
<head>
  <title>Quotizer online</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./assets/css/player.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/player.js"></script>
  <style>
    body {
        background-image: url(./assets/pix/bg-img/infinity-scenario-background-stars2-logo-1920x2880.jpg) !important;
        background-size: cover;
    }
    img {
        width: 100%;
        height: 100%;
    }
    
  </style>
</head>
<body>
    <div id="landing" style="display:flex;"></div>
    <div id="main" style="display:none;">
        <div id="carouselSlideShow" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php 
                    $images = getImagesFromPix("./assets/pix/");
                    $isFirstSlide = 'active';
                    foreach($images as $image) {
                        echo '<div class="carousel-item '.$isFirstSlide.'" data-bs-interval="3000"><img src="'.$image.'"class="img-fluid" alt="no image"></div>';
                        $isFirstSlide = '';
                    }
                    $audios = getAudiosFromMp3("./assets/mp3/");
                    $curAudio = array_rand($audios);                
                ?>
            </div>
        </div>
        <audio id="cs_audio" controls>
            <source src="./assets/mp3/Free_Test_Data_5MB_MP3_1.mp3" type="audio/mpeg">
        </audio>
    </div>   
</body>
</html>
<?php
    function getImagesFromPix($dir) {
        $images = glob($dir.'*.{jpg,JPG,png,PNG}', GLOB_BRACE);
        return $images;
    }
    function getAudiosFromMp3($dir){
        $audios = glob($dir.'*.{mp3, MP3}', GLOB_BRACE);
        return $audios;
    }
?>

<script>
    var preset_time = <?php echo $preset_time; ?>;
    // The slide show is displayed after preset time
    setTimeout(() => {
        const main = document.querySelector('#main');
        const landing = document.querySelector('#landing');
        main.style.display = "block";
        landing.style.display = "none";
    }, preset_time);

    // background soundtrach controller

</script>