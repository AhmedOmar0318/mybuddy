<?php
include '../private/conn.php';
if (isset($_SESSION['userid'])) {?>
    <div class="topnav">
        <a class="active" href="index.php?page=groups">Groepenoverzicht</a>

        <a href="php/logout.php">Log uit</a>
    </div>

<?php } ?>

