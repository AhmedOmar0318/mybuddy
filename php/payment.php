<?php
session_start();
include '../../private/conn.php';

$user = $_SESSION['userid'];

$amount = $_POST['amount'];
$groupid = $_POST['groupid'];
$description = $_POST['description'];
$date = $_POST['date'];
$userid = $_POST['userid'];
$exists = false;


$stmt = $conn->prepare("insert into payment (amount, description,date,groupid,userid)
                                                   values(:amount,:description,:date,:groupid,:userid)");
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':groupid', $groupid);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':userid', $user);
$stmt->execute();

$newpaymentid = $conn->lastInsertId();


foreach ($userid as $value) {


    $sql = "SELECT userid FROM userpayment where paymentid = :paymentid and userid = :userid ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':paymentid', $newpaymentid);
    $stmt->bindParam(':userid', $value);
    $stmt->execute();


    if ($stmt->rowCount() != 0) {
        $exists = true;
        break;
    }
}

if (!$exists) {


    if (!in_array($user, $userid)) {
        foreach ($userid as $value) {
            $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, paymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
            $stmt2->bindParam(':userid', $value);
            $stmt2->bindParam(':paymentid', $newpaymentid);
            $stmt2->bindParam(':debt', $amount);
            $stmt2->bindParam(':groupid', $groupid);

            $stmt2->execute();
            $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
        }


        $sql = "SELECT  COUNT(*) from  userpayment  where paymentid  = $newpaymentid";
        $stmt6 = $conn->prepare($sql);
        $stmt6->execute();
        $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

        $groupdebt = $amount / (int)$row6['COUNT(*)'];


        echo $groupdebt;


        echo $amount;


        $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;


        //$groupdebt1 = round($groupdebt);
        //$ownerdebt1 = round($ownerdebt);


        $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where paymentid = :paymentid");
        $stmt7->bindParam(':paymentid', $newpaymentid);
        $stmt7->execute();


    } else {
        foreach ($userid as $value) {
            $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, paymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
            $stmt2->bindParam(':userid', $value);
            $stmt2->bindParam(':paymentid', $newpaymentid);
            $stmt2->bindParam(':debt', $amount);
            $stmt2->bindParam(':groupid', $groupid);

            $stmt2->execute();
            $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
        }


        $sql = "SELECT  COUNT(*) from  userpayment  where paymentid  = $newpaymentid";
        $stmt6 = $conn->prepare($sql);
        $stmt6->execute();
        $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

        $groupdebt = $amount / (int)$row6['COUNT(*)'];


        $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;





        $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where paymentid = :paymentid ");
        $stmt7->bindParam(':paymentid', $newpaymentid);
        $stmt7->execute();


    }


} else {
    $_SESSION['melding'] = '1 of meer deelnemers al gekoppeld aan deze betaling.';
}


header('location: ../index.php?page=groupview&groupid=' . $groupid);


