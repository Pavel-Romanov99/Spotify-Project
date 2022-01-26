function deleteFriend(friend_id, user_id)
{
    $.ajax({
        url: "../handlers/deleteFriendHandling.php",
        type: 'post',
        data: {
            friend_id: friend_id,
            user_id: user_id
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