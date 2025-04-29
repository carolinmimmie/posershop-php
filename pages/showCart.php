<?php
require_once("Models/Product.php");
require_once("Models/Database.php");
require_once("components/Footer.php");
require_once("components/Nav.php");

$dbContext = new Database();

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
    <title>Shoppingcart</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <?php Nav($dbContext, $cart); ?>
    <!-- Section-->
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">

            <table class="table">
                <thead>
                    <th>Produktnamn
                    </th>
                    <th>A-pris
                    </th>
                    <th>Antal
                    </th>
                    <th>Row-price
                    </th>
                    <th>Modifiera
                    </th>
                </thead>
                <tbody>
                    <?php foreach ($cart->getItems() as $cartItem) { ?>
                        <tr>
                            <td><?php echo $cartItem->productName; ?></td>
                            <td><?php echo $cartItem->productPrice; ?></td>
                            <td><?php echo $cartItem->quantity; ?></td>
                            <td><?php echo $cartItem->rowPrice; ?></td>
                            <td><a href="/admin/delete?id=<>" class=" btn btn-danger">Ta bort</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <td>Total:</td>
                <td><?php echo $cart->getTotalPrice(); ?></td>
            </table>
        </div>
    </section>
    <!-- Footer-->
    <?php Footer(); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>