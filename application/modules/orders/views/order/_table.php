<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statuses app\modules\orders\helpers\OrderHelper::statusLabels() */
/* @var $services array */
/* @var $modes app\modules\orders\helpers\OrderHelper::modes() */
?>

<table class="table order-table">
    <thead>
        <tr>
            <th><?= Yii::t('app', 'ID') ?></th>
            <th><?= Yii::t('app', 'User') ?></th>
            <th><?= Yii::t('app', 'Link') ?></th>
            <th><?= Yii::t('app', 'Quantity') ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Yii::t('app', 'Service'); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

                        <li class="<?= empty(Yii::$app->request->getQueryParams()['service_ids']) ? 'active' : '' ?>">
                            <?= Html::a(
                                    Yii::t('app', 'All') . " {$dataProvider->getTotalCount()}",
                                    Url::current(['service_ids' => null])
                            ); ?>
                        </li>
                        <?php foreach ($services as $service): ?>
                            <?php if ($service['url']): ?>
                                <li class="<?= $service['is_active'] ? 'active' : '' ?>">
                                    <?= Html::a("<span class='label-id'>{$service['count']}</span> {$service['name']}", $service['url']) ?>
                                </li>
                            <?php else: ?>
                                <li>
                                    <span class="label-id"><?= $service['count'] ?></span><?= $service['name'] ?>
                                </li>
                            <?php endif; ?>
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
                        <li class="<?= !isset(Yii::$app->request->getQueryParams()['mode']) ? 'active' : '' ?>">
                            <?= Html::a(Yii::t('app', 'All'), Url::current(['mode' => null])); ?>
                        </li>
                        <?php foreach ($modes as $mode): ?>
                            <li class="<?= (isset(Yii::$app->request->getQueryParams()['mode']) && Yii::$app->request->getQueryParams()['mode'] == $mode)? 'active' : '' ?>">
                                <?= Html::a(
                                    Yii::t('app', $mode ? 'Auto' : 'Manual'),
                                    Url::current(['mode' => $mode]));
                                ?>
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
                <td><?= Html::encode($model->user->first_name . ' ' . $model->user->last_name) ?></td>
                <td><?= Html::encode($model->link) ?></td>
                <td><?= Html::encode($model->quantity) ?></td>
                <td>
                    <span class="label-id"><?= $services[$model->service_id]['count'] ?></span>
                    <?= Html::encode($model->service->name) ?>
                </td>
                <td><?= Html::encode($statuses[$model->status] ?? 'Unknown'); ?></td>
                <td><?= $model->mode ? 'Auto' : 'Manual'?></td>
                <td><?= date('Y-m-d H:i:s', $model->created_at) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>