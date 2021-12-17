var redirect_uri = "http://localhost/Spotify%20Clone/home.php"; // change this your value

var client_id = ""; 
var client_secret = ""; // In a real app you should not expose your client_secret to the user

var access_token = null;
var refresh_token = null;

const AUTHORIZE = "https://accounts.spotify.com/authorize"
const TOKEN = "https://accounts.spotify.com/api/token";
const PLAYLISTS = "https://api.spotify.com/v1/me/playlists";


function onPageLoad(){
    client_id = localStorage.getItem("client_id");
    client_secret = localStorage.getItem("client_secret");
    if ( window.location.search.length > 0 ){
        handleRedirect();
    }
    else{
        access_token = localStorage.getItem("access_token");
        if ( access_token == null ){
            // we don't have an access token so present token section
            document.getElementById("tokenSection").style.display = 'block';  
        }
        else {
            // we have an access token so present device section
            refreshPlaylists();
        }
    }
}

///////////////////////////////////
function handleRedirect(){
    let code = getCode();
    fetchAccessToken( code );
    window.history.pushState("", "", redirect_uri); // remove param from url
}
///////////////////////////////////


///////////////////////////////////
function getCode(){
    let code = null;
    const queryString = window.location.search;
    if ( queryString.length > 0 ){
        const urlParams = new URLSearchParams(queryString);
        code = urlParams.get('code')
    }
    return code;
}
///////////////////////////////////

//////////////////////////////////
function requestAuthorization(){ 
    client_id = document.getElementById("clientId").value;
    client_secret = document.getElementById("clientSecret").value;
    localStorage.setItem("client_id", client_id);
    localStorage.setItem("client_secret", client_secret); // In a real app you should not expose your client_secret to the user

    let url = AUTHORIZE;
    url += "?client_id=" + client_id;
    url += "&response_type=code";
    url += "&redirect_uri=" + encodeURI(redirect_uri);
    url += "&show_dialog=true";
    url += "&scope=user-read-private user-read-email user-modify-playback-state user-read-playback-position user-library-read streaming user-read-playback-state user-read-recently-played playlist-read-private";
    window.location.href = url; // Show Spotify's authorization screen
}
///////////////////////////////////


///////////////////////////////////
function fetchAccessToken( code ){
    let body = "grant_type=authorization_code";
    body += "&code=" + code; 
    body += "&redirect_uri=" + encodeURI(redirect_uri);
    body += "&client_id=" + client_id;
    body += "&client_secret=" + client_secret;
    callAuthorizationApi(body);
}
///////////////////////////////////

///////////////////////////////////
function refreshAccessToken(){
    refresh_token = localStorage.getItem("refresh_token");
    let body = "grant_type=refresh_token";
    body += "&refresh_token=" + refresh_token;
    body += "&client_id=" + client_id;
    callAuthorizationApi(body);
}
///////////////////////////////////

///////////////////////////////////
function callAuthorizationApi(body){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", TOKEN, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('Authorization', 'Basic ' + btoa(client_id + ":" + client_secret));
    xhr.send(body);
    xhr.onload = handleAuthorizationResponse;
}
///////////////////////////////////

///////////////////////////////////
function handleAuthorizationResponse(){
    if ( this.status == 200 ){
        var data = JSON.parse(this.responseText);
        console.log(data);
        var data = JSON.parse(this.responseText);
        if ( data.access_token != undefined ){
            access_token = data.access_token;
            localStorage.setItem("access_token", access_token);
        }
        if ( data.refresh_token  != undefined ){
            refresh_token = data.refresh_token;
            localStorage.setItem("refresh_token", refresh_token);
        }
        onPageLoad();
    }
    else {
        console.log(this.responseText);
        alert(this.responseText);
    }
}
///////////////////////////////////

///////////////////////////////////
function callApi(method, url, body, callback){
    let xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Authorization', 'Bearer ' + access_token);
    xhr.send(body);
    xhr.onload = callback;
}
///////////////////////////////////

function refreshPlaylists(){
    callApi( "GET", PLAYLISTS, null, handlePlaylistsResponse );
}

function handlePlaylistsResponse(){
    if ( this.status == 200 ){
        var data = JSON.parse(this.responseText);

        console.log(data);
        //all the tracks from the request
        const items = data.tracks.items;

        const artist_id = items[0].artists[0].id;
        console.log("Id of the artist is: " + artist_id);
        
        //for each item in the tracks array
        items.forEach(item => {

            //we create an li holding the track name and image url
            const track = document.createElement('li');
            track.innerHTML = item.name;

            //we take the url of the image of the track
            const url = item.album.images[0].url;
            const img = document.createElement('img');
            img.src = url;

            //we append the name of the track and the image
            tracks.appendChild(track);
            tracks.appendChild(img);
        });
    }
    else if ( this.status == 401 ){
        refreshAccessToken()
    }
    else {
        console.log(this.responseText);
        alert(this.responseText);
    }
}

function removeChildren(){
    while(tracks.firstChild){
        tracks.removeChild(tracks.lastChild);
    }
}

const button = document.querySelector("#search_artist");
const tracks = document.querySelector('#tracks');


button.addEventListener('click', (e) => {
    e.preventDefault();
    removeChildren();
    const fieldValue = document.querySelector('#artist_field').value;
    callApi( "GET", `https://api.spotify.com/v1/search?q=name:${fieldValue}&type=artist,track`, null, handlePlaylistsResponse );
})

