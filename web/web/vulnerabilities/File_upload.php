<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/style_fileUpload.css">
    <meta charset="UTF-8">
    <title>PHP_File-Upload</title>
</head>
<body>
    <div class="menu">
        <ul>
            <li><a href="?action=image">Upload file image</a></li>
            <li><a href="?action=zip">Upload file zip</a></li>
            <li><a href="upload/">Upload</a></li>
        </ul>
    </div>
    <div class="content">
        <form action="#" method="POST" enctype="multipart/form-data" id="main-form">
            <p>Select image to upload</p>
            <input type="file" name="file_upload">
            <input type="submit" name="submit" value="Upload">
        </form>
        <?php
            if (isset($_POST["submit"])) {
                $target_dir  = "upload/";
                $target_dir .= basename($_FILES["file_upload"]["name"]);

                $upload_name = $_FILES["file_upload"]["name"];
                $upload_size = $_FILES["file_upload"]["size"];
                $upload_type = $_FILES["file_upload"]["type"];

                if ($upload_type == "image/jpeg" or $upload_type == "image/png" or $upload_type == "image/jpg") {
                    if (!move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_dir)) {
                        echo "File Error";
                    } else {
                        echo "{$target_dir} successfully uploaded!";
                    }
                } else {
                    echo "File Error: Only JPEG, PNG and JPG files are allowed.";
                }
            }
        ?>
    </div>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/style_fileUpload.css">
    <meta charset="UTF-8">
    <title>PHP_File-Upload</title>
</head>
<body>
    <div class="menu">
        <ul>
            <li><a href="?action=image">Upload file image</a></li>
            <li><a href="?action=zip">Upload file zip</a></li>
            <li><a href="upload/">Upload</a></li>
        </ul>
    </div>
    <div class="content">
        <form action="#" method="POST" enctype="multipart/form-data" id="main-form">
            <p>Select image to upload</p>
            <input type="file" name="file_upload" accept="image/jpeg, image/png, image/jpg">
            <input type="submit" name="submit" value="Upload">
        </form>
        <?php
            if (isset($_POST["submit"])) {
                $target_dir = "upload/";
                $file_name = basename($_FILES["file_upload"]["name"]);
                $target_file = $target_dir . $file_name;
                $upload_size = $_FILES["file_upload"]["size"];
                $upload_type = $_FILES["file_upload"]["type"];

                // Validate file extension
                $allowed_types = array('jpg', 'jpeg', 'png');
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

                if (in_array(strtolower($file_extension), $allowed_types)) {
                    if ($upload_size < 5000000) { // Limit the file size to 5MB
                        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
                            echo htmlspecialchars($target_file) . " successfully uploaded!";
                        } else {
                            echo "File Error: Could not move the file.";
                        }
                    } else {
                        echo "File Error: File size is too large.";
                    }
                } else {
                    echo "File Error: Only JPEG, PNG and JPG files are allowed.";
                }
            }
        ?>
    </div>
</body>
</html> -->

