$(document).ready(function () {
    
    var tracking = $("#docTrackHolder").data('tracking');

    $("#printReceipt").click(function(){
        window.open('../pdf/print_dts_tracking.php?trackingnum='+tracking, 'window name', 'window settings');
        return false;
      });

      //event listener when page is loaded
    $(window).focus(function(e) {
        location.reload();
    });
    

});


//user-defined functions

