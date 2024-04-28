<?php
// Check if the file was uploaded without errors
if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
    $target_dir = "uploads/"; // Directory where you want to store the uploaded photo
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if($check !== false) {
        // File is an image
        $uploadOk = 1;
    } else {
        // File is not an image
        echo json_encode(array("status" => "error", "message" => "File is not an image."));
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["photo"]["size"] > 500000) {
        echo json_encode(array("status" => "error", "message" => "Sorry, your file is too large."));
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo json_encode(array("status" => "error", "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."));
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo json_encode(array("status" => "error", "message" => "Sorry, your file was not uploaded."));
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            echo json_encode(array("status" => "success", "message" => "The file ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " has been uploaded."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Sorry, there was an error uploading your file."));
        }
    }
} else {
    echo json_encode(array("status" => "error", "message" => "No file uploaded or file upload error occurred."));
}
?>
