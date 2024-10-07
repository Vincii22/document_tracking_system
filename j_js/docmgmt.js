$(document).ready(function () {
    var dept = $("#usernameHolder").data('dept');
    console.log($("#viewSelect").val());
    
    $("#doc_search").val("#");

    getDocList(1);

    $("#tableHolder").on("click", ".page-item", function() {
        var page = $(this).data('value');
        getDocList(page);
    });

    // Event listener for view select
    $("body").on("change", "select", function() {
        getDocList(1);
        console.log($("#viewSelect").val());
    });

    // Event listener for search
    $("body").on("keyup", "#doc_search", function() {
        console.log('shit');
        if ($("#doc_search").val().length > 2 || $("#doc_search").val().length == 0) {
            getDocList(1);
            console.log('yes');
        }
    });

    // Event listener for track document button
    $("body").on("click", ".btn-success", function() {
        var track = $(this).parent().prev().prev().prev().prev().prev().text();
        window.open('../track_doc.php?tracking=' + track, 'window name', 'window settings');
        return false;
    });
    


    // Event listener when page is loaded
    /* $(window).focus(function(e) {
        location.reload();
    }); */
});

// User-defined functions
function getDocList(page) {
    $.get("../../j_php/documents_results_list.php", {
        docstatus: $("#viewSelect").val(),
        page: page,
        search: $("#doc_search").val()
    }, 
    function(data) {
        $("#tableHolder").html(data);
    });
}
