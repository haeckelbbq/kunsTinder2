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

        <table style="width: 100%">

            <tbody>

            <tr>
                <td>Das Bild soll maximal 500px * 500px haben, bis 2Mb gross sein und muß im Format JPG, JPEG, PNG oder
                    GIF vorliegen.
                </td>
            </tr>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="bildhochladen">
                <tr>
                    <td>
                        <input type="file" name="datei"><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Bildtitel">Titelbild</label>
                        <input id="Bildtitel" name="bildtitel" type="text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Erstelldatum">Erstelldatum</label>
                        <input id="Erstelldatum" name="erstelldatum" type="date">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Kategorie">Kategorie</label>
                        <input id="Kategorie" name="kategorie" type="text">
                        <!--                 <?php //echo Html::getPullDown(Kategorietyp::getDataFromDatabase(), 'kategorietypen'); ?>-->
                    </td>
                </tr>
                <tr>
                    <input type="submit" value="Hochladen">
                </tr>
            </form>
            </tbody>
        </table>
        <?php echo $fehlermeldung; ?>
    </article>
    <footer><a href="view/nutzungsbedingung.php">Nutzungsbedingung</a></footer>

    <?php include 'module/htmlend.php'; ?>
