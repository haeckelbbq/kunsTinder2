<?php

include 'config.php';

spl_autoload_register(function ($class)
{
    include 'class/' . $class . '.php';
});

session_start();

$userdaten = $_SESSION['userdaten'] ?? [];

if($userdaten != [])
{
    $userId = $userdaten->getId() ?? 0;
    $usernameSession = $userdaten->getUsername() ?? '';
    $rolleSession = $userdaten->getRolle() ?? '';
    $vornameSession = $userdaten->getVorname() ?? '';
    $nachnameSession = $userdaten->getNachname() ?? '';
    $passwortSession = $userdaten->getPasswort() ?? '';
    $plzSession = $userdaten->getPlz() ?? '';
    $ortSession = $userdaten->getOrt() ?? '';
    $strassehausnummerSession = $userdaten->getStrassehausnummer() ?? '';
}
else
{
    $userId = 0;
    $usernameSession = '';
    $rolleSession = '';
    $vornameSession = '';
    $nachnameSession = '';
    $passwortSession = '';
    $plzSession = '';
    $ortSession = '';
    $strassehausnummerSession = '';
}


$bildPfad = $_FILES['datei']['tmp_name'] ?? '';

$action = $_REQUEST['action'] ?? 'startseite';
$area = $_REQUEST['area'] ?? 'anonymous';
$username = $_REQUEST['username'] ?? '';
$rolle = $_REQUEST['rolle'] ?? '';

$nachname = $_POST['nachname'] ?? '';
$vorname = $_POST['vorname'] ?? '';
$passwort = $_POST['passwort'] ?? '';
$passwort2 = $_POST['passwort2'] ?? '';
$plz = $_POST['plz'] ?? '';
$ort = $_POST['ort'] ?? '';
$strassehausnummer = $_POST['strassehausnummer'] ?? '';
$bild = $_POST['bild'] ?? '';
$erstelldatum = $_POST['erstelldatum'] ?? '';
$bildtitel = $_POST['bildtitel'] ?? '';
$kategorie = $_POST['kategorie'] ?? '';
$bewertung = $_POST['bewertung'] ?? '';
$fehlermeldung = $_POST['fehlermeldung'] ?? '';


if ($action === 'startseite')
{
    $bilddaten = Bild::bildWechseln();
    $bild = $bilddaten['bild'];
    $kuenstler = $bilddaten['kuenstler'];
    $bildtitel = $bilddaten['bildtitel'];
    $erstelldatum = $bilddaten['erstelldatum'];
    $durchschnittsbewertung = $bilddaten['durchschnittsbewertung'];


    if($userId > 0)
    {
        $area = 'user';
    }
    else
    {
        $area = 'anonymous';
    }

    include 'view/startseite.php';
}
elseif($action === 'einloggen')
{
    include 'view/einloggen.php';
}
elseif($action === 'einloggenueberpruefen')
{
//    echo '<pre>';
//    print_r($username);
//    print_r($passwort);
//    echo '</pre>';

    $fehlermeldung = User::userEinloggen($username,$passwort);
    include 'view/einloggen.php';
}
elseif($action === 'registrieren')
{
    include 'view/registrieren.php';
//    echo '<pre>';
//    echo $action;
//    echo '</pre>';
}
elseif($action === 'registrierenueberpruefen')
{
    $fehlermeldung = User::userRegistrieren($username, $vorname, $nachname, $plz, $ort, $strassehausnummer, $passwort, $passwort2);
    include 'view/registrieren.php';
}
elseif($action === 'bildanzeigen')
{
    $bildString = Bild::bildStringErstellen($bildPfad);

    $fehlermeldung = Bild::insertBild('TestTitel','2020-06-26',$bildString,1);

    echo $fehlermeldung;

    $einBild = Bild::bildDatenHolen('TestTitel');

    Bild::bildAnzeigen($einBild->getBild());
//    echo '<pre>';
//        print_r($_FILES);
//    echo $_FILES['datei'];
//    echo '</pre>';
}
elseif($action === 'ausloggen')
{
    session_destroy();

    $bilddaten = Bild::bildWechseln();
    $bild = $bilddaten['bild'];
    $kuenstler = $bilddaten['kuenstler'];
    $bildtitel = $bilddaten['bildtitel'];
    $erstelldatum = $bilddaten['erstelldatum'];
    $durchschnittsbewertung = $bilddaten['durchschnittsbewertung'];

    $area = 'anonymous';
    $userId = 0;
    $usernameSession = '';
    $rolleSession = '';
    $vornameSession = '';
    $nachnameSession = '';
    $passwortSession = '';
    $plzSession = '';
    $ortSession = '';
    $strassehausnummerSession = '';

    include 'view/startseite.php';
}
elseif($action === 'bildhochladendialog')
{
    if($userId > 0)
    {
        $area = 'user';
    }
    else
    {
        $area = 'anonymous';
    }

    include 'view/bildhochladen.php';
}
elseif($action === 'bildhochladen')
{

    $bildString = Bild::bildStringErstellen($bildPfad);
    $fehlermeldung = Bild::insertBild($bildtitel,$erstelldatum,$bildString,$userId);
    include 'view/bildhochladen.php';
}
elseif($action === 'profilaendern')
{

    if($userId > 0)
    {
        $area = 'user';
    }
    else
    {
        $area = 'anonymous';
    }

    include 'view/profilaendern.php';
}
elseif($action === 'updaten')
{
    $fehlermeldung = User::profilAendern($username, $vorname, $nachname, $plz, $ort, $strassehausnummer, $passwort, $passwort2);
    session_destroy();
    $area = 'anonymous';
    $userId = 0;
    $usernameSession = '';
    $rolleSession = '';
    $vornameSession = '';
    $nachnameSession = '';
    $passwortSession = '';
    $plzSession = '';
    $ortSession = '';
    $strassehausnummerSession = '';
    include 'view/einloggen.php';
}
elseif($action === 'usersperren')
{

}
elseif($action === 'userloeschen')
{

}
elseif($action === 'bildloeschen')
{

}

?>

