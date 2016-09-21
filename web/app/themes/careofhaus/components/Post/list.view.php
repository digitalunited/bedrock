<div class="row">
    <?php if (!empty($imgId)) { ?>
        <div class="col-sm-6">
            <?= \CoH\ResponsiveImage::render([
                'imgId' => $imgId,
                'output' => 'img',
                'ratio' => '16x9',
                'wrapperAttributes' => [
                    'class' => ['visible-lg'],
                ],
            ]) ?>

            <?= \CoH\ResponsiveImage::render([
                'imgId' => $imgId,
                'output' => 'img',
                'ratio' => '9x16',
                'wrapperAttributes' => [
                    'class' => ['visible-md visible-sm'],
                ],
            ]) ?>

            <?= \CoH\ResponsiveImage::render([
                'imgId' => $imgId,
                'output' => 'img',
                'ratio' => '16x9',
                'wrapperAttributes' => [
                    'class' => ['visible-xs'],
                ],
            ]) ?>
        </div>
    <?php } ?>
    <div class="<?= !empty($imgId) ? 'col-sm-6' : 'col-sm-12' ?>">
        <div class="component-post--list__body <?= !empty($imgId) ? '' : 'full' ?>">
            <div class="meta">
                <time class="date" datetime="<?= get_post_time('c', true); ?>">
                    <?= $component->getPostDate('Y-m-d') ?>
                </time>
            </div>

            <?= (new \Component\Heading([
                'heading' => $component->getHeadline(),
                'tag' => 'h2',
                'size' => 'h1',
                'theme' => 'heading-left',
                'color' => 'standard',
                'link' => $component->getPermalink()
            ]))->render() ?>
            <a href="<?= $component->getPermalink() ?>" class="title-link">
            </a>

            <p><?= $component->getExcerpt(40) ?></p>

            <a href="<?= $component->getPermalink() ?>" class="read-more btn--link">
                <?= __('read.more', 'components') ?>
            </a>
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
        </div>
    </div>
</div>
