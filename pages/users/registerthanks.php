<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once('Models/Database.php');
require_once("components/Head.php");
require_once("components/Nav.php");

global $dbContext, $cart;

?>

<!DOCTYPE html>
<html lang="en">


<?php Head(); ?>

<body>
    <?php Nav($dbContext, $cart); ?>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h1>Tack</h1>
            <p>Tack för din registrering</p>
            <div class="my-2">
                <a href="/user/login" class="btn btn-dark">Logga in</a>
            </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>