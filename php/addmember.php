<?php
session_start();
include '../../private/conn.php';

$email = $_POST['email'];
$groupid = $_POST['groupid'];


$sql = 'SELECT userid FROM users where email = :email ';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() > 0) {

    $sql2 = 'SELECT userid FROM members where userid = :userid and groupid = :groupid ';
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(':userid', $row['userid']);
    $stmt2->bindParam(':groupid', $groupid);

    $stmt2->execute();
    if ($stmt2->rowCount() == 0) {
        $stmt3 = $conn->prepare("INSERT INTO members (userid, groupid)
                    VALUES(:userid, :groupid)");
        $stmt3->bindParam(':userid', $row['userid']);
        $stmt3->bindParam(':groupid', $groupid);
        $stmt3->execute();

        $_SESSION['melding'] = 'Gebruiker is toegevoegd aan de groep.';
    } else {
        $_SESSION['melding'] = 'Gebruiker is al een deelnemer.';
    }
} else {
    $_SESSION['melding'] = 'Email bestaat niet.';
}


header('location: ../index.php?page=groupview&groupid=' . $groupid);


