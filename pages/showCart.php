<?php
require_once("Models/Product.php");
require_once("Models/Database.php");
require_once("components/Footer.php");
require_once("components/Head.php");
require_once("components/Nav.php");

$dbContext = new Database();

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
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">

            <table class="table">
                <thead>
                    <th>Produkt</th>
                    <th>Pris</th>
                    <th>Antal</th>
                    <th>Radpris</th>
                    <th>Hantera</th>
                    </th>
                </thead>
                <tbody>
                    <?php foreach ($cart->getItems() as $cartItem) { ?>
                        <tr>
                            <td><?php echo $cartItem->productName; ?></td>
                            <td><?php echo $cartItem->productPrice; ?></td>
                            <td><button>-</button><?php echo $cartItem->quantity; ?><button>+</button></td>
                            <td><?php echo $cartItem->rowPrice; ?></td>
                            <td><a href="/admin/delete?id=<>" class=" btn btn-danger">Ta bort</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <th>Total:</th>
                <th></th>
                <th></th>
                <th></th>
                <td><?php echo $cart->getTotalPrice(); ?> kr</td>
            </table>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>