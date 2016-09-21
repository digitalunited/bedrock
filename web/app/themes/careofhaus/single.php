<?php
$content = new \Component\Post([
    'post' => get_post(),
    'view' => 'single',
]);
echo new \Component\row([], $content);