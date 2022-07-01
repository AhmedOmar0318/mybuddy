<?php
include '../../private/conn.php';
session_start();

$user = $_SESSION['userid'];

$userid = $_POST['userid'];
$amount = $_POST['amount'];
$description = $_POST['description'];
$date = $_POST['date'];
$paymentid = $_POST['paymentid'];
$groupid = $_POST['groupid'];

$exists = false;
$check = true;

//echo '<pre>', print_r($userid['userid'] ), '</pre>';

//echo $paymentid;

//echo $groupid;

//echo $check;


$stmt = $conn->prepare("UPDATE payment SET amount = :amount, description = :description, date = :date WHERE paymentid = :paymentid");
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':paymentid', $paymentid);
$stmt->execute();
//echo '<pre>', print_r($_POST['userid']), '</pre>';


if(isset($_POST['userid'])){


    foreach ($userid as $value) {


        $sql = "SELECT userid FROM userpayment where paymentid = :paymentid and userid = :userid ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':paymentid', $paymentid);
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
                $stmt2->bindParam(':paymentid', $paymentid);
                $stmt2->bindParam(':debt', $amount);
                $stmt2->bindParam(':groupid', $groupid);

                $stmt2->execute();
                $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
            }




            $sql = "SELECT  COUNT(*) from  userpayment  where paymentid  = $paymentid";
            $stmt6 = $conn->prepare($sql);
            $stmt6->execute();
            $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

            $groupdebt = $amount / (int)$row6['COUNT(*)'];
            $ownerdebt = $groupdebt * (int)$row6['COUNT(*)'];


            echo $groupdebt;



            echo $amount;


            $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;


            //$groupdebt1 = round($groupdebt);
            //$ownerdebt1 = round($ownerdebt);


            $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where paymentid = :paymentid");
            $stmt7->bindParam(':paymentid', $paymentid);
            $stmt7->execute();



        } else {
            foreach ($userid as $value) {
                $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, paymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
                $stmt2->bindParam(':userid', $value);
                $stmt2->bindParam(':paymentid', $paymentid);
                $stmt2->bindParam(':debt', $amount);
                $stmt2->bindParam(':groupid', $groupid);

                $stmt2->execute();
                $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
            }




            $sql = "SELECT  COUNT(*) from  userpayment  where paymentid  = $paymentid";
            $stmt5 = $conn->prepare($sql);
            $stmt5->execute();
            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT  COUNT(*) from  userpayment  where paymentid  = $paymentid";
            $stmt6 = $conn->prepare($sql);
            $stmt6->execute();
            $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

            $groupdebt = $amount / (int)$row6['COUNT(*)'];


            $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;


            //$groupdebt1 = round($groupdebt);
            //$ownerdebt1 = round($ownerdebt);


            $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where paymentid = :paymentid");
            $stmt7->bindParam(':paymentid', $paymentid);
            $stmt7->execute();



        }


    } else {

        $stmt = $conn->prepare("DELETE FROM userpayment WHERE paymentid = :id");
        $stmt->bindParam(':id', $paymentid);
        $stmt->execute();


        if (!in_array($user, $userid)) {
            foreach ($userid as $value) {
                $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, paymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
                $stmt2->bindParam(':userid', $value);
                $stmt2->bindParam(':paymentid', $paymentid);
                $stmt2->bindParam(':debt', $amount);
                $stmt2->bindParam(':groupid', $groupid);

                $stmt2->execute();
                $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
            }




            $sql = "SELECT  COUNT(*) from  userpayment  where paymentid  = $paymentid";
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
            $stmt7->bindParam(':paymentid', $paymentid);
            $stmt7->execute();


        } else {
            foreach ($userid as $value) {
                $stmt2 = $conn->prepare("INSERT INTO userpayment (userid, paymentid,debt,groupid)
                    VALUES(:userid, :paymentid,:debt,:groupid)");
                $stmt2->bindParam(':userid', $value);
                $stmt2->bindParam(':paymentid', $paymentid);
                $stmt2->bindParam(':debt', $amount);
                $stmt2->bindParam(':groupid', $groupid);

                $stmt2->execute();
                $_SESSION['melding'] = 'Deelnemer(s) gekoppeld aan betaling.';
            }





            $sql = "SELECT  COUNT(*) from  userpayment  where paymentid  = $paymentid";
            $stmt6 = $conn->prepare($sql);
            $stmt6->execute();
            $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

            $groupdebt = $amount / (int)$row6['COUNT(*)'];


            $groupdebt1 = (round($groupdebt / 0.05, 0)) * 0.05;


            //$groupdebt1 = round($groupdebt);
            //$ownerdebt1 = round($ownerdebt);


            $stmt7 = $conn->prepare("UPDATE userpayment SET debt = - $groupdebt1  where paymentid = :paymentid");
            $stmt7->bindParam(':paymentid', $paymentid);
            $stmt7->execute();



    }

}}else{
    $_SESSION['melding'] = 'Minimaal 1 persoon selecteren.';
    header('location: ../index.php?page=editpayment&paymentid=' . $paymentid . '&groupid=' . $groupid);
$check = false;
}

if ($check){
    header('location: ../index.php?page=payments&paymentid=&groupid=' . $groupid);

}
?>
