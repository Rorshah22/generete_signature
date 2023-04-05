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

    private function signature(ColorEnum $colorEnum): string
    {
        return "<div style='color: {$colorEnum->value};'>
                    <p>__________________</p>
                    <p>С уважением,
                    <br>
                    {$this->data->getName()}
                    <br>
                    Тел:
                    <br>
                    <a style='text-decoration: none' href='tel:{$this->formatPhone($this->data->phones[0])}'>{$this->formatPhone($this->data->phones[0])}</a>
                    <br>
                    <a style='text-decoration: none' href='tel:{$this->formatPhone($this->data->phones[1])}'>{$this->formatPhone($this->data->phones[1])}</a>
                    </p>
                    <p>E-Mail:
                    <br>
                    <a href='mailto:{$this->data->emails[0]}'>{$this->data->emails[0]}</a>
                    <br>
                    <a href='mailto:{$this->data->emails[1]}'>{$this->data->emails[1]}</a></p>
                </div>";
    }

    private function formatPhone(string $phone): string
    {
        $phone = str_replace(['+', ' ', ')', '(', '-'], '', $phone);
        return preg_replace('/(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})/', '$1 ($2) $3-$4-$5', $phone);
    }

}
