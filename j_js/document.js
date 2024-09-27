$(document).ready(function () {
    // Handle form submission
    $("#documentForm").on("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object from the form
        var formData = new FormData(this); // 'this' refers to the form element

        // Use jQuery AJAX to submit the form
        $.ajax({
            url: '../j_php/document_add.php',
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set content type
            success: function (response) {
                console.log('Response:', response);
                if (response) {
                    // Assuming the server returns some tracking number or success message
                    window.location.href = "add_document_success.php?tracking=" + response;
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function () {
                console.error('Error uploading the file');
                alert('An error occurred during submission.');
            }
        });
    });

    // ... Your other menu visibility code remains unchanged
});
