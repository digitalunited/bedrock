<?php
if ($link->url) {
    echo $link->renderTag($image);
}
else {
    echo $image;
}
