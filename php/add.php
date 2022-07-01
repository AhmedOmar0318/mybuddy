<?php
include '../../private/conn.php';

session_start();

$name = $_POST['name'];
$description = $_POST['description'];
$userid = $_SESSION['userid'];


$ahmed = "picture/" . basename($_FILES["picture"]["name"]);

$target_dir = "../picture/";
$target_file = $target_dir . basename($_FILES["picture"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    echo $ahmed . '<br>';
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["picture"]["name"])) . " has been uploaded.";
            $stmt = $conn->prepare("INSERT INTO groups  (name, description,picture,createdby)
                        VALUES(:name, :description,:picture,:createdby)");
            $stmt->bindParam(':picture', $ahmed);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':createdby', $userid);
            $stmt->execute();
            $groupidnew = $conn->lastInsertId();


            $stmt = $conn->prepare("INSERT INTO members  (groupid, userid)
                        VALUES(:groupid,:userid)");
            $stmt->bindParam(':groupid', $groupidnew);
            $stmt->bindParam(':userid', $userid);
            $stmt->execute();


        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

header('location: ../index.php?page=groups');

?>