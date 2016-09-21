<?php

$content = new \Component\SearchResult(['s' => $_GET['s']]);
echo new \Component\row([], $content);
