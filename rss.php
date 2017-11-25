<?php

require_once('sql-connector.php');

if ($_GET['username'] != '') {
    header('Content-Type: text/xml; charset=utf-8', true);
}
else {
    header('Location: images.php');
    exit();
}

$user_id = $sql->GetUserId(htmlspecialchars($_GET['username']));
$images = $sql->GetImages($user_id);

$baseXML = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
</rss>
XML;

$rss = new SimpleXMLElement($baseXML);
$channel = $rss->addChild('channel');
$title = $channel->addChild('title', '420px Images');
$description = $channel->addChild('description', 'RSS feed for user '.$_GET['username']);
$link = $channel->addChild('link', 'localhost');

while ($image = $images->fetch(PDO::FETCH_OBJ)) {
    $item = $channel->addChild('item');
    $t = $item->addChild('title', 'Image');
    $d = $item->addChild('description', $image->path);
}

echo $rss->asXML();