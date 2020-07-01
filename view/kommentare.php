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
<thead>
<th>Datum</th>
<th>Username</th>
<th>Kommentar</th>
</thead>
            <tbody>
            <tr>

                <?php if (isset($user_id) && User::getById($user_id)->getRolle() === 'user') {
                    echo '<th>bisherige Bewertung</th>';
                } ?>
                <?php if (isset($user_id) && User::getById($user_id)->getRolle() === 'admin') {
                    echo '';
                } ?>

            </tr>
            <?php
            for ($i = 0; $i < count($kommentare); $i++) {
            ?>
            <tr>
                <td><?php echo $kommentare[$i]->getDatum(); ?></td>
                <td><?php echo $kommentare[$i]->getUsername(); ?></td>
                <td><?php echo $kommentare[$i]->getKommentar(); ?></td>
            </tr>

                <tr>
                    <?php if (isset($user_id) && User::getById($user_id)->getRolle() === 'user') {
                        if (User::getRestaurantbewertung($users[$i]->getId(), $user_id) == 0) {
                            $id = $users[$i]->getId();
                            echo '<td><a href="index.php?action=zeigeaendern&area=user' ?><?php echo $id; ?><?php echo '"><button>bewerten</button></a></td>';

                        } else {

                            echo '<td>' . User::getbildbewertung($users[$i]->getId(), $user_id) . '</td>';
                        }
                    }
                    if (isset($user_id) && User::getById($user_id)->getRolle() === 'admin') {
                        echo '<td><a href="index.php?action=userloeschen&area=user' . $users[$i]->getId() . '"><button>Löschen</button></a></td>';
                    }
                    ?>
                </tr>
                <td>
                    <?php
                    if (Bewertung_Restaurant_User::getKommentar($users[$i]->getId(), $user_id) === '-' && ($user_id != 0)) {
                        echo '<a href="index.php?action=zeigeaendern&area=user' ?><?php echo $id; ?><?php echo '" ><button>kommentieren</button></a>';
                    } else {
                        echo Bewertung_Restaurant_User::getKommentar($users[$i]->getId(), $user_id);
                    }
                    ?></td>

            <?php
            }
            ?>

            <tr>

            </tr>
            </tbody>

        </table>
    </article>
    <footer><a href="view/nutzungsbedingung.php">Nutzungsbedingung</a></footer>

    <?php include 'module/htmlend.php'; ?>
