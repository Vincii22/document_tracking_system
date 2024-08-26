$(document).ready(function () {
   var tracking = $('#search').data('tracking');

   //condition if no tracking number has been provided
   if(tracking != ""){
     getDocHist(tracking);
   }  
        
        

   
});

//user-defined functions



function getDocHist(doc){
    $.get("../j_php/document_get_dochist.php",{
        tracking: doc,
        }, 
         function(data){
            $("#resultsTable").html(data);
            }
        );
    }
