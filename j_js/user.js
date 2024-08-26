$(document).ready(function () {
    var selected;
    loadUserData(1);
    loadDepts();

    $("#tableArea").on( "click", ".page-item",function() {
        loadUserData($(this).data('value'));
      });

    $("#tableArea").on( "click", ".btn-primary",function() {
        selected=$(this).parent().parent().data('id');
        loadSelectedUser(selected);
        $("input:password").parent().hide();
        $("#saveUser").removeAttr("disabled");
     });

     // Event Listener for Delete Button
     $("#tableArea").on( "click", ".btn-danger",function() {
        selected=$(this).parent().parent().data('id');
        deleteUser(selected);
     });

     // Event Listener for Reset Password Button
     $("#tableArea").on( "click", ".btn-success",function() {
        selected=$(this).parent().parent().data('id');
        if(confirm("Are you sure you want to reset the password of selected user?")){
            resetPassword(selected);
        }
        
     });
    
    $("body").on( "click", ".btn-success",function() {
        $("input:password").parent().show();
        $("select,input").val("");
     });

    $("#addUser").click(function() {
        selected = 0;
        //$("#saveUser").attr("disabled", "disabled");
    });

    $("#saveUser").click(function() {
        console.log(selected);
        if(selected) {
            updateUser(selected);
            //location.reload();
        } else {
            saveUser();
            //location.reload();
        }
    });

    

});

function loadUserData(pagenum){
    $.get("../../j_php/users_view.php",{
        page: pagenum,
        }, 
        function(data){
            $('#tableArea').html(data); 
        }
    );
}

function loadDepts(){
    $.get("../../j_php/departments_retrieve.php", function(data){
            $("#dept").children().html(data);
            }
        );
    
    } 

function loadSelectedUser(userid){
    $.get("../../j_php/user_view.php",{
        user_id: userid,
        }, 
        function(data){
            var r = JSON.parse(data);
            $("#username").val(r.username);
            $("#firstname").val(r.firstname);
            $("#lastname").val(r.lastname);
            $("#dept").val(r.dept_id);
            $("#usertype").val(r.usertype);
        }
    );
}

function updateUser(userid){
    $.get("../../j_php/user_edit.php",{
        user_id: userid,
        username: $("#username").val(),
        firstname: $("#firstname").val(),
        lastname: $("#lastname").val(),
        dept_id: $("#dept").val(),
        usertype: $("#usertype").val()
        }, 
        function(data){
            if(data==1) {
                alert("User data succesfully updated!")
                location.reload();
            }
            else   
                alert("Something went wrong!");
        }
    );
}

function saveUser(){
    $.post("../../j_php/user_add.php",{
        username: $("#username").val(),
        firstname: $("#firstname").val(),
        lastname: $("#lastname").val(),
        password: $("#password1").val(),
        dept: $("#dept").val(),
        usertype: $("#usertype").val()
        }, 
        function(data){
            if(data==1){
                alert("User data succesfully added!");
                location.reload();
            }
            else {   
                console.log(data);
                alert("Something went wrong!");
            }
        }
    );
}

// function for deleting a user
function deleteUser(userid){
    if (confirm("Are you sure you want to delete this user?")) {
        $.get("../../j_php/user_delete.php",{
            user_id: userid
            }, 
            function(data){
                if(data==1){
                    alert("User succesfully deleted!")
                    location.reload();
                }
                else {   
                    alert("Something went wrong!");
                    location.reload();
                }
            }
        );
    } else {
        //txt = "You pressed Cancel!";
    } 
}


//function for resetting password
function resetPassword(select){
    $.post("../../j_php/user_change_password.php", {
        user_id: select,
        password: "deped4ever"
        },function(data){ 
            if (data==1){
                alert("Password reset successful!");
            }
        });
}




