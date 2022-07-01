<?php
include '../../private/conn.php';

$paymentid = $_GET['paymentid'];
$groupid = $_GET['groupid'];

//FIXEN
$stmt = $conn->prepare("DELETE FROM userpayment WHERE paymentid = :id");
$stmt->bindParam(':id', $paymentid);
$stmt->execute();


$stmt = $conn->prepare("DELETE FROM payment WHERE paymentid = :id");
$stmt->bindParam(':id', $paymentid);
$stmt->execute();

header('location: ../index.php?page=payments&groupid=' . $groupid);
