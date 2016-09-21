<h3><?= $faq_category_name ?></h3>
<?php if (!empty($faq_posts)) { ?>
    <ul class="faq__list">
        <?php foreach ($faq_posts as $post) { ?>
            <li class="faq_item">
                <a href="" class="faq_question"><?= $post->post_title ?></a>
                <div class="faq_answer"><?= wpautop($post->post_content) ?></div>
            </li>
        <?php } ?>
    </ul>
    <?php
}
else {
    echo __('component.faq.listing.no.questions', 'components');
}
?>
