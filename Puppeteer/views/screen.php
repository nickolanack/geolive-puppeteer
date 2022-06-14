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
$id=str_replace('.png', '', $id);
$file= $this->getImage($name, $id);


header('Content-Type: image/png;');
readfile($file);