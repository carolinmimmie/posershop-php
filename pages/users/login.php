<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once('Models/Database.php');
require_once("components/Nav.php");
require_once("Models/Cart.php");


global $dbContext, $cart;



$errorMessage = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {  // om det är felaktigt användarnamn eller lösenord så kastas ett undantag
        // och vi hamnar i catch
        $cart = new Cart($dbContext, session_id(), null);
        $dbContext->getUsersDatabase()->getAuth()->login($username, $password);
        $cart->convertSessionToUser($dbContext->getUsersDatabase()->getAuth()->getUserId(), session_id());
        header('Location: /');
        exit;
    } catch (Exception $e) {
        $errorMessage = "Kunde inte logga in";
    }
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
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
</head>
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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>