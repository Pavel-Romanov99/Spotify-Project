function submitShareForm(formName, event)
{
  const myForm = document.getElementById(formName);
  myForm.onsubmit = ajaxSubmit(event, formName);
}

function ajaxSubmit(event, formName)
{
  event.preventDefault();
  const myForm = document.getElementById(formName);
  const msgBox = document.getElementById('msg'+formName);
  msgBox.innerHTML = "Sharing..";
  var dataString = $(myForm).serialize();

  $.ajax({
    url: "../handlers/songShareHandling.php",
    type: 'post',
    data: dataString,
    success: function (response) {
        msgBox.innerHTML = response;
        $('input[type=checkbox]').prop('checked',false);
    },
    error: function(textStatus, errorThrown) {
       console.log(textStatus, errorThrown);
    }
  });
}