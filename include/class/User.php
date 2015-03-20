<?php
/**
 * Fichier User.php
 *
 * PHP version 5
 *
 * @category User
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com
 * @since Version 0.1
 */

/**
 * Class Category
 *
 * @category User
 * @package Ebrid
 * @since Version 0.1
 */
class User
{
    private $uid;
    private $email;
    private $nickname;
    private $password;
    private $firstname;
    private $lastname;
    private $signature;
    private $created;
    private $connected;
    private $navigated;
    private $ip;
    private $status;
    private $bantime;
    
    /**
     * Constructeur
     * @param int $uid
     * @package Ebrid
     * @since 0.1
     *
     */
    public function __construct($uid = 0) {
        if (self::_exist($uid)) {
            if (is_numeric($uid)) {
                $req = "SELECT * FROM user WHERE uid = '$uid'";
            } 
            else {
                $req = "SELECT * FROM user WHERE nickname = '$uid'";
            }
            
            foreach (Database::_query($req) as $a) {
                $this->uid = $a['uid'];
                $this->email = $a['email'];
                $this->nickname = $a['nickname'];
                $this->password = $a['password'];
                $this->firstname = $a['first_name'];
                $this->lastname = $a['last_name'];
                $this->signature = $a['signature'];
                $this->created = $a['created'];
                $this->connected = $a['connected'];
                $this->navigated = $a['navigated'];
                $this->ip = $a['ip'];
                $this->status = $a['status'];
                $this->bantime = $a['bantime'];
            }
        } 
        else {
            $this->uid = 0;
            $this->email = 0;
            $this->nickname = 0;
            $this->password = 0;
            $this->name = null;
            $this->last_name = null;
            $this->signature = null;
            $this->created = 0;
            $this->connected = 0;
            $this->navigated = 0;
            $this->ip = '0.0.0.0';
            $this->status = 0;
            $this->bantime = 0;
        }
    }
    
    public function setUid($uid) {
        
        $this->uid = $uid;
    }
    
    public function getUid() {
        
        return $this->uid;
    }
    public function setEmail($email) {
        
        if (!preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,4}$#", $email)) {
            return false;
        }
        $this->email = $email;
        return true;
    }
    
    public function getEmail() {
        
        return $this->email;
    }
    
    public function setNickame($nick) {
        
        if (!preg_match("#^[\w\.\#\-\s]{5,}$#", $nickname)) {
            return false;
        }
        $this->nickname = $nickname;
        return true;
    }
    
    public function getNickname() {
        
        return $this->nickname;
    }
    
    public function setPassword($password) {
        
        if (!preg_match("#^[\w\.\#\-\s]{6,}$#", $password)) {
            return false;
        }
        $this->password = $password;
        return true;
    }
    
    public function getPassword() {
        
        return $this->password;
    }
    
    public function setFirstname($name) {
        
        if (!preg_match("#^[\w\-]{2,}$#", $name)) {
            return false;
        }
        $this->firstname = $name;
        return true;
    }
    
    public function getFirstname() {
        
        return $this->firstname;
    }
    
    public function setLastname($last_name) {
        if (!preg_match("#^[\w\-]{3,}$#", $last_name)) {
            return false;
        }
        $this->lastname = $last_name;
        return true;
    }
    
    public function getLastname() {
        
        return $this->lastname;
    }
    
    public function setSignature($signature) {
        
        if (!preg_match("#^[\w\s\-\.]{6,}$#", $signature)) {
            return false;
        }
        
        $this->signature = $signature;
        return true;
    }
    
    public function getSignature() {
        
        return $this->signature;
    }
    
    public function setCreated($created) {
        
        $this->created = $created;
    }
    
    public function getCreated() {
        
        return $this->created;
    }
    
    public function setConnected($connected) {
        
        $_SESSION['id'] = $connected;
        $this->connected = $connected;
    }
    
    public function getConnected() {
        
        return $this->connected;
    }
    
    public function setNavigated($navigated) {
        
        $this->navigated = $navigated;
    }
    
    public function getNavigated() {
        
        return $this->navigated;
    }
    
    public function setIp($ip) {
        if (!preg_match("#^[\d\.]{1,3}$#", $ip)) {
            return false;
        }
        
        $this->ip = $ip;
        return true;
    }
    
    public function getIp() {
        
        return $this->ip;
    }
    
    public function setStatus($status) {
        $status = false;
        $this->status = $status;
    }
    
    public function getstatus() {
        
        return $this->status;
    }
    
    public function setBantime($bantime) {
        
        if (!preg_match("#^[\d]$#", $bantime)) {
            return false;
        }
        $this->bantime = $bantime;
        return true;
    }
    
    public function getBantime() {
        
        return $this->bantime;
    }
    
    public function insert() {
        $req = "INSERT INTO user(
                email
                , nickname
                , password
                , first_name
                , last_name
                , created
                , status
            ) VALUES (
                '" . $this->email . "'
                , '" . $this->nickname . "'
                , '" . _sha4($this->password) . "'
                , '" . $this->firstname . "'
                , '" . $this->lastname . "'
                , NOW()
                , '1'
            )";
        return Database::_exec($req);
    }
    
    public function update() {
        $req = "
            UPDATE user
            SET `password` = '" . $this->password . "',
                `first_name` = '" . $this->firstname . "',
                `last_name` = '" . $this->lastname . "',
                `signature` = '" . $this->signature . "',
                `connected` = '" . $this->connected . "',
                `navigated` = '" . $this->navigated . "',
                `ip` = '" . $this->ip . "'
                `status` = '" . $this->status . "',
                `bantime` = '" . $this->bantime . "'
            WHERE `uid` = '" . $this->uid . "'
        ";
        return Database::_exec($req);
    }
    
    public function delete() {
        $req = "DELETE FROM user WHERE uid = '" . $this->uid . "'";
        return Database::_exec($req);
    }
    
    public function create($post) {
        $this->nickname = $post['signup_nick'];
        $this->email = $post['signup_mail'];
        $this->password = $post['signup_pass'];
        $this->insert();
    }
    
    public function checkPassword($password) {
        if (_sha4($password) != $this->password) {
            return false;
        }
        return true;
    }
    
    static public function _exist($u = null) {
        if (!is_null($u)) {
            if (checkEmail($u)) $where = "email = '$u'";
            else if (is_numeric($u)) $where = "uid = '" . intval($u) . "'";
            else if (checkNickname($u)) $where = "nickname = '$u'";
            else return false;
            
            $req = "SELECT COUNT(1) FROM user WHERE " . $where;
            if (Database::_selectOne($req) > 0) return true;
        }
        return false;
    }
}
