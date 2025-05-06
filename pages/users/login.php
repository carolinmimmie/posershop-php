<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once('Models/Database.php');
require_once("components/Nav.php");
require_once("components/Head.php");
require_once("Models/Cart.php");

global $dbContext, $cart;

$errorMessage = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $cart = new Cart($dbContext, session_id(), null);
        $dbContext->getUsersDatabase()->getAuth()->login($username, $password);
        $cart->convertSessionToUser($dbContext->getUsersDatabase()->getAuth()->getUserId(), session_id());
        header('Location: /');
        exit;
    } catch (Exception $e) {
        $errorMessage = "Kunde inte logga in";
    }
} else {
}

?>
<!DOCTYPE html>
<html lang="en">

<?php Head(); ?>
<?php Nav($dbContext, $cart); ?>

<body>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h1>Logga in</h1>
            <?php
            if ($errorMessage != "") {
                echo "<div class='alert alert-danger' role='alert'>" . $errorMessage . "</div>";
            }
            ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">E-postadress</label>
                    <input type="text" class="form-control" name="username" placeholder="Ange din e-postadress" value="<?php echo $username ?>">
                </div>
                <div class="form-group">
                    <label for="password">Lösenord</label>
                    <input type="password" class="form-control" name="password" placeholder="Ange ditt lösenord" value="">
                </div>
                <div class="my-2">
                    <input type="submit" class="btn btn-dark" value="Logga in">
                    <a href="/user/register" class="btn btn-dark">Registrera dig</a>
                    <a href="/forgot" class="btn btn-dark">Glömt lösenord</a>
                </div>
            </form>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>