<?php

// test_login.php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'persil_guest');
if ($mysqli->connect_error) {
    exit('Connection failed: '.$mysqli->connect_error);
}
$result = $mysqli->query('SELECT id, email, role FROM users ORDER BY id');
echo "Users in database:\n";
while ($row = $result->fetch_assoc()) {
    echo $row['id'].' | '.$row['email'].' | '.$row['role']."\n";
}
$mysqli->close();
