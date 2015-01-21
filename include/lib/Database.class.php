<?php

/**
 *  Class Description
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 */
class Database extends PDO
{
    static private $db;
    static private $last; //La dernière requete effectuée
    static private $error = null;

    /**
     *  Constructeur
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     */
    public function __construct()
    {
        $dsn = 'mysql:dbname='.DBNAME.';host='.DBHOST;
        $user = DBUSER;
        $password = DBPASSWORD;

        try{
            self::$db = parent::__construct($dsn, $user, $password);
        } catch (PDOException $e) {
            self::$error = $e;
        }
    }

    /**
     *  Initialise la classe Database
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @return bool
     */
    static public function _init(){
        self::$db = new Database();
        return true;
    }

    /**
     *  Get the last error
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @return mixed
     */
    static public function _lastError(){
        return self::$error;
    }

    /**
     *  Fonction qui fait une requete donnée et 
     *  retourne le résultat.
     *  On doit inserer la requete SQL dans la
     *  fonction en temps que paramètre.
     *
     *  Exemple: 
     *  $sql = "SELECT * FROM user";
     *  $result = Database::_query($sql);
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @param string $req la requete SQL
     *  @return mixed
     */
    static public function _query($sql = ""){
        self::$last = self::$db->query($sql);
        return self::$last;
    }

    /**
     *  Fonction qui fait une requete donnée et 
     *  retourne le résultat. Ce dernier sera
     *  unique, d'où l'interet de la fonction.
     *  On doit inserer la requete SQL dans la
     *  fonction en temps que paramètre.
     *
     *  Exemple: 
     *  $sql = "SELECT count(1) FROM user";
     *  $result = Database::_query($sql);
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @param string $req la requete SQL
     *  @return mixed
     */
    static public function _selectOne($sql = ""){
        self::$last = self::$db->query($sql);

        $return = null;
        foreach (self::$last as $k => $v) {
            foreach ($v as $kk => $vv) {
                $return =  $vv;
                break;
            }
            break;
        }
        return $return;
    }

    /**
     *  Fonction qui récupère l'id de la dernière
     *  insertion en DB.
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @return int
     */
    static public function _lastInsertId(){
        return self::$db->lastInsertId();
    }

    /**
     *  Exec function, permet d'executer une requete
     *
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @param string $sql la requete sql
     *  @return int
     */
    static public function _exec($sql){
        self::$last = self::$db->exec($sql);
        return self::$last;
    }

    /**
     *  BeginTransaction
     *  @see http://php.net/manual/fr/pdo.begintransaction.php
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @return bool
     */
    static public function _beginTransaction(){
        return self::$db->beginTransaction();
    }

    /**
     *  Commit
     *  @see http://php.net/manual/fr/pdo.commit.php
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @return bool
     */
    static public function _commit(){
        return self::$db->commit();
    }

    /**
     *  RollBack
     *  @see http://php.net/manual/fr/pdo.rollback.php
     *
     *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
     *
     *  @return bool
     */
    static public function _rollBack(){
        return self::$db->rollBack();
    }
}