<?php

$it = new FilesystemIterator(__DIR__ . '/uploads');

if (!empty($_FILES['images']['name'][0])) {
    $files = $_FILES['images'];
    $uploaded = [];
    $errors = [];
    $allowed = ['jpg','png','gif', 'jpeg'];

    foreach ($files['name'] as $position => $fileName) {
        $fileTmp = $files['tmp_name'][$position];
        $fileSize = $files['size'][$position];
        $fileError = $files['error'][$position];
        $ext = explode('.', $fileName);
        $ext = strtolower(end($ext));

        if (in_array($ext, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize <= 1000000) {
                    $fileNameNew = uniqid('', true) . '.' . $ext;
                    $fileDestination = __DIR__ . '/uploads/' . $fileNameNew;

                    if (move_uploaded_file($fileTmp, $fileDestination)) {
                        $uploaded[$position] = $fileDestination;
                        header('Location : upload.php');
                    } else {
                        $errors[$position] = "[{$fileName}] n'a pas pu être uploadé";
                    }

                } else {
                    $errors[$position] = "[{$fileName}] est trop lourd (1Mo max)";
                }

            } else {
                $errors[$position] = "Un problème est survenu";
            }

        } else {
            $errors[$position] = "Seuls les jpg, png et gif sont acceptés";
            }
        }

    if (!empty($uploaded)) {
        print_r($uploaded);
    }
    if (!empty($errors)) {
        print_r($errors);
    }
}

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
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        <input type="file" class="form-control-file" name="images[]" id="imageUpload" multiple="multiple">
        <button type="submit">Send</button>
    </div>
</form>


<?php foreach ($it as $fileInfo): ?>
    <figure>
        <img src="uploads/<?= $fileInfo->getFilename()?>" alt="<?= $fileInfo->getFilename()?>" style="width: 300px">
        <figcaption><?= $fileInfo->getFilename() . "\n" ?></figcaption>
    </figure>
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
