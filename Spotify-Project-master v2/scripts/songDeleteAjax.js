function deleteSong(song, cover) 
{
    $.ajax({
        url: "../handlers/songDeleteHandling.php",
        type: 'post',
        data: {
            song_id: song,
            cover_id: cover
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