
$(document).ready(function () {

//script for user menu option visibility
    
    //hide default error message
    //$('#errorContainer').hide();
  
    $('#loginForm').submit(function(event) {
        event.preventDefault();
    $.post("../j_php/login.php",{
        username: $('#username').val(),
        password: $('#password').val(),
        },
        successFn,
        "text");
    });

    $( 'input' ).keypress(function() {
        $('#errorContainer').hide();
    });

});


function successFn(result){
 
    if(result==1){
        window.location.href = "index.php";
        console.log('Yes'); 
        }
    else if(result==0){
        $('#errorContainer').show();
        console.log('No');
     //    console.log(msg);
    //    $("#loginNotify").html(msg);
         
         
    }
}  

      