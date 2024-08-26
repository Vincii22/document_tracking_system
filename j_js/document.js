$(document).ready(function () {
    var docOwner;
    loadDistricts();

$("input,select").val("");

//event listener for entry validation
$("body").on( "change keyup", "select,input",function() {
    //condition to check if main inputs are present
    if(($.trim($("#docName").val()) != "") && ($.trim($("#docType").val()) != "") && ($.trim($("#docOwnerType").val()) != "") && ($("#contactNum").val()>9000000000) && ($("#contactNum").val()<9999999999) ){
        //doc owner is district
        if(($("#docOwnerType").val() == 1) && ($("#district").val() != null )){
            $("#addDoc").removeAttr("disabled");
        }
        //doc owner is school
        else if(($("#docOwnerType").val() == 2) && ($("#school").val() != null )){
            $("#addDoc").removeAttr("disabled");
        }
        //doc owner is individual
        else if(($("#docOwnerType").val() == 3) && ($.trim($("#individual").val()) != "" )){
            $("#addDoc").removeAttr("disabled");
        }
        //doc owner is others
        else if(($("#docOwnerType").val() == 4) && ($.trim($("#other").val()) != "" )){
            $("#addDoc").removeAttr("disabled");
        }
        else {
            $("#addDoc").attr("disabled", "disabled");
        }     
    }  
    else
        $("#addDoc").attr("disabled", "disabled");
});

$("body").on( "change", "#docOwnerType",function() {
    //condition to check if main inputs are present
    if($("#docOwnerType").val()==1){
        $("#school,#individual,#other").attr("disabled", "disabled");
        $("#district").removeAttr("disabled");
    }
    else if($("#docOwnerType").val()==2){
        $("#individual,#other").attr("disabled", "disabled");
        $("#district,#school").removeAttr("disabled");
    } 
    else if($("#docOwnerType").val()==3){
        $("#district,#school,#other").attr("disabled", "disabled");
        $("#individual").removeAttr("disabled");
    } 
    else if($("#docOwnerType").val()==4){
        $("#district,#school,#individual").attr("disabled", "disabled");
        $("#other").removeAttr("disabled");
    }
        
});



$("#addDoc").click(function() {
    ownerSelected = $("#docOwnerType").val();
    if(ownerSelected==1){
        docOwner = $("#district option:selected").text();
     } else if(ownerSelected==2){
        docOwner = $("#school option:selected").text();
     } else if(ownerSelected==3){
        docOwner = $("#individual").val();
     } else if(ownerSelected==4){
        docOwner = $("#other").val();
     }
    addDoc(docOwner);
  });

$("body").on( "change", "#district",function() {
    loadSchools();
});

  //event listener when page is loaded
  $(window).focus(function(e) {
    location.reload();
});




});


//user-defined functions

//loads districts option
function loadDistricts(){
    $.get("../j_php/districts_retrieve.php", function(data){
            $("#district").append(data);
            $("#district").val("");
            }
    );
    
}  
//loads schools option
function loadSchools(){
    $.get("../j_php/schools_retrieve.php",{district: $("#district").val() },function(data){
            $("#school").html(data);
            $("#school").val("");
            }
    );
    
}  

//add document 
function addDoc(docowner){
    $.get("../j_php/document_add.php",{
        docname: $("#docName").val(),
        docowner: docowner,
        mobilenum: parseInt($("#contactNum").val()),
        doctype: $("#docType").val()
        }, 
        function(data){
            console.log(data);
            if(data){
                window.location.href = "add_document_success.php?tracking="+data;
            }
            else
                alert('Something went wrong!');
            
        }
    );
   
} 

    






