<?php
session_start();

include '../../private/conn.php';

$email = $_POST['email'];
$password = $_POST['psw'];

$sql = "SELECT userid FROM users WHERE email= :email AND password = :password";

$query = $conn->prepare($sql);
$query->bindParam(':email', $email);
$query->bindParam(':password', $password);
$query->execute();


if ($query->rowCount() == 1) {
    $result = $query->fetch(PDO::FETCH_ASSOC);


    $_SESSION['userid'] = $result['userid'];


    header('location: ../index.php?page=groups');


} else {

    $_SESSION['melding'] = 'Combination email and password are incorrect.Try again.';
    //unset( $_SESSION['melding']);
    header('location: ../index.php?page=login');
}


?>