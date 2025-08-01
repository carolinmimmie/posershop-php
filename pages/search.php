<?php
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("components/Head.php");
require_once("components/SortButtons.php");
require_once("Models/Database.php");
require_once("Utils/searchengine.php");

global $dbContext, $cart;
$q = $_GET['q'] ?? "";
$sortCol = $_GET['sortCol'] ?? "title";
$sortOrder = $_GET['sortOrder'] ?? "asc";
$SearchEngine = new SearchEngine();


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
                    <h2 class="mb-3"><?php echo ucfirst($q); ?></h2>
                </div>
            </div>
            <?php SortButtons("q", $q); ?>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-spacebetween">
                <?php
                $products = $SearchEngine->searchProducts($q, $sortCol, $sortOrder);
                if (empty($products)) {
                    echo '<div class="col-12 my-5"><p>Inga produkter hittades.</p></div>';
                } else {
                    foreach ($products as $prod) {
                ?>
                        <div class="col mb-5">
                            <div class="card h-100 shadow-sm py-3">
                                <?php if ($prod->price < 10) {  ?>
                                    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                <?php } ?>
                                <img class="card-img-top" src="<?php echo $prod->img; ?>" alt="..." />
                                <div class="card-body">
                                    <div class="text-center">
                                        <h5 class="py-2"><?php echo $prod->title; ?></h5>
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <?php
                                            $popularity = $prod->popularity;
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo ($i <= $popularity)
                                                    ? '<i class="bi bi-star-fill me-1"></i>'
                                                    : '<i class="bi bi-star me-1"></i>';
                                            }
                                            ?>
                                        </div>
                                        <?php echo $prod->price; ?> kr
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent py-2">
                                    <div class="text-center"><a class="btn bg-dark mt-auto text-white" href="/productdetails?pimId=<?php echo $prod->pimId; ?>">Köp nu</a></div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>