<?php
// Interfaces.php

interface QueryHandlerInterface {
    public function getAllQueries();
    public function displayQueries();
}

interface ReplyHandlerInterface {
    public function sendReply($email, $subject, $message);
}
?>
