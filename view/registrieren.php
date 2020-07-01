<?php include 'module/htmlbegin.php'; ?>

<body>

<div id="container">
    <header>

    </header>
    <nav>

        <table>
            <?php
            include 'module/navStartseite' . $area . '.php';
            ?>
        </table>
    </nav>
    <aside>
        <?php include 'module/aside.php'; ?>
    </aside>
    <article>
        <h1> Anmelden </h1>
        <form action= "index.php" method="post">
            <input type="hidden" name="action" value="registrierenueberpruefen">
            <table>

                <tbody>
                <tr>
                    <td><label for ="Username">Username: </label></td>
                    <td><input type="text" name="username">
                </tr>
                <tr>
                    <td><label for ="Vorname">Vorname: </label></td>
                    <td><input type="text" name="vorname">
                </tr>
                <tr>
                    <td><label for ="Nachname">Nachname: </label></td>
                    <td><input type="text" name="nachname">
                </tr>
                <tr>
                    <td><label for ="Plz">Plz: </label></td>
                    <td><input type="text" name="plz"></td>
                </tr>
                <tr>
                    <td><label for ="Ort">Ort: </label></td>
                    <td><input type="text" name="ort"></td>
                </tr>
                <tr>
                    <td><label for ="Strasse und Hausnummer">Strasse und Hausnummer: </label></td>
                    <td><input type="text" name="strassehausnummer"></td>
                </tr>
                <tr>
                    <td><label for ="Passwort">Passwort: </label></td>
                    <td><input type="passwort" name="passwort"></td>
                </tr>
                <tr>
                    <td><label for ="Passwort wiederholen">Passwort wiederholen: </label></td>
                    <td><input type="passwort" name="passwort2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="reset"> <input type="submit" name="" value="Registrieren"></td>
                </tr>
                </tbody>
            </table>
        </form>
        <?php echo $fehlermeldung; ?>
    </article>
    <footer><a href="view/nutzungsbedingung.php">Nutzungsbedingung</a></footer>

    <?php include 'module/htmlend.php'; ?>
