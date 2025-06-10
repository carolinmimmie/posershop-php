<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");
require_once("components/Head.php");
require_once("Utils/Validator.php");

$id = $_GET['pimId'];
global $dbContext, $cart;
$productUpdateMessage = "";
$product = $dbContext->getProduct($id);
$v = new Validator($_POST);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product->title = $_POST['title'];
    $product->stock = $_POST['stock'];
    $product->price = $_POST['price'];
    $product->category = $_POST['category'];
    $product->img = $_POST['img'];
    $product->popularity = $_POST['popularity'];
    $dbContext->updateProduct($product);
    $productUpdateMessage = "Produkten har uppdaterats i databasen";

    $v->field('title')->required()->alpha_num([' '])->min_len(3)->max_len(50);
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
        $dbContext->updateProduct($product);
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
            <?php if ($productUpdateMessage): ?>
                <div class="alert alert-success">
                    <?php echo $productUpdateMessage; ?>
                </div>
            <?php endif; ?>

            <?php

            $id = $_GET['pimId'];

            ?>
            <h2>Ändra produkt</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="title">Produkt</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('title') != "" ? "is-invalid" : ""  ?>" name=" title" value="<?php echo $product->title ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('title');  ?></span>
                </div>
                <div class="form-group">
                    <label for="price">Pris</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('price') != "" ? "is-invalid" : ""  ?>" name="price" value="<?php echo $product->price ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('price');  ?></span>
                </div>
                <div class="form-group">
                    <label for="stock">Lagerstatus</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('stock') != "" ? "is-invalid" : ""  ?>" name="stock" value="<?php echo $product->stock ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('stock');  ?></span>
                </div>
                <div class="form-group">
                    <label for="categoryName">Kategori</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('category') != "" ? "is-invalid" : ""  ?>" name="category" value="<?php echo $product->category ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('categoryName');  ?></span>
                </div>
                <div class="form-group">
                    <label for="image">Bildkälla</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('img') != "" ? "is-invalid" : ""  ?>" name="img" value="<?php echo $product->img ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('img');  ?></span>
                </div>
                <div class="form-group">
                    <label for="popularity">Popularitet</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('popularity') != "" ? "is-invalid" : ""  ?>" name="popularity" value="<?php echo $product->popularity ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('popularity');  ?></span>
                </div>
                <div class="my-2">
                    <input type="submit" class="btn btn-dark" value="Uppdatera">
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