<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");


// Hämta den produkt med detta ID
$dbContext = new Database();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Här kommer vi när man har tryckt  på SUBMIT
    // IMORGON TISDAG SÅ UPDATE PRODUCT SET title = $_POST['title'] WHERE id = $id
    $title = $_POST['title'];
    $stockLevel = $_POST['stockLevel'];
    $price = $_POST['price'];
    $categoryName = $_POST['categoryName'];
    $imageUrl = $_POST['imageUrl'];
    $dbContext->insertProduct($title, $stockLevel, $price, $categoryName, $imageUrl);
    echo "<h1>Produkten har skapats</h1>";
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
    <title>Basic Wear</title>
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
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">

            <?php


            // Hämta den produkt med detta ID
            // $product = getProduct($id); // TODO felhantering om inget produkt




            //Kunna lagra i databas


            ?>

            <form method="POST">
                <div class="form-group">
                    <label for="title">Produkt</label>
                    <input type="text" class="form-control" name="title" value="">
                </div>
                <div class="form-group">
                    <label for="price">Pris</label>
                    <input type="text" class="form-control" name="price" value="">
                </div>
                <div class="form-group">
                    <label for="stockLevel">Lagerstatus</label>
                    <input type="text" class="form-control" name="stockLevel" value="">
                </div>
                <div class="form-group">
                    <label for="categoryName">Kategori</label>
                    <input type="text" class="form-control" name="categoryName" value="">
                </div>
                <div class="form-group">
                    <label for="imageUrl">Bildkälla</label>
                    <input type="text" class="form-control" name="imageUrl" value="">
                </div>
                <input type="submit" class="btn btn-primary" value="Spara produkt">
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

<!-- 
<input type="text" name="title" value="<?php echo $product->title ?>">
        <input type="text" name="price" value="<?php echo $product->price ?>">
        <input type="text" name="stockLevel" value="<?php echo $product->stockLevel ?>">
        <input type="text" name="categoryName" value="<?php echo $product->categoryName ?>">
        <input type="submit" value="Uppdatera"> -->