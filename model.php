<?php

// Alustetaan tarvittavat tiedostot ja määritellään asetukset
// Otetaan käyttöön konfiguraatiotiedosto, näkymä ja ohjain

require_once("config.php");
require_once("view.php");
require_once("controller.php");
/*error_reporting(E_ALL);
ini_set('display_errors', 1);
*/

mb_internal_encoding('UTF-8');
$cs = ini_get("default_charset");
ini_set("auto_detect_line_endings", true);

// Alustetaan muuttujat
$columnNames = [];
$columnNamesMap = [];
$alkoData = [];
$drinkTypes = [];
$drinkCountries = [];
$drinkSize = [];


// Luetaan hinnasto ja palautetaan alkoData
function readPriceList() {
    global $priceListDate, $columnNames, $drinkTypes, $drinkCountries, $drinkSize, $local_filename_csv;

    //välimuistin kesto sekunteina
    $cacheDuration = 3600;
    // Haetaan viimeksi muokattu aika paikallisesta CSV-tiedostosta
    $lastModifiedTime = file_exists($local_filename_csv) ? filemtime($local_filename_csv) : 0;
    $currentTime = time();

    // testejä varten
    // $startTime = microtime(true);

    // jos ei ole tuntiin päivitetty tiedostoa, päivitetään
    if ($currentTime - $lastModifiedTime > $cacheDuration) {
        fetchXlxs();
    }

    // testejä varten
    // $endTime = microtime(true);
    // $executionTime = $endTime - $startTime;
    // echo "Execution Time: {$executionTime} seconds\n";

    $row = 0;
    $alkoData = [];
    $alkoDataIndex = 0;

    if (($handle = fopen($local_filename_csv, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            if( $row === 0 ) {
                // Alkon hinnasto xx.xx.xxxx                
                $key = "Alkon hinnasto ";                
                $keyLen = strlen($key);
                
                if( $key == substr($data[0], 0, strlen($key)) ) {
                    $priceListDate = substr($data[0],strlen($key));
                } else {
                    $priceListDate = "Unknown date";
                }
            } else if( $row === 1 ) {
                //tyhjä
                ;
            } else if( $row === 2 ) {
                //tyhjä
                ;
            } else if ( $row === 3 ) {
                //sarakenimet
                $columnNames = $data;
            } else {
                // Normaalit rivit alkavat tästä
                $alkoData[$alkoDataIndex] = $data;
                $alkoDataIndex++;
            }
            $row++;
        }
        fclose($handle);
    }    

    // Etsitään sarakkeiden indeksit juomatyyppiä, valmistusmaata ja kokoa varten
    $typeColumnIndex = array_search('Tyyppi', $columnNames);
    $countryColumnIndex = array_search('Valmistusmaa', $columnNames);
    $sizeColumnIndex = array_search('Pullokoko', $columnNames);

    // Kerätään uniikit juomatyypit, pois lukien tyhjät arvot
    $drinkTypes = array_filter(array_unique(array_column($alkoData, $typeColumnIndex)));
    sort($drinkTypes);

    // Kerätään uniikit valmistusmaat, pois lukien tyhjät arvot
    $drinkCountries = array_filter(array_unique(array_column($alkoData, $countryColumnIndex)));
    sort($drinkCountries);

    // Kerätään uniikit koot, pois lukien tyhjät arvot
    $drinkSize = array_filter(array_unique(array_column($alkoData, $sizeColumnIndex)));
    natsort($drinkSize);

    return $alkoData;
}



function createColumnNamesMap($cn) {
    $cnMap = [];
    for($i = 0; $i < count($cn); $i++) {
        $cnMap[$cn[$i]] = $i;
    }
    return $cnMap;
}

// Alustaa mallin ja palauttaa hinnastodatan
function initModel() {
    global $alkoData, $columnNames, $columnNamesMap;
    
    $alkoData = readPriceList();

    $columnNamesMap = createColumnNamesMap($columnNames);
        
    return $alkoData;
}

// Asennetaan SimpleXLSX-kirjasto
require_once(__DIR__.'/vendor/shuchkin/simplexlsx/src/SimpleXLSX.php');
  

// Hakee XLSX-tiedoston ja tallentaa sen paikalliseen tallennustilaan

function fetchXlxs() {
    global $remote_filename_xlsx, $local_filename_xlsx, $local_filename_csv;
    $xlsxContent = file_get_contents($remote_filename_xlsx);

    if ($xlsxContent !== false) {
        $bytesWritten = file_put_contents($local_filename_xlsx, $xlsxContent);

        if ($bytesWritten !== false) {
            // Muuntaa XLSX-tiedoston CSV-muotoon
            xlxsToCsv($local_filename_xlsx, $local_filename_csv);
        } else {
            $lastError = error_get_last();
        }
    } else {
        echo "Failed to fetch xlsx";
    }
}
//Huomasin moodlessa, että oli ohjeet että pitäisi vielä tuo xlsx tiedosto muuttaa csv:ksi
//Toimi ilman tuota muutostakin kyllä datan lukeminen xlsx tiedostosta, tosin csv tiedosta lukeminen vaikuttaa
//olevan paljon nopeampaa.
function xlxsToCsv($local_filename_xlsx, $local_filename_csv) {
    if ($xlsx = SimpleXLSX::parse($local_filename_xlsx)) {
        $f = fopen($local_filename_csv, 'wb');
        foreach ($xlsx->rows() as $r) {
            $cleanedRow = array_map(function ($cell) {
                return str_replace(["\r", "\n"], ' ', $cell);
            }, $r);
        
            fwrite($f, implode(';', $cleanedRow) . PHP_EOL);
        }
        fclose($f);
    } else {
        echo SimpleXLSX::parseError();
    }
}
