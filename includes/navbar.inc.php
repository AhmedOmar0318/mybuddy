<?php
include '../private/conn.php';
if (isset($_SESSION['userid'])) {



    $userid = $_SESSION['userid'];

    $sql = "SELECT g.groupid, m.userid, g.name,g.description, g.date, g.picture 
    FROM groups g
    LEFT JOIN members m on g.groupid = m.groupid
    WHERE m.userid = $userid";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);




    $sql = "SELECT *
    FROM payment
    WHERE groupid = :groupid";
    $stmt6 = $conn->prepare($sql);
    $stmt6->bindParam(':groupid', $row['groupid']);
    $stmt6->execute();
    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

    ?>



    <div class="topnav">
        <a class="active" href="index.php?page=groups">Groepenoverzicht</a>
        <a class="active" href="index.php?page=payments&groupid=<?= $row['groupid'] ?>"> Betalingen bekijken</a>
        <a class="active" href="index.php?page=groupview&groupid=<?= $row['groupid'] ?>"> Groep bekijken</a>
        <a href="php/logout.php">Log uit</a>
    </div>

<?php } ?>

