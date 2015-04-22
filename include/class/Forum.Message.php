<?php
/**
 * Fichier Forum.Message.php
 *
 * PHP version 5
 *
 * @category Forum
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com
 * @since Version 0.1
 */

/**
 * Class Message
 *
 * @category Forum
 * @package Ebrid
 * @since Version 0.1
 */
class ForumMessage extends ForumTopic
{
    private $idm;
    private $idt;
    private $uid;
    private $title;
    private $date;

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
            foreach (Database::_query($req) as $a){
                $this->idm = $a['idm'];
                $this->idt = $a['idt'];
                $this->uid= $a['uid'];
                $this->title = $a['title'];
                $this->date = $a['date'];
            }
        }else {
            $this->idm = 0;
            $this->idt = 0;
            $this->uid = 0;
            $this->title = 0;
            $this->date = 0;
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
        return $this->idm;
    }

    /**
     *  Get Idt
     *
     *  @return int
     *  @since 0.1
     */
    public function getIdt()
    {
        return $this->idt;
    }

    /**
     *  Get Uid
     *
     *  @return int
     *  @since 0.1
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     *  Get Title
     *
     *  @return string
     *  @since 0.1
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *  Get Date
     *
     *  @return string
     *  @since 0.1
     */
    public function getDate()
    {
        return $this->date;
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
        $this->date = date('Y-m-d H:i:s', $d);
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
        $req = "INSERT INTO forum_message(title, date) VALUES ('".$this->title."', '".$this->date."')";
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
            
            $req = "SELECT COUNT(1) FROM forum_message WHERE " . $where;
            if (Database::_selectOne($req) > 0) return true;
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