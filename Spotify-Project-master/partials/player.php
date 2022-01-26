<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../styles/playerStyles.css" />
    <title>Music Player</title>
  </head>
  <body>

    <div class="music-container" id="music-container">
      <div class="music-info">
        <div class="info-container">
          <h4 id="title"></h4>
          <div class="progress-container" id="progress-container">
            <div class="progress" id="progress"></div>
          </div>
          <div class="times-container">
            <div id = "currTime"></div>
            <div id = "durTime"></div>
          </div>
        </div>

        <div class="navigation">
          <div class="buttons">
            <button id="prev" class="action-btn">
              <i class="fas fa-backward"></i>
            </button>
            <button id="play" class="action-btn action-btn-big">
              <i class="fas fa-play"></i>
            </button>
            <button id="next" class="action-btn">
              <i class="fas fa-forward"></i>
            </button>
          </div>
          <div class="volume-container">
            <input type="range" min="1" max="100" value="5" id="volume" value="0.5">
          </div>
        </div>
      </div>
      <div class="navigation-container">
        <div class="img-container">
          <img src="../uploads-covers/default-cover.jpg" alt="music-cover" id="cover" />
        </div>
      </div>
    </div>
    <audio src="" id="audio"></audio>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="../scripts/player.js"></script>
  </body>
</html>