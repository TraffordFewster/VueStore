<?php 
    $headerLinks = [];
    $headerLinks[] = ['title' => 'Products', 'link' => '/product', 'selected' => ($title == 'Products')];
    $headerLinks[] = ['title' => 'Invoices', 'link' => '/invoice', 'selected' => ($title == 'Invoices')];
?>

<theader :links='{!! json_encode($headerLinks) !!}'></theader>