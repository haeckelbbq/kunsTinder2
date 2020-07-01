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
<aside> <?php include 'module/aside.php'; ?></aside>
<article>
    <h2>Usereingabe</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="insert">
        <input type="hidden" name="area" value="user">
        <table>
            <thead>
            <tbody>
            <tr>
                <td><label for="user"</label></td>
                <td><input name="user" type="text"></td>
            </tr>
            <tr>
                <td><label for="passwort">Passwort:</label></td>
                <td><input name="passwort" type="passwort" id="passwort"></td>
            </tr>

            <tr>
                <td></td>
                <td><input type="submit" name="submitname" value="OK"></td>
            </tr>
            <footer><a href="view/nutzungsbedingung.php">Nutzungsbedingung</a></footer>
            <?php include 'view/module/htmlend.php'; ?>


    </form>
    <?php
    $users = User::getDataFromDatabase();
    ?>
</article>

