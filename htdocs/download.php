<?php

$file = __DIR__ . '/signature.html';
if (file_exists($file)) {
    ob_end_clean();
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    unlink($file);

    exit();
}
header('Location: /');
