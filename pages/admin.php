<?php
require_once("Models/Product.php");
require_once("Models/Database.php");
require_once("components/Footer.php");
require_once("components/Head.php");
require_once("components/Nav.php");

global $dbContext, $cart;

$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";

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
                    <th>Produktnamn
                        <a href="admin?sortCol=title&sortOrder=asc"><i class="bi bi-arrow-down-circle-fill"></i></a>
                        <a href="admin?sortCol=title&sortOrder=desc"><i class="bi bi-arrow-up-circle-fill"></i></a>
                    </th>
                    <th>Kategori <a href="admin?sortCol=categoryName&sortOrder=asc"><i class="bi bi-arrow-down-circle-fill"></i></a>
                        <a href="admin?sortCol=categoryName&sortOrder=desc"><i class="bi bi-arrow-up-circle-fill"></i></a>
                    </th>
                    <th>Pris <a href="admin?sortCol=price&sortOrder=asc"><i class="bi bi-arrow-down-circle-fill"></i></a>
                        <a href="admin?sortCol=price&sortOrder=desc"><i class="bi bi-arrow-up-circle-fill"></i></a>
                    </th>
                    <th>Lagersaldo <a href="admin?sortCol=stock&sortOrder=asc"><i class="bi bi-arrow-down-circle-fill"></i></a>
                        <a href="admin?sortCol=stock&sortOrder=desc"><i class="bi bi-arrow-up-circle-fill"></i></a>
                    </th>
                    <th>Popularitet <a href="admin?sortCol=popularity&sortOrder=asc"><i class="bi bi-arrow-down-circle-fill"></i></a>
                        <a href="admin?sortCol=popularity&sortOrder=desc"><i class="bi bi-arrow-up-circle-fill"></i></a>
                    </th>
                    <th>Modifiera</th>
                </thead>

                <tbody>
                    <?php foreach ($dbContext->getAllProducts($sortCol, $sortOrder) as $prod) { ?>
                        <tr>
                            <td><?php echo $prod->title; ?></td>
                            <td><?php echo $prod->category; ?></td>
                            <td><?php echo $prod->price; ?></td>
                            <td><?php echo $prod->stock; ?></td>
                            <td><?php echo $prod->popularity; ?></td>
                            <td><a href="/admin/edit?pimId=<?php echo $prod->pimId; ?>" class="btn btn-dark">Ändra</a></td>
                            <td><a href="/admin/delete?pimId=<?php echo $prod->pimId; ?>" class=" btn btn-danger">Radera</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="text-end">
                <a href="/admin/new" class="btn btn-dark">Skapa ny produkt</a>
            </div>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>