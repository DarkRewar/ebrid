<?php

/**
 *  Class User
 *  @author Manu
 *  @package Ebrid
 *
 */
class User{
    private $uid;
    private $email;
    private $pseudo;
    private $password;
    private $nom;
    private $prenom;
    private $signature;
    private $created;
    private $connected;
    private $navigated;
    private $ip;
    private $statut;
    private $bantime;

    /**
        *Constructeur
        *@param int $uid
        *@package Ebrid
        *@since 0.1
        *
    */

   public  function __construct($uid = 0)
    {
        if(self::exist($uid)){
            if (verifInt($uid)){

                $req = "SELECT * FROM user WHERE uid = '$uid'";
            }else{
                $req = "SELECT * FROM user WHERE pseudo = '$uid'";
            }
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
            while($a = mysqli_fetch_assoc($res)){

                $this->uid = $a['uid'];
                $this->email = $a['email'];
                $this->pseudo = $a['pseudo'];
                $this->password = $a['password'];
                $this->nom = $a['nom'];
                $this->prenom = $a['prenom'];
                $this->signature = $a['signature'];
                $this->created = $a['created'];
                $this->connected = $a['connected'];
                $this->navigated = $a['navigated'];
                $this->ip = $a['ip'];
                $this->statut = $a['statut'];
                $this->bantime = $a['bantime'];
            }
        }else {
            $this->uid = 0;
            $this->email = 0;
            $this->pseudo = 0;
            $this->password = 0;
            $this->nom = 0;
            $this->prenom = 0;
            $this->signature = 0;
            $this->created = 0;
            $this->connected = 0;
            $this->navigated = 0;
            $this->ip = 0;
            $this->statut = 0;
            $this->bantime = 0;
        }        
    }


 
    public function setUid($uid){
        
        $this->uid = $uid;
    }

    public function getUid(){
        
        return $this->uid;
    }
    public function setEmail($email){
        
       if (!preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,4}$#", $email)) 
        {
            return false;
        }
        $this->email = $email;
        return true;
    }

    public function getEmail(){
        
        return $this->email;
    }

    public function setPseudo($pseudo){
         
        if (!preg_match("#^[\w\.\#\-\s]{5,}$#", $pseudo)) 
        {
            return false;
        }
        $this->pseudo = $pseudo;
        return true;
    }

    public function getPseudo(){
        
        return $this->pseudo;
    }

    public function setPassword($password){
        
        if (!preg_match("#^[\w\.\#\-\s]{6,}$#", $password)) 
        {
            return false;
        }   
        $this->password = $password;
        return true;
    }

    public function getPassword(){
        
        return $this->password;
    }

    public function setNom($nom){
        
        if(!preg_match("#^[\w\-]{2,}$#", $nom)){
            return false;
        }
        $this->nom = $nom;
        return true;
    }

    public function getNom(){
        
        return $this->nom;
    }

    public function setPrenom($prenom){
        if(!preg_match("#^[\w\-]{3,}$#", $prenom)){
            return false;
        }
        $this->prenom = $prenom;
        return true;
    }

    public function getPrenom(){
        
        return $this->prenom;
    }

    public function setSignature($signature){
        
        if(!preg_match("#^[\w\s\-\.]{6,}$#", $signature)){
            return false;
        }

        $this->signature = $signature;
        return true;
    }

    public function getSignature(){
        
        return $this->signature;
    }

    public function setCreated($created){
        
        $this->created = $created;
    }

    public function getCreated(){
        
        return $this->created;
    }

    public function setConnected($connected){
        
        $_SESSION['id'] = $connected;
        $this->connected = $connected;
    }

    public function getConnected(){
        
        return $this->connected;
    }

    public function setNavigated($navigated){
        
        $this->navigated = $navigated;
    }

    public function getNavigated(){
        
        return $this->navigated;
    }

    public function setIp($ip){
        if(!preg_match("#^[\d\.]{1,3}$#", $ip)){
            return false;
        }

        $this->ip = $ip;
        return true;           
    }

    public function getIp(){
        
        return $this->ip;
    }

    public function setStatut($statut){
        $statut = false;
        $this->statut = $statut;
    }

    public function getStatut(){
        
        return $this->statut;
    }

    public function setBantime($bantime){
    
        if(!preg_match("#^[\d]$#", $bantime)){
            return false;
        }    
        $this->bantime = $bantime;
        return true;
    
    }

    public function getBantime(){
        
        return $this->bantime;
    }

    public function insert()
    {
        $req = "INSERT INTO user(
                email
                ,pseudo
                ,password
                ,nom
                ,prenom
                ,signature
                ,created
                ,connected
                ,navigated
                ,ip
                ,statut
                ,bantime
            ) VALUES (
                '".$this->email."'
                , '".$this->pseudo."'
                , '" . md5($this->password) . "'
                , '".$this->nom."'
                ,'".$this->prenom."'
                ,'".$this->signature."'
                ,'".$this->created."'
                ,'".$this->connected."'
                ,'".$this->navigated."'
                ,'".$this->ip."'
                ,'".$this->statut."'
                ,'".$this->bantime."'
            )";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . __FILE__ . ' at the line ' . __LINE__ . ' with the resquest : ' . $req);
        if(!$res) return false;
        $this->_id = mysqli_insert_id();
        return true;
    }

    public function checkPassword($password)
    {
        if (md5($password) != $this->password) {
            return false;
        }
        return true;
    }

    static public function exist($u = null) 
    {
        if (!is_null($u)) 
        {
            if (verifMail($u)) $where = "email = '$u'";
            else if (verifInt($u)) $where = "uid = '" . intval($u) . "'";
            else if (verifName($u)) $where = "pseudo = '$u'";
            else return false;
            
            $req = "SELECT uid FROM user WHERE " . $where;
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . __FILE__ . ' at the line ' . __LINE__ . ' with the resquest : ' . $req);
            if (mysqli_num_rows($res) > 0) return true;
            else return false;
        }
        return false;
    }
        
}

