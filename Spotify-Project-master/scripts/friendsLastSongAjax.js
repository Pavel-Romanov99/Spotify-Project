function updateLatestFriendsSong(user_id)
{
    loadLatestSongInFriendsHistory(user_id);
    
    window.setInterval(function(){
        loadLatestSongInFriendsHistory(user_id);
      }, 10000); //update every 10 seconds
}

function loadLatestSongInFriendsHistory(user_id)
{
    $.ajax({
        url : '../handlers/getLatestHistoryOfFriendsHandling.php',
        type: 'get',
        data: {
            user_id: user_id
        },
        success : function(response){
            //alert(response);
            if(response)
            {
                for(var i = 0; i < response.length; i++)
                {
                    parsed_response = JSON.parse(response[i]);
                    var text_field = document.getElementById(parsed_response["id"]);

                    if(parsed_response["name"]) // if there is a song in the response then we update (there may not be a song if the user's history is empty)
                    {
                        text_field.innerHTML = parsed_response["author"] + " - " + parsed_response["name"];
                    }
                    else //if the user's history is empty, then the text field will be empty too
                    {
                        text_field.innerHTML = "";
                    }
                }
            }
        },
        error: function(textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
  }