<?php
// Handlers.php

include('Interfaces.php'); // Include the interfaces

class QueryHandler implements QueryHandlerInterface {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection;
    }

    public function getAllQueries() {
        $sql = "SELECT * FROM `contact`";
        return mysqli_query($this->con, $sql);
    }

    public function displayQueries() {
        $result = $this->getAllQueries();
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>
                    <td>{$row['fullname']}</td>
                    <td>{$row['phoneno']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['message']}</td>
                    <td>{$row['cdate']}</td>
                    <td>{$row['approval']}</td>
                    <td><a href='newsletterdel.php?eid={$row['id']}'><button class='btn btn-danger'>Delete</button></a></td>
                  </tr>";
        }
    }
}

class ReplyHandler implements ReplyHandlerInterface {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection;
    }

    public function sendReply($email, $subject, $message) {
        $stmt = $this->con->prepare("INSERT INTO `newsletterlog`(`email`, `subject`, `news`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $subject, $message);
        
        if ($stmt->execute()) {
            echo '<script>alert("Reply Added")</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
