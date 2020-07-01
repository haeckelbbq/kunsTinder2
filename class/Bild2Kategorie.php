<?php


class Bild2Kategorie
{
private int $id;
private int $bild_id;
private int $kategorie_id;

    /**
     * Bild2Kategorie constructor.
     * @param int $id
     * @param int $bild_id
     * @param int $kategorie_id
     */
    public function __construct(int $id, int $bild_id, int $kategorie_id)
    {
        $this->id = $id;
        $this->bild_id = $bild_id;
        $this->kategorie_id = $kategorie_id;
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
     * @return int
     */
    public function getBildId(): int
    {
        return $this->bild_id;
    }

    /**
     * @param int $bild_id
     */
    public function setBildId(int $bild_id): void
    {
        $this->bild_id = $bild_id;
    }

    /**
     * @return int
     */
    public function getKategorieId(): int
    {
        return $this->kategorie_id;
    }

    /**
     * @param int $kategorie_id
     */
    public function setKategorieId(int $kategorie_id): void
    {
        $this->kategorie_id = $kategorie_id;
    }

    //Methode um Kategorie-Objekt als Rückgabe zu bekommen
    //Methode ohne Struktogramm, @Lars und Thomas bitte genau prüfen, danke
    public static function insert(int $bild_id, int $kategorie_id ) : void
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen
            $sql = 'INSERT INTO bild2kategorie(id, bild_id, kategorie_id)
                        VALUES(NULL, :bild_id, :kategorie_id)';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('bild_id', $bild_id, PDO::PARAM_INT);
            $sth->bindParam('kategorie_id', $kategorie_id, PDO::PARAM_INT);
            $sth->execute();
            $bildKategorie = Kategorie::getById($kategorie_id);
            echo $dbh->lastInsertId();
            $bilds = $sth->fetchAll(PDO::FETCH_FUNC, 'Bild::buildFromPDO');
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //Methode aus Restaurant genommen. Wofür wird sie gebraucht?
    //Methode ohne Struktogramm, @Lars und Thomas bitte genau prüfen, danke
    public static function getKategorie_idsByBild(int $bild_id) : array
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'SELECT kategorie_id 
                FROM bild2kategorie
                WHERE bild_id = :bild_id';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('bild_id', $bild_id, PDO::PARAM_INT);
            $sth->execute();
            $bildKategorie_ids = $sth->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
        return $bildKategorie_ids;
    }

    //Kategorie vom Bild löschen
    ////Methode ohne Struktogramm, @Lars und Thomas bitte genau prüfen, danke
    public static function bildKategorieLoeschen(int $bild_id, int $kategorie_id) : void
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'DELETE FROM bild2kategorie
                WHERE bild_id = :bild_id AND kategorie_id = :kategorie_id';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('bild_id', $bild_id, PDO::PARAM_INT);
            $sth->bindParam('kategorie_id', $kategorie_id, PDO::PARAM_INT);
            $sth->execute();
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

}