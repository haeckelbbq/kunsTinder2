<?php include 'module/htmlbegin.php'; ?>
<!--<input type="hidden" name="area" value="kunstinder">-->
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
                <td align="center">
                    <table>
                        <tr><td>Username: </td><td><?php echo $kuenstler ?></td></tr>
                        <tr><td>Bildtitel: </td><td><?php echo $bildtitel ?></td></tr>
                        <tr><td>Erstelldatum: </td><td><?php echo $erstelldatum ?></td></tr>
                        <tr><td>Durchschnittsbewertung: </td><td><?php echo $durchschnittsbewertung ?></td></tr>
                        <tr><td><a href="index.php?action=kommentieren&area=user">Kommentar</a></td></tr>
                    </table>
                </td>
                <td colspan="2" align="center">
                    <div id="bildanzeige"> <?php Bild::bildAnzeigen($bild); ?> </div> <!-- <img src="img/schoenes500mal500.png"> -->
                </td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td align="center">
                    <?php
                    if($userId != 0)
                    {
                        echo "<a href='index.php?action=bewerten&bewertung=top'><button>TOP</button></a>";
                    }
                    else
                    {
                        echo "<button disabled>TOP</button></a>";
                    }
                    ?>
                </td>
                <td align="center">
                    <?php
                    if($userId != 0)
                    {
                        echo "<a href='index.php?action=bewerten&bewertung=flop'><button>FLOP</button></a>";
                    }
                    else
                    {
                        echo "<button disabled>FLOP</button></a>";
                    }
                    ?>
                </td>
                <td><a href=""><button>nächstes</button></a></td>
            </tr>
            </tbody>

        </table>
    </article>
    <footer><a href="view/nutzungsbedingung.php">Nutzungsbedingung</a></footer>

    <?php include 'module/htmlend.php'; ?>
