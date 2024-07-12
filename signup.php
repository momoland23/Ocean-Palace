<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container-custom {
            margin-top: 50px;
        }
        .image-stack img {
            width: 100%;
            margin-bottom: 10px;
        }
        .form-container {
            border-left: 1px solid #ddd;
            padding-left: 20px;
        }
        .form-heading {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container container-custom">
        <div class="row justify-content-center">
            <div class="col-md-5 image-stack">
            <img src="images/Sign1.jpg" alt="Image 1">
            <img src="images/Sign2.jpg" alt="Image 2">
            <img src="images/Sign0.jpg" alt="Image 3">
            </div>
            <div class="col-md-5 form-container">
                <h2 class="form-heading">Sign Up</h2>
                <form action="signup_action.php" method="POST">
                    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact:</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                    <div class="form-group text-center">
                        <p>Already have an account? <a href="UserLogin.php">Login Here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
