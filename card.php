<?php
session_start();

require_once 'products.php';

if ($_GET['action'] === 'add') {
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [
            'products' => [
                //'100' => '3'
            ],
        ];
    }
    
    $ids = array_keys($_SESSION['cart']['products']);
    if (in_array($_GET['product_id'], $ids)) {
        $_SESSION['cart']['products'][$_GET['product_id']]++;
    } else {
        $_SESSION['cart']['products'][$_GET['product_id']] = 1;
    }

    header('Location: card.php?action=list');
};


if ($_GET['action'] === 'list') {

    if (count ($_SESSION['cart']['products']) > 0) {
        $cardItems = [];
        foreach($_SESSION['cart']['products'] as $product_id => $qty) {
            $cardItems[] = (object)[
                'id' => $product_id,
                'qty' => $qty,
                'info' => (object)$products[$product_id],
            ];
        }
        require_once 'views/card.view.php';
        exit;
    } else {
       $cardItems = [];
       require_once 'views/card.view.php';
    }
};

if (isset($_POST['btn'])) {
        $update = array_combine(
            $_POST['qty']['id'],
            $_POST['qty']['qty']
        );
      foreach($update as $id => $qty ){
          $_SESSION['cart']['products'][$id] = $qty;
      }
      header('Location: card.php?action=list');
    
};

if ($_GET['action'] === 'remove'){
    unset($_SESSION['cart']['products'][$_GET['product_id']]);
    header('Location: card.php?action=list');
}
if($_GET['action'] === 'clean'){
    $_SESSION['cart']['products'] = [];
    header('Location: card.php?action=list');
}
