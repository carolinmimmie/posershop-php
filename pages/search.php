<?php
// ONCE = en gång även om det blir cirkelreferenser
#include_once("Models/Products.php") - OK även om filen inte finns
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");

$dbContext = new Database();

$q = $_GET['q'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BasicWear</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <?php Nav(); ?>

    <!-- Section-->
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="mb-5">
                <a href="?sortCol=price&sortOrder=asc&q=<?php echo $q; ?>" class="btn btn-dark">Lågt pris</a>
                <a href="?sortCol=price&sortOrder=desc&q=<?php echo $q; ?>" class="btn btn-dark">Högt pris</a>
                <a href="?sortCol=title&sortOrder=asc&q=<?php echo $q; ?>" class="btn btn-dark">A–Ö</a>
                <a href="?sortCol=title&sortOrder=desc&q=<?php echo $q; ?>" class="btn btn-dark">Ö–A</a>
            </div>

            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-spacebetween">
                <?php
                $products = $dbContext->searchProducts($q, $sortCol, $sortOrder);

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
                                <!-- Product image-->
                                <img class="card-img-top" src="<?php echo $prod->imageUrl; ?>" alt="..." />
                                <!-- Product details-->
                                <div class="card-body">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="py-2"><?php echo $prod->title; ?></h5>
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <?php
                                            // Antal stjärnor som ska visas
                                            $popularityFactor = $prod->popularityFactor;

                                            // Loop för att skapa stjärnorna baserat på popularityFactor
                                            for ($i = 1; $i <= 5; $i++) {
                                                // Om $i är mindre än eller lika med popularityFactor, visa en fylld stjärna
                                                echo ($i <= $popularityFactor)
                                                    ? '<i class="bi bi-star-fill me-1"></i>'  // Fylld stjärna
                                                    : '<i class="bi bi-star me-1"></i>';      // Tom stjärna
                                            }
                                            ?>
                                        </div>
                                        <!-- Product price-->
                                        <?php echo $prod->price; ?> kr
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer bg-transparent py-2">
                                    <div class="text-center "><a class="btn bg-dark mt-auto text-white" href="#">Köp nu</a></div>
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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

</body>

</html>