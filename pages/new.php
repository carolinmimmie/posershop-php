<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");
require_once("Utils/Validator.php"); // För validering 


// Hämta den produkt med detta ID
$dbContext = new Database();

$productSavedMessage = "";
$v = new Validator($_POST); // VALIDERINGEN

$title = "";
$stockLevel = "";
$price = "";
$categoryName = "";
$imageUrl =  "";
$popularityFactor = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Här kommer vi när man har tryckt  på SUBMIT
    // IMORGON TISDAG SÅ UPDATE PRODUCT SET title = $_POST['title'] WHERE id = $id
    $title = $_POST['title'];
    $stockLevel = $_POST['stockLevel'];
    $price = $_POST['price'];
    $categoryName = $_POST['categoryName'];
    $imageUrl = $_POST['imageUrl'];
    $popularityFactor = $_POST['popularityFactor'];


    // Här ska det valideras - SERVERSIDE validering
    $v->field('title')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('stockLevel')->required()->numeric()->min_val(0);
    $v->field('price')->required()->numeric()->min_val(0);
    $v->field('categoryName')->required()->alpha_num([''])->min_len(3)->max_len(50);
    $v->field('popularityFactor')->required()->numeric()->min_val(0);

    // om ok så spara i databas
    if ($v->is_valid()) {

        // SKICKA MAILET!!!
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
        // OK - spara i databas
        $dbContext->insertProduct($title, $stockLevel, $price, $categoryName, $imageUrl, $popularityFactor);
        $productSavedMessage = "Produkten har sparats i databasen";
        // header("Location: /admin");
        // exit;
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
    <title>Postergalleriet</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <?php Nav(); ?>
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
                    <label for="title">Produkt</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('title') != "" ? "is-invalid" : ""  ?>" name=" title" value="<?php echo $title ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('title');  ?></span>
                </div>
                <div class="form-group">
                    <label for="price">Pris</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('price') != "" ? "is-invalid" : ""  ?>" name="price" value="<?php echo $price ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('price');  ?></span>
                </div>
                <div class="form-group">
                    <label for="stockLevel">Lagerstatus</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('title') != "" ? "is-invalid" : ""  ?>" name="stockLevel" value="<?php echo $stockLevel ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('stockLevel');  ?></span>
                </div>
                <div class="form-group">
                    <label for="categoryName">Kategori</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('categoryName') != "" ? "is-invalid" : ""  ?>" <?php echo $v->get_error_message('categoryName') != "" ? "is-invalid" : ""  ?>" name="categoryName" value="<?php echo $categoryName ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('categoryName');  ?></span>
                </div>
                <div class="form-group">
                    <label for="imageUrl">Bildkälla</label>
                    <input type="text" class="form-control  <?php echo $v->get_error_message('imageUrl') != "" ? "is-invalid" : ""  ?>" name="imageUrl" value="<?php echo $imageUrl ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('imageUrl');  ?></span>
                </div>
                <div class="form-group">
                    <label for="popularityFactor">Popularitet</label>
                    <input type="number" class="form-control  <?php echo $v->get_error_message('popularityFactor') != "" ? "is-invalid" : ""  ?>" name="popularityFactor" value="<?php echo $popularityFactor ?>">
                    <span class="invalid-feedback"><?php echo $v->get_error_message('popularityFactor');  ?></span>
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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

</body>

</html>