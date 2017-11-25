<?php

session_start();

require_once('sql-connector.php');
require_once('image-manager.php');

if (!isset($_SESSION['user_id']) || isset($_POST['delete_cookie'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

if (isset($_POST['upload'])) {
    $upload_path = "images/".$_FILES["picture"]["name"];
    $manager = new ImageManager();
    $manager->Upload($upload_path, $_FILES["picture"]["tmp_name"], $sql, htmlspecialchars($_SESSION['user_id']));
}

if (isset($_POST['delete_image'])) {
    $path = $_POST['image_path'];

    unlink($path);
    $sql->deleteImage($path, htmlspecialchars($_SESSION['user_id']));
}

if (isset($_POST['color-search'])) {
    $color = $_POST['color'];
    $images = $sql->GetImagesByColor(htmlspecialchars($_SESSION['user_id']), $color);
}
else
    $images = $sql->GetImages(htmlspecialchars($_SESSION['user_id']));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="static/style.css">
    <title>Home</title>
</head>

<body>
<h1>420px home</h1>
<h2>Welcome <?php echo $_SESSION['username']; ?></h2>
<form name="pictureAdd" method="post" action="home.php" enctype="multipart/form-data">
    <input type="file" name="picture" id="picture"/> <br/>
    <input id="upload" type="submit" name="upload" value="Upload"/>
</form>
</body>
<br>

<form name="delete" method="post" action="home.php">
    <input type="submit" name="delete_cookie" value="Disconnect"/>
</form>
<h2>Show by dominant color</h2>
<form name="color-choose" method="post" action="home.php">
    <select name="color">
        <option value="R">Red</option>
        <option value="G">Green</option>
        <option value="B">Blue</option>
    </select>
    <input id="search" type="submit" name="color-search" value="Search"/>
</form>
<h2>Images</h2>
<div class='grid'>
<?php
    while($image = $images->fetch(PDO::FETCH_OBJ))
    {
        echo '<div class="cell">';
        echo "<img src=".$image->path."?=".Date('U')." width=420 height=420 />";
        echo "<br/><form class='inline' name='modify' method='post' action='apply-filters.php'>
                <input type='hidden' name='image_path' value=\"$image->path\">
                <input class='btn-update' type='submit' name='modify_image' value='Modify'/>
              </form>";
        echo "<form class='inline' name='delete' method='post' action='home.php'>
                <input type='hidden' name='image_path' value=\"$image->path\">
                <input class='btn-delete' type='submit' name='delete_image' value='Delete'/>
              </form><br /><br />";
        echo '</div>';
    }
?>
</div>
</html>
<?php
if (isset($_POST['upload'])) {
    flush();
    $manager->SetColor($upload_path, $sql, htmlspecialchars($_SESSION['user_id']));
}
?>
