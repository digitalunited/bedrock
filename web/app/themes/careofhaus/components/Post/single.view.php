<div class="col-xs-12">
    <?= (new \Component\Heading([
        'heading' => $component->getHeadline(),
        'tag' => 'h1',
        'size' => 'h1',
        'theme' => 'heading-center',
        'max_width' => '500px'
    ]))->render() ?>

    <?= (new \Component\Ingress([
        'text' => $component->getExcerpt()
    ]))->render() ?>


    <p class="date"><?= $component->getPostDate('Y-m-d') ?></p>


    <?php
    $tags = $component->getPostTags();
    if ($tags) {
        echo '<div class="tags">';
        echo '<i class="icon icon-tag"></i>';

        foreach ($tags as $num => $tag) {
            echo '<span class="tag"><a href="' . get_term_link($tag) . '">' . $tag->name . '</a></span>';
            if ($num + 1 < count($tags)) {
                echo ', ';
            }
        }
        echo '</div>';
    }
    ?>

    <?= $image ?>


    <div class="row">
        <?= $post->post_content ?>
    </div>

    <!--    <div class="row">-->
    <!--        <div class="col-xs-12">-->
    <!--            <nav>-->
    <!--                <hr>-->
    <!--                --><?php //if (($prevLink = $component->getPrevPostLink())) { ?>
    <!--                    <a href="--><? //= $prevLink ?><!--" class="btn--link prev-post"><span-->
    <!--                            class="icon icon-arrow_left"></span>-->
    <? //= __('prev.posts', 'components') ?><!--</a>-->
    <!--                --><?php //} ?>
    <!--                --><?php //if (($nextLink = $component->getNextPostLink())) { ?>
    <!--                    <a href="--><? //= $nextLink ?><!--" class="btn--link next-post">-->
    <? //= __('next.posts', 'components') ?><!--<span-->
    <!--                            class="icon icon-arrow_right"></span></a>-->
    <!--                --><?php //} ?>
    <!--            </nav>-->
    <!--        </div>-->
    <!--    </div>-->

</div>
