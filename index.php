<?php

session_start();

require_once('sql-connector.php');

$error = false;

if (count($_POST) > 0) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $id = $sql->SelectUser($username, $password);

    if ($id > 0) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header('Location: home.php');
        exit();
    }
    else
        $error = true;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="static/style.css">
    <title>Login</title>
</head>

<body>
<h1>Login</h1>
<h2>Please fill in the fields</h2>
<form name="login" method="post" action="index.php">
    <span>Username : </span> <input type="text" name="username"/> <br/>
    <span>Password : </span> <input type="password" name="password"/><br/>
    <br/>
    <input type="submit" name="validate" value="Login"/>
</form>
<br>
<a href="signup.php">SignUp</a> |
<a href="images.php">Images</a>
<?php if($error) echo '<br />Login failed'; ?>
</body>

</html>
