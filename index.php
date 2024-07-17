<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roistat</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
</head>
<body>
    <div class="container">
        <?php 
        // Создать страницу и добавить на неё форму из 4-х полей: имя, email, телефон, цена
        $fields = [ ['name' => 'name', 'type' => 'text', 'text' => 'Имя'], ['name' => 'email', 'type' => 'email', 'text' => 'email'], ['name' => 'telephone', 'type' => 'text', 'text' => 'Телефон'], ['name' => 'price', 'type' => 'text', 'text' => 'Цена']];
            foreach ($fields as $field) {
                echo "<div class=\"row g-2 align-items-center mb-3\">
                    <div class=\"col-auto\">
                        <label for=\"{$field['name']}\" class=\"col-form-label\">{$field['text']}</label>
                    </div>
                    <div class=\"col-auto\">
                        <input type=\"{$field['type']}\" id=\"{$field['name']}\" class=\"form-control\">
                    </div>
                    </div>";
            }
        ?>
    <button type="button" class="btn btn-success" onclick="send()">Отправить</button>
    </div>
</body>
<script src="main.js"></script>
</html>