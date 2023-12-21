<?php

// Käsittelee URL-parametrit ja alustaa suodattimet
function handleRequest() {
    
    // Alustetaan suodattimet oletusarvoilla tai URL-parametrien arvoilla
    $filters['MODE'] = $_GET['mode'] ?? "view";
    $filters['TYPE'] = $_GET['type'] ?? null;
    $filters['LIMIT'] = $_GET['limit'] ?? 25;
    $filters['PAGE'] = $_GET['page'] ?? 0;
    $filters['COUNTRY'] = $_GET['country'] ?? null;
    $filters['PRICELOW'] = $_GET['priceLow'] ?? null;
    $filters['PRICEHIGH'] = $_GET['priceHigh'] ?? null;
    $filters['SIZE'] = $_GET['size'] ?? null;
    $filters['ENERGYLOW'] = $_GET['energyLow'] ?? null;
    $filters['ENERGYHIGH'] = $_GET['energyHigh'] ?? null;

    return $filters;    
}
