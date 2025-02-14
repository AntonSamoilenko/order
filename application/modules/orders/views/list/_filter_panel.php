<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $searchFields app\modules\orders\helpers\OrderHelper::searchFields() */
?>

<ul class="nav nav-tabs p-b">
    <li class="active"><a href="/orders">All orders</a></li>
    <?php
        $statuses = [0 => 'pending', 1 => 'in_progress', 2 => 'completed', 3 => 'canceled', 4 => 'error'];
        foreach ($statuses as $key => $label):
            $url = Url::to(['', 'status' => $label]);
    ?>
        <li>
            <?= Html::a($label, $url, ['class' => 'filter-item']) ?>
        </li>
    <?php endforeach; ?>
    <li class="pull-right custom-search">
        <form class="form-inline" action="" method="get">
            <div class="input-group">
                <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search_type">
                <?php foreach ($searchFields as $key => $label): ?>
                    <option value=<?= $key ?>>
                            <?= $label ?>
                        </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
            </div>
        </form>
    </li>
</ul>
