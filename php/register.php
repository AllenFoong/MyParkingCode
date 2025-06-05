<?php
include 'db.php';

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
if (mysqli_query($conn, $query)) {
    echo "Registration successful! <a href='../login.html'>Login here</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
