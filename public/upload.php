<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['avatar']['name'])) {
    $type = mime_content_type($_FILES['avatar']['tmp_name']);
    $extension = explode('/', $type);
    if ($extension[1] === "jpeg" || $extension[1] === "png" || $extension[1] === "gif") {
        $filename = uniqid() . "." . "$extension[1]";
        $uploadDir = '../public/uploads/';
        $uploadFile = $uploadDir . $filename;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    } else {
        $errors = "Vous ne pouvez uploader que des jpg, png ou gif";
    }

}
/*$it = new FilesystemIterator("../public/uploads"(__FILE__));
foreach ($it as $fileinfo) {
    echo $fileinfo->getFilename() . "\n";
}
var_dump($it);
*/

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upload files</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="imageUpload">Upload an profile image</label>
        <input type="file" class="form-control-file" name="avatar" id="imageUpload" multiple>
        <button type="submit">Send</button>
        <?php if (!empty($errors)):?>
        <?php foreach ($errors as $error)?>
        <span><?= $error ?></span>
            <?php endif?>
    </div>
</form>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
