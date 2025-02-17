<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $searchFields app\modules\orders\helpers\OrderHelper::searchFields() */
/* @var $statuses app\modules\orders\helpers\OrderHelper::statuses() */
/* @var $statusLabels app\modules\orders\helpers\OrderHelper::statusLabels() */
?>

<ul class="nav nav-tabs p-b">
    <li class="active"><a href="/orders">All orders</a></li>
    <?php foreach ($statuses as $key => $status): ?>
        <?php $url = Url::to(['', 'status' => $status]);?>
        <li><?= Html::a($statusLabels[$key], $url, ['class' => 'filter-item']) ?></li>
    <?php endforeach; ?>
    <li class="pull-right custom-search">
        <form class="form-inline" action="" method="get">
            <div class="input-group">
                <input type="text" name="search" class="form-control" value="" placeholder="<?= Yii::t('app', 'Search orders')?>">
                <span class="input-group-btn search-select-wrap">
                    <select class="form-control search-select" name="search_type">
                        <?php foreach ($searchFields as $key => $label): ?>
                            <option value=<?= $key ?>>
                                    <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                </span>
            </div>
        </form>
    </li>
</ul>
