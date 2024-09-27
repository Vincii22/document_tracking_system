<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Access Denied - Unauthorized</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/unauthorized.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .unauthorized-card {
            background-color: #fff;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            border-radius: 10px;
        }
        .unauthorized-card h1 {
            font-size: 72px;
            color: #dc3545;
        }
        .unauthorized-card h4 {
            font-size: 24px;
            color: #6c757d;
        }
        .unauthorized-card p {
            color: #6c757d;
        }
        .btn-home {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 30px;
            transition: background-color 0.3s;
        }
        .btn-home:hover {
            background-color: #0056b3;
        }
        .fa-exclamation-circle {
            font-size: 100px;
            color: #dc3545;
        }
    </style>
</head>
<body>

    <div class="unauthorized-card">
        <i class="fa fa-exclamation-circle"></i>
        <h1>403</h1>
        <h4>Access Denied</h4>
        <p>Sorry, you do not have permission to access this page.</p>
        <a href="../public/dashboard.php" class="btn btn-home">Go back to Dashboard</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
