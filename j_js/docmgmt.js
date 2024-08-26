$(document).ready(function () {
    var dept = $("#usernameHolder").data('dept');
    console.log($("#viewSelect").val());
    
    $("#doc_search").val("#");

    getDocList(1);
   // getDocList(0,1,64);

    $("#tableHolder").on( "click", ".page-item",function() {
        page = $(this).data('value');

       getDocList(page);
      });

    //event listener for view select
    $("body").on( "change", "select",function() {
        getDocList(1);
        console.log($("#viewSelect").val());
      });
    //event listener for search
    $("body").on( "keyup", "#doc_search",function() {
        console.log('shit');
        if($("#doc_search").val().length > 2 || $("#doc_search").val().length == 0){
            getDocList(1);
            console.log('yes');
        }
          
    });
    //event listener for track document button
    $("body").on( "click", ".btn-success",function() {
        var track = $(this).parent().prev().prev().prev().prev().prev().text();
        
       // window.location.href = "../track_doc.php?tracking="+track;
        window.open('../track_doc.php?tracking='+track, 'window name', 'window settings');
        return false;
    });
    
      //event listener when page is loaded
  /*  $(window).focus(function(e) {
        location.reload();
    });*/
    

});

//user-defined functions



function getDocList(page){
    $.get("../../j_php/documents_results_list.php",{
        docstatus: $("#viewSelect").val(),
        page: page,
        search: $("#doc_search").val()
        }, 
         function(data){
            $("#tableHolder").html(data);
            }
        );
    }


