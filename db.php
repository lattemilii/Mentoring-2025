<?php
$db = mysqli_connect('localhost', 'root', '', 'panitia_mentoring2025');

if ($db->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
    exit();
}