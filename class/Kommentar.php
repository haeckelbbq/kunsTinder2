<?php


class Kommentar
{
    private int $id;
    private string $kommentartext;
    private string $erstelldatum;
    private int $user_id;
    private int $bild_id;

    /**
     * Kommentar constructor.
     * @param int $id
     * @param string $kommentartext
     * @param string $erstelldatum
     * @param int $user_id
     * @param int $bild_id
     */
    public function __construct(int $id, string $kommentartext, string $erstelldatum, int $user_id, int $bild_id)
    {
        $this->id = $id;
        $this->kommentartext = $kommentartext;
        $this->erstelldatum = $erstelldatum;
        $this->user_id = $user_id;
        $this->bild_id = $bild_id;
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
    public function getKommentartext(): string
    {
        return $this->kommentartext;
    }

    /**
     * @param string $kommentartext
     */
    public function setKommentartext(string $kommentartext): void
    {
        $this->kommentartext = $kommentartext;
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

//Kommentar einfügen
//Datum sollte automatisch kommen-> jetzt noch nicht in der Methode eingefügt
//-> lieber direkt in der DB mit CURRENT_TIMESTAMP als Standardwert
//Methode ohne Struktogramm, @Lars und Thomas bitte genau prüfen, danke
public static function kommentarEinfuegen(int $user_id, int $bild_id, string $kommentartext) : string
{
    try {
        $dbh = Db::getConnection();
        //DB abfragen
        $sql = 'INSERT INTO kommentar (user_id, bild_id, kommentartext, erstelldatum)
                        VALUES(:user_id, :bild_id, :kommentartext)';
        $sth = $dbh->prepare($sql);
        $sth->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $sth->bindParam('bild_id', $bild_id, PDO::PARAM_INT);
        $sth->bindParam('kommentartext', $kommentartext, PDO::PARAM_INT);
        $sth->execute();
    } catch (PDOException $e)
    {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

//Kommentar löschen
//Methode ohne Struktogramm, @Lars und Thomas bitte genau prüfen, danke
    public static function kommentarLoeschen(int $id) : void
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'DELETE FROM kommentar WHERE id = :id ';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('id', $id, PDO::PARAM_INT);
            $sth->execute();
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //Kommentar anzeigen
    //Datum automatisch anzeigen auch hier? Versuch mit NOW()
    //Methode ohne Struktogramm, @Lars und Thomas bitte genau prüfen, danke
    public static function kommentarAnzeigen(int $id) : string
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen
            $sql = 'SELECT *, NOW() FROM kommentar
                    WHERE id = :id';
            $sth = $dbh->prepare($sql); //$sh für PDOStatement (prepared Statement)
            $sth->bindParam('id', $id, PDO::PARAM_STR);
            $sth->execute();
            $holeKommentar = $sth->fetchAll(PDO::FETCH_COLUMN);
            return $holeKommentar;
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //Kommentar updaten von User aus -> in View anpassen?
    //wie ist es hier mit Datum gedacht? Neues oder altes?
    //Methode ohne Struktogramm, @Lars und Thomas bitte genau prüfen, danke
    public static function kommentarAnpassen(int $user_id, int $bild_id, string $kommentartext) : string
    {
        try {
            $dbh = Db::getConnection();

            //DB abfragen
            $sql = 'UPDATE kommentar
                    SET user_id = :user_id, bild_id = :bild_id, kommentartext = :kommentartext
                    WHERE id = :id';
            $sth = $dbh->prepare($sql); //$sh für PDOStatement (prepared Statement)
            $sth->bindParam('user_id', $user_id, PDO::PARAM_INT);
            $sth->bindParam('bild_id', $bild_id, PDO::PARAM_INT);
            $sth->bindParam('kommentartext', $kommentartext, PDO::PARAM_STR);
            $sth->execute();
        }catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function buildFromPDO(int $id, string $kommentartext, string $erstelldatum, int $user_id, int $bild_id ) : Kommentar
    {
        return new Kommentar($id, $kommentartext, $erstelldatum, $user_id, $bild_id);
    }
}