<?php
// ONCE = en gång även om det blir cirkelreferenser
#include_once("Models/Products.php") - OK även om filen inte finns
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");

$dbContext = new Database();
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
    <?php Nav(); ?>
    <!-- Header-->
    <header style="background-image: url('https://images.unsplash.com/photo-1618221381711-42ca8ab6e908?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; height: 80vh; display: flex; align-items: center; justify-content: center;">
        <div class="containertext-center ">
            <h1 class="display-4 fw-bolder text-white">Postergalleriet</h1>
            <p class="lead fw-normal text-white-50 mb-0">Skapa din egen väggkonst</p>
        </div>
    </header>
    <div class="w-100 banner d-flex justify-content-center align-items-center text-white text-center" style="height: 100px;">
        <div>
            <h2 class="mb-2">30% rabatt på alla posters*</h2>
            <p class="mb-0">*Använd koden <strong>POSTER30</strong> i kassan – gäller till och med 30 april.</p>
        </div>
    </div>
    <!-- Section-->
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row justify-content-center my-4">
                <div class="col-md-6 text-center">
                    <h2 class="mb-3">Nyheter</h2>
                    <p>Utforska våra senaste posters och kollektioner – designade för att ge ditt hem en personlig och stilren touch.</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-spacebetween">
                <?php
                foreach ($dbContext->getAllProducts() as $prod) {
                ?>
                    <div class="col mb-5">
                        <div class="card h-100 shadow-sm py-3">
                            <?php if ($prod->price < 10) {  ?>
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <?php } ?>
                            <!-- Product image-->
                            <img class="card-img-top" src="<?php echo $prod->imageUrl; ?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="py-2"><?php echo $prod->title; ?></h5>
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <?php
                                        // Antal stjärnor som ska visas
                                        $popularityFactor = $prod->popularityFactor;

                                        // Loop för att skapa stjärnorna baserat på popularityFactor
                                        for ($i = 1; $i <= 5; $i++) {
                                            // Om $i är mindre än eller lika med popularityFactor, visa en fylld stjärna
                                            echo ($i <= $popularityFactor)
                                                ? '<i class="bi bi-star-fill me-1"></i>'  // Fylld stjärna
                                                : '<i class="bi bi-star me-1"></i>';      // Tom stjärna
                                        }
                                        ?>
                                    </div>
                                    <!-- Product price-->
                                    <?php echo $prod->price; ?> kr
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer bg-transparent py-2">
                                <div class="text-center">
                                    <a class="btn bg-dark mt-auto text-white" href="/productdetails?id=<?php echo $prod->id; ?>">Köp nu</a>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
    </section>
    <div class="w-100 banner d-flex justify-content-center align-items-center text-white text-center" style="height: 100px;">
        <div>
            <h2 class="mb-2">4 för 3 på alla posters</h2>
            <p class="mb-0">Lägg fyra posters i varukorgen – du får den billigaste på köpet. Gäller t.o.m. 30 april.</p>
        </div>
    </div>
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div>
                <h3>Tavlor Online hos Postergalleriet</h3>
                <p>Välkommen till Postergalleriet – din destination för stilrena och trendiga tavlor online! Vi erbjuder ett brett sortiment av posters och konstverk i olika stilar, perfekt för att förvandla ditt hem till ett personligt galleri.</p>
            </div>
            <div>
                <h3>Skapa din egen tavelvägg</h3>
                <p>Med våra tavlor kan du enkelt skapa en unik tavelvägg som speglar din personliga stil. Välj bland moderna fotoposters, abstrakta motiv, svartvita klassiker och mycket mer. Kombinera olika storlekar och ramar för att skapa en dynamisk och inspirerande vägg.</p>
            </div>
            <div>
                <h3>Tavlor för alla rum</h3>
                <p>Oavsett om du inreder vardagsrummet, sovrummet, hallen eller kontoret har vi tavlor som passar. Vårt sortiment är noggrant utvalt för att erbjuda något för varje smak och inredningsstil.</p>
            </div>
            <div>
                <h3>Unika motiv och hög kvalitet</h3>
                <p>Vi samarbetar med talangfulla konstnärer och fotografer för att erbjuda exklusiva motiv som du inte hittar någon annanstans. Alla våra posters trycks på högkvalitativt papper för att säkerställa lång hållbarhet och skarpa detaljer.</p>
            </div>
            <div>
                <h3>Inspiration och tips</h3>
                <p>Behöver du inspiration? Utforska våra inspirationssidor där vi visar olika sätt att kombinera tavlor och skapa harmoniska tavelväggar. Följ oss på sociala medier för dagliga tips, nyheter och exklusiva erbjudanden.</p>

                <p>Skapa ditt eget galleri hemma med Postergalleriet – där konst möter personlig stil!</p>
            </div>
        </div>
    </section>
    </div>


    <!-- Footer-->
    <?php Footer(); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>