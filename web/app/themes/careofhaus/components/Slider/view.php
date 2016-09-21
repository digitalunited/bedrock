<?php foreach ($slides as $num => $slide) { ?>
    <div class="slide slide<?= $num ?>">
        <?= do_shortcode($slide->post_content) ?>
    </div>
<?php } ?>
