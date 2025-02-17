<?php

use app\modules\orders\DTO\Orders;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $services array */
/* @var $searchFields app\modules\orders\helpers\OrderHelper::searchFields() */
/* @var $statuses app\modules\orders\helpers\OrderHelper::statuses() */
/* @var $statusLabels app\modules\orders\helpers\OrderHelper::statusLabels() */
/* @var $modes app\modules\orders\helpers\OrderHelper::modes() */
/* @var $currentParams array */
?>

<?php echo $this->render('_navigation'); ?>

<div class="container-fluid">
    <?php echo $this->render('_filter_panel', [
            'searchFields'  => $searchFields,
            'statusLabels'  => $statusLabels,
            'statuses'      => $statuses,
        ]);
    ?>

    <?php echo $this->render('_table', [
        'dataProvider' => $dataProvider,
        'services' => $services,
        'statuses' => $statuses,
        'modes' => $modes,
        'currentParams' => $currentParams,
        ]);
    ?>

    <div class="pagination">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>

    <div>
        <?= Html::a(
                Yii::t('app', 'Save file'),
                Url::to(array_merge(['/orders/export_csv'], $currentParams))
        ); ?>
    </div>


</div>