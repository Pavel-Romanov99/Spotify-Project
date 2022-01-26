function playPlaylist(playlist_name)
{
    $.ajax({
        url: "../handlers/getPlaylistSongsHandling.php",
        type: 'get',
        data: {
          playlist_name: playlist_name
        },
        success: function (response) {

            var playlist_song_ids = [];
            var playlist_cover_ids = [];
            var playlist_song_names = [];
            var playlist_song_authors = [];

            for(var i = 0; i < response.length; i++)
            {
                playlist_song_ids.push(JSON.parse(response[i])["song_id"]);
                playlist_cover_ids.push(JSON.parse(response[i])["cover_id"]);
                playlist_song_names.push(JSON.parse(response[i])["name"]);
                playlist_song_authors.push(JSON.parse(response[i])["author"]);
            }

            //updating player variables
            songIds = playlist_song_ids;
            coverIds = playlist_cover_ids;
            songNames = playlist_song_names;
            songAuthors = playlist_song_authors;

            loadSong(songIds[0], songNames[0], songAuthors[0], coverIds[0], true);
        },
        error: function(textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
      });
}

function deletePlaylist(playlist_name)
{
    $.ajax({
        url: "../handlers/deletePlaylistHandling.php",
        type: 'post',
        data: {
            playlist_name: playlist_name
        },
        success: function (response) {
            //alert(response);
            window.location.reload();
        },
        error: function(textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
      });
}

function removeFromPlaylist(song_id, playlist_name)
{
    $.ajax({
        url: "../handlers/removeFromPlaylistHandling.php",
        type: 'post',
        data: {
            song_id: song_id,
            playlist_name: playlist_name
        },
        success: function (response) {
            //alert(response);
            window.location.reload();
        },
        error: function(textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
      });
}

function movePlaylistSong(song_id, playlist_name, song_position, playlist_size, move_up)
{
    if((move_up && song_position == 0) || (!move_up && song_position == playlist_size - 1))
    {
        return; //these moves are illegal
    }
    else
    {
        $.ajax({
            url: "../handlers/moveInPlaylistHandling.php",
            type: 'post',
            data: {
                song_id: song_id,
                playlist_name: playlist_name,
                song_position: song_position,
                move_up: move_up
            },
            success: function (response) {
                //alert(response);
                window.location.reload();
            },
            error: function(textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
          });
    }
}

function showPlaylistContent(playlist_name)
{
    const playlist_content_container = document.getElementById(playlist_name);

    if (playlist_content_container.style.display !== "none") 
    {
        playlist_content_container.style.display = "none";
    } 
    else 
    {
        playlist_content_container.style.display = "flex";
    }
}