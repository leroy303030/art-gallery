<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art_gallery2";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted and process the file upload
if (isset($_POST['submit'])) {
    // File upload handling
    $target_dir = "proof_of_payment/"; // Directory where uploaded payment proof files will be stored

    // Ensure the target directory exists or create it if it doesn't
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["payment_proof"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if a file with the same name already exists
    if (file_exists($target_file)) {
        echo "Sorry, a file with the same name already exists.";
        $uploadOk = 0;
    }

    // Check if the file size is too large (you can adjust the size limit as needed)
    if ($_FILES["payment_proof"]["size"] > 5000000) { // 5MB limit, you can adjust this
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can add more formats if needed)
    if ($fileType != "pdf" && $fileType != "jpg" && $fileType != "jpeg" && $fileType != "png") {
        echo "Sorry, only PDF, JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is fine, try to upload the file
        if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
            // Insert the payment proof information into the database
            $file_path = $target_file; // Store the file path
            $file_name = basename($_FILES["payment_proof"]["name"]);
            $sql = "INSERT INTO payment_proof (file_name, file_path, upload_date) VALUES ('$file_name', '$file_path', NOW())";
            if ($conn->query($sql) === TRUE) {
                echo "The file " . basename($_FILES["payment_proof"]["name"]) . " has been uploaded and the data has been added to the database.";
            } else {
                echo "Error inserting data: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Handle the Photo Upload
if (isset($_POST['upload_photo'])) {
    $photo_name = $_POST['photo_name'];
    $photo_description = $_POST['photo_description'];

    // File upload handling
    $target_dir = "uploads/"; // Directory where uploaded photos will be stored
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the uploaded file is an image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if a file with the same name already exists
    if (file_exists($target_file)) {
        echo "Sorry, a file with the same name already exists.";
        $uploadOk = 0;
    }

    // Check if the file size is too large (you can adjust the size limit as needed)
    if ($_FILES["photo"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can add more formats if needed)
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is fine, try to upload the file
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Insert the photo information into the database
            $photo_file = $target_file; // Store the file path
            $sql = "INSERT INTO qr_code (photo_name, photo_description, photo_file) VALUES ('$photo_name', '$photo_description', '$photo_file')";
            if ($conn->query($sql) === TRUE) {
                echo "The file " . basename($_FILES["photo"]["name"]) . " has been uploaded and the data has been added to the database.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close the database connection
$conn->close();
?>
