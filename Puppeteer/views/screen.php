<?php

$segments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
array_shift($segments);
array_shift($segments);

if (count($segments) !== 2) {
	echo "Invalid URL";
	exit();
}


$name=array_shift($segments);
$id=array_shift($segments);

echo $this->getPlugin()->getImage($name, $id);