<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $services */

$currentParams = Yii::$app->request->getQueryParams();
$serviceIds = $currentParams['service_id'] ?? [];
?>

<table class="table order-table">
    <thead>
    <tr>
        <th><?= Yii::t('app', 'ID') ?></th>
        <th><?= Yii::t('app', 'User') ?></th>
        <th><?= Yii::t('app', 'Link') ?></th>
        <th><?= Yii::t('app', 'Quantity') ?></th>
        <th class="dropdown-th">
            <div class="dropdown open">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('app', 'Service'); ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li class=<?= empty($serviceIds) ? 'active' : '' ?>><a href="">All (<?= $dataProvider->getTotalCount() ?>)</a></li>
                    <?php foreach ($services as $service): ?>
                        <li>
                            <span class="label-id"><?= $service['count'] ?></span>
                            <?php if ($service['count'] > 0): ?>
                                <?php
                                    if (($key = array_search($service['service_id'], $serviceIds)) !== false) {
                                        unset($serviceIds[$key]);
                                    } else {
                                        $serviceIds[] = $service['service_id'];
                                    }

                                    $url = Url::to(
                                        array_merge(
                                            [''],
                                            $currentParams,
                                            ['service_id' => $serviceIds ? array_values($serviceIds) : null]
                                        )
                                    );
                                ?>
                                <?= Html::a(
                                    $service['name'],
                                    $url,
                                    ['class' => in_array($service['service_id'], $serviceIds) ? 'active' : '']
                                ) ?>
                            <?php else: ?>
                                <?= $service['name'] ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </th>
        <th><?= Yii::t('app', 'Status') ?></th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('app', 'Mode') ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <li class="active"><a href="">All</a></li>
                    <?php foreach ($services as $service): ?>
                        <li>
                            <?= $service['name'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </th>
        <th><?= Yii::t('app', 'Created') ?></th>
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
                    <span class="label-id"><?= $services[$model->service_id]['count'] ?></span>
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