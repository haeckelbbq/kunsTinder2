<?php


class User
{
    private int $id;
    private string $vorname;
    private string $nachname;
    private string $plz;
    private string $ort;
    private string $strassehausnummer;
    private string $username;
    private string $passwort;
    private string $rolle;
    private string $status;

    /**
     * User constructor.
     * @param int $id
     * @param string $vorname
     * @param string $nachname
     * @param string $plz
     * @param string $ort
     * @param string $strassehausnummer
     * @param string $username
     * @param string $passwort
     * @param string $rolle
     * @param string $status
     */
    public function __construct($id, $vorname, $nachname, $plz, $ort, $strassehausnummer, $username, $passwort, $rolle, $status)
    {
        $this->id = $id;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->plz = $plz;
        $this->ort = $ort;
        $this->strassehausnummer = $strassehausnummer;
        $this->username = $username;
        $this->passwort = $passwort;
        $this->rolle = $rolle;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * @param string $vorname
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

    /**
     * @return string
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    /**
     * @param string $nachname
     */
    public function setNachname($nachname)
    {
        $this->nachname = $nachname;
    }

    /**
     * @return string
     */
    public function getPlz()
    {
        return $this->plz;
    }

    /**
     * @param string $plz
     */
    public function setPlz($plz)
    {
        $this->plz = $plz;
    }

    /**
     * @return string
     */
    public function getOrt()
    {
        return $this->ort;
    }

    /**
     * @param string $ort
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;
    }

    /**
     * @return string
     */
    public function getStrassehausnummer()
    {
        return $this->strassehausnummer;
    }

    /**
     * @param string $strassehausnummer
     */
    public function setStrassehausnummer($strassehausnummer)
    {
        $this->strassehausnummer = $strassehausnummer;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPasswort()
    {
        return $this->passwort;
    }

    /**
     * @param string $passwort
     */
    public function setPasswort($passwort)
    {
        $this->passwort = $passwort;
    }

    /**
     * @return string
     */
    public function getRolle()
    {
        return $this->rolle;
    }

    /**
     * @param string $rolle
     */
    public function setRolle($rolle)
    {
        $this->rolle = $rolle;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    //Username Überprüfen für Registrierung
    public static function usernamenUeberpruefen (string $username) : bool
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen
            $sql = 'SELECT * FROM user
                    WHERE username = :username';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('username', $username, PDO::PARAM_STR);
            $sth->execute();
            $name = $sth->fetchAll(PDO::FETCH_FUNC, 'User::buildFromPDO');
            echo count($name) . '<br>';
            if(count($name) > 0){
                return true;
                echo '<br> User OK <br>';
            }
            else{
                echo '<br> User nicht OK <br>';
                return false;
            }
    }catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //Passwort überprüfen für Registrierung
    public static function passwortUeberpruefen(string $passwort1, string $passwort2) : bool
    {
        if($passwort1 != ''){
            if($passwort1===$passwort2){
                echo '<br> passwort OK <br>';
                return true;
            }
            else{
                echo '<br> passwort nicht OK <br>';
                return false;
            }
        }
        else{
            return false;
        }
    }

    //User Registrierung
    public static function userRegistrieren(string $username, string $vorname, string $nachname, string $plz, string $ort, string $strassehausnummer, string $passwort, string $passwort2) :string
    {
        if(!self::usernamenUeberpruefen($username)){
            if(self::passwortUeberpruefen($passwort, $passwort2)){
                try {
                    $dbh = Db::getConnection();
                    //DB abfragen
                    $sql = 'INSERT INTO user(username, vorname, nachname, plz, ort, strassehausnummer, passwort, rolle, status)
                        VALUES(:username, :vorname, :nachname, :plz, :ort, :strassehausnummer, SHA(:passwort), "user", "aktiv")';
                    $sth = $dbh->prepare($sql);
                    $sth->bindParam('username', $username, PDO::PARAM_STR);
                    $sth->bindParam('vorname', $vorname, PDO::PARAM_STR);
                    $sth->bindParam('nachname', $nachname, PDO::PARAM_STR);
                    $sth->bindParam('plz', $plz, PDO::PARAM_STR);
                    $sth->bindParam('ort', $ort, PDO::PARAM_STR);
                    $sth->bindParam('strassehausnummer', $strassehausnummer, PDO::PARAM_STR);
                    $sth->bindParam('passwort', $passwort, PDO::PARAM_STR);
                    $sth->execute();
                    return 'Sie haben sich erfolgreich registriert, willkommen!';
                } catch (PDOException $e)
                {
                    echo 'Connection failed: ' . $e->getMessage();
                }
            }else{
                return 'Die Passwörter stimmen nicht überein';
            }
        }
        else
        {
            return 'Der Username existiert bereits!';
        }
    }

    //Daten von User holen fürs Einloggen
    public static function userDatenHolen(string $username)
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen
            $sql = 'SELECT * FROM user
                    WHERE username = :username';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('username', $username, PDO::PARAM_STR);
            $sth->execute();
            $holeDaten = $sth->fetchAll(PDO::FETCH_FUNC, 'User::buildFromPDO');
           return $holeDaten[0];
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //User Einloggen
    public static function userEinloggen(string $username, string $passwort) : string
    {
        $userdaten = self::userDatenHolen($username) ;
        $loginPruefen = '';
        $loginPruefen = $userdaten->getUsername();
        $passwortPruefen = '';
        $passwortPruefen = $userdaten->getPasswort();
        $userId= 0;
        $userId = $userdaten ->getId();

        if($loginPruefen===$username){
            if($passwortPruefen===SHA1($passwort)){
                $_SESSION['userdaten'] = $userdaten;
//                echo '<pre>';
//                print_r($_SESSION);
//                echo '</pre>';
//            $_SESSION['username'] = $username;
            return 'Login erfolgreich';
            }
            else{
                return 'Das Passwort ist falsch';
            }
        }
        else{
            return 'Der Username existiert nicht';
        }
    }

    //Profil Ändern von User vom User
    public static function profilAendern(string $username, string $vorname, string $nachname, string $plz, string $ort, string $strassehausnummer, string $passwort, string $passwort2): string
    {
        try {
            $dbh = Db::getConnection();
            if($passwort != '')
            {
                if(self::passwortUeberpruefen($passwort, $passwort2))
                {
                    //DB abfragen
                    $sql = 'UPDATE user
                    SET vorname = :vorname, nachname = :nachname, plz = :plz, ort = :ort, strassehausnummer = :strassehausnummer, passwort = SHA(:passwort)
                    WHERE username = :username';
                    $sth = $dbh->prepare($sql); //$sh für PDOStatement (prepared Statement)
                    $sth->bindParam('vorname', $vorname, PDO::PARAM_STR);
                    $sth->bindParam('nachname', $nachname, PDO::PARAM_STR);
                    $sth->bindParam('plz', $plz, PDO::PARAM_STR);
                    $sth->bindParam('ort', $ort, PDO::PARAM_STR);
                    $sth->bindParam('strassehausnummer', $strassehausnummer, PDO::PARAM_STR);
                    $sth->bindParam('username', $username, PDO::PARAM_STR);
                    $sth->bindParam('passwort', $passwort, PDO::PARAM_STR);
                    $sth->execute();
                    $fehlermeldung = 'Die Änderung war erfolgreich!';
                }
                else
                {
                    $fehlermeldung = 'Die Änderung ist fehlgeschlagen, da das Passwort nicht mit der wiederholten Eingabe übereinstimmte!';
                }
            }
            else
            {
                $sql = 'UPDATE user SET vorname = :vorname, nachname = :nachname, plz = :plz, ort = :ort, strassehausnummer = :strassehausnummer WHERE username = :username';
                $sth = $dbh->prepare($sql); //$sh für PDOStatement (prepared Statement)
                $sth->bindParam('vorname', $vorname, PDO::PARAM_STR);
                $sth->bindParam('nachname', $nachname, PDO::PARAM_STR);
                $sth->bindParam('plz', $plz, PDO::PARAM_STR);
                $sth->bindParam('ort', $ort, PDO::PARAM_STR);
                $sth->bindParam('strassehausnummer', $strassehausnummer, PDO::PARAM_STR);
                $sth->bindParam('username', $username, PDO::PARAM_STR);
                $sth->execute();
                $fehlermeldung = 'Die Änderung war erfolgreich!';
            }
            return $fehlermeldung;
        }catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //User sperren vom Admin
    public static function userSperren(string $username, string $status): void
    {
        try {
            $dbh = Db::getConnection();

            //DB abfragen
            $sql = 'UPDATE user
                    SET username = :username, status = :status
                    WHERE username = :username';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('username', $username, PDO::PARAM_STR);
            $sth->bindParam('status', $status, PDO::PARAM_STR);
            $sth->execute();
        }catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //Status von User abfragen. Ist er aktiv oder nicht? Beeinflusst was gesehen wird oder nicht
    public static function userStatusAbfragen(string $username, string $status) : string
    {
        try {
            $dbh = Db::getConnection();
            //DB abfragen
            $sql = 'SELECT status = :status FROM user
                    WHERE username = :username';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('username', $username, PDO::PARAM_STR);
            $sth->bindParam('status', $status, PDO::PARAM_STR);
            $sth->execute();
            $status = $sth->fetchColumn(PDO::FETCH_COLUMN);
            return $status;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //User löschen vom Admin aus
    //war kein Struktogram! @Lars und Thomas, bitte genau prüfen->danke
    public static function userLoeschen(string $username) : void
    {
        try {
            $dbh = Db::getConnection();
            $sql = 'DELETE FROM user WHERE username = :username ';
            $sth = $dbh->prepare($sql);
            $sth->bindParam('username', $username, PDO::PARAM_STR);
            $sth->execute();
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function buildFromPDO(int $id, string $vorname, string $nachname, string $plz, string $ort, string $strassehausnummer, string $username, string $passwort, string $rolle, string $status) : User
    {
        return new User($id, $vorname, $nachname, $plz, $ort, $strassehausnummer, $username, $passwort, $rolle, $status);
    }
}