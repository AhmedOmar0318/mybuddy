<?php
include '../../private/conn.php';
session_start();


$memberid = $_GET['memberid'];
$groupid = $_GET['groupid'];
$userid = $_GET['userid'];



$sql = "SELECT userid FROM userpayment where  userid = :userid ";
$stmt2 = $conn->prepare($sql);
$stmt2->bindParam(':userid', $userid);
$stmt2->execute();


if ($stmt2->rowCount() == 0) {

//FIXEN
    $stmt = $conn->prepare("DELETE FROM members WHERE memberid = :id");
    $stmt->bindParam(':id', $memberid);
    $stmt->execute();
}else{
    $_SESSION['melding'] = 'Deelnemer kan niet verwijderd worden. Er staan betaling(en) open.';

}


header('location: ../index.php?page=groupview&groupid=' . $groupid);