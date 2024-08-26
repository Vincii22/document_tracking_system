$(document).ready(function () {

//script for user menu option visibility
var utype = $('#usernameHolder').data('utype');

if(utype=='guest'){
    $('.dts_a').remove();
    $('.dts_am').remove();
    $('.dts_uam').remove();
    $('#changePassword').remove();
} else if(utype=='user'){
    $('.dts_a').remove();
    $('.dts_am').remove();
} else if(utype=='mgmt'){
    $('.dts_a').remove();
} 

$("#mPasswordSave").attr("disabled", "disabled");
//$("#editPassword small").text('* must be more than 6 characters.');
//$("#editPassword small").text('* must match.');
//$("#editPassword small").show();
console.log(utype);
  
//event listener for password input changes
$("#editPassword").on( "change keyup", "input",function() {
    //condition to check if main inputs are present

    console.log('shit');
    if($("#mPassword1").val().length < 7){
        $("#editPassword small").text('* must be more than 6 characters.');
        $("#editPassword small").show();
        $("#mPasswordSave").attr("disabled", "disabled");
    }
    else if ($("#mPassword1").val()!=$("#mPassword2").val()){
        $("#editPassword small").text('* must match.');
        $("#editPassword small").show();
        $("#mPasswordSave").attr("disabled", "disabled");
    }
    else {
        $("#editPassword small").hide();
        $("#mPasswordSave").removeAttr("disabled");

        console.log();
    }
});

//event listener for saving the new user-entered password
$("#mPasswordSave").click(function() {
    changePassword();
  });


});

//user-defined functions

//function for changing password
function changePassword(){
    var path = window.location.protocol +"//"+window.location.hostname+"/sl-dts/j_php/user_change_password.php";
    var path2 = window.location.protocol +"//"+window.location.hostname+"/sl-dts/public/logout.php";
    console.log(path);
    $.post(path, {
        user_id: $('#usernameHolder').data('id'),
        password: $("#mPassword1").val()
        },function(data){ 
            if (data==1){
                alert("Password successfully changed!");
                window.location.href = path2;
            }
        });
}

