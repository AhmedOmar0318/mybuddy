<?php
include '../private/conn.php';

$userid = $_SESSION['userid'];
$groupid = $_GET['groupid'];

$sql = "SELECT u.userid,u.email,m.groupid,m.memberid,m.groupid,m.userid
        FROM members m
        LEFT JOIN users u ON m.userid = u.userid        
        WHERE groupid = :groupid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':userid', $userid);
$stmt->bindParam(':groupid', $groupid);

($row = $stmt->fetch(PDO::FETCH_ASSOC));


if (isset($_SESSION['userid'])) {

    ?>

    <div class="container mt-3">
        <h2>Voeg deelnemer toe</h2>
        <form action="php/addmember.php" method="POST">


            <div class="mb-3 mt-3">
                <label>Email:</label>
                <input type="text" class="form-control" placeholder="Email" name="email">
            </div>
            <input type="hidden" name="groupid" value="<?= $groupid ?>">
            <button name="submit" type="submit" class="btn btn-success">Voeg toe</button>
        </form>
    </div>


<?php } else {
    header('location: index.php?page=login');
} ?>