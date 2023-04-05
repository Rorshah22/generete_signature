<?php

use App\Core\ColorEnum;
use App\Core\SignatureGenerator;

/**
 * @var $color ColorEnum;
 * @var $name  SignatureGenerator;
 * @var $phone1 SignatureGenerator;
 * @var $phone2 SignatureGenerator;
 * @var $email1 SignatureGenerator;
 * @var $email2 SignatureGenerator;
 */

return "
<div style='color: {$color};'>
    <p>__________________</p>
    <p>С уважением,
        <br>
        {$name}
        <br>
        Тел:
        <br>
        <a style='color: {$color};' href='tel:{$phone1}'>{$phone1}</a>
        <br>
        <a style='color: {$color};' href='tel:{$phone2}'>{$phone2}</a>
    </p>
    <p>E-Mail:
        <br>
        <a style='color: {$color};' href='mailto:{$email1}'>{$email1}</a>
        <br>
        <a style='color: {$color};' href='mailto:{$email2}'>{$email2}</a></p>
</div>
";
