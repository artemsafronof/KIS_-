<?php
$productsContent = file_get_contents('products.xml');
$productsXML = new SimpleXMLElement($productsContent);

$sectionsContent = file_get_contents('sections.xml');
$sectionsXML = new SimpleXMLElement($sectionsContent);

$outputContent = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"></rss>';
$outputXML = new SimpleXMLElement($outputContent);
$rss = $outputXML->addChild('Элементыкаталога')->addChild('Разделы');
foreach ($sectionsXML->Раздел as $section){
    $newSection = $rss->addChild('Раздел');
    $newSection->addChild('Ид', $section->Ид);
    $newSection->addChild('Наименование', $section->Наименование);
    $addProductsToSection = $newSection->addChild('Товары');
    foreach ($productsXML->Товар as $product) {
        foreach($product->Разделы->ИдРаздела as $id) {
            if (strcmp($section->Ид, $id) == 0) {
                $addProductToSection = $addProductsToSection->addChild('Товар');
                $addProductToSection->addChild('Ид', $product->Ид);
                $addProductToSection->addChild('Наименование', $product->Наименование);
                $addProductToSection->addChild('Артикул', $product->Артикул);
            }
        }
    }
}

$outputXML->asXML('output.xml');
echo '<h1>Загляните в output.xml</h1>';