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
            if (is_numeric($idm)) {
                $req = "SELECT * FROM forum_message WHERE id = '$idm'";
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
    public function insertMessage()
    {
        $req = "INSERT INTO forum_message(title, date) VALUES ('".$this->_title."', '".$this->_date."')";
        $res = Database::_exec($req);

        if($res){
            $this->idm = Database::_lastInsertId();
        }
        return $this;        
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
            if (is_numeric($u)) $where = "idm = '" . intval($u) . "'";
            else if (is_string($u)) $where = "title = '$u'";
            else return false;
            
            $req = "SELECT idm FROM forum_message WHERE " . $where;
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
            if (mysqli_num_rows($res) > 0) return true;
            else return false;
        }
        return false;
    }
    public function generateMessage($uid){
        $this->uid = $uid;
        $this->insertMessage();
    }

    static public function _getMessages(){
    $req = "SELECT fm.idm, (SELECT title FROM forum_revision fr WHERE fr.idm = fm.idm ORDER BY idr DESC LIMIT 0,1) title
        FROM forum_message fm
        ORDER BY fm.idm
        LIMIT 0,5";
    return Database::_query($req);
    }

    static public function _getLastRevision($idm){
    $req = "SELECT idr FROM forum_revision WHERE idm = '$idm' ORDER BY idr DESC LIMIT 0,1";

    $revision = new ForumRevision(array('idm'=>$idm, 'idr'=>Database::_selectOne($req)));
    return $revision;
    }

    static public function _getRevisions($idm, $param = array()){
        $list = array();

        if(self::_exist($idm)){
            $req = "SELECT idm, idr, title, content, date, nickname
                FROM forum_revision fr, user u, forum_message fm
                WHERE fr.idm = '$idm' 
                AND fm.uid = u.uid";

            $list = Database::_query($req);
        }

        return $list;
    }


}