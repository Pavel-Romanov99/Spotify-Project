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