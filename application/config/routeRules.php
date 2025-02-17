<?php

return [
    'orders/export_csv/<status:\d+>' => 'orders/order/export-csv',
    'orders/export_csv' => 'orders/order/export-csv',
    'orders/<status:\w+>' => 'orders/order/index',
    'orders/' => 'orders/order/index',
    'orders' => 'orders/order/index',
    '/' => 'orders/order/index',
];