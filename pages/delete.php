<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("components/Head.php");
require_once('Models/Database.php');

$id = $_GET['id'];
$confirmed = $_GET['confirmed'] ?? false;
global $dbContext, $cart;
$productDeleteMessage = "";
$product = $dbContext->getProduct($id);

if ($confirmed == true) {
    $dbContext->deleteProduct($id);
    $productDeleteMessage = "Produkten har tagits bort i databasen";
    $product = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php Head(); ?>

<body>
    <?php Nav($dbContext, $cart); ?>
    <section class="py-6">
        <div class="container px-4 px-lg-5 mt-5">
            <?php if ($productDeleteMessage): ?>
                <div class="alert alert-success">
                    <?php echo $productDeleteMessage; ?>
                </div>
            <?php endif; ?>
            <?php if ($product !== null): ?>
                <h1><?php echo $product->title; ?></h1>
                <img class="card-img-top" src="<?php echo $product->img; ?>" alt="Produktbild" />
                <h2>Är du säker på att du vill ta bort produkten?</h2>
                <a href="/admin/delete?id=<?php echo $id; ?>&confirmed=true" class="btn btn-danger">Ja</a>
                <a href="/admin" class="btn btn-primary">Nej</a>
            <?php else: ?>
                <div class="mb-5">
                    <a href="/admin" class="btn btn-dark py-8">Tillbaka till adminsidan</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>