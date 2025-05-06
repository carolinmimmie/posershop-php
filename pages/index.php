<?php
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("components/Slider.php");
require_once("components/Head.php");
require_once("Models/Database.php");
require_once("Models/Cart.php");

global $dbContext, $cart;

?>
<!DOCTYPE html>
<html lang="en">
<?php Head(); ?>

<body>
    <?php Nav($dbContext, $cart); ?>
    <header style="background-image: url('https://images.unsplash.com/photo-1618221381711-42ca8ab6e908?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; height: 80vh; display: flex; align-items: center; justify-content: center;">
        <div class="containertext-center ">
            <h1 class="display-4 fw-bolder text-white">Postergalleriet</h1>
            <p class="lead fw-normal text-white-50 mb-0 text-center">Skapa din egen väggkonst</p>
        </div>
    </header>
    <div class="w-100 banner d-flex justify-content-center align-items-center text-white text-center px-3" style=" height: 180px;">
        <div>
            <h2 class="mb-3" style="font-size: 1.8rem; font-weight: 600;"> ✨ 30% rabatt på alla posters ✨</h2>
            <p class="mb-0" style="font-size: 1rem;">
                <span>*Använd koden </span><strong style="background-color: #ffffff55; padding: 0.2em 0.4em; border-radius: 5px;">POSTER30</strong><span> i kassan – gäller till och med 30 april.</span>
            </p>
        </div>
    </div>
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row justify-content-center my-4">
                <div class="col-md-6 text-center">
                    <h2 class="mb-3">Nyheter</h2>
                    <p>Färska favoriter för ditt hem! Hitta inspiration bland våra nyaste posters.</p>

                </div>
            </div>
            <?php Slider($dbContext->getAllProducts(), "productCarouselNews"); ?>
    </section>
    <div class="w-100 banner d-flex justify-content-center align-items-center text-white text-center" style="height: 200px; background: linear-gradient(to right, #f8cfd5, #f6a5b3); padding: 2rem;">
        <div>
            <h2 class="mb-3 fw-bold" style="font-size: 1.8rem;">✨ Nyhet! Skapa din egna väggkonst ✨</h2>
            <p class="mb-2" style="font-size: 1rem;">Mix & match dina favoritmotiv och bygg ett personligt galleri hemma.</p>
            <p class="mb-0" style="font-size: 1rem;">Testa vårt nya verktyg för väggplanering – direkt i shoppen!</p>
        </div>
    </div>

    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row justify-content-center my-4">
                <div class="col-md-6 text-center">
                    <h2 class="mb-3">Populärast just nu</h2>
                    <p>Våra mest omtyckta posters – handplockade favoriter som gör skillnad i varje rum.</p>

                </div>
            </div>
            <?php Slider($dbContext->getPopularProducts(), "productCarousel"); ?>
    </section>
    <div class="w-100 banner d-flex justify-content-center align-items-center text-center text-white" style="background-color:rgb(238, 172, 188); height: 250px; color:rgb(129, 45, 83); padding: 2rem;">
        <div>
            <h2 class="mb-3 fw-bold" style="font-size: 1.8rem;">✨ Ge dina väggar personlighet ✨</h2>
            <p class="mb-2" style="font-size: 1rem;">Upptäck unika posters som får ditt hem att kännas mer som *du*.</p>
            <p class="mb-2" style="font-size: 1rem;">Från abstrakt konst till ikoniska citat – vi har något för varje stil!</p>
            <p class="mb-3" style="font-size: 1rem;">Fri frakt vid köp över 299 kr</p>
        </div>
    </div>
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div>
                <h3 style="font-size: 1.25rem;">Skapa din egen tavelvägg</h3>
                <p style="font-size: 0.95rem;">Med våra tavlor kan du enkelt skapa en unik tavelvägg som speglar din personliga stil. Välj bland moderna fotoposters, abstrakta motiv, svartvita klassiker och mycket mer. Kombinera olika storlekar och ramar för att skapa en dynamisk och inspirerande vägg.</p>
            </div>
            <div>
                <h3 style="font-size: 1.25rem;">Tavlor för alla rum</h3>
                <p style="font-size: 0.95rem;">Oavsett om du inreder vardagsrummet, sovrummet, hallen eller kontoret har vi tavlor som passar. Vårt sortiment är noggrant utvalt för att erbjuda något för varje smak och inredningsstil.</p>
            </div>
            <div>
                <h3 style="font-size: 1.25rem;">Unika motiv och hög kvalitet</h3>
                <p style="font-size: 0.95rem;">Vi samarbetar med talangfulla konstnärer och fotografer för att erbjuda exklusiva motiv som du inte hittar någon annanstans. Alla våra posters trycks på högkvalitativt papper för att säkerställa lång hållbarhet och skarpa detaljer.</p>
            </div>
            <div>
                <h3 style="font-size: 1.25rem;">Inspiration och tips</h3>
                <p style="font-size: 0.95rem;">Behöver du inspiration? Utforska våra inspirationssidor där vi visar olika sätt att kombinera tavlor och skapa harmoniska tavelväggar. Följ oss på sociala medier för dagliga tips, nyheter och exklusiva erbjudanden.</p>

                <p style="font-size: 0.95rem;">Skapa ditt eget galleri hemma med Postergalleriet – där konst möter personlig stil!</p>
            </div>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>