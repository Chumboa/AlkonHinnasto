<?php

// Määritellään tiedostonimet ja URL-osoitteet
$remote_filename_xlsx ="https://www.alko.fi/INTERSHOP/static/WFS/Alko-OnlineShop-Site/-/Alko-OnlineShop/fi_FI/Alkon%20Hinnasto%20Tekstitiedostona/alkon-hinnasto-tekstitiedostona.xlsx";
$local_filename_xlsx = 'data/alkoUusi.xlsx';
$local_filename_csv = 'data/alkonHinnat.csv';
$priceListDate = "";

// define columns to include in the display
$columns2Include = [
"Numero",
"Nimi",
"Valmistaja",
"Pullokoko",
"Hinta",
"Litrahinta",
/*    
"Uutuus",
"Hinnastojärjestyskoodi",
 */
"Tyyppi",
/*
"Alatyyppi",
"Erityisryhmä",
"Oluttyyppi",
 */
"Valmistusmaa",
/*
"Alue",
*/
"Vuosikerta",
/*
"Etikettimerkintöjä",
"Huomautus",
"Rypäleet",
"Luonnehdinta",
"Pakkaustyyppi",
"Suljentatyyppi",
*/
"Alkoholi-%",
/*
"Hapot g/l",
"Sokeri g/l-%",
"Väri EBC",
"Katkerot EBU",
*/
"Energia kcal/100 ml",
/*
"Valikoima",
"EA"
 * 
 */
];


/* all columns listed below
 * Numero;
 * Nimi;
 * Valmistaja;
 * Pullokoko;
 * Hinta;
 * Litrahinta;
 * Uutuus;
 * Hinnastojärjestyskoodi;
 * Tyyppi;
 * Alatyyppi;
 * Erityisryhmä;
 * Oluttyyppi;
 * Valmistusmaa;
 * Alue;
 * Vuosikerta;
 * Etikettimerkintöjä;
 * Huomautus;
 * Rypäleet;
 * Luonnehdinta;
 * Pakkaustyyppi;
 * Suljentatyyppi;
 * Alkoholi-%;
 * Hapot g/l;
 * Sokeri g/l;
 * Kantavierrep-%;
 * Väri EBC;
 * Katkerot EBU;
 * Energia kcal/100 ml;
 * Valikoima;
 * EAN
 */
