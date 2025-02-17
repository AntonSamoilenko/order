<?php

use app\modules\orders\DTO\Orders;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statuses app\modules\orders\helpers\OrderHelper::statusLabels() */
/* @var $services array */
/* @var $currentParams array */
/* @var $modes app\modules\orders\helpers\OrderHelper::modes() */
?>

<table class="table order-table">
    <thead>
        <tr>
            <th><?= Yii::t('orders', 'fields.id') ?></th>
            <th><?= Yii::t('orders', 'fields.user') ?></th>
            <th><?= Yii::t('orders', 'fields.link') ?></th>
            <th><?= Yii::t('orders', 'fields.quantity') ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Yii::t('orders', 'fields.service'); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

                        <li class="<?= empty($currentParams['service_ids']) ? 'active' : '' ?>">
                            <?= Html::a(
                                    Yii::t('orders', 'all') . " {$dataProvider->getTotalCount()}",
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
            <th><?= Yii::t('orders', 'fields.status') ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Yii::t('orders', 'fields.mode') ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <li class="<?= !isset($currentParams['mode']) ? 'active' : '' ?>">
                            <?= Html::a(Yii::t('orders', 'all'), Url::current(['mode' => null])); ?>
                        </li>
                        <?php foreach ($modes as $mode): ?>
                            <li class="<?= (isset($currentParams['mode']) && $currentParams['mode'] == $mode)? 'active' : '' ?>">
                                <?= Html::a(
                                    Yii::t('orders', $mode ? 'mode.auto' : 'mode.manual'),
                                    Url::current(['mode' => $mode]));
                                ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </th>
            <th><?= Yii::t('orders', 'fields.created') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->getModels() as $order): ?>
            <tr>
                <td><?= Html::encode($order->id) ?></td>
                <td><?= Html::encode($order->username) ?></td>
                <td><?= Html::encode($order->link) ?></td>
                <td><?= Html::encode($order->quantity) ?></td>
                <td>
                    <span class="label-id"><?= $order->serviceCount?></span>
                    <?= Html::encode($order->serviceName) ?>
                </td>
                <td><?= Html::encode($order->status); ?></td>
                <td><?= $order->mode ?></td>
                <td><?= $order->createdAt ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>