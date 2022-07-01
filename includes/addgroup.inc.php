<?php if (isset($_SESSION['userid'])) { ?>

    <div class="container mt-3">
        <h2>Voeg groep toe</h2>
        <form action="php/add.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label>Naam:</label>
                <input type="text" class="form-control" placeholder="Naam" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label>Beschrijving:</label>
                <input type="text" class="form-control" placeholder="Beschrijving" name="description">
            </div>
            <div class="mb-3 mt-3">
                <label>Afbeelding:</label>
                <input type="file" class="form-control" placeholder="Naam" name="picture">
            </div>

            <button name="submit" type="submit" class="btn btn-success">Voeg toe</button>
        </form>
    </div>
<?php } else {
    header('location: index.php?page=login');
} ?>