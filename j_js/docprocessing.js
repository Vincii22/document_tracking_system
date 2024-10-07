$(document).ready(function () {
    
    $("#doc_search").val("#");
    
    retrieveIncoming();
    retrieveOnQueue();
    retrieveForwarded();
    loadDepts();
    
    $("#incomingButtons button,#onQueueButtons button,#outgoingButtons button").attr("disabled", "disabled");

    //event listener when an incoming document is selected
    $("#incomingList").on("click", "optgroup", function() {
        $("#incomingButtons button").removeAttr("disabled");
        $("#onQueueButtons button, #outgoingButtons button").attr("disabled", "disabled");
        $("#onQueueList,#outgoingList").val("");
    });

    //event listener when an onqueue document is selected
    $("#onQueueList").on("click", "optgroup", function() {
        $("#incomingButtons button,#outgoingButtons button").attr("disabled", "disabled");
        $("#onQueueButtons button").removeAttr("disabled");
        $("#incomingList, #outgoingList").val("");
    });

    //event listener when an outgoing document is selected
    $("#outgoingList").on("click", "optgroup", function() {
        $("#incomingButtons button,#onQueueButtons button").attr("disabled", "disabled");
        $("#outgoingButtons button").removeAttr("disabled");
        $("#onQueueList,#incomingList").val("");
    });

    // Forwarding document event
    $("#mForward").click(function() {
        var dept = $("#forwardDoc option:selected").val();

        if(confirm("Are you sure you want to forward the selected documents?")){
            $("#onQueueList option:selected").each(function(index) {
                var sel = $(this).val();
                docForward(sel, dept); 
            });
        }
    });

    // Cancel forwarding document
    $("#cancelForward").click(function() {
        if(confirm("Are you sure you want to cancel the forwarding of the selected documents?")){
            $("#outgoingList option:selected").each(function(index) {
                var sel = $(this).val();
                docCForward(sel); 
            });
        }
    });

    // Accept document
    $("#acceptIncoming").click(function() {
        if(confirm("Are you sure you want to accept the selected documents?")){
            $("#incomingList option:selected").each(function(index) {
                var sel = $(this).val();
                docAccept(sel); 
            });
        }
    });

    // Mark document as completed
    $("#completed").click(function() {
        if(confirm("Are you sure you want to mark selected documents as completed?")){
            $("#onQueueList option:selected").each(function(index) {
                var sel = $(this).val();
                markCompleted(sel); 
            });
        }
    });

    // Mark document as cancelled
    $("#cancel").click(function() {
        if(confirm("Are you sure you want to mark selected documents as cancelled?")){
            $("#onQueueList option:selected").each(function(index) {
                var sel = $(this).val();
                markCancelled(sel); 
            });
        }
    });

    // Save remarks
    $("#remarksSave").click(function() {
        var remarks = $("#remarksModal textarea").val();
        if(confirm("Are you sure you want to save the following remarks?")){
            $("#incomingList option:selected, #onQueueList option:selected, #outgoingList option:selected").each(function(index) {
                var sel = $(this).val();
                addRemarks(sel, remarks); 
            });
        }
    });

    // Refresh page when focused
    $(window).focus(function(e) {
        location.reload();
    });

    // Search functionality
    $("body").on("keyup", "#doc_search", function() {
        retrieveIncoming();
        retrieveOnQueue();
        retrieveForwarded();
    });

    $(document).ready(function () {
        $("#doc_search").val("#");
        retrieveIncoming();
        retrieveOnQueue();
        retrieveForwarded();
        loadDepts();
        
        $("#incomingButtons button,#onQueueButtons button,#outgoingButtons button").attr("disabled", "disabled");
    
        // Event listener when an incoming document is selected
        $("#incomingList").on("change", "option", function() {
            $("#incomingButtons button").removeAttr("disabled");
            $("#onQueueButtons button, #outgoingButtons button").attr("disabled", "disabled");
            $("#onQueueList,#outgoingList").val("");
        });
    
        // Other event listeners...
    
      
        // Other user-defined functions...
    });
    
});

//user-defined functions

// Retrieve incoming documents
function retrieveIncoming() {
    $.get("../j_php/incomingdocs_retrieve.php", {
        doc_search: $("#doc_search").val()
    }, function(data){
        $("#incomingList optgroup").html(data);
    });
}

// Retrieve on queue documents
function retrieveOnQueue() {
    $.get("../j_php/onqueuedocs_retrieve.php", {
        doc_search: $("#doc_search").val()
    }, function(data){
        $("#onQueueList optgroup").html(data);
    });
}

// Retrieve forwarded documents
function retrieveForwarded() {
    $.get("../j_php/forwardeddocs_retrieve.php", {
        doc_search: $("#doc_search").val()
    }, function(data){
        $("#outgoingList optgroup").html(data);
    });
}

// Load departments to forward option
function loadDepts(){
    $.get("../j_php/departments_retrieve.php", function(data){
        $("#forwardDoc select optgroup").html(data);
    });
}

// Forward document to selected department
function docForward(doc, dept){
    $.get("../j_php/document_forward.php", {
        dept_id: dept,
        doc_id: doc
    }, function(data){
        location.reload();
    });
}

// Accept incoming document
function docAccept(doc){
    $.get("../j_php/document_accept.php", {
        doc_id: doc
    }, function(data){
        console.log(data);
        location.reload();
    });
}

// Cancel forward document
function docCForward(doc){
    $.get("../j_php/document_cforward.php", {
        doc_id: doc
    }, function(data){
        console.log(data);
        location.reload();
    });
}

// Mark document as completed
function markCompleted(doc){
    $.get("../j_php/document_mark_complete.php", {
        doc_id: doc
    }, function(data){
        console.log(data);
        location.reload();
    });
}

// Mark document as cancelled
function markCancelled(doc){
    $.get("../j_php/document_cancel.php", {
        doc_id: doc
    }, function(data){
        console.log(data);
        location.reload();
    });
}

// Add remarks to document
function addRemarks(doc, rem){
    $.post("../j_php/document_add_remarks.php", {
        doc_id: doc,
        remarks: rem
    }, function(data){
        console.log(data);
        location.reload();
    });
}
