<?php

require_once 'bootstrap.php';

/**
 * @var \VintageGamesParser\Application
 */
$app = $container['application'];
$app->run("http://www.arcade-museum.com/TOP100.php");