<?php

$routes->get('/', 'RouterController::products');
$routes->get('/carrinho', 'RouterController::cart');
$routes->get('/checkout', 'RouterController::checkout');