<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("components/Head.php");
require_once('Models/Database.php');

global $dbContext, $cart;
$errorMessage = "";
$username = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username);
        header('Location: /user/registerthanks');
        exit;
    } catch (\Delight\Auth\InvalidEmailException $e) {
        $errorMessage = "Ej korrekt email";
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        $errorMessage = "Felaktigt lösenord";
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
        $errorMessage = "Användare finns redan";
    } catch (\Exception $e) {
        $errorMessage = "Något gick fel";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php Head() ?>

<body>
    <?php Nav($dbContext, $cart); ?>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h1>Registrera dig</h1>
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
                    <input type="password" class="form-control" name="password" value="" placeholder="Välj ett lösenord">
                </div>
                <div class="form-group">
                    <label for="password2">Upprepa lösenord</label>
                    <input type="password" class="form-control" name="password2" value="" placeholder="Upprepa lösenordet">
                </div>
                <div class="my-2">
                    <input type="submit" class="btn btn-dark" value="Registrera">
                </div>
        </div>
        </form>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>