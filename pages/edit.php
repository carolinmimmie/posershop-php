<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");

$id = $_GET['id'];
// Hämta den produkt med detta ID
$dbContext = new Database();

$productUpdateMessage = "";
$product = $dbContext->getProduct($id); // TODO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Här kommer vi när man har tryckt  på SUBMIT
    // IMORGON TISDAG SÅ UPDATE PRODUCT SET title = $_POST['title'] WHERE id = $id
    $product->title = $_POST['title'];
    $product->stockLevel = $_POST['stockLevel'];
    $product->price = $_POST['price'];
    $product->categoryName = $_POST['categoryName'];
    $product->imageUrl = $_POST['imageUrl'];
    $product->popularityFactor = $_POST['popularityFactor'];
    $dbContext->updateProduct($product);
    $productUpdateMessage = "Produkten har sparats i databasen";
} else {
    // Det är INTE ett formulär som har postats - utan man har klickat in på länk tex edit.php?id=12
}
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
    <!-- Navigation-->
    <?php Nav(); ?>
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <?php if ($productUpdateMessage): ?>
                <div class="alert alert-sucess">
                    <?php echo $productUpdateMessage; ?>
                </div>
            <?php endif; ?>

            <?php

            $id = $_GET['id'];



            ?>

            <form method="POST">
                <div class="form-group">
                    <label for="title">Produkt</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $product->title ?>">
                </div>
                <div class="form-group">
                    <label for="price">Pris</label>
                    <input type="text" class="form-control" name="price" value="<?php echo $product->price ?>">
                </div>
                <div class="form-group">
                    <label for="stockLevel">Lagerstatus</label>
                    <input type="text" class="form-control" name="stockLevel" value="<?php echo $product->stockLevel ?>">
                </div>
                <div class="form-group">
                    <label for="categoryName">Kategori</label>
                    <input type="text" class="form-control" name="categoryName" value="<?php echo $product->categoryName ?>">
                </div>
                <div class="form-group">
                    <label for="imageUrl">Bildkälla</label>
                    <input type="text" class="form-control" name="imageUrl" value="<?php echo $product->imageUrl ?>">
                </div>
                <div class="form-group">
                    <label for="popularityFactor">Popularitet</label>
                    <input type="text" class="form-control" name="popularityFactor" value="<?php echo $product->popularityFactor ?>">
                </div>
                <div class="my-2">
                    <input type="submit" class="btn btn-dark" value="Uppdatera">
                </div>
            </form>
        </div>
    </section>



    <?php Footer(); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

</body>

</html>