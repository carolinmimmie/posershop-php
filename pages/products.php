<?php
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("components/ProductCard.php");
require_once("components/Head.php");
require_once("components/SortButtons.php");
require_once("Models/Database.php");

global $dbContext, $cart;
$catName = $_GET['catname'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$products = $dbContext->getCategoryProducts($catName, $sortCol, $sortOrder);
$header = $catName;

if ($catName == "") {
    $header = "Posters";
}

?>
<!DOCTYPE html>
<html lang="en">

<?php Head(); ?>

<body>
    <?php Nav($dbContext, $cart); ?>
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row justify-content-center my-4">
                <div class="col-md-6 text-center">
                    <h2 class="mb-3"><?php echo $header ?></h2>
                    <p>Utforska våra senaste posters och kollektioner – designade för att ge ditt hem en personlig och stilren touch.</p>
                </div>
            </div>
            <?php SortButtons("catname", $catName); ?>
            <?php ProductCard($products); ?>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>