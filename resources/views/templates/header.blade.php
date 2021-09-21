<?php 
    $headerLinks = [];
    $headerLinks[] = ['title' => 'Products', 'link' => '/product', 'selected' => ($title == 'Products')];
    $headerLinks[] = ['title' => 'Invoices', 'link' => '/invoice', 'selected' => ($title == 'Invoices')];
    $headerLinks[] = ['title' => 'Summaries', 'link' => '/summary', 'selected' => ($title == 'Summaries')]
?>

<theader :links='{!! json_encode($headerLinks) !!}'></theader>