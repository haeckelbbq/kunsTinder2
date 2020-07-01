<?php


class Bild
{
    private int $id;
    private string $bildtitel;
    private string $erstelldatum;
    private string $bild; // @Lars und Thomas, als string, right?
    private int $user_id;
    //private string $vorschau;

    /**
     * Bild constructor.
     * @param int $id
     * @param string $bildtitel
     * @param string $erstelldatum
     * @param string $bild
     * @param int $user_id
     * @param string $vorschau
     */
    public function __construct(int $id, string $bildtitel, string $erstelldatum, string $bild, int $user_id) //, string $vorschau
    {
        $this->id = $id;
        $this->bildtitel = $bildtitel;
        $this->erstelldatum = $erstelldatum;
        $this->bild = $bild;
        $this->user_id = $user_id;
        //$this->vorschau = $vorschau;
    }

    /**
     * @return string
     */
    public function getVorschau(): string
    {
        return $this->vorschau;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getBildtitel(): string
    {
        return $this->bildtitel;
    }

    /**
     * @param string $bildtitel
     */
    public function setBildtitel(string $bildtitel): void
    {
        $this->bildtitel = $bildtitel;
    }

    /**
     * @return string
     */
    public function getErstelldatum(): string
    {
        return $this->erstelldatum;
    }

    /**
     * @param string $erstelldatum
     */
    public function setErstelldatum(string $erstelldatum): void
    {
        $this->erstelldatum = $erstelldatum;
    }

    /**
     * @return string
     */
    public function getBild(): string
    {
        return $this->bild;
    }

    /**
     * @param string $bild
     */
    public function setBild(string $bild): void
    {
        $this->bild = $bild;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

//Bild löschen kann sowohl von Admin als auch von User benutzt werden
    public static function bildLoeschen(string $bildtitel):void
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'DELETE FROM bild WHERE bildtitel = :bildtitel ';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('bildtitel', $bildtitel, PDO::PARAM_STR);
            $sth->execute();
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

//Bild Wechseln, wenn button next gedrückt wird in View
    public static function bildWechseln() : array
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'SELECT max(id) FROM bild';
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $bildID = $sth->fetchAll();
            do{
                $zufallsBildId = random_int(1, $bildID[0][0]);
                $sql = 'SELECT * FROM bild WHERE id = :zufallsBildId ';
                $sth = $dbh->prepare($sql);
                $sth->bindParam('zufallsBildId', $zufallsBildId, PDO::PARAM_STR);
                $sth->execute();
                $zufallsBild = $sth->fetchAll(PDO::FETCH_FUNC,'Bild::buildFromPDO');
            }
            while(count($zufallsBild) === 0);
            //Bild::bildAnzeigen($zufallsBild[0]->getBild());

            $sql = 'SELECT * FROM bewertung WHERE bild_id = :id ';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('id', $zufallsBildId, PDO::PARAM_STR);
            $sth->execute();
            $bewertungen = $sth->fetchAll(PDO::FETCH_FUNC,'Bewertung::buildFromPDO');

            if(count($bewertungen) === 0)
            {
                $durchschnittsbewertung = 0;
            }
            else
            {
                $durchschnittsbewertung = 1; // Bewertung::durchschnittsbewertungErmitteln($zufallsBildId)
            }

            $userId = $zufallsBild[0]->getUserId();
            $sql = 'SELECT * FROM user WHERE id = :id';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('id', $userId, PDO::PARAM_STR);
            $sth->execute();
            $userDaten = $sth->fetchAll(PDO::FETCH_FUNC, 'User::buildFromPDO');

            $ausgabe = array('bildId' => $zufallsBildId, 'kuenstler' => $userDaten[0]->getUsername(), 'bildtitel' => $zufallsBild[0]->getBildtitel(), 'erstelldatum' => $zufallsBild[0]->getErstelldatum(), 'durchschnittsbewertung' => $durchschnittsbewertung, 'bild' => $zufallsBild[0]->getBild());
            return $ausgabe;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //SUCH FUNKTION, von aside in View, was der User unter bildtitel, Künstler und Kategorie suchen kann
    public static function datenSuchen($kategorie, $username, $bildtitel) : array
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen
            $sql = "SELECT * FROM bild
                    WHERE kategorie LIKE '%:kategorie%' AND  username LIKE '%:username%' AND bildtitel LIKE '%:bildtitel%' ";
            $sth = $dbh->prepare($sql);
            $sth->bindParam('kategorie', $kategorie, PDO::PARAM_STR);
            $sth->bindParam('username', $username, PDO::PARAM_STR);
            $sth->bindParam('bildtitel', $bildtitel, PDO::PARAM_STR);
            $sth->execute();
            $suchDaten = $sth->fetchAll(PDO::FETCH_FUNC, 'Bild::buildFromPDO');
            return $suchDaten;
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //Tabelle anzeigen
    //getVorschau() prüfen
    public static function tabelleAnzeigen($seite, $bildtitel, $kategorie, $username) : string
    {
        $ausgabe = '';
        $startpunkt = 0;
        $area= $_REQUEST['area'] ?? 'anonymous';
        $rolle= $_REQUEST['rolle'] ?? '';
        if ($seite > 1)
        {
            $startpunkt = $seite * 10 - 10;
        }
        $suchDaten[ ] = self::datenSuchen($kategorie, $username, $bildtitel);
        if ($suchDaten -> Length < 10)
        {
            $anzahlEinträge = $suchDaten -> Length;
        }
        else
        {
            $anzahlEinträge = 10;
        }
        if ($area!= 'anonymous')
        {
            if ($rolle === 'admin')
            {
                $ausgabe = $ausgabe.
                '
                <th>Kunstwerk</th>
				<th></th>
				<th>Vorschau</th>
				<th>Kategorie</th>
				<th>Künstler</th>
				<th></th>
				<th></th>';
                for ( $i = $startpunkt; $i <= $startpunkt + $anzahlEinträge-1 ; $i += (1))
                {
                    $ausgabe = $ausgabe.
                    '
                    <tr>
                    <td>$suchDaten[i] -> getBildtitel()</td>
					<td><a href ="index.php?action=bildloeschen&area=user">Bild löschen</a></td> 
					<td>$suchDaten[i] -> getVorschau()</td> 
					<td>$suchDaten[i] -> getKategorie()</td>
					<td>$suchDaten[i] -> getUsername()</td>
					<td><a href ="index.php?action=usersperren&area=user">Benutzer sperren</a></td>
					<td><a href ="index.php?action=userloeschen&area=user">Benutzer löschen</a></td>
					</tr>';
                }
            }
            else
            {
                $ausgabe = $ausgabe.
                '
                <th>Kunstwerk</th>
				<th>Vorschau</th>
				<th>Kategorie</th>
				<th>Künstler</th>';
                for ($i = $startpunkt; $i <= $startpunkt + $anzahlEinträge-1; $i += (1))
                {
                    $ausgabe = $ausgabe.
                    '
                    <tr>
                    <td>$suchDaten[i] -> getBildtitel()</td>
					<td>$suchDaten[i] -> getVorschau()</td> 
					<td>$suchDaten[i] -> getKategorie()</td>
					<td>$suchDaten[i] -> getUsername()</td>
					</tr>';
                }
            }
        }
        else
        {
            $ausgabe = $ausgabe.
            '
            <th>Kunstwerk</th>
			<th>Vorschau</th>
			<th>Kategorie</th>
			<th>Künstler</th>';
            for ($i = $startpunkt; $i <= $startpunkt + $anzahlEinträge-1; $i += (1))
            {
                $ausgabe = $ausgabe.
                '
                <tr>
                <td>$suchDaten[i] -> getBildtitel()</td>
				<td>$suchDaten[i] -> getVorschau()</td>
				<td>$suchDaten[i] -> getKategorie()</td>
				<td>$suchDaten[i] -> getUsername()</td>
				</tr>';

            }
        }
        return $ausgabe;
    }

    //Bild anzeigen
    public static function bildAnzeigen(string $bild)
    {
        echo '<img src="data:image/png;base64,'.base64_encode($bild).'"/>';
    }

    // String aus BLOB erstellen
    public static function bildStringErstellen(string $pfad)
    {
        $filename = $pfad;
        $handle = fopen($filename, "rb");
        $bildstring = fread($handle, filesize($filename));
        fclose($handle);
        return $bildstring;
    }

    //Bild in DB speichern
    public static function insertBild(string $bildtitel, string $erstelldatum, string $bild, string $userid)
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen
            $sql = 'INSERT INTO bild(bildtitel, erstelldatum, bild, user_id) VALUES(:bildtitel, :erstelldatum, :bild, :userid)';
            $sth = $dbh->prepare($sql); //$sh für PDOStatement (prepared Statement)
            $sth->bindParam('bildtitel', $bildtitel, PDO::PARAM_STR);
            $sth->bindParam('erstelldatum', $erstelldatum, PDO::PARAM_STR);
            $sth->bindParam('bild', $bild, PDO::PARAM_STR);
            $sth->bindParam('userid', $userid, PDO::PARAM_INT);
            $sth->execute();
            return 'Das Bild wurde erfolgreich hochgeladen!';
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
            return 'FEHLER!!!';
        }
    }

    //Bild aus dem DB holen
    public static function bildDatenHolen(string $bildtitel)
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen
            $sql = 'SELECT * FROM bild
                    WHERE bildtitel = :bildtitel';
            $sth = $dbh->prepare($sql); //$sh für PDOStatement (prepared Statement)
            $sth->bindParam('bildtitel', $bildtitel, PDO::PARAM_STR);
            $sth->execute();
            $holeDaten = $sth->fetchAll(PDO::FETCH_FUNC, 'Bild::buildFromPDO');
            return $holeDaten[0];
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }


    public static function buildFromPDO(int $id, string $bildtitel, string $erstelldatum, string $bild, int $user_id) : Bild // @Lars und Thomas ist $bild ein string???
    {
        return new Bild($id, $bildtitel, $erstelldatum, $bild, $user_id);
    }


// TO DO:
//Methode bildAnzeigen fehlt -> done
//Methode bildHochladen fehlt -> done
//Tabelle anzeigen -> done
//Bild Vorschau
}