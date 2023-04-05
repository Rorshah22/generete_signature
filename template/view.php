<?php
if (!empty($error)): ?>
    <p class="alert alert-warning"><?= $error ?></p>
    <?php die();
endif;
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container-sm" style="max-width: 600px">
<header>
    <a class="m-5" href="https://github.com/Rorshah22/generete_signature">Исходный код</a>
</header>

<form id="form" class="mt-3  p-5" action="/" method="post">

    <span id="error"></span>
    <div class="mb-3">
        <label class="form-label" for="surname">Фамилия:</label>
        <input class="form-control"
               type="text"
               name="name[]"
               id="surname"
               value="<?= $_POST['surname'] ?? '' ?>"
               pattern="[A-Za-zА-Яа-яЁё]{1,32}"
               placeholder="Иванов"
               required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="first_name">Имя:</label>
        <input class="form-control"
               type="text"
               name="name[]"
               id="first_name"
               value="<?= $_POST['first_name'] ?? '' ?>"
               pattern="[A-Za-zА-Яа-яЁё]{1,32}"
               placeholder="Иван"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="last_name">Отчество:</label>
        <input class="form-control"
               type="text"
               name="name[]"
               id="last_name"
               value="<?= $_POST['last_name'] ?? '' ?>"
               pattern="[A-Za-zА-Яа-яЁё]{1,32}"
               placeholder="Иванович"
        >
    </div>
    <div class="mb-3">
        <label class="form-label" for="phone">Номер телефона с кодом:</label>
        <input class="form-control phone  mb-2"
               type="tel"
               name="phones[]"
               id="phone"
               value="<?= $_POST['phone'][0] ?? '' ?>"
               pattern="[0-9]{12}"
               placeholder="375293332211"
               title="375293332211"
               required>
        <input class="form-control phone  mb-2"
               type="tel"
               name="phones[]"
               id="phone2"
               value="<?= $_POST['phone'][1] ?? '' ?>"
               pattern="[0-9]{12}"
               title="375293332211"
               placeholder="375293332211">
    </div>
    <div class="mb-3">
        <label class="form-label" for="email">Email:</label>
        <input class="form-control mb-2"
               type="email"
               name="emails[]"
               id="email"
               value="<?= $_POST['email'][0] ?? '' ?>"
               pattern="[A-za-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
               placeholder='mail@mail.com'
               title="mail@mail.com"
               required>
        <input class="form-control mb-2"
               type="email"
               name="emails[]"
               id="email2"
               value="<?= $_POST['email'][1] ?? '' ?>"
               pattern="[A-za-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
               title="mail@mail.com"
               placeholder='mail@mail.com'>
        <div id="insert-email"></div>
    </div>


    <div id="link" class="mb-3">
        <input id="view-data-btn" class="btn btn-light" type="button" value="предпросмотр">
        <input id="send-data-btn" class="btn btn-success" type="submit" value="сгенерировать">
    </div>
</form>

<script>

    const viewDataBtn = document.getElementById('view-data-btn');
    const download = document.createElement('a');
    const input = document.getElementById('link');
    const form = document.getElementById('form');

    function getValue() {
        const surname = document.getElementById('surname').value;
        const firstName = document.getElementById('first_name').value;
        const lastName = document.getElementById('last_name').value;
        const phone = document.getElementById('phone').value;
        const phone2 = document.getElementById('phone2').value;
        const email = document.getElementById('email').value;
        const email2 = document.getElementById('email2').value;
        return [surname, firstName, lastName, phone, phone2, email, email2];
    }

    function validate() {
        const [surname, firstName, lastName, phone, phone2, email, email2] = getValue();
        if (surname === ''
            || firstName === ''
            || phone === ''
            || email === ''
        ) {
            alert('Введите данные для предварительного просмотра');
            return false;
        }
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        download.classList.add('btn');
        download.classList.add('btn-success');
        download.innerText = 'Скачать';
        download.href = "download.php";


        if (validate() === false) {
            return;
        }

        const data = new FormData(form)
        fetch("/", {
            method: "POST",
            body: data
        }).then(response => {
            if (response.status === 200) {
                input.appendChild(download);
                download.setAttribute("data-down", 1);
            }
            if (response.status === 400) {
                return response.text();
            }
        }).then((text) => {
            if (text) {
                document.getElementById('error').innerHTML = text;
            }else{
                document.getElementById('error').innerHTML = '';
            }
        });


    })

    document.getElementById('link').addEventListener('click', e =>{
            if (e.target.dataset.down == 1 ){
                form.reset()
                e.target.remove()
            }
    })
    viewDataBtn.addEventListener('click', () => {
        getValue();
        if (validate() === false) {
            return;
        }

        const data = new FormData(form);
        data.append('preview', true);
        let popupContent = '';
        fetch("/", {
            method: "POST",
            body: data
        }).then(response => {
            if (response.status === 200) {
                return response.text();
            }
            if (response.status === 400) {
                return response.text();
            }
        }).then((text) => {
            popupContent = text;
            const popup = window.open('', 'popup', 'width=400,height=400');
            popup.document.open();
            popup.document.write('');
            popup.document.close();
            popup.document.write(popupContent);
        });
    });
</script>
</body>
</html>

