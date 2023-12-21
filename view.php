<script src="scripts.js"></script>

<?php

// Funktio laskee suodatetun taulukon rivimäärän
function calculateFiltered($products, $filters, $columnNamesMap) {
    global $totalCounter;
    $totalCounter = 0;
    for($i = 0; $i < count($products); $i++) {
        $product = $products[$i];
        
        // filters
        if($filters['TYPE'] != null){
            if($product[$columnNamesMap['Tyyppi']] !== $filters['TYPE']) {
                continue;
            }
        }
        if($filters['COUNTRY'] != null){
            if($product[$columnNamesMap['Valmistusmaa']] !== $filters['COUNTRY']) {
                continue;
            }
        }
        
        if($filters['PRICELOW'] != null){
            if($product[$columnNamesMap['Hinta']] < $filters['PRICELOW']) {
                continue;
            }
        }
        if($filters['PRICEHIGH'] != null){
            if($product[$columnNamesMap['Hinta']] > $filters['PRICEHIGH']) {
                continue;
            }
        }
        if($filters['SIZE'] != null){
            if($product[$columnNamesMap['Pullokoko']] !== $filters['SIZE']) {
                continue;
            }
        }
        if($filters['ENERGYLOW'] != null){
            if($product[$columnNamesMap['Energia kcal/100 ml']] < $filters['ENERGYLOW']) {
                continue;
            }
        }
        if($filters['ENERGYHIGH'] != null){
            if($product[$columnNamesMap['Energia kcal/100 ml']] > $filters['ENERGYHIGH']) {
                continue;
            }
        }
        $totalCounter++;
}
}
// Funktio luo sivunavigaation next ja prev napit
function createPagination($filters) {
    global $totalCounter;
    // Määritellään nykyinen, edellinen, seuraava ja viimeinen sivu
    $currpage = isset($filters['PAGE']) ? $filters['PAGE'] : 0;
    $prevpage = max(0, $filters['PAGE'] - 1);
    $nextpage = $filters['PAGE'] + 1;
    $lastpage = ceil($totalCounter / $filters['LIMIT']) - 1;

    // Luodaan evästeiden string
    $cookieParams = ['country', 'type', 'size', 'priceLow', 'priceHigh', 'energyLow', 'energyHigh'];
    $cookieString = "";

    foreach ($cookieParams as $param) {
        $cookieString .= isset($_COOKIE[$param]) ? "&$param=" . $_COOKIE[$param] : "";
    }

    echo "<input type=button onClick=\"location.href='./index.php?page=$prevpage$cookieString'\" value='prev'>";

    if ($nextpage <= $lastpage) {
        echo "<input type=button onClick=\"location.href='./index.php?page=$nextpage$cookieString'\" value='next'>";
    }
    else {
        echo "<input type='button' value='Nothing on next page' disabled>";
    }
}

// Funktio luo suodatusvalinnat
function createFilters($filters, $drinkTypes, $drinkCountries, $drinkSize) {
    echo "<input type=button onClick=\"setCookies()\" value='set filter'";
    echo "<form><select name='country' id='country'><option value='sel'>--- select country ---</option>";
    foreach ($drinkCountries as $countryItem) {
        echo "<option value='" . $countryItem . "'>" . $countryItem . "</option>";
    }
    echo "</select>";
    echo "<select name='type' id='type'><option value='sel'>--- select tyyppi ---</option>";
    foreach ($drinkTypes as $typeItem) {
        echo "<option value='" . $typeItem . "'>" . $typeItem . "</option>";
    }
    echo "</select>";
    echo "<select name='size' id='size'><option value='sel'>--- select koko ---</option>";
    foreach ($drinkSize as $drinkSizeItem) {
        echo "<option value='" . $drinkSizeItem . "'>" . $drinkSizeItem . "</option>";
    }
    echo "</select>";
    echo "<input type='number' id='priceLow' name='priceLow' placeholder='Price Low'>";
    echo "<input type='number' id='priceHigh' name='priceHigh' placeholder='Price High'>";
    echo "<input type='number' id='energyLow' name='energyLow' placeholder='Energy Low'>";
    echo "<input type='number' id='energyHigh' name='energyHigh' placeholder='Energy High'>";
    echo "</form>";
}

