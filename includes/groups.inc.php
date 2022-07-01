<?php
include '../private/conn.php';

$userid = $_SESSION['userid'];

if (isset($_SESSION['userid'])) {
    $sql = "SELECT g.groupid,g.name,g.description,g.picture,g.createdby,g.date,m.userid FROM groups g
left join members m on g.groupid = m.groupid
where m.userid = :userid ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();

    ?>

    <button class="btn btn-success" onclick="window.location.href='index.php?page=addgroup'">Groep toevoegen</button>

    <div class="">
        <h2>Groepen</h2>

        <li class="table-header">
            <div class="col col-1">Afbeelding</div>
            <div class="col col-1">Naam</div>
            <div class="col col-1">Datum</div>
            <div class="col col-1">Beschrijving</div>
            <div class="col col-1">Open groep</div>
        </li>
    </div>

    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

            <li class="table-row">
                <div class="col col-1" data-label="Job Id"><img class="picture" src=" <?= $row["picture"] ?>"></div>
                <div class="col col-1" data-label="Job Id"><?= $row["name"] ?></div>
                <div class="col col-1" data-label="Job Id"><?= $row["date"] ?></div>
                <div class="col col-1" data-label="Job Id"><?= $row["description"] ?></div>
                <div class="col col-1" data-label="Job Id">
                    <td>
                        <button onclick="window.location.href='index.php?page=groupview&groupid=<?= $row["groupid"] ?>'">
                            Bekijk groep
                        </button>
                    </td>
                </div>

            </li>

            <?php


            $sql2 = "SELECT createdby FROM groups where  groupid = :groupid";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindParam(':groupid', $row['groupid']);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($row2['createdby'] == $userid) {
                ?>

                <li class="table-row">

                    <div class="col col-1" data-label="Job Id">
                        <td>
                            <button onclick="window.location.href='index.php?page=groupedit&id=<?= $row["groupid"] ?>'">
                                Bewerk
                            </button>
                        </td>
                    </div>
                    <div class="col col-1" data-label="Job Id">
                        <button class="btn-admin-delete"
                                onclick=" if(confirm('Weet u zeker dat u deze groep wilt verwijderen?'))window.location.href='php/delete.php?id=<?= $row["groupid"] ?>'">
                            Verwijderen
                        </button>
                    </div>
                </li>

                <?php
            }


        }
    }
} ?>
