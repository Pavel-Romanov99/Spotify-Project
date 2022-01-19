function removeFromHistory(date, deleteAllHistory) 
{
    $.ajax({
        url: "../handlers/removeFromHistoryHandling.php",
        type: 'post',
        data: {
            date: date,
            deleteAllHistory: deleteAllHistory
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