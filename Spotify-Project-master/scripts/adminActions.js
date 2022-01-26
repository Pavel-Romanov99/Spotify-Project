function adminDeleteUser(user_id, user_name) 
{
    $.ajax({
        url: "../handlers/adminDeleteUserHandling.php",
        type: 'post',
        data: {
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

function adminDeleteSong(song, cover, user_id, user_name)
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

function showConfirmationBox(user_id)
{
    const confbox_id = 'confbox' + user_id;
    const confirmation_box_container = document.getElementById(confbox_id);

    if (confirmation_box_container.style.display !== "none") 
    {
        confirmation_box_container.style.display = "none";
    } 
    else 
    {
        confirmation_box_container.style.display = "flex";
    }
}

function showSongConfirmationBox(song_id, user_name)
{
    const confbox_id = 'confbox' + song_id + user_name;
    const confirmation_box_container = document.getElementById(confbox_id);

    if (confirmation_box_container.style.display !== "none") 
    {
        confirmation_box_container.style.display = "none";
    } 
    else 
    {
        confirmation_box_container.style.display = "flex";
    }
}