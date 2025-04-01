<?php
require_once("Models/Database.php");

function Nav()
{
    $dbContext = new Database(); // Flytta in i funktionen
?>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="/">BasicWear</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategorier</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">Alla Produkter</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <?php
                            $categories = $dbContext->getAllCategories();
                            if ($categories) {
                                foreach ($categories as $cat) {
                                    echo "<li><a class='dropdown-item' href='#!'>$cat</a></li>";
                                }
                            } else {
                                echo "<li><a class='dropdown-item' href='#!'>Inga kategorier tillgängliga</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#!">Logga in</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Skapa konto</a></li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Kassa
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
<?php
}
?>