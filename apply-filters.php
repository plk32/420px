<?php

session_start();

require_once ('filters.php');
require_once('sql-connector.php');
require_once('image-manager.php');

if (isset($_POST['modify_image'])) {
    $path = $_POST['image_path'];
}
else if (isset($_POST['filter'])) {
    $path = $_POST['image_path'];
    $filters = new Filters();
    $filters->ApplyFilter($_POST['filter_name'], $path);
}
else {
    header('Location: home.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="static/style.css">
    <title>Filters</title>
</head>

<body>
<h1>Image</h1>
<?php echo "<img src=".$path."?=".Date('U')." width=420 height=420 />"; ?>

<h2>Filters</h2>
<form name="filter" method="post" action="apply-filters.php">
    <input type='hidden' name='image_path' value="<?php echo $path ?>">
    <input type='hidden' name='filter_name' value="c+">
    <input type="submit" name="filter" value="Contrast +"/>
</form>
<form name="filter" method="post" action="apply-filters.php">
    <input type='hidden' name='image_path' value="<?php echo $path ?>">
    <input type='hidden' name='filter_name' value="c-">
    <input type="submit" name="filter" value="Contrast -"/>
</form>
<form name="filter" method="post" action="apply-filters.php">
    <input type='hidden' name='image_path' value="<?php echo $path ?>">
    <input type='hidden' name='filter_name' value="l+">
    <input type="submit" name="filter" value="Luminosity +"/>
</form>
<form name="filter" method="post" action="apply-filters.php">
    <input type='hidden' name='image_path' value="<?php echo $path ?>">
    <input type='hidden' name='filter_name' value="l-">
    <input type="submit" name="filter" value="Luminosity -"/>
</form>
<form name="filter" method="post" action="apply-filters.php">
    <input type='hidden' name='image_path' value="<?php echo $path ?>">
    <input type='hidden' name='filter_name' value="sepia">
    <input type="submit" name="filter" value="Sepia"/>
</form>
<form name="filter" method="post" action="apply-filters.php">
    <input type='hidden' name='image_path' value="<?php echo $path ?>">
    <input type='hidden' name='filter_name' value="gray">
    <input type="submit" name="filter" value="Grayscale"/>
</form>
<form name="filter" method="post" action="apply-filters.php">
    <input type='hidden' name='image_path' value="<?php echo $path ?>">
    <input type='hidden' name='filter_name' value="gauss">
    <input type="submit" name="filter" value="Gauss"/>
</form>
<form name="filter" method="post" action="apply-filters.php">
    <input type='hidden' name='image_path' value="<?php echo $path ?>">
    <input type='hidden' name='filter_name' value="edge">
    <input type="submit" name="filter" value="Edge Detect"/>
</form>
<br>
<a href="home.php">Home</a>
</body>
</html>
<?php
if (isset($_POST['filter'])) {
    flush();
    $manager = new ImageManager();
    $manager->SetColor($path, $sql, htmlspecialchars($_SESSION['user_id']));
}
?>