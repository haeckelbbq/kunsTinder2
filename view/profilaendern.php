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
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="updaten">
            <input type="hidden" name="id" value="<?php echo $userId ?>">
            <table>
                <tbody>
                <tr>
                    <td>Username:</td>
                    <td><input name="username" type="text" value="<?php echo $usernameSession; ?>"
                            <?php if($rolleSession === 'user') {echo 'readonly';}?> ></td>
                </tr>
                <tr>
                    <td>PLZ:</td>
                    <td><input name="plz" type="text" value="<?php echo $plzSession; ?>"></td>
                </tr>
                <tr>
                    <td>Ort:</td>
                    <td><input name="ort" type="text" value="<?php echo $ortSession; ?>"></td>
                </tr>
                <tr>
                    <td>Strasse, Hausnummer:</td>
                    <td><input name="strassehausnummer" type="text" value="<?php echo $strassehausnummerSession; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Passwort:</td>
                    <td><input type="passwort" name="passwort"></td>
                </tr>
                <tr>
                    <td>Passwort wiederholen:</td>
                    <td><input type="passwort" name="passwort2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Ändern"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </article>

    <footer><a href="view/nutzungsbedingung.php">Nutzungsbedingung</a></footer>

<?php include 'module/htmlend.php'; ?>