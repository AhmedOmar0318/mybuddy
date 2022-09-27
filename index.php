<?php
session_start();
if (isset($_GET['page'])) {
    $page = $_GET['page'];

} else {
    $page = 'login';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>


    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="CSS/mybuddycss.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js%22%3E"></script>


</head>

<body>

<?php include 'includes/navbar.inc.php'; ?>


<?php include 'includes/' . $page . '.inc.php'; ?>


</body>
</html>