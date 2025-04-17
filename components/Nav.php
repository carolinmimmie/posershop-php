<?php
require_once("Models/Database.php");

function Nav()
{
    $dbContext = new Database(); // Flytta in i funktionen
    $q = $_GET['q'] ?? "";
?>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light nav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="/">Postergalleriet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Posters</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/products">Alla posters</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <?php
                            foreach ($dbContext->getAllCategories() as $cat) {
                                echo "<li><a class='dropdown-item' href='/products?catname=$cat'>$cat</a></li>";
                            }
                            ?>

                        </ul>
                    </li>
                    <?php
                    if ($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) { ?>

                        <li class="nav-item"><a class="nav-link" href="/user/logout">Logga ut</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="nav-link" href="/user/login">Logga in</a></li>
                        <li class="nav-item"><a class="nav-link" href="/user/register">Skapa konto</a></li>
                    <?php
                    }
                    ?>
                </ul>
                <?php if ($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) { ?>
                    Välkommen <?php echo $dbContext->getUsersDatabase()->getAuth()->getUsername() ?>
                <?php } ?>
                <form action="/search" method="GET" class="d-flex gap-3">
                    <input type="text" name="q" value="<?php echo $q; ?>" placeholder="Sök"
                        class="form-control">
                    <button class="btn btn-outline-dark " type="submit">Ok</button>
                </form>
            </div>
        </div>
    </nav>
<?php
}
?>