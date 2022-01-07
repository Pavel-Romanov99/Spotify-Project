var form =  document.getElementById('song-upload-form');
var messageBox = document.getElementById('upload-messages');
var coverButton = document.getElementById('cover-button-hidden');
var mp3Button = document.getElementById('mp3-button-hidden');

form.addEventListener('submit', handleForm);

function handleForm(event) {

    event.preventDefault();

    messageBox.innerHTML = 'Uploading...';

    var authorName = form.elements[0].value;
    var songName = form.elements[1].value;
    var selectedCover = coverButton.value;
    var selectedMp3 = mp3Button.value;

    // Check if all the required fields are filled in
    if(!authorName || !songName || !selectedMp3){
        messageBox.innerHTML = 'Please fill in all the required fields!';
        return;
    }

    // Check the selected cover image file type if such exists
    if(selectedCover){
        if(selectedCover.indexOf(".png") != selectedCover.length - 4 &&
        selectedCover.indexOf(".jpg") != selectedCover.length - 4 &&
        selectedCover.indexOf(".jpeg") != selectedCover.length - 5) {
            messageBox.innerHTML = 'The selected cover image is not a .png, .jpg or .jpeg!';
            return;
        }
    }
    // Check the selected mp3 file type
    if(selectedMp3.indexOf(".mp3") != selectedMp3.length - 4) {
        messageBox.innerHTML = 'The selected song is not a .mp3!';
        return;
    }
    form.submit();
}