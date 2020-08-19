<?php
require 'config/autoload.php';

use App\UI\AppController;

try {
    $controller = new AppController();
    $url = $controller->readShortUrl();
    if($url) {
        header("Location: $url");
    }
}
catch (Exception $e) {
    // log exception and then redirect to error page.
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div>
    <form id="form" method="POST">
        <label for="url">Введите url</label>
        <input type="text" name="url" id="url">
        <br>
        <label for="date_end">Введите дату окончания</label>
        <input name="date_end" id="date_end" type="datetime-local">
        <button>Получить короткий url</button>
    </form>
    <div><p id="response_message"></p></div>
</div>

<div>
    <form id="form" method="GET" action="counter.php">
        <label for="url">Введите url</label>
        <input type="text" name="url" id="url">
        <br>
        <button>Получить статистику</button>
    </form>
    <div><p id="response_message"></p></div>
</div>


<script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>


<script>
    $('#form').submit(function(){
        $.post(
            'script.php',
            $("#form").serialize(),

            function(msg) { // получен ответ сервера
                $('#response_message').text(JSON.parse(msg).message)
            }
        );
        return false;
    });

</script>

</body>
</html>