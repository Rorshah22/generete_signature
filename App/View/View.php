<?php

namespace App\View;

class View
{
    public function renderHtml(array $vars = [], int $code = 200): void
    {
        extract($vars);
        http_response_code($code);

        ob_start();
        include __DIR__ . '/../../template/view.php';
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }
}