<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Orders');


$params = $params ?? [];

echo Html::beginForm('', 'get', ['class' => 'mb-3']);


echo Html::dropDownList(
    'status',
    $params['status'] ?? null,
    [
        '' => Yii::t('app', 'All Statuses'),
        0 => Yii::t('app', 'Pending'),
        1 => Yii::t('app', 'In Progress'),
        2 => Yii::t('app', 'Completed'),
        3 => Yii::t('app', 'Canceled'),
        4 => Yii::t('app', 'Fail'),
    ],
    ['class' => 'form-control']
);


echo Html::dropDownList(
    'mode',
    $params['mode'] ?? null,
    array_combine($availableModes, $availableModes),
    ['class' => 'form-control']
);


$options = [];
foreach ($services as $id => $count) {
    $options[$id] = $count > 0 ? "({$count})" : "({$count}) - disabled";
}

echo Html::dropDownList(
    'service_id',
    $params['service_id'] ?? null,
    $options,
    ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select Service')]
);


echo Html::textInput(
    'search_id',
    $params['search_id'] ?? null,
    ['placeholder' => Yii::t('app', 'Search by ID'), 'class' => 'form-control']
);


echo Html::textInput(
    'search_user',
    $params['search_user'] ?? null,
    ['placeholder' => Yii::t('app', 'Search by User'), 'class' => 'form-control']
);


echo Html::textInput(
    'search_link',
    $params['search_link'] ?? null,
    ['placeholder' => Yii::t('app', 'Search by Link'), 'class' => 'form-control']
);


echo Html::submitButton(Yii::t('app', 'Filter'), ['class' => 'btn btn-primary']);
echo Html::endForm();




echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'full_name', // Используем псевдоним
            'label' => Yii::t('app', 'User'),
            'value' => function ($model) {
                return $model->user->getFullName();
            },
        ],
        'link',
        'quantity',
        [
            'attribute' => 'service.name',
            'label' => Yii::t('app', 'Service'),
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                $statuses = [
                    0 => Yii::t('app', 'Pending'),
                    1 => Yii::t('app', 'In Progress'),
                    2 => Yii::t('app', 'Completed'),
                    3 => Yii::t('app', 'Canceled'),
                    4 => Yii::t('app', 'Fail'),
                ];
                return $statuses[$model->status];
            },
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
        [
            'attribute' => 'mode',
            'value' => function ($model) {
                return $model->mode === 0 ? Yii::t('app', 'Manual') : Yii::t('app', 'Auto');
            },
        ],
    ],
]);



$pagination = $dataProvider->getPagination();
if ($pagination !== false && $totalCount > $pagination->pageSize) {
    echo '<div class="pagination-info">';
    echo Yii::t('app', 'Showing {start}-{end} of {total} records', [
        'start' => $pagination->getOffset() + 1,
        'end' => min($pagination->getOffset() + $pagination->getPageSize(), $totalCount),
        'total' => $totalCount,
    ]);
    echo '</div>';

    echo LinkPager::widget([
        'pagination' => $pagination,
        'options' => ['class' => 'pagination'],
    ]);
} else {
    echo '<div class="pagination-info">';
    echo Yii::t('app', 'Total records: {total}', ['total' => $totalCount]);
    echo '</div>';
}





$pagination = $dataProvider->getPagination();
if ($pagination !== false && $totalCount > $pagination->pageSize) {
    echo '<div class="pagination-info">';
    echo Yii::t('app', 'Showing {start}-{end} of {total} records', [
        'start' => $pagination->getOffset() + 1,
        'end' => min($pagination->getOffset() + $pagination->getPageSize(), $totalCount),
        'total' => $totalCount,
    ]);
    echo '</div>';

    // Вывод постраничной навигации
    echo LinkPager::widget([
        'pagination' => $pagination,
        'options' => ['class' => 'pagination'],
    ]);
} else {
    echo '<div class="pagination-info">';
    echo Yii::t('app', 'Total records: {total}', ['total' => $totalCount]);
    echo '</div>';
}




echo Html::a(Yii::t('app', 'Save result'), ['export-csv'] + $params, [
    'class' => 'btn btn-secondary float-right mt-3',
]);