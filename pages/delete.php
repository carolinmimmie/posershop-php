<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once('Models/Database.php');

$id = $_GET['id'];
$confirmed = $_GET['confirmed'] ?? false;
$dbContext = new Database();
// Hämta den produkt med detta ID

$product = $dbContext->getProduct($id); // TODO felhantering om inget produkt

if ($confirmed == true) {
    $dbContext->deleteProduct($id);
    header("Location: /admin");
    exit;
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
    <?php Nav(); ?>
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">

            <h1><?php echo $product->title; ?></h1>
            <img class="card-img-top" src="<?php echo $product->imageUrl; ?>" alt="Produktbild" />

            <h2>Är du säker att du vill ta bort produkten?</h2>
            <a href="/admin/delete?id=<?php echo $id; ?>&confirmed=true" class="btn btn-danger">Ja</a>
            <a href="/admin/products" class="btn btn-primary">Nej</a>

        </div>
    </section>



    <?php Footer(); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

</body>

</html>