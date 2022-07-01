<?php
include '../private/conn.php';

$id = $_GET['groupid'];
$userid = $_SESSION['userid'];


$sql = "SELECT * FROM groups where groupid = $id";
$result = $conn->query($sql);

$sql = "SELECT * FROM groups where groupid = $id";
$result12 = $conn->query($sql);


$sql = "SELECT u.userid, u.firstname, u.lastname,u.middlename,m.memberid
    FROM members m 
    RIGHT JOIN users u on m.userid = u.userid
    WHERE groupid = $id";
$result2 = $conn->query($sql);


$sql = "SELECT * FROM payment where groupid =$id";
$result3 = $conn->query($sql);
$row3 = $result3->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM payment";
$stmt4 = $conn->prepare($sql);
$stmt4->execute();
$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT u.userid, sum(debt) AS sum FROM users u RIGHT JOIN members m on m.userid = u.userid left JOIN userpayment p on p.userid = u.userid where  m.groupid = :groupid GROUP BY userid";
$stmt10 = $conn->prepare($sql);
$stmt10->bindParam(':groupid', $id);
$stmt10->execute();


if (isset($_SESSION['userid'])) {


    if (isset($_SESSION['melding'])) {
        echo '<p>' . $_SESSION['melding'] . '</p>';
        unset($_SESSION['melding']);
    }
    if (isset($_SESSION['melding10'])) {
        echo '<p>' . $_SESSION['melding10'] . '</p>';
        unset($_SESSION['melding10']);
    } ?>

    <li class="table-header">
        <div class="col col-1">Afbeelding</div>
        <div class="col col-1">Naam</div>
        <div class="col col-1">Datum</div>
        <div class="col col-1">Beschrijving</div>
        <div class="col col-1">Betaling toevoegen</div>
    </li>


    <?php
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>

            <li class="table-row">
                <div class="col col-1" data-label="Job Id"><img class="picture" src=" <?= $row["picture"] ?>"></div>
                <div class="col col-1" data-label="Job Id"><?= $row["name"] ?></div>
                <div class="col col-1" data-label="Job Id"><?= $row["date"] ?></div>
                <div class="col col-1" data-label="Job Id"><?= $row["description"] ?></div>
                <div class="col col-1" data-label="Job Id">
                    <td>
                        <button onclick="window.location.href='index.php?page=payments&groupid=<?= $row["groupid"] ?>'">
                            Ga naar betalingen
                        </button>
                    </td>
                </div>


            </li>

            <?php $sql2 = "SELECT createdby FROM groups where  groupid = :groupid";
            $stmt8 = $conn->prepare($sql2);
            $stmt8->bindParam(':groupid', $row['groupid']);
            $stmt8->execute();
            $row8 = $stmt8->fetch(PDO::FETCH_ASSOC);

            if ($row8['createdby'] == $userid) {
                ?>

                <li class="table-row">
                    <div class="col col-1" data-label="Job Id">
                        <td>
                            <button onclick="window.location.href='index.php?page=addmember&groupid=<?= $row["groupid"] ?>'">
                                Voeg deelnemer
                            </button>
                        </td>
                    </div>
                </li>

            <?php } ?>
            <br>
            <li class="table-header">
                <div class="col col-1">Groepsbalans:</div>

            </li>


            <?php while ($row10 = $stmt10->fetchAll(PDO::FETCH_ASSOC)) {


                $sql = "SELECT u.userid, sum(amount) AS sum FROM users u RIGHT JOIN members m on m.userid = u.userid left JOIN payment p on p.userid = u.userid where  m.groupid=:groupid GROUP BY userid";
                $stmt15 = $conn->prepare($sql);
                $stmt15->bindParam(':groupid', $id);
                $stmt15->execute();
                $row15 = $stmt15->fetchAll(PDO::FETCH_ASSOC);


                $array = array_merge($row15, $row10);
                // echo '<pre>', print_r($array), '</pre>';


                $result5 = array();
                //$result5 = $array;


                foreach ($array as $k => $v) {
                    $id = $v['userid'];
                    $result5[$id][] = $v['sum'];
                }

                $new = array();
                //$new = $array;


                //echo '<pre>', print_r($result5), '</pre>';


                foreach ($result5 as $key => $value) {
                    $new[] = array('userid' => $key, 'sum' => array_sum($value));


                }


                $i = 0;
                foreach ($new as $rowtest) {

                    $sql = "SELECT firstname FROM users where userid=:userid";
                    $stmt11 = $conn->prepare($sql);
                    $stmt11->bindParam(':userid', $rowtest['userid']);
                    $stmt11->execute();
                    $row11 = $stmt11->fetch(PDO::FETCH_ASSOC);
                    //echo '<pre>', print_r($new), '</pre>';

                    ?>


                    <li class="table-row">

                    <div class="col col-1" data-label="Job Id"><?= $row11["firstname"] ?></div>

                    <div class="col col-1" data-label="Job Id"><?= $new[$i]['sum'] ?></div></li><?php $i++;
                } ?><br>


                <br>
                <div class="col col-1" data-label="Job Id"></div>
            <?php } ?>
            <li class="table-header">
                <div class="col col-1">Leden:</div>

            </li>

            <?php $row12 = $result12->fetch(PDO::FETCH_ASSOC);
            while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {


                ?>

                <li class="table-row">
                    <?php if ($row8['createdby'] == $_SESSION['userid'] && $row8['createdby'] != $row2["userid"]) {
                        ?>

                        <div class="col col-1" data-label="Job Id">

                            <button class="btn-admin-delete"
                                    onclick=" if(confirm('Weet u zeker dat u deze deelnemer wilt verwijderen?'))window.location.href='php/deletemember.php?&groupid=<?= $row12["groupid"] ?>&memberid=<?= $row2["memberid"] ?>&userid=<?= $row2["userid"] ?>'">
                                Lid verwijderen
                            </button>
                        </div>


                    <?php } else { ?>
                        <div class="col col-1" data-label="Job Id"></div>
                    <?php } ?>


                    <div class="col col-1" data-label="Job Id"><?= $row2["firstname"] ?></div>


                </li>
            <?php }


        }
    } else {
        header('location: index.php?page=login');
    }
} ?>



