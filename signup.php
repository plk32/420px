<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="static/style.css">
    <title>SignUp</title>
</head>

<body>
<h1>SignUp</h1>
<h2>Please fill in the fields</h2>
<form name="signup" method="post" action="signup.php">
    <span>Username : </span><input type="text" name="username"/> <br/>
    <span>Password : </span><input type="password" name="password"/><br/>
    <br/>
    <input type="submit" name="validate" value="SignUp"/>
</form>
<br>
<a href="index.php">Login</a> |
<a href="images.php">Images</a>
</body>

</html>

<?php

include_once('sql-connector.php');

if (count($_POST) > 0) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $sql->InsertUser($username, $password);
}
