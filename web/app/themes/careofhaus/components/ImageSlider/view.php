<?php
$imagesliders = $component->getImageUrls();
if ($imagesliders) {
    ?>
    <div class="slider-wrapper">
        <?php foreach ($imagesliders as $imageslider) { ?>
            <div>
                <img src="<?= $imageslider ?>" alt="" class="image">
            </div>
        <?php } ?>
    </div>
<?php } ?>