// Funktio luo taulukon sarakeotsikot
function createColumnHeaders($columns2Include) {
    $t = "<thead>";
    $t = "<tr>";
    for($i = 0; $i < count($columns2Include); $i++ ) {
        $val = $columns2Include[$i];
        $t .= '<th scope="col">'.$val."</th>";
    }
    $t .= "</tr></thead>";    
    return $t;
}

// Funktio luo taulukon rivin
function createTableRow($product,$columns2Include,$columnNamesMap) {
    $t = "<tr>";

    // Lisätään jokainen solu
    for($i = 0; $i < count($columns2Include); $i++ ) {
        $columnName = $columns2Include[$i];
        $item = $product[ $columnNamesMap[$columnName]];
        // Ensimmäinen solu voi olla th (otsikko)
        if($i == 0) {
            $t .= '<th scope="row">'.$item."</td>";
        } else {
            $t .= "<td>".$item."</td>";
        }
    }
    $t .= "</tr>";    
    return $t;    
}

// Funktio luo taulukon Alkon tuotteista
function createAlkoProductsTable($products, $columns2Include, $columnNamesMap, $filters, $tblId) {
    $limitCounter = 0;
    $limitCounterLow = $filters['LIMIT']*$filters['PAGE'];
    $limitCounterHigh = $limitCounterLow + $filters['LIMIT'];
    
    if($tblId != null) {
        $t = "<table id=\"$tblId\" class=\"table\">";    
    } else {
        $t = '<table class="table">';    
    }
    $t .= createColumnHeaders($columns2Include); 
    $t .= '<tbody>';
    for($i = 0; $i < count($products); $i++) {
        $product = $products[$i];
        
        // Suodatuslogiikka
        if($filters['TYPE'] != null){
            if($product[$columnNamesMap['Tyyppi']] !== $filters['TYPE']) {
                continue;
            }
        }
        if($filters['COUNTRY'] != null){
            if($product[$columnNamesMap['Valmistusmaa']] !== $filters['COUNTRY']) {
                continue;
            }
        }
        
        if($filters['PRICELOW'] != null){
            if($product[$columnNamesMap['Hinta']] < $filters['PRICELOW']) {
                continue;
            }
        }
        if($filters['PRICEHIGH'] != null){
            if($product[$columnNamesMap['Hinta']] > $filters['PRICEHIGH']) {
                continue;
            }
        }
        if($filters['SIZE'] != null){
            if($product[$columnNamesMap['Pullokoko']] !== $filters['SIZE']) {
                continue;
            }
        }
        if($filters['ENERGYLOW'] != null){
            if($product[$columnNamesMap['Energia kcal/100 ml']] < $filters['ENERGYLOW']) {
                continue;
            }
        }
        if($filters['ENERGYHIGH'] != null){
            if($product[$columnNamesMap['Energia kcal/100 ml']] > $filters['ENERGYHIGH']) {
                continue;
            }
        }
        
        $limitCounter++;
        if($limitCounter > $limitCounterLow) {
            $t .= createTableRow($product,$columns2Include,$columnNamesMap);
            if($limitCounter >= $limitCounterHigh) {
                break;
            }
        }
    }
    $t .= '</tbody>';
    $t .= "</table>";
    return $t;
}

// Funktio generoi näkymän
function generateView($alkoData, $filters, $tblId = null, $drinkTypes, $drinkCountries, $drinkSize) {
    global $columns2Include, $columnNamesMap;

    $output = '';

    if ($filters['MODE'] === 'view') {
        $alkoProductTable = createAlkoProductsTable(
            $alkoData, $columns2Include, $columnNamesMap, $filters, $tblId
        );

        calculateFiltered($alkoData, $filters, $columnNamesMap);

        // Lisätään taulukko tulosteeseen
        $output .= $alkoProductTable;

        // Lisätään sivutus ja suodatus tulosteeseen
        $output .= createPagination($filters) . ' ' . createFilters($filters, $drinkTypes, $drinkCountries, $drinkSize);
    } else if ($filters['MODE'] === 'update') {
        //fetchXlsx();
        $output = "<h2>Update csv file from original source</h2>";
    } else {
        $output = "<h2>Unknown command </h2>";
    }

    return $output;
}