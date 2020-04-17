<?php
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();

    header("Content-Type: text/xml;charset=iso-8859-1");

    echo "<?xml version='1.0' encoding='UTF-8' ?> " . PHP_EOL;
    echo "<rss version='2.0'>" . PHP_EOL;
    echo "<channel>" . PHP_EOL;
    echo "<title>Feed Title | RSS</title>" . PHP_EOL;
    echo "<link>".LinkUrl::LINKURL."index</link>" . PHP_EOL;
    echo "<description>Cloud RSS</description>" . PHP_EOL;
    echo "<language>nl</language>" . PHP_EOL;

    $ArticleViewObj = new ArticleView();
    $ArticleViewObj->showArtchanArticlesXml($_GET["rssID"]);

    echo "</channel>" . PHP_EOL;
    echo "</rss>" . PHP_EOL;
?>

