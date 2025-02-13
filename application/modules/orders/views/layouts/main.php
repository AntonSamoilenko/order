<?php

use app\modules\orders\assets\OrdersAsset;
use yii\helpers\Html;

// Регистрация ассетов модуля
OrdersAsset::register($this);

$this->title = 'Мой модуль Orders';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->head() ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
<!--    <link href="css/bootstrap.min.css" rel="stylesheet">-->
<!--    <link href="css/custom.css" rel="stylesheet">-->

    <style>
        .label-default{
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
    </style>

    <?php
//    var_dump($this->registerCssFile('@web/modules/orders/assets/css/custom.css', ['depends' => []]));die;
        $this->registerCssFile('@web/modules/orders/assets/css/custom.css', ['depends' => []]);
        $this->registerCssFile('@web/modules/orders/assets/css/bootstrap.min.css', ['depends' => []]);
        $this->registerJsFile('@web/modules/orders/assets/js/bootstrap.min.js', ['depends' => []]);
    ?>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>
<body>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>