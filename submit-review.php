<?php
$con = mysqli_connect("localhost", "root", "", "hotel") or die(mysqli_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent SQL injection
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $rating = mysqli_real_escape_string($con, $_POST['rating']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);

    // Insert data into the 'reviews' table
    $query = "INSERT INTO reviews (username, rating, comment) VALUES ('$username', '$rating', '$comment')";

    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Review submitted successfully";
        
        // Redirect back to the index page after a short delay (e.g., 2 seconds)
        header("refresh:2;url=index.php");
    } else {
        echo "Error: " . mysqli_error($con);
    }
    
}

mysqli_close($con);
?>
