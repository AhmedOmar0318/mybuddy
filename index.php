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




</head>

<body>

<?php include 'includes/navbar.inc.php'; ?>


<?php include 'includes/' . $page . '.inc.php'; ?>


</body>
</html>