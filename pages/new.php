<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");
require_once("Utils/Validator.php");
require_once("components/Head.php");


global $dbContext, $cart;

$productSavedMessage = "";
$v = new Validator($_POST);

$pimId = "";
$title = "";
$description = "";
$stock = "";
$price = "";
$category = "";
$img =  "";
$popularity = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pimId = $_POST['pimId'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $img = $_POST['img'];
    $popularity = $_POST['popularity'];

    $v->field('pimId')->required()->min_len(3)->max_len(50);
    $v->field('title')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('description')->required()->min_len(3)->max_len(50);
    $v->field('stock')->required()->numeric()->min_val(0);
    $v->field('price')->required()->numeric()->min_val(0);
    $v->field('category')->required()->alpha_num([''])->min_len(3)->max_len(50);
    $v->field('popularity')->required()->numeric()->min_val(0);

    if ($v->is_valid()) {

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.ethereal.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'mariah.hegmann52@ethereal.email';
        $mail->Password = 'F91kB6CXj2jwwwCuzf';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->From = "carolin@postergalleriet.com";
        $mail->FromName = "Postergalleriet"; //To address and name 
        $mail->addAddress("bill.gates@microsoft.com"); //Address to which recipient will reply 
        $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply"); //CC and BCC 
        $mail->isHTML(true);
        $mail->Subject = "Orderbekräftelse-postergalleriet";
        $mail->Body = "<h2>Hej</h2>, Vilket kul nyhetsbrev <b>fdsfds</b>";
        $mail->send();
        $dbContext->insertProduct($pimId, $title, $description, $stock, $price, $category, $img, $popularity);
        $productSavedMessage = "Produkten har sparats i databasen";
    }
} else {
}
?>

<!DOCTYPE html>
<html lang="en">

<?php Head(); ?>

<body>
    <?php Nav($dbContext, $cart); ?>
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <?php if ($productSavedMessage): ?>
                <div class="alert alert-success">
                    <?php echo $productSavedMessage; ?>
                </div>
            <?php endif; ?>

            <?php
            ?>
            <h2>Skapa ny produkt</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="pimId">PimId</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('pimId') != "" ? "is-invalid" : ""  ?>" name=" pimId" value="<?php echo $pimId ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('pimId');  ?></span>
                </div>
                <div class="form-group">
                    <label for="title">Produkt</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('title') != "" ? "is-invalid" : ""  ?>" name=" title" value="<?php echo $title ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('title');  ?></span>
                </div>
                <div class="form-group">
                    <label for="description">Beskrivning</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('description') != "" ? "is-invalid" : ""  ?>" name=" description" value="<?php echo $title ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('description');  ?></span>
                </div>
                <div class="form-group">
                    <label for="price">Pris</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('price') != "" ? "is-invalid" : ""  ?>" name="price" value="<?php echo $price ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('price');  ?></span>
                </div>
                <div class="form-group">
                    <label for="stock">Lagerstatus</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('title') != "" ? "is-invalid" : ""  ?>" name="stock" value="<?php echo $stock ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('stock');  ?></span>
                </div>
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('category') != "" ? "is-invalid" : ""  ?>" <?php echo $v->get_error_message('category') != "" ? "is-invalid" : ""  ?>" name="category" value="<?php echo $category ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('category');  ?></span>
                </div>
                <div class="form-group">
                    <label for="img">Bildkälla</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('img') != "" ? "is-invalid" : ""  ?>" name="img" value="<?php echo $img ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('img');  ?></span>
                </div>
                <div class="form-group">
                    <label for="popularity">Popularitet</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('popularity') != "" ? "is-invalid" : ""  ?>" name="popularity" value="<?php echo $popularity ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('popularity');  ?></span>
                </div>
                <div class="my-2">
                    <input type="submit" class="btn btn-dark my-6" value="Spara produkt">
                </div>
            </form>
            <div class="mb-5">
                <a href="/admin" class="btn btn-dark py-8">Tillbaka till adminsidan</a>
            </div>
        </div>
    </section>



    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>

</body>

</html>