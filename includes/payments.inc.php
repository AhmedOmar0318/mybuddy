<?php
include '../private/conn.php';

$id = $_GET['groupid'];
$userid = $_SESSION['userid'];


$sql = "SELECT *
        FROM payment
        WHERE groupid = :group_ID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':group_ID', $id);
$stmt->execute();


$sql2 = "SELECT *
        FROM groups
        WHERE groupid = :group_ID";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':group_ID', $id);
$stmt2->execute();
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);





//$row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
if (isset($_SESSION['userid'])) {

    if (isset($_SESSION['melding'])) {
        echo '<p>' . $_SESSION['melding'] . '</p>';
        unset($_SESSION['melding']);
    } ?>
    <button onclick="history.back()">Ga terug</button>
    <div class="col col-1" data-label="Job Id">
        <td>
            <button onclick="window.location.href='index.php?page=addpayment&groupid=<?= $row2["groupid"] ?>'">Betaling
                toevoegen
            </button>
        </td>
    </div>


    <div class="">
        <li class="table-row">
            <div class="col col-1">Bedrag</div>
            <div class="col col-1">Beschrijving</div>
            <div class="col col-1">Datum</div>
            <div class="col col-1">Betaling van</div>
            <div class="col col-1">Betaling zien</div>
            <div class="col col-1">Betaling verwijderen</div>
            <div class="col col-1">Betaling bewerken</div>
        </li>
    </div>


    <?php if ($stmt->rowCount() > 0) { ?><?php

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sql = "SELECT firstname
                        FROM users
                        WHERE userid = :user_ID";
            $stmt3 = $conn->prepare($sql);
            $stmt3->bindParam(':user_ID', $row['userid']);
            $stmt3->execute();
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

            ?>

            <li class="table-header">
            <div class="col col-1" data-label="Job Id"><?= $row["amount"] ?>$</div>
            <div class="col col-1" data-label="Job Id"><?= $row["description"] ?></div>
            <div class="col col-1" data-label="Job Id"><?= $row["date"] ?></div>
            <div class="col col-1" data-label="Job Id"><?= $row3["firstname"] ?></div>
            <div class="col col-1" data-label="Job Id">
                <td>
                    <button onclick="window.location.href='index.php?page=groupbalance&paymentid=<?= $row["paymentid"] ?>&groupid=<?= $row["groupid"] ?>'">
                        Betaling zien
                    </button>
                </td>
            </div>




            <?php if ($row['userid'] == $userid) { ?>


                <div class="col col-1" data-label="Job Id">
                    <button class="btn-admin-delete"
                            onclick=" if(confirm('Weet u zeker dat u deze betaling wilt verwijderen?'))window.location.href='php/deletepayment.php?paymentid=<?= $row["paymentid"] ?>&groupid=<?= $row2["groupid"] ?>'">
                        Verwijderen
                    </button>
                </div>
                <div class="col col-1" data-label="Job Id">
                    <td>
                        <button onclick="window.location.href='index.php?page=editpayment&paymentid=<?= $row["paymentid"] ?>&groupid=<?= $row2["groupid"] ?>'">
                            Betaling bewerken
                        </button>
                    </td>
                </div>


                </li>
            <?php } else { ?>

                <div class="col col-1" data-label="Job Id"></div>
                <div class="col col-1" data-label="Job Id"></div>
                <div class="col col-1" data-label="Job Id"></div>

            <?php }
        }
    }
}else {


    header('location: index.php?page=login');

} ?>



