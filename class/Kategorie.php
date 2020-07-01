<?php


class Kategorie
{
private int $id;
private string $bezeichnung;

    /**
     * Kategorie constructor.
     * @param int $id
     * @param string $bezeichnung
     */
    public function __construct(int $id, string $bezeichnung)
    {
        $this->id = $id;
        $this->bezeichnung = $bezeichnung;
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
    public function getBezeichnung(): string
    {
        return $this->bezeichnung;
    }

    /**
     * @param string $bezeichnung
     */
    public function setBezeichnung(string $bezeichnung): void
    {
        $this->bezeichnung = $bezeichnung;
    }

    //ALLE FUNKTIONEN in dieser Klasse sind von Restauranttyp.php.... nur geändert
    //Methoden ohne Struktogramm, @Lars und Thomas bitte genau prüfen, danke


    //Brauchen wir diese Funktion?
    //aus allen Daten ein Objekt Kategorie erstellen
    public static function getDataFromDatabase(): array
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'SELECT *
                FROM kategorie';
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $bildKategorie = $sth->fetchAll(PDO::FETCH_FUNC, 'Kategorie::builtFromPDO'); //Stimmt es so?
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        return $bildKategorie;
    }

    public static function builtFromPDO(int $id, string $bezeichnung): Kategorie
    {
        return new Kategorie($id, $bezeichnung);
    }

    public static function getById(int $id): Kategorie
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'SELECT *
                FROM kategorie
                WHERE id = :id';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('id', $id, PDO::PARAM_INT);
            $sth->execute();
            $bildKategorie = $sth->fetchAll(PDO::FETCH_FUNC, 'Kategorie::builtFromPDO');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        return $bildKategorie[0];
    }

    private static function insert(string $bezeichnung): void
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'INSERT INTO kategorie(id, bezeichnung)
                    VALUES(NULL, :bezeichnung)';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('bezeichnung', $bezeichnung, PDO::PARAM_STR);
            $sth->execute();
            $bildKategorie = $sth->fetchAll(PDO::FETCH_FUNC, 'Kategorie::builtFromPDO');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function buildBildKategorie(string $bezeichnung): void
    {
        //Methode insert aufrufen
        Kategorie::insert($bezeichnung);
    }

    //Methode aus Restaurant. Wird es hier benötigt??? Achtung nicht angepasst an KunsTinder!
//    public static function getPullDown() : string
//    {
//      $html= '';
//      $restauranttyps = self::getDataFromDatabase(); //Array mit allen Objekten von DB
//        $html .= '<select name="restauranttyp[]" multiple size="4">';
//        $html .= '<option value="0"></option>';
//        for($i=0; $i< count($restauranttyps); $i++)
//        {
//        $html .= ' <option value="' . $restauranttyps[$i]->getId() . '">' . $restauranttyps[$i]->getName() . '</option>';
//        }
//        $html .= '</select>';
//        return  $html;
//    }

    public static function deleteKategorie(int $id): void
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen

            $sql = 'DELETE FROM kategorie WHERE id = :id ';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('id', $id, PDO::PARAM_INT);
            $sth->execute();
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function updateKategorie(int $id, string $bezeichnung) : void
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'UPDATE kategorie
                    SET bezeichnung = :bezeichnung
                    WHERE id = :id';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('id', $id, PDO::PARAM_INT);
            $sth->bindParam('bezeichnung', $bezeichnung, PDO::PARAM_STR);
            $sth->execute();
            $bildKategorie = $sth->fetchAll(PDO::FETCH_FUNC, 'Kategorie::buildFromPDO');
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function buildFromPDO(int $id, string $bezeichnung): Kategorie
    {
        return new Kategorie($id, $bezeichnung);
    }

//    public function jsonSerialize()
//    {
//        return
//            [
//                'id'=>$this->getId(),
//                'bezeichnung'=>$this->getBezeichnung()
//            ];
//    }

}