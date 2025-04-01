<?php
// Denna fil kommer alltid att laddas in först
// vi ska mappa urler mot Pages
// om url = "/admin" så visa admin.php
// om url = "/edit" så visa edit.php
// om url = "/" så visa index.php

require_once("Utils/router.php"); // LADDAR IN ROUTER KLASSEN
require_once("vendor/autoload.php"); // LADDA ALLA DEPENDENCIES FROM VENDOR
//  :: en STATIC funktion
$dotenv = Dotenv\Dotenv::createImmutable("."); // . is  current folder for the PAGE
$dotenv->load();
// Pilar istf .
// \ istf .

// import * as dotenv from 'dotenv';



$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/pages/index.php';
});
$router->addRoute('/admin', function () {
    require __DIR__ . '/pages/admin.php';
});
$router->addRoute('/admin/edit', function () {
    require __DIR__ . '/pages/edit.php';
});
$router->addRoute('/admin/new', function () {
    require __DIR__ . '/pages/new.php';
});
$router->dispatch();
