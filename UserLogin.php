<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            max-width: 800px;
            width: 100%;
        }
        .login-image {
            width: 50%;
            height: 100%;
            background: url('images/LOG.jpeg') no-repeat center center;
            background-size: cover;
        }
        .login-form {
            width: 50%;
            padding: 30px;
        }
        .login-form h2 {
            margin-bottom: 30px;
            color: #343a40;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container text-center mb-5">
        <h1 class="mt-5">Welcome to Ocean Palace</h1>
    </div>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form">
            <h2>User Login</h2>
            <form action="login_action.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <div class="form-group text-center">
                    <p>Don't have an account? <a href="signup.php">Sign up Now!</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
