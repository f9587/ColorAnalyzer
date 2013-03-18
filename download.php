<?php
require './libs/Nette/loader.php';

$loader = new Nette\Loaders\RobotLoader;
// přidáme adresáře, které má RobotLoader indexovat
$loader->addDirectory('app');
$loader->addDirectory('libs');
// nastavíme cachování na disk do adresáře 'temp'
$loader->setCacheStorage(new Nette\Caching\Storages\FileStorage('temp'));
$loader->register(); // spustíme RobotLoader

$db = new Nette\Database\Connection('localhost', 'root', 'heslo');

$webpagesRepository=new PictureAnalyzer\WebpagesRepository($db);
$picturesRepository=new PictureAnalyzer\PicturesRepository($db);
$colorsRepository=new PictureAnalyzer\ColorsRepository($db);

$adresses=$webpagesRepository->findAll()->select('url');
print_r($adresses);
?>
