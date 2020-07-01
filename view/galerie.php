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

        <br>Galerieansicht</br>


        <form action="index.php" method="post">
            <input type="hidden" name="action" value="galerieanzeigen">

            <table>
                <tbody>
                <tr style="width: 500px; height: 100px">
                    <td style="width: 50px; height: 50px"><div id="galerieanzeige"> <?php ; ?> </div></td>
                    <td style="width: 50px; height: 50px">Bild2</td>
                    <td style="width: 50px; height: 50px">Bild3</td>
                    <td style="width: 50px; height: 50px">Bild4</td>
                    <td style="width: 50px; height: 50px">Bild5</td>
                </tr>
                <tr style="width: 500px; height: 100px">
                    <td style="width: 50px; height: 50px">Bild6</td>
                    <td style="width: 50px; height: 50px">Bild7</td>
                    <td style="width: 50px; height: 50px">Bild8</td>
                    <td style="width: 50px; height: 50px">Bild9</td>
                    <td style="width: 50px; height: 50px">Bild10</td>
                </tr>
                <tr style="width: 500px; height: 100px">
                    <td style="width: 50px; height: 50px">Bild11</td>
                    <td style="width: 50px; height: 50px">Bild12</td>
                    <td style="width: 50px; height: 50px">Bild13</td>
                    <td style="width: 50px; height: 50px">Bild14</td>
                    <td style="width: 50px; height: 50px">Bild15</td>
                </tr>
                <tr style="width: 500px; height: 100px">
                    <td style="width: 50px; height: 50px">Bild16</td>
                    <td style="width: 50px; height: 50px">Bild17</td>
                    <td style="width: 50px; height: 50px">Bild18</td>
                    <td style="width: 50px; height: 50px">Bild19</td>
                    <td style="width: 50px; height: 50px">Bild20</td>
                </tr>
                <tr style="width: 500px; height: 100px">
                    <td style="width: 50px; height: 50px">Bild21</td>
                    <td style="width: 50px; height: 50px">Bild22</td>
                    <td style="width: 50px; height: 50px">Bild23</td>
                    <td style="width: 50px; height: 50px">Bild24</td>
                    <td style="width: 50px; height: 50px">Bild25</td>
                </tr>
                </tbody>
            </table>

        </form>
        <?php echo $fehlermeldung; ?>
    </article>
    <footer><a href="view/nutzungsbedingung.php">Nutzungsbedingung</a></footer>

<?php include 'module/htmlend.php'; ?>
<?php
