<?php 
    $headerLinks = [];
    $headerLinks[] = ['title' => 'Products', 'link' => '/product', 'selected' => ($title == 'Products')];
    $headerLinks[] = ['title' => 'Invoices', 'link' => '/invoice', 'selected' => ($title == 'Invoices')];
    $headerLinks[] = ['title' => 'Create Invoice', 'link' => '/invoice/create', 'selected' => ($title == 'Create Invoice')];

?>

<theader :links='{!! json_encode($headerLinks) !!}'></theader>