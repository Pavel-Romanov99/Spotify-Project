const musicContainer = document.getElementById("music-container");
const playBtn = document.getElementById("play");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");

const audio = document.getElementById("audio");
const progress = document.getElementById("progress");
const progressContainer = document.getElementById("progress-container");
const title = document.getElementById("title");
const cover = document.getElementById("cover");
const currTime = document.querySelector("#currTime");
const durTime = document.querySelector("#durTime");
const volume = document.querySelector("#volume");

var songIds = [];
var coverIds = [];
var songNames = [];
var songAuthors = [];
// Keep track of song
let songIndex = 0;

// loading the songs from the user library
$.ajax({
  url: "../handlers/getUserSongsHandling.php",
  type: 'get',
  async: false,
  success: function (response) {
    if(response)
    {
      for(var i = 0; i < response.length; i++)
      {
        songIds.push(JSON.parse(response[i])["song_id"]);
        coverIds.push(JSON.parse(response[i])["cover_id"]);
        songNames.push(JSON.parse(response[i])["name"]);
        songAuthors.push(JSON.parse(response[i])["author"]);
      }
    }
  },
  error: function(textStatus, errorThrown) {
     console.log(textStatus, errorThrown);
  }
});

var has_loaded_some_song;
// Initially load song details into DOM
// if the user has no songs:
if(songIds.length == 0) {
  has_loaded_some_song = false;
  loadSong(null, 'add your first song!', 'Please', 'default-cover.jpg', false);
}
//if the user has songs:
else {
  has_loaded_some_song = true;
  loadSong(songIds[0], songNames[0], songAuthors[0], coverIds[0], false);
}

audio.volume = 0.5;
volume.value = 50;

volume.oninput = function()
{
  audio.volume = this.value / 100 - 0.01;
}

var loaded_song;
var loaded_name;
var loaded_author;
var loaded_cover;

var loaded_but_not_played = true;

// Update song details
function loadSong(song, name, author, cover_name, play_after_load) {
  title.innerText = author + ' - '+ name;

  if(song){
    
    loaded_but_not_played = true;

    loaded_song = song;
    loaded_name = name;
    loaded_author = author;
    loaded_cover = cover_name;

    audio.src = `../uploads-songs/${song}`;
    cover.src = `../uploads-covers/${cover_name}`;

    has_loaded_some_song = true;

    if(play_after_load){
      addToHistory();
      loaded_but_not_played = false;
      playSong();
    }
  }
}

// Add loaded and played song to user history
function addToHistory()
{
  $.ajax({
    url: "../handlers/addToHistoryHandling.php",
    type: 'post',
    data: {
      song_id: loaded_song,
      cover_id: loaded_cover,
      name: loaded_name,
      author: loaded_author
    },
    success: function (response) {
        //alert(response);
    },
    error: function(textStatus, errorThrown) {
       console.log(textStatus, errorThrown);
    }
  });
}

// Play song
function playSong() {
 if(has_loaded_some_song){

    if(loaded_but_not_played) {
      loaded_but_not_played = false;
      addToHistory();
    }
    musicContainer.classList.add("play");
    playBtn.querySelector("i.fas").classList.remove("fa-play");
    playBtn.querySelector("i.fas").classList.add("fa-pause");

    audio.play();
 }
}

// Pause song
function pauseSong() {
  musicContainer.classList.remove("play");
  playBtn.querySelector("i.fas").classList.add("fa-play");
  playBtn.querySelector("i.fas").classList.remove("fa-pause");

  audio.pause();
}

// Previous song
function prevSong() {
  if(has_loaded_some_song) {

    songIndex--;

    if (songIndex < 0) {
      songIndex = songIds.length - 1;
    }

    loadSong(songIds[songIndex], songNames[songIndex], songAuthors[songIndex], coverIds[songIndex], true);

    playSong();
  }
}

// Next song
function nextSong() {
  if(has_loaded_some_song) {
    
    songIndex++;

    if (songIndex > songIds.length - 1) {
      songIndex = 0;
    }

    loadSong(songIds[songIndex], songNames[songIndex], songAuthors[songIndex], coverIds[songIndex], true);

    playSong();
  }
}

// Update progress bar
function updateProgress(e) {
  const { duration, currentTime } = e.srcElement;
  const progressPercent = (currentTime / duration) * 100;
  progress.style.width = `${progressPercent}%`;
}

// Set progress bar
function setProgress(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const duration = audio.duration;

  audio.currentTime = (clickX / width) * duration;
}

//get duration & currentTime for Time of song
function DurTime(e) {
  const { duration, currentTime } = e.srcElement;
  var sec;
  var sec_d;

  // define minutes currentTime
  let min = currentTime == null ? 0 : Math.floor(currentTime / 60);
  min = min < 10 ? "0" + min : min;

  // define seconds currentTime
  function get_sec(x) {
    if (Math.floor(x) >= 60) {
      for (var i = 1; i <= 60; i++) {
        if (Math.floor(x) >= 60 * i && Math.floor(x) < 60 * (i + 1)) {
          sec = Math.floor(x) - 60 * i;
          sec = sec < 10 ? "0" + sec : sec;
        }
      }
    } else {
      sec = Math.floor(x);
      sec = sec < 10 ? "0" + sec : sec;
    }
  }

  get_sec(currentTime, sec);

  // change currentTime DOM
  currTime.innerHTML = min + ":" + sec;

  // define minutes duration
  let min_d = isNaN(duration) === true ? "0" : Math.floor(duration / 60);
  min_d = min_d < 10 ? "0" + min_d : min_d;

  function get_sec_d(x) {
    if (Math.floor(x) >= 60) {
      for (var i = 1; i <= 60; i++) {
        if (Math.floor(x) >= 60 * i && Math.floor(x) < 60 * (i + 1)) {
          sec_d = Math.floor(x) - 60 * i;
          sec_d = sec_d < 10 ? "0" + sec_d : sec_d;
        }
      }
    } else {
      sec_d = isNaN(duration) === true ? "0" : Math.floor(x);
      sec_d = sec_d < 10 ? "0" + sec_d : sec_d;
    }
  }

  // define seconds duration

  get_sec_d(duration);

  // change duration DOM
  durTime.innerHTML = min_d + ":" + sec_d;
}

// Event listeners
playBtn.addEventListener("click", () => {
  const isPlaying = musicContainer.classList.contains("play");

  if (isPlaying) {
    pauseSong();
  } else {
    playSong();
  }
});

// Change song
prevBtn.addEventListener("click", prevSong);
nextBtn.addEventListener("click", nextSong);

// Time/song update
audio.addEventListener("timeupdate", updateProgress);

// Click on progress bar
progressContainer.addEventListener("click", setProgress);

// Song ends
audio.addEventListener("ended", nextSong);

// Time of song
audio.addEventListener("timeupdate", DurTime);