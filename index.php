<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Alkon hinnasto</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    // Tietojen käsittely ja mallin, näkymän sekä ohjaimen lataaminen
    require("model.php");
    require_once("view.php"); 
    require_once("controller.php");

    $alkoData = initModel();
    // Suodatetut arvot
    $filters = handleRequest();

    // Alustetaan malli suodatetuilla arvoilla

    // Lasketaan löydettyjen rivien määrä
    $rowsFound = count($alkoData);

    // Tulostetaan otsikko ja löydettyjen rivien määrä
    echo "<div id=\"tbl-header\" class=\"alert alert-success\" role=\"\">Alkon hinnasto $priceListDate (Total items $rowsFound)</div>";

    // Generoidaan näkymä
    $alkoProductTable = generateView($alkoData, $filters, 'products', $drinkTypes, $drinkCountries, $drinkSize);
    echo $alkoProductTable;
    ?>
    
    <!-- tarkistetaan nykyinen URL ja asetetaan eväste tietyssä osoitteessa -->
    <script>
        const currentUrl = window.location.href;

        // Asetetaan eväste vain tietyssä URL:ssä
        if (currentUrl === 'https://niisku.lab.fi/~x074901/Alko/') {
            setCookies();
        }
    </script>
</body>
</html>
