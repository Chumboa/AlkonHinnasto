// Funktio poistaa tietyt evästeet selaimesta.
function removeCookies() {
    
    const cookieNames = ['country', 'type', 'size', 'priceLow', 'priceHigh', 'energyLow', 'energyHigh'];

    const currentUrl = window.location.href;

    console.log('Current URL:', currentUrl);  

    // Käydään läpi evästenimet ja evästeet erikseen.
    for (let i = 0; i < cookieNames.length; i++) {
        // Asetetaan evästeen vanhentumisaika menneisyyteen, jolloin se poistuu.
        document.cookie = cookieNames[i] + "= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
        console.log(cookieNames[i] + ' cookie removed.');  
    }
}

// Funktio asettaa evästeet selaimessa.
function setCookies() {

    // Apufunktio, joka hakee arvon tietyn HTML-elementin id:n perusteella.
    // vähän uutta javascriptiä
    const getValue = (elementId) => {
    const value = document.getElementById(elementId).value;
    return value === 'sel' ? '' : value;
    };
    // Apufunktio, joka luo evästekielen mukaisen merkkijonon tietylle evästeelle ja arvolle.
    const getCookieString = (cookieName, value) => value ? `&${cookieName}=${value}` : '';

    // Haetaan evästeille tarkoitetut arvot käyttäjän syötteistä
    const country = getCookieString('country', getValue('country'));
    const type = getCookieString('type', getValue('type'));
    const size = getCookieString('size', getValue('size'));
    const priceLow = getCookieString('priceLow', getValue('priceLow'));
    const priceHigh = getCookieString('priceHigh', getValue('priceHigh'));
    const energyLow = getCookieString('energyLow', getValue('energyLow'));
    const energyHigh = getCookieString('energyHigh', getValue('energyHigh'));


    //poistetaan vanhat evästeet
    removeCookies();
    const cookieString = country + type + size + priceLow + priceHigh + energyLow + energyHigh;
    if (!cookieString) {
        window.location = "./index.php?page=0";
    } else {
        document.cookie = cookieString.substring(1);
        window.location = `./index.php?page=0${cookieString}`;
    }
}
