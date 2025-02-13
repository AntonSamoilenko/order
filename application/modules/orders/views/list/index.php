<?php

use app\modules\orders\models\Service;
use yii\helpers\Html;
use yii\widgets\LinkPager;



?>
<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Orders</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li class="active"><a href="#">All orders</a></li>
        <?php $statuses = [0 => 'Pending', 1 => 'In progress', 2 => 'Completed', 3 => 'Canceled', 4 => 'Error']; ?>
        <?php foreach ($statuses as $key => $label): ?>
            <li>
                <?= Html::a($label, ['index', 'status' => $key], ['class' => 'filter-item']) ?>
            </li>
        <?php endforeach; ?>
        <li class="pull-right custom-search">
            <form class="form-inline" action="/admin/orders" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                    <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="1" selected="">Order ID</option>
              <option value="2">Link</option>
              <option value="3">Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
                </div>
            </form>
        </li>
    </ul>



    <!-- Таблица заказов -->
    <table class="table order-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Link</th>
            <th>Quantity</th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Service
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="active"><a href="">All (894931)</a></li>
                        <?php foreach (Service::find()->all() as $service): ?>
                            <li value="<?= $service->id ?>"<?= in_array($service->id, Yii::$app->request->get('service_id', [])) ? ' selected' : '' ?>>
                                <?= $service->name ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </th>
            <th>Status</th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Mode
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="active"><a href="">All</a></li>
                        <?php foreach (Service::find()->all() as $service): ?>
                            <li value="<?= $service->id ?>"<?= in_array($service->id, Yii::$app->request->get('service_id', [])) ? ' selected' : '' ?>>
                                <?= $service->name ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <tr>
                <td><?= Html::encode($model->id) ?></td>
                <td>
                    <?= Html::encode($model->user->first_name . ' ' . $model->user->last_name) ?>
                </td>
                <td><?= Html::encode($model->link) ?></td>
                <td><?= Html::encode($model->quantity) ?></td>
                <td>
                    <?= Html::encode($model->service->name) ?>
                </td>
                <td>
                    <?php
                    $statuses = [0 => 'Pending', 1 => 'In progress', 2 => 'Completed', 3 => 'Canceled', 4 => 'Error'];
                    echo Html::encode($statuses[$model->status] ?? 'Unknown');
                    ?>
                </td>
                <td>
                    <?= $model->mode ? 'Auto' : 'Manual' ?>
                </td>
                <td><?= date('Y-m-d H:i:s', $model->created_at) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Пагинация -->
    <div class="pagination">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]) ?>
    </div>
</div>