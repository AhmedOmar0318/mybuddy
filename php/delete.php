<?php
include '../../private/conn.php';

$groupid = $_GET['id'];


$stmt = $conn->prepare("DELETE FROM userpayment WHERE groupid = :id");
$stmt->bindParam(':id', $groupid);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM members WHERE groupid = :id");
$stmt->bindParam(':id', $groupid);
$stmt->execute();




$stmt = $conn->prepare("DELETE FROM payment WHERE groupid = :id");
$stmt->bindParam(':id', $groupid);
$stmt->execute();


$stmt = $conn->prepare("DELETE FROM groups WHERE groupid = :id");
$stmt->bindParam(':id', $groupid);
$stmt->execute();




header('location: ../index.php?page=groups');


?>
