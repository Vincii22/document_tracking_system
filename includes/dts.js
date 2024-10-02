$(document).ready(function () {
    $(document).ready(function() {
        console.log("Document is ready, JavaScript is running.");
    });
    console.log("jQuery is loaded");  // Check if jQuery is loading

    // Hide default error message
    $('#errorContainer').hide();

    // Intercept form submission
    $('#loginForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission
        console.log("Form submission intercepted");  // Log when form is submitted

        // Capture form values
        var email = $('#email').val();
        var password = $('#password').val();
        
        console.log("Email:", email);  // Log to check if email is captured
        console.log("Password:", password);  // Log to check if password is captured

        if (!email || !password) {
            alert("Both fields are required.");
            return;
        }

        // Perform AJAX request for login
        $.ajax({
            url: "../j_php/login.php",  // Ensure this path is correct
            type: "POST",
            data: {
                email: email,
                password: password
            },
            success: function(result) {
                console.log("AJAX Success Response:", result);  // Log the response
                successFn(result); // Call the success function if request succeeds
            },
            error: function(xhr, status, error) {
                console.error("AJAX error: " + status + " - " + error);
                alert("There was an error processing your request.");
            }
        });
    });

    // Hide error message on any keypress in input fields
    $('input').keypress(function() {
        $('#errorContainer').hide();
    });
});

// Callback function to handle the response
function successFn(result) {
    if (result == 1) {
        // Redirect on successful login
        console.log("Login successful, redirecting...");
        window.location.href = "index.php";
    } else if (result == 0) {
        // Show error on failed login
        console.log("Login failed, showing error...");
        $('#errorContainer').show();
    }
}
