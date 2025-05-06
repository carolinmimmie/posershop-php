<?php
function ProductCard($products)
{
?>
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-spacebetween">
        <?php foreach ($products as $prod) { ?>
            <div class="col mb-5">
                <div class="card h-100 shadow-sm py-3">
                    <?php if ($prod->price < 10) {  ?>
                        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                    <?php } ?>

                    <img class="card-img-top" src="<?php echo $prod->imageUrl; ?>" alt="..." />
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="py-2"><?php echo $prod->title; ?></h5>
                            <div class="d-flex justify-content-center small text-warning mb-2">
                                <?php
                                $popularityFactor = $prod->popularityFactor;
                                for ($i = 1; $i <= 5; $i++) {
                                    echo ($i <= $popularityFactor)
                                        ? '<i class="bi bi-star-fill me-1"></i>'
                                        : '<i class="bi bi-star me-1"></i>';
                                }
                                ?>
                            </div>
                            <?php echo $prod->price; ?> kr
                        </div>
                    </div>
                    <div class="card-footer bg-transparent py-2">
                        <div class="text-center"><a class="btn bg-dark mt-auto text-white" href="/productdetails?id=<?php echo $prod->id; ?>">Köp nu</a></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
}
?>