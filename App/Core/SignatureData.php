<?php

namespace App\Core;

use App\Core\Exception\InvalidArgument;

class SignatureData
{
    public array $phones;
    public array $emails;
    public array $fullName;

    /**
     * @throws InvalidArgument
     */
    public function __construct(array $postData)
    {
        extract($postData);
        $this->phones = $phones;
        $this->emails = $emails;
        $this->fullName = $name;
        $this->validatePhone();
        $this->validateEmail();
        $this->validateName();
    }

    /**
     * @throws InvalidArgument
     */
    private function validatePhone(): void
    {
        foreach ($this->phones as $phone) {
            if ($phone === '') {
                continue;
            }
            if (!preg_match('/^\d+$/', $phone)) {
                throw new InvalidArgument('Номер должен содержать только цифры');
            }
            if (!preg_match('/^\d{12}$/', $phone)) {
                throw new InvalidArgument('Не верное количество цифр должно быть 12 введено ' . strlen($phone));
            }
        }
    }

    private function validateEmail(): void
    {
        foreach ($this->emails as $email) {
            if ($email === '') {
                continue;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgument('Неверный email');
            }
        }
    }

    private function validateName(): void
    {
        foreach ($this->fullName as $name) {
            if ($name === '') {
                continue;
            }
            if (!preg_match('/^[A-Za-zА-Яа-яЁё]+$/u', $name)) {
                throw new InvalidArgument('В фамилии и имени должны быть только буквы');
            }
        }
    }

    public function getName(): string
    {
        $firstName = mb_substr($this->fullName[1], 0, 1) . '.';
        $lastName = $this->fullName[2] !== '' ? mb_substr($this->fullName[2], 0, 1) . '.' : '';

        return mb_convert_case($this->fullName[0], MB_CASE_TITLE, "UTF-8") .
            ' ' .
            mb_convert_case($firstName, MB_CASE_TITLE, "UTF-8") .
            mb_convert_case($lastName, MB_CASE_TITLE, "UTF-8");
    }
}
