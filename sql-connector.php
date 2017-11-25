<?php

class SQLConnector
{
    private $connection = null;

    public function Connect()
    {
        // Error with localhost -> access denied
        $dsn = 'mysql:host=127.0.0.1;';
        $user = 'root';
        $password = 'password';
        $option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        try {
            $this->connection = new PDO($dsn, $user, $password, $option);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function CreateDB(){
        $this->connection->query("CREATE DATABASE IF NOT EXISTS php1");
        $this->connection->query("use php1");
    }

    public function CreateTableUser()
    {
        try {
            $createTable = "CREATE TABLE IF NOT EXISTS Users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL
)";

            $this->connection->exec($createTable);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function CreateTableImages()
    {
        try {
            $createTable = "CREATE TABLE IF NOT EXISTS Images (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
path VARCHAR(255) NOT NULL UNIQUE,
main_color VARCHAR(10) NOT NULL,
user_id INT(6) NOT NULL
)";

            $this->connection->exec($createTable);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function InsertUser($username, $password)
    {
        try {
            $prepa = $this->connection->prepare('INSERT INTO Users (username, password) VALUES(?, ?)');
            $hash = md5($password);
            $prepa->execute(array("$username","$hash"));
            echo '<br />SignUp successfull';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function SelectUser($username, $password)
    {
        try {
            $prepa = $this->connection->prepare('SELECT * FROM Users WHERE username like :name AND password like :pwd;');
            $hash = md5($password);
            $prepa->execute(array('name' => "$username", 'pwd' => "$hash"));
            $result = $prepa->fetch(PDO::FETCH_OBJ);

            if ($result)
                return $result->id;
            else
                return 0;
        }
        catch(PDOException $e)
        {
            return 0;
        }
    }

    public function GetUserId($username)
    {
        try {
            $prepa = $this->connection->prepare('SELECT * FROM Users WHERE username like :name');
            $prepa->execute(array('name' => "$username"));
            $result = $prepa->fetch(PDO::FETCH_OBJ);

            if ($result)
                return $result->id;
            else
                return 0;
        }
        catch(PDOException $e)
        {
            return 0;
        }
    }

    public function InsertImage($path, $user_id)
    {
        try {
            $prepa = $this->connection->prepare('INSERT INTO Images (path, user_id, main_color) VALUES(?, ?, ?)');
            $nbInsert = $prepa->execute(array("$path", "$user_id", "NONE"));
            echo $nbInsert.' image uploaded.';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function UpdateImageWithColor($path, $user_id, $color)
    {
        try {
            $prepa = $this->connection->prepare('UPDATE Images SET main_color=:color WHERE path like :path AND user_id like :id');
            $prepa->execute(array('color' => "$color", 'path' => "$path", 'id' => "$user_id"));
            echo 'image color updated';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function GetImages($user_id)
    {
        try {
            $prepa = $this->connection->prepare('SELECT path FROM Images WHERE user_id like :user_id');
            $prepa->execute(array('user_id' => "$user_id"));
            return $prepa;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function GetImagesByColor($user_id, $color)
    {
        try {
            $prepa = $this->connection->prepare('SELECT path FROM Images WHERE user_id like :user_id
AND (main_color like :color OR main_color like :none)');
            $prepa->execute(array('user_id' => "$user_id", 'color' => "$color", 'none' => "NONE"));
            return $prepa;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function DeleteImage($path, $user_id)
    {
        try {
            $prepa = $this->connection->prepare('DELETE FROM Images WHERE path like :path AND user_id like :user_id');
            $nbDelete = $prepa->execute(array('path' => "$path", 'user_id' => "$user_id"));
            echo $nbDelete.' image deleted.';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}

$sql = new SQLConnector();
$sql->Connect();
$sql->CreateDB();
$sql->CreateTableUser();
$sql->CreateTableImages();