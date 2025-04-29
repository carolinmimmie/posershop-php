<?php
ob_start(); // Startar output buffering
// ensure_session();
session_start();

error_reporting(E_ALL & ~E_DEPRECATED); // FICK LÄGGA TILL DEN HÄR
require_once("Utils/router.php");
require_once("vendor/autoload.php");
require_once("Models/Cart.php");
require_once("Models/Database.php");

//  :: en STATIC funktion
$dotenv = Dotenv\Dotenv::createImmutable("."); // . is  current folder for the PAGE
$dotenv->load();

$dbContext = new Database();
$userId = null;
$session_id = null;

if ($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
    $userId = $dbContext->getUsersDatabase()->getAuth()->getUserId();
}
//$cart = $dbContext->getCartByUser($userId);
$session_id = session_id();

$cart = new Cart($dbContext, $session_id, $userId);

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
$router->addRoute('/admin/delete', function () {
    require_once(__DIR__ . '/Pages/delete.php');
});
$router->addRoute('/products', function () {
    require_once(__DIR__ . '/Pages/products.php');
});

$router->addRoute('/user/login', function () {
    require_once(__DIR__ . '/Pages/users/login.php');
});
$router->addRoute('/user/logout', function () {
    require_once(__DIR__ . '/Pages/users/logout.php');
});
$router->addRoute('/user/register', function () {
    require_once(__DIR__ . '/Pages/users/register.php');
});
$router->addRoute('/user/registerthanks', function () {
    require_once(__DIR__ . '/Pages/users/registerthanks.php');
});
$router->addRoute('/search', function () {
    require_once(__DIR__ . '/Pages/search.php');
});
$router->addRoute('/productdetails', function () {
    require_once(__DIR__ . '/Pages/productdetails.php');
});
$router->addRoute('/cart', function () {
    require_once(__DIR__ . '/Pages/showCart.php');
});
$router->addRoute('/addtocart', function () {
    require_once(__DIR__ . '/Pages/addToCart.php');
});

$router->dispatch();
