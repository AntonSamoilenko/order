<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $services */
/* @var $searchFields app\modules\orders\helpers\OrderHelper::searchFields() */
?>

<?php echo $this->render('_navigation'); ?>

<div class="container-fluid">
    <?php echo $this->render('_filter_panel', [
            'searchFields' => $searchFields,
        ]);
    ?>

    <?php echo $this->render('_table', [
        'dataProvider'  => $dataProvider,
        'services'      => $services,
    ]);
    ?>

    <div class="pagination">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]) ?>
    </div>
</div>