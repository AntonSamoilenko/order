<?php

use app\modules\orders\helpers\OrderHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Orders');


//
//$currentParams = Yii::$app->request->queryParams;
//$status = !empty($params['status']) ? '/' . $params['status'] : '';
////var_dump($params, !empty($params['status']));die;
//$baseUrl = ['/orders/list' . $status];



//echo '<h6>Filter by services:</h6>';
//foreach ($services as $id => $service) {
//    // Обновляем параметры: добавляем или заменяем service_id
//    $options[$id] = $service['count'] > 0 ? "[{$service['count']}] {$service['name']}" : "{$service['name']} - disabled";
//    $params = array_merge($currentParams, ['service_id' => $id]);
//    $url = Url::to(array_merge($baseUrl, $params));
//    echo Html::a($service['name'], $url) . '<br>';
//}

//foreach ($services as $id => $service) {
//    $options[$id] = $service['count'] > 0 ? "[{$service['count']}] {$service['name']}" : "{$service['name']} - disabled";
//}

//echo Html::dropDownList(
//    'service_id',
//    $params['service_id'] ?? null,
//    $options,
//    ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select Service')]
//);

// Ссылки для фильтрации по mode
//echo '<h6>Filter by Mode:</h6>';
//$modes = [
//    0 => 'Manual',
//    1 => 'Auto',
//];
//foreach ($modes as $id => $name) {
//    // Обновляем параметры: добавляем или заменяем mode
//    $params = array_merge($currentParams, ['mode' => $id]);
//    $url = Url::to(array_merge($baseUrl, $params));
//    echo Html::a($name, $url) . '<br>';
//}



//var_dump($params);die;
//unset($params['status']);
$params = $params ?? [];
echo '<h6>Filter by Statuses:</h6>';
echo Html::a('All Statuses', '/orders'). '<br>';
foreach ($urls as $textStatus => $url) {
    echo Html::a(ucfirst(str_replace('_', ' ', $textStatus)), $url) . '<br>';
}

//echo Html::beginForm('', 'get', ['class' => 'mb-3']);

//echo Html::dropDownList(
//    'mode',
//    $params['mode'] ?? null,
//    array_combine($availableModes, $availableModes),
//    ['class' => 'form-control']
//);
//
//
//$options = [];
//
//foreach ($services as $id => $service) {
//    $options[$id] = $service['count'] > 0 ? "[{$service['count']}] {$service['name']}" : "{$service['name']} - disabled";
//}
//
//echo Html::dropDownList(
//    'service_id',
//    $params['service_id'] ?? null,
//    $options,
//    ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select Service')]
//);


//echo Html::textInput(
//    'search_id',
//    $params['search_id'] ?? null,
//    ['placeholder' => Yii::t('app', 'Search by ID'), 'class' => 'form-control']
//);


//echo Html::textInput(
//    'search_user',
//    $params['search_user'] ?? null,
//    ['placeholder' => Yii::t('app', 'Search by User'), 'class' => 'form-control']
//);


//echo Html::textInput(
//    'search_link',
//    $params['search_link'] ?? null,
//    ['placeholder' => Yii::t('app', 'Search by Link'), 'class' => 'form-control']
//);


//echo Html::submitButton(Yii::t('app', 'Filter'), ['class' => 'btn btn-primary']);
//echo Html::endForm();




echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => Yii::t('app', 'Id'),
            'value' => function ($model) {
                return $model->id;
            },
        ],
        [
            'attribute' => 'full_name',
            'label' => Yii::t('app', 'User'),
            'value' => function ($model) {
                return $model->user->getFullName();
            },
        ],
        [
            'label' => Yii::t('app', 'Link'),
            'value' => function ($model) {
                return $model->link;
            },
        ],
        [
            'label' => Yii::t('app', 'Quantity'),
            'value' => function ($model) {
                return $model->quantity;
            },
        ],
        [
            'attribute' => 'service.name',
            'label' => Yii::t('app', 'Service'),
        ],
        [
            'label' => Yii::t('app', 'Status'),
            'value' => function ($model) {
                $statuses = OrderHelper::statusLabels();
                return $statuses[$model->status];
            },
        ],
        [
            'label' => Yii::t('app', 'Created'),
            'value' => function ($model) {
                return $model->created_at;
            },
            'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
        [
            'label' => Yii::t('app', 'Mode'),
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




echo Html::a(Yii::t('app', 'Save result'), ['export-csv'] + $params, [
    'class' => 'btn btn-secondary float-right mt-3',
]);