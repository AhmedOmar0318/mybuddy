<?php
session_start();
include '../../private/conn.php';

$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['psw'];
$passwordrepeat = $_POST['pswrepeat'];
$role = 'user';

if ($password == $passwordrepeat) {


    $stmt = $conn->prepare("insert into users (firstname, middlename,lastname,email,password, role)
                                                   values(:firstname, :middlename, :lastname,:email,:password,:role)");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':middlename', $middlename);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->execute();


    $_SESSION['userid'] = $conn->lastInsertId();

    header('location: ../index.php?page=groups');
} else {

    $_SESSION['melding2'] = 'Wachtwoorden komen niet overeen, probeer het opnieuw.';
    header('location: ../index.php?page=register');
}


?>
