<?php
require('../conn/constants.php' );
session_start();
require('../conn/csrf.class.php' );
require('../conn/csrf_init.php' );
session_write_close();
require('special_offer_model.php');

// CSRF protection
if (!$csrf->check_valid('post') && !$csrf->check_valid('get')) {
    MyShortEcho('Token is unkowned!');
    exit;
}


// Get parameters
$command = isset($_POST[$POST_params['a0']]) ? $_POST[$POST_params['a0']] : NULL;
$search = isset($_POST[$POST_params['b0']]) ? $_POST[$POST_params['b0']] : NULL;
$order_by = isset($_POST[$POST_params['c0']]) ? $_POST[$POST_params['c0']] : NULL;
$page_offset = isset($_POST[$POST_params['d0']]) ? $_POST[$POST_params['d0']] : NULL;
$page_quantity = isset($_POST[$POST_params['e0']]) ? $_POST[$POST_params['e0']] : NULL;
$spo_id = isset($_POST[$POST_params['f0']]) ? $_POST[$POST_params['f0']] : NULL;
$spo_name = isset($_POST[$POST_params['a1']]) ? $_POST[$POST_params['a1']] : NULL;
$spo_percentage = isset($_POST[$POST_params['b1']]) ? $_POST[$POST_params['b1']] : NULL;

if (!$search) $search = '%';
if (!$order_by) $order_by = 'SPO_NAME ASC';
if (!$page_offset) $page_offset = '0';
if (!$page_quantity) $page_quantity = '50';

switch ($command) {
    case $COMMAND_QUERY :
        $json = GetAllSpecialOffers($search, $order_by, $page_offset, $page_quantity);
        MyShortEcho($json, 'application/json');
        break;

    case $COMMAND_INSERT :
        $result = AddSpecialOffer($spo_name, $spo_percentage);
        $json = GetAllSpecialOffers($search, $order_by, $page_offset, $page_quantity);
        MyShortEcho($json, 'application/json');
        break;

    case $COMMAND_EDIT :
        $result = EditSpecialOffer($spo_id, $spo_name, $spo_percentage);
        $json = GetAllSpecialOffers($search, $order_by, $page_offset, $page_quantity);
        MyShortEcho($json, 'application/json');
        break;

    case $COMMAND_DELETE :
        $result = DelSpecialOffer($spo_id);
        $json = GetAllSpecialOffers($search, $order_by, $page_offset, $page_quantity);
        MyShortEcho($json, 'application/json');
        break;
}
