<?php

/**
 *  Class ForumMessage
 *  @package Ebrid;
 */
class ForumMessage extends ForumTopic
{
    private $_idm;
    private $_idt;
    private $_uid;
    private $_title;
    private $_date;

    /**
     *  Construct
     *
     *  @param int $idm id of message
     *  @since 0.1
     */
    public function __construct($idm = 0)
    {
        if(self::exist($idm)) {
            if (verifInt($idm)) {
                $req = "SELECT * FROM forum WHERE id = '$idm'";
            }
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
            while ($a = mysqli_fetch_assoc($res)){
                $this->_idm = $a['idm'];
                $this->_idt = $a['idt'];
                $this->_uid= $a['uid'];
                $this->_title = $a['title'];
                $this->_date = $a['date'];
            }
        }else {
            $this->_idm = 0;
            $this->_idt = 0;
            $this->_uid = 0;
            $this->_title = 0;
            $this->_date = 0;
        }
    }

    /**
     *  Get Idm
     *
     *  @return int
     *  @since 0.1
     */
    public function getIdm()
    {
        return $this->_idm;
    }

    /**
     *  Get Idt
     *
     *  @return int
     *  @since 0.1
     */
    public function getIdt()
    {
        return $this->_idt;
    }

    /**
     *  Get Uid
     *
     *  @return int
     *  @since 0.1
     */
    public function getUid()
    {
        return $this->_uid;
    }

    /**
     *  Get Title
     *
     *  @return string
     *  @since 0.1
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     *  Get Date
     *
     *  @return string
     *  @since 0.1
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     *  Set Name and Check if it is correct
     *
     *  @param string $name name of the forum
     *  @return bool
     *  @since 0.1
     */
    public function setName($name){
        if (!preg_match("#^[\w]+$#", $name)) return false;
        $this->_name = $name;
        return true;
    }

    /**
     *  Set Description and Check if it is correct
     *  
     *  @param string $description description of the forum
     *  @return bool
     *  @since 0.1
     */
    public function setDescription($description){
       if (!preg_match("#^[\w\.\#\-\s]+$#", $description)) return false;
       $this->_description = $description;
       return true;
    }

    /**
     *  Set Date and Check if it is correct
     *  
     *  @param int $date date of the Message
     *  @return bool
     *  @since 0.1
     */
    public function setDate($date){
        if (preg_match("#^[\d]+$#", $date)){
            $d = $date;
        } else $d = time();
        $this->_date = date('Y-m-d H:i:s', $d);
        return true;
    }

    /**
     *  Insert the Name and the Description in the DB as a new Forum in the Category choosen
     *
     *  @return bool
     *  @since 0.1
     */
    public function insert()
    {
        $req = "INSERT INTO ForumMessage(title, date) VALUES ('".$this->_title."', '".$this->_date."')";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
        if(!$res) return false;
        return true;
    }

    /**
     *  Check if the Message already exists
     *  
     *  @param mixed $u idm or title
     *  @return bool
     *  @since 0.1
     */
    static public function _exist($u = null) 
    {
        if (!is_null($u)) 
        {
            if (verifInt($u)) $where = "idm = '" . intval($u) . "'";
            else if (verifName($u)) $where = "title = '$u'";
            else return false;
            
            $req = "SELECT idm FROM forumMessage WHERE " . $where;
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
            if (mysqli_num_rows($res) > 0) return true;
            else return false;
        }
        return false;
    }
}