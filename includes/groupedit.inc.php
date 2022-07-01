<?php
include '../private/conn.php';

$id = $_GET['id'];

$sql = "SELECT * FROM groups WHERE groupid = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch();


if (isset($_SESSION['userid'])) {

    ?>
    <h1 class="h1-book-overview">Groep bewerken</h1>

    <div class="container">

        <form action="php/edit.php" method="post" enctype="multipart/form-data">

            <label><b>Naam</b></label>
            <input type="text" placeholder="Naam" name="name" value="<?php echo $row['name'] ?>" id="naam" required>


            <br><label><b>Beschrijving</b></label>
            <input type="text" placeholder="Beschrijving" name="description" value="<?php echo $row['description'] ?>"
                   id="schrijver" required>

            <label><b>Afbeelding</b></label>
            <input type="file" name="picture" value="<?php echo $row['picture'] ?>" required><br>

            <input type="hidden" name="groupid" value="<?php echo $row['groupid'] ?>" required>

            <button id="add-product-button" name="submit" class="button">Opslaan</button>

        </form>

    </div>

<?php } else {
    header('location: index.php?page=login');
} ?>


