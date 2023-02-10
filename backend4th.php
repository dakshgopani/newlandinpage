<?php

// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "outfits";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the outfits and outfits_plan tables if they do not exist
$sql = "CREATE TABLE IF NOT EXISTS outfits (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    image VARCHAR(100) NOT NULL
);";

if (mysqli_query($conn, $sql)) {
    echo "Table outfits created successfully";
} else {
    echo "Error creating table outfits: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS outfits_plan (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    outfit_id INT(6) NOT NULL,
    day VARCHAR(10) NOT NULL
);";

if (mysqli_query($conn, $sql)) {
    echo "Table outfits_plan created successfully";
} else {
    echo "Error creating table outfits_plan: " . mysqli_error($conn);
}

// Handle image upload
if (isset($_POST["upload-image"])) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }