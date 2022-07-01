<?php include '../private/conn.php';

$userid = $_SESSION['userid'];
$groupid = $_GET['groupid'];


$sql2 = "SELECT u.userid, u.firstname
    FROM members m 
        
    LEFT JOIN users u on m.userid = u.userid
    
    WHERE m.groupid = $groupid";
$result2 = $conn->query($sql2);


if (isset($_SESSION['melding'])) {
    echo '<p>' . $_SESSION['melding'] . '</p>';
    unset($_SESSION['melding']);
}


if (isset($_SESSION['userid'])) {
    ?>

    <div class="container mt-3">
        <h2>Voeg een betaling</h2>
        <form action="php/payment.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label>Bedrag:</label>
                <input type="number" class="form-control" placeholder="Bedrag" name="amount"><br>
            </div>
           <br> <div class="mb-3 mt-3">
                <label>Beschrijving:</label>
                <input type="text" class="form-control" placeholder="Beschrijving" name="description">
            </div>
            <div class="mb-3 mt-3">
                <label>Datum:</label>
                <input type="date" class="form-control" placeholder="Datum" name="date"><br>
            </div>

            <input type="hidden" name="groupid" value="<?= $groupid ?>">




            <?php while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) { ?>


                <input type="checkbox" name="userid[]" value="<?= $row2['userid'] ?>">
                <label for="vehicle1" ><?= $row2['firstname'] ?></label><br><?php } ?>

            <input type="hidden" name="groupid" value="<?= $groupid ?>">



            <button name="submit" type="submit" class="btn btn-success">Voeg toe</button>
        </form>
    </div>
<?php } else {
    header('location: index.php?page=login');
} ?>