<?php
include '../private/conn.php';

$paymentid = $_GET['paymentid'];
$groupid = $_GET['groupid'];


$sql = "SELECT * FROM payment WHERE paymentid = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $paymentid);
$stmt->execute();
$row = $stmt->fetch();

//$sql = "SELECT * FROM groups WHERE groupid = :id";
//$stmt2 = $conn->prepare($sql);
//$stmt2->bindParam(':id', $groupid);
//$stmt2->execute();
//$row2 = $stmt2->fetch();

$sql2 = "SELECT u.userid, u.firstname
    FROM members m 
        
    LEFT JOIN users u on m.userid = u.userid
    
    WHERE m.groupid = $groupid";
$result2 = $conn->query($sql2);


if (isset($_SESSION['userid'])) {

    ?>
    <h1 class="h1-book-overview">Betaling bewerken</h1>

    <div class="container">


        <?php if (isset($_SESSION['melding'])) {
            echo '<p>' . $_SESSION['melding'] . '</p>';
            unset($_SESSION['melding']);
        } ?>

        <form action="php/editpayment.php" method="post">

            <label><b>Naam</b></label>
            <input type="text" placeholder="Bedrag" name="amount" value="<?= $row['amount'] ?>" required>


            <br><label><b>Beschrijving</b></label>
            <input type="text" placeholder="Beschrijving" name="description" value="<?= $row['description'] ?>"
                   required>

            <br><label><b>Datum</b></label>
            <input type="date" placeholder="Beschrijving" name="date" value="<?= $row['date'] ?>" required><br>


            <?php while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {


                $sql = "SELECT userid FROM userpayment WHERE paymentid = :id";
                $stmt50 = $conn->prepare($sql);
                $stmt50->bindParam(':id', $paymentid);
                $stmt50->execute();
                ?>


                <input type="checkbox" name="userid[]" value="<?= $row2['userid'] ?>"
                    <?php while ($row50 = $stmt50->fetch(PDO::FETCH_ASSOC)) {

                        echo ($row50['userid'] == $row2['userid']) ? 'checked="checked"' : '';
                    } ?>/>

                <label for="vehicle1"><?= $row2['firstname'] ?></label><br><?php } ?>

            <br><input type="hidden" name="groupid" value="<?= $groupid ?>" required>
            <input type="hidden" name="paymentid" value="<?= $paymentid ?>" required>


            <button id="add-product-button" name="submit" class="button">Opslaan</button>

        </form>

    </div>

<?php } else {
    header('location: index.php?page=login');
} ?>


