<?php

use App\Core\Exception\InvalidArgument;
use App\Core\SignatureData;
use App\Core\SignatureGenerator;
use App\View\View;

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});
$view = new View();
try {
    if (!empty($_POST)) {
        $data = new SignatureData($_POST);
        $generator = new SignatureGenerator($data);
        $signature = $generator->generateHtml();

        if ($_POST['preview']) {
            echo $signature;
            exit();
        }
    }
    $view->renderHtml();
} catch (InvalidArgument $e) {
    $view->renderHtml(['error' => $e->getMessage()],400);
    return;
}
