<?php

namespace App\Core;

use App\Core\ColorEnum;
use App\Core\SignatureData;

class SignatureGenerator
{
    private SignatureData $data;

    public function __construct(SignatureData $data)
    {
        $this->data = $data;
    }

    public function generateHtml(): string
    {
        $first = $this->signature(ColorEnum::RED);
        $second = $this->signature(ColorEnum::GREEN);
        file_put_contents('signature.html', $first . $second);
        return $first . $second;
    }

    private function signature(ColorEnum $colorEnum)
    {
        $color = $colorEnum->value;
        $name = $this->data->getName();
        $phone1 = $this->formatPhone($this->data->phones[0]);
        $phone2 = $this->formatPhone($this->data->phones[1]);
        $email1 = $this->data->emails[0];
        $email2 = $this->data->emails[1];

        // Создаем HTML-код для подписи
        return require __DIR__ . '/../../template/email.php';
    }

    private function formatPhone(string $phone): string
    {
        $phone = str_replace(['+', ' ', ')', '(', '-'], '', $phone);
        return preg_replace('/(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})/', '$1 ($2) $3-$4-$5', $phone);
    }

}
