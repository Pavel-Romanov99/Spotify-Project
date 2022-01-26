function deleteSong(song, cover, user_id, user_name) 
{
    $.ajax({
        url: "../handlers/songDeleteHandling.php",
        type: 'post',
        data: {
            song_id: song,
            cover_id: cover,
            user_id: user_id,
            user_name: user_name
        } ,
        success: function (response) {
            //alert(response);
        },
        error: function(textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });

   $(document).ajaxStop(function(){
        window.location.reload();
    });
}

function submitShareForm(formName, event)
{
  const myForm = document.getElementById(formName);
  myForm.onsubmit = ajaxSubmitShare(event, formName);
}

function ajaxSubmitShare(event, formName)
{
  event.preventDefault();
  const myForm = document.getElementById(formName);
  const msgBox = document.getElementById('msg'+formName);
  msgBox.innerHTML = "Sharing..";
  var dataString = $(myForm).serialize();

  $.ajax({
    url: "../handlers/songShareHandling.php",
    type: 'post',
    data: dataString,
    success: function (response) {
        msgBox.innerHTML = response;
        $('input[type=checkbox]').prop('checked',false);
    },
    error: function(textStatus, errorThrown) {
       console.log(textStatus, errorThrown);
    }
  });
}

function submitAddToPlaylistForm(formName, event)
{
  const myForm = document.getElementById(formName);
  myForm.onsubmit = ajaxSubmitPlaylists(event, formName);
}

function ajaxSubmitPlaylists(event, formName)
{
  event.preventDefault();
  const myForm = document.getElementById(formName);
  const msgBox = document.getElementById('msg'+formName);
  msgBox.innerHTML = "Adding..";
  var dataString = $(myForm).serialize();

  $.ajax({
    url: "../handlers/addToPlaylistHandling.php",
    type: 'post',
    data: dataString,
    success: function (response) {
        msgBox.innerHTML = response;
        $('input[type=checkbox]').prop('checked',false);
    },
    error: function(textStatus, errorThrown) {
       console.log(textStatus, errorThrown);
    }
  });
}

function downloadSong(song_id) 
{
    $.ajax({
        url: "../handlers/songDownloadHandling.php",
        type: 'post',
        data: {
            song_id: song_id
        },
        success: function (response) {
            //alert(response);
        },
        error: function(textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}