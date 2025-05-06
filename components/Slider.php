<?php
function Slider($products, $carouselId = "productCarousel")
{
    $chunks = array_chunk($products, 3);
?>
    <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($chunks as $index => $productChunk) { ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="row gx-4 gx-lg-5 d-flex flex-nowrap overflow-auto">
                        <?php foreach ($productChunk as $prod) { ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm py-3">
                                    <?php if ($prod->price < 10) { ?>
                                        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                    <?php } ?>
                                    <img class="card-img-top" src="<?php echo $prod->imageUrl; ?>" alt="..." />
                                    <div class="card-body">
                                        <div class="text-center">
                                            <h5 class="py-2"><?php echo $prod->title; ?></h5>
                                            <div class="d-flex justify-content-center small text-warning mb-2">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo ($i <= $prod->popularityFactor)
                                                        ? '<i class="bi bi-star-fill me-1"></i>'
                                                        : '<i class="bi bi-star me-1"></i>';
                                                }
                                                ?>
                                            </div>
                                            <?php echo $prod->price; ?> kr
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent py-2">
                                        <div class="text-center">
                                            <a class="btn bg-dark mt-auto text-white" href="/productdetails?id=<?php echo $prod->id; ?>">Köp nu</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
            <span class="visually-hidden">Föregående</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
            <span class="visually-hidden">Nästa</span>
        </button>
    </div>
<?php
}
?>