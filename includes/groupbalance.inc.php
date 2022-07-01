<?php

include '../private/conn.php';

$paymentid = $_GET['paymentid'];
$userid = $_SESSION['userid'];


$sql = "SELECT  up.paymentid,up.debt,up.userid,p.date,p.description 
        FROM userpayment up        
        LEFT JOIN payment p on up.paymentid = p.paymentid        
        WHERE up.paymentid = :paymentid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':paymentid', $paymentid);
$stmt->execute();


$sql = "SELECT  firstname
        FROM users
        WHERE userid = :userid";
$stmt3 = $conn->prepare($sql);
$stmt3->bindParam(':userid', $userid);
$stmt3->execute();
$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);






if (isset($_SESSION['userid'])) { ?>

    <div class="">
        <?php if ($stmt3->rowCount() > 0) { ?>
            <h1 class="h1-book-overview">Betaling van <?= $row3['firstname'] ?> </h1>
        <?php } ?>

        <li class="table-row">
            <div class="col col-1">Balans</div>
            <div class="col col-1">Schuld</div>
        </li>
    </div>

    <?php if ($stmt->rowCount() > 0) {

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $sql = "SELECT firstname 
                    FROM users 
                    WHERE userid = :user_ID";
            $stmt2 = $conn->prepare($sql);
            $stmt2->bindParam(':user_ID', $row['userid']);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC); ?>


            <li class="table-header">
                <div class="col col-1" data-label="Job Id"><?= $row2['firstname'] ?></div>
                <div class="col col-1" data-label="Job Id"><?= $row["debt"] ?></div>
            </li>

            <?php

        }
    }
}






