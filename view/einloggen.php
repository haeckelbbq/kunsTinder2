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

        <br>einloggenanzeige</br>


        <form action="index.php" method="post">
            <input type="hidden" name="action" value="einloggenueberpruefen">

            <table>
                <tbody>
                <tr>
                    <td>Username:</td>
                    <td><input name="username" type="text" ></td>
                </tr>
                <tr>
                    <td>Passwort:</td>
                    <td><input name="passwort" type="passwort" ></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submitname" value="senden"></td>
                </tr>
                </tbody>
                </table>

        </form>
        <?php echo $fehlermeldung; ?>
    </article>
    <footer><a href="view/nutzungsbedingung.php">Nutzungsbedingung</a></footer>

    <?php include 'module/htmlend.php'; ?>
