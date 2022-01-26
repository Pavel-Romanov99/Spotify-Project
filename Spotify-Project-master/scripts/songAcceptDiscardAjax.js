function acceptDiscardSong(song, will_accept)
{
    $.ajax({
        url: "../handlers/songAcceptDiscardHandling.php",
        type: 'post',
        data: {
            song_id: song,
            accept_song: will_accept
        },
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