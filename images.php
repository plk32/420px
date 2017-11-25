<?php

require_once('sql-connector.php');

$user_id = 0;

if (isset($_POST['rss']))
{
    if ($sql->GetUserId(htmlspecialchars($_POST['username'])) != 0) {
        header('Location: rss.php?username=' . htmlspecialchars($_POST['username']));
        exit();
    }
}

if (isset($_POST['search']))
{
    $user_id = $sql->GetUserId(htmlspecialchars($_POST['username']));
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="static/style.css">
    <title>Images</title>
</head>

<body>
<h1>Image Viewer</h1>
<h2>Fill in the username to see his images</h2>
<form name="login" method="post" action="images.php">
    <span>Username : </span><input type="text" name="username"/> <br/>
    <br/>
    <input type="submit" name="search" value="Search"/><br/>
    <input type="submit" name="rss" value="See RSS"/>
</form>
<br />
<a href="signup.php">SignUp</a> |
<a href="index.php">Login</a>
<br />
<?php
if ($user_id != 0)
{
    echo '<h2>Images</h2>';
    echo '<div class="grid">';
    $images = $sql->GetImages($user_id);
    while ($image = $images->fetch(PDO::FETCH_OBJ)) {
        echo '<div class="cell">';
        echo "<img src=" . $image->path . " width=420 height=420 />";
        echo '</div>';
    }
    echo '</div>';
}
?>

</body>
</html>
