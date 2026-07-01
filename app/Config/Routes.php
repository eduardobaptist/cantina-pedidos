<?php

$routes->get('/', 'RouterController::start');
$routes->get('/cardapio', 'RouterController::products');
$routes->get('/carrinho', 'RouterController::cart');
$routes->get('/checkout', 'RouterController::checkout');