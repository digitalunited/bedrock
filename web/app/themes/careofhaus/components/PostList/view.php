<?php
$sb = new \Component\Sidebar(['theme' => 'archive']);
echo $sb->render();
?>

<div class="col-xs-12 col-sm-12 col-md-9 col-md-pull-3 posts">
    <?php
    if ($hits) {
        foreach ($hits as $hit) {
            echo $hit;
        }
    }
    else {
        echo '<div class="alert alert-warning" role="alert">'
            . $component->getErrorMessage()
            . '<div>';
    }
    ?>

</div>
<?php if ($prev_button || $next_button) { ?>
    <div class="ajax__buttons col-sm-12 col-md-9">
        <?= $prev_button
            ? '<div class="prev nav-wrapper">' . $prev_button . '</div>'
            : ''; ?>

        <?= $next_button
            ? '<div class="next nav-wrapper">' . $next_button . '</div>'
            : ''; ?>
    </div>
<?php } ?>
