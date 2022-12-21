// Possible improvements:
// - Change timeline and volume slider into input sliders, reskinned
// - Change into Vue or React component
// - Be able to grab a custom title instead of "Music Song"
// - Hover over sliders to see preview of timestamp/volume change

const audioPlayer = document.querySelector(".audio-player");
const playBtn = audioPlayer.querySelector(".controls .toggle-play");
const audio_name = $(".audio-player-custom .name");
const audio = new Audio(
  // "https://ia800905.us.archive.org/19/items/FREE_background_music_dhalius/backsound.mp3",
  pickRandomMusic()
);
//audio player settings
audio.preload = "auto";
//Set audio player title
audio_name.text(audio.src.split('/').at(-1));
//credit for song: Adrian kreativaweb@gmail.com

// autoplay music
var promise  = audio.play();
if(promise !== undefined) {
  playBtn.classList.remove("play");
  playBtn.classList.add("pause");
}

audio.addEventListener(
  "loadeddata",
  () => {
    audioPlayer.querySelector(".time .length").textContent = getTimeCodeFromNum(
      audio.duration
    );
    audio.volume = .75;
  },
  false
);
//When the current song is over, play some random music again.
audio.addEventListener("ended", () => {
  $(".landing").toggle();
  $("canvas").toggle();
  $(".ball").toggle();
  $("#carousel").toggle();
  $("#carousel").carousel("pause");
  $(".bi-play-circle-fill").hide();

  audio.src = pickRandomMusic();
  audio.load();
  audio.play();
  audio_name.text(audio.src.split('/').at(-1)); // Set audio player title

  setTimeout(() => {
    $(".landing").toggle();
    $("canvas").toggle();
    $(".ball").toggle();
    $("#carousel").toggle();
    $("#carousel").carousel("cycle");
  }, preset_time);
});


//click on timeline to skip around
const timeline = audioPlayer.querySelector(".timeline");
timeline.addEventListener("click", e => {
  const timelineWidth = window.getComputedStyle(timeline).width;
  const timeToSeek = e.offsetX / parseInt(timelineWidth) * audio.duration;
  audio.currentTime = timeToSeek;
}, false);

//click volume slider to change volume
const volumeSlider = audioPlayer.querySelector(".controls .volume-slider");
volumeSlider.addEventListener('click', e => {
  const sliderWidth = window.getComputedStyle(volumeSlider).width;
  const newVolume = e.offsetX / parseInt(sliderWidth);
  audio.volume = newVolume;
  audioPlayer.querySelector(".controls .volume-percentage").style.width = newVolume * 100 + '%';
}, false)

//check audio percentage and update time accordingly
setInterval(() => {
  const progressBar = audioPlayer.querySelector(".progress");
  progressBar.style.width = audio.currentTime / audio.duration * 100 + "%";
  audioPlayer.querySelector(".time .current").textContent = getTimeCodeFromNum(
    audio.currentTime
  );
}, 200);

//toggle between playing and pausing on button click
playBtn.addEventListener(
  "click",
  () => {
    if (audio.paused) {
      playBtn.classList.remove("play");
      playBtn.classList.add("pause");
      audio.play();
    } else {
      playBtn.classList.remove("pause");
      playBtn.classList.add("play");
      audio.pause();
    }
  },
  false
);

audioPlayer.querySelector(".volume-button").addEventListener("click", () => {
  const volumeEl = audioPlayer.querySelector(".volume-container .volume");
  audio.muted = !audio.muted;
  if (audio.muted) {
    volumeEl.classList.remove("icono-volumeMedium");
    volumeEl.classList.add("icono-volumeMute");
  } else {
    volumeEl.classList.add("icono-volumeMedium");
    volumeEl.classList.remove("icono-volumeMute");
  }
});

//turn 128 seconds into 2:08
function getTimeCodeFromNum(num) {
  let seconds = parseInt(num);
  let minutes = parseInt(seconds / 60);
  seconds -= minutes * 60;
  const hours = parseInt(minutes / 60);
  minutes -= hours * 60;

  if (hours === 0) return `${minutes}:${String(seconds % 60).padStart(2, 0)}`;
  return `${String(hours).padStart(2, 0)}:${minutes}:${String(
    seconds % 60
  ).padStart(2, 0)}`;
}
