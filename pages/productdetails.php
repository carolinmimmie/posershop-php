<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once('Models/Database.php');
require_once("Models/Cart.php");

$id = $_GET['id'];
$confirmed = $_GET['confirmed'] ?? false;
$dbContext = new Database();
// Hämta den produkt med detta ID

$product = $dbContext->getProduct($id); // TODO felhantering om inget produkt

$q = $_GET['q'] ?? "";
$userId = null;
$session_id = null;

if ($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
    $userId = $dbContext->getUsersDatabase()->getAuth()->getUserId();
}
//$cart = $dbContext->getCartByUser($userId);
$session_id = session_id();

$cart = new Cart($dbContext, $session_id, $userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Postergalleriet</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php Nav($dbContext, $cart); ?>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row align-items-center">
                <!-- Produktbild -->
                <div class="col-md-6 mb-4">
                    <img class="img-fluid rounded shadow-sm product-details-img" src="<?php echo $product->imageUrl; ?>" alt="<?php echo $product->title; ?>" />
                </div>

                <!-- Produktinformation -->
                <div class="col-md-6">
                    <h4 class="display-4 mb-3"><?php echo $product->title; ?></h4>
                    <p class="fs-4 mb-2"><?php echo $product->price; ?> kr</p>

                    <!-- Stjärnbetyg -->
                    <div class="mb-3">
                        <?php
                        $popularityFactor = $product->popularityFactor;
                        for ($i = 1; $i <= 5; $i++) {
                            echo ($i <= $popularityFactor)
                                ? '<i class="bi bi-star-fill text-warning me-1"></i>'
                                : '<i class="bi bi-star text-warning me-1"></i>';
                        }
                        ?>
                    </div>

                    <!-- Köpknapp -->
                    <div class="mb-4">
                        <a class="btn bg-dark mt-auto text-white" href="addtocart?productId=<?php echo $product->id ?>&fromPage=<?php echo urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>">Lägg i varukorgen</a>
                    </div>

                    <!-- Produktbeskrivning -->
                    <h3>Beskrivning</h3>
                    <p><?php echo $product->description; ?></p>
                </div>
            </div>
        </div>
    </section>





    <?php Footer(); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

</body>

</html>