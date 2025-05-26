<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once('Models/Database.php');
require_once("components/Head.php");
require_once("Models/Cart.php");

$pimId = $_GET['pimId'];

$confirmed = $_GET['confirmed'] ?? false;
$dbContext = new Database();

$product = $dbContext->getProduct($pimId);

$q = $_GET['q'] ?? "";
$userId = null;
$session_id = null;

if ($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
    $userId = $dbContext->getUsersDatabase()->getAuth()->getUserId();
}

$session_id = session_id();

$cart = new Cart($dbContext, $session_id, $userId);

?>

<!DOCTYPE html>
<html lang="en">

<?php Head(); ?>

<body>
    <?php Nav($dbContext, $cart); ?>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4">
                    <img class="img-fluid rounded shadow-sm product-details-img" src="<?php echo $product->img; ?>" alt="<?php echo $product->title; ?>" />
                </div>
                <div class="col-md-6">
                    <h4 class="display-4 mb-3"><?php echo $product->title; ?></h4>
                    <p class="fs-4 mb-2"><?php echo $product->price; ?> kr</p>
                    <div class="mb-3">
                        <?php
                        $popularity = $product->popularity;
                        for ($i = 1; $i <= 5; $i++) {
                            echo ($i <= $popularity)
                                ? '<i class="bi bi-star-fill text-warning me-1"></i>'
                                : '<i class="bi bi-star text-warning me-1"></i>';
                        }
                        ?>
                    </div>
                    <div class="mb-4">
                        <a class="btn bg-dark mt-auto text-white" href="addtocart?productId=<?php echo $product->pimId ?>&fromPage=<?php echo urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>">Lägg i varukorgen</a>
                    </div>

                    <h3>Beskrivning</h3>
                    <p><?php echo $product->description; ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>