<?php
include '../private/conn.php';

$paymentid = $_GET['paymentid'];
$groupid = $_GET['groupid'];
$userid = $_SESSION['userid'];


$sql = "SELECT * FROM payment WHERE paymentid = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $paymentid);
$stmt->execute();
$row = $stmt->fetch();


$sql2 = "SELECT u.userid, u.firstname
    FROM members m 
        
    LEFT JOIN users u on m.userid = u.userid
    
    WHERE m.groupid = $groupid";
$result2 = $conn->query($sql2);


$sql3 = "SELECT firstname FROM users where userid = :userid  ";
$stmt3 = $conn->prepare($sql3);
$stmt3->bindParam(':userid', $userid);
$stmt3->execute();
$row3 = $stmt3->fetch();


if (isset($_SESSION['userid'])) {

    ?>


    <h1 class="h1-book-overview">Betaling koppelen van <?= $row3['firstname'] ?> </h1>

    <div class="container">

        <form action="php/linkpayment.php" method="post">

            <label><b>Bedrag</b></label>
            <input type="text" placeholder="Bedrag" name="amount" value="<?= $row['amount'] ?>" required>


            <?php while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) { ?>


                <input type="checkbox" name="userid[]" value="<?= $row2['userid'] ?>">
                <label for="vehicle1" ><?= $row2['firstname'] ?></label><br><?php } ?>

            <input type="hidden" name="paymentid" value="<?= $paymentid ?>">
            <input type="hidden" name="groupid" value="<?= $groupid ?>">
            <input type="hidden" name="amount" value="<?= $row['amount'] ?>">

            <button  name="submit" class="button">Koppel</button>

        </form>


    </div>


<?php } else {

    header('location: index.php?page=login');

}
