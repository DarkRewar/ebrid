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
 * @version 0.2
 */

/**
 * Class Category
 *
 * @category User
 * @package Ebrid
 * @since Version 0.1
 * @version 0.2
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
     *
     * @param int $uid
     * @package Ebrid
     * @since 0.1
     */
    public function __construct($uid = 0) {
        if ( self::_exist($uid) ) {
            if ( is_numeric($uid) ) {
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
            $this->password = null;
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
        if (preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,4}$#", $email)) {
            $this->email = $email;
        }
        return $this;
    }
    
    public function getEmail() {
        
        return $this->email;
    }
    
    public function setNickname($nickname) {
        
        if (!preg_match("#^[\w\.\#\-\s]{5,}$#", $nickname)) {
            return false;
        }
        $this->nickname = $nickname;
        return $this;
    }
    
    public function getNickname() {
        
        return $this->nickname;
    }
    
    public function setPassword($password) {
        
        if (!preg_match("#^[\w\.\#\-\s]{6,}$#", $password)) {
            return false;
        }
        $this->password = $password;
        return $this;
    }
    
    public function getPassword() {
        
        return $this->password;
    }
    
    public function setFirstname($name) {
        
        if ( preg_match("#^[a-zA-Z\-\' -à]+$#", $name) ) {
            $this->firstname = $name;
        }
        return $this;
    }
    
    public function getFirstname() {
        
        return $this->firstname;
    }
    
    public function setLastname($last_name) {
        if ( preg_match("#^[a-zA-Z\-\' -à]+$#", $last_name) ) {
            $this->lastname = $last_name;
        }
        return $this;
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
    
    public function getStatus() {        
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
    
    /**
     * Insert function
     *
     * @return self
     * @since Version 0.1
     * @version 0.2
     */
    public function insert() {
        $insert = "INSERT INTO user(
                email
                , nickname
                , password
                , first_name
                , last_name
                , created
                , status
            ) VALUES (
                :email
                , :nickname
                , :password
                , :firstname
                , :lastname
                , NOW()
                , '1'
            )";
        Database::_prepare( $insert );
        
        $params = array(
            ':email' => $this->getEmail(), 
            ':nickname' => $this->getNickname(), 
            ':password' => _sha4( $this->getPassword() ),
            ':firstname' => $this->getFirstname(), 
            ':lastname' => $this->getLastname()
        );
        Database::_execute( $params );
        var_dump(Database::_lastError());

        $this->setUid( Database::_lastInsertId() );
        return $this;
    }
    
    /**
     * Update function
     *
     * @return self
     * @since Version 0.1
     * @version 0.2
     */
    public function update() {
        $update = "
            UPDATE user
            SET `password` = :password,
                `first_name` = :firstname,
                `last_name` = :lastname,
                `signature` = :signature,
                `connected` = :connected,
                `navigated` = :navigated,
                `ip` = :ip,
                `status` = :status,
                `bantime` = :bantime
            WHERE `uid` = :uid
        ";
        Database::_prepare( $update );

        $params = array(
            ':uid' => $this->getUid(),
            ':password' => $this->getPassword(),
            ':firstname' => $this->getFirstname(),
            ':lastname' => $this->getLastname(),
            ':signature' => $this->getSignature(),
            ':connected' => $this->getConnected(),
            ':navigated' => $this->getNavigated(),
            ':ip' => $this->getIp(),
            ':status' => $this->getStatus(),
            ':bantime' => $this->getBantime()
        );
        Database::_execute( $params );

        return $this;
    }
    
    /**
     * Delete function
     *
     * @return self
     * @since Version 0.1
     * @version 0.2
     */
    public function delete() {
        $delete = "DELETE FROM user WHERE uid = :id";
        Database::_prepare( $delete );
        $param = array( ':id' => $this->getUid() );
        Database::_execute( $param );
        return $this;
    }
    
    /**
     * Create an user with the params
     * passed in post array
     *
     * @param array $post the $_POST array with elements to set
     * @return self
     * @since Version 0.1
     * @version 0.2
     */
    public function create($post) {
        $this->setNickname( $post['signup_nick'] );
        $this->setEmail( $post['signup_mail'] );
        $this->setPassword( $post['signup_pass'] );
        return $this->insert();
    }
    
    /**
     * Check if passwords match
     *
     * @param string $password the password to check
     * @return bool
     * @since Version 0.1
     * @version 0.2
     */
    public function checkPassword($password) {
        return _sha4($password) == $this->getPassword();
    }

    /**
     * Check if an user exists
     *
     * @param mixed $u id, email or nickame of user
     * @return bool
     * @since Version 0.1
     * @version 0.2
     */    
    static public function _exist($u = null) {
        if (checkEmail($u)) $where = "email = :user";
        else if (is_numeric($u)) $where = "uid = :user";
        else $where = "nickname = :user";
        
        $exist = "SELECT COUNT(1) FROM user WHERE " . $where;
        Database::_prepare($exist);
        $param =  array(':user' => $u);
        return (bool)Database::_selectOne( $param );
    }

    /**
     * Get all users
     *
     * @param int $page the number of the page to get
     * @return array
     * @since Version 0.2
     * @version 0.2
     */
    static public function _getAll($page = 0){
        if( !is_numeric( $page) ){
            return array();
        }

        $limitMin = (int)$page * 30;
        $limitMax = $limitMin + 30;

        $getAll = "SELECT uid 
            FROM user 
            ORDER BY uid ASC 
            LIMIT $limitMin, $limitMax";

        $users = array();

        foreach (Database::_query( $getAll ) as $user) {
            $users[$user['uid']] = new User( $user['uid'] );
        }

        return $users;
    }

    /**
     * Get the username of an user
     *
     * @param int $id id of the user concerned
     * @return string
     * @since Version 0.2
     */
    static function _getNickname($id){
        $getNick = "SELECT nickname FROM user WHERE uid = :id";
        Database::_prepare($getNick);
        Database::_bindParam(':id', intval($id), PDO::PARAM_INT);
        return Database::_selectOne();
    }
}
