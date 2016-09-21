<?php
global $post;

$localpath = get_attached_file($post->ID);

if (!file_exists($localpath)) {
    exit;
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($localpath));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($localpath));
ob_clean();
flush();
readfile($localpath);
exit;
