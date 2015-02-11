<?php

/**
 *  Class Revision
 *
 */
class ForumRevision extends ForumMessage
{
    private $_idr;
    private $_idm;
    private $_title;
    private $_content;
    private $_date;

    /**
     *  Construct
     *
     *  @param int $idc id of category
     *  @since 0.1
     */

    public function __construct($save = array("idr"=>0, "idm"=>0)){
        if(is_array($save)){
            if(isset($save["idr"]) && self::_exist($save['idr']) ){
                $this->setIdr($_idr); 
                $req = "
                    SELECT *
                    FROM forumRevision 
                    WHERE idr = '".$a['idr']."'";
                $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__ . ' avec la requete : ' . $req);
                while($a = mysqli_fetch_assoc($res)){
                    $this->_idm = $a['idm'];
                    $this->_idr = $a['idr'];
                    $this->_title = $a['title'];
                    $this->_content = $a['content'];
                    $this->_date = $a['date'];
                }
            }else if(isset($save['idm']) && BlogArticle:: _exist($save['idm'])){
                $req = "SELECT COUNT(1) FROM forumRevision WHERE idm = '".$save['idm']."'";
                $this->_idm = $save['idm'];
                $this->_idr = intval(Database::_selectOne($req))+1;
                $this->_title = 0;
                $this->_content = 0;
                $this->_date = 0;
            }            
        }else{
            $this->_idm = 0;
            $this->_idr = 0;
            $this->_title = 0;
            $this->_content = 0;
            $this->_date = 0;
        }
    }

    /**
     *  Get Idr
     *
     *  @return int
     *  @since 0.1
     */
    public function getIdr()
    {
        return $this->_idr;
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
     *  Get Content
     *
     *  @return string
     *  @since 0.1
     */
    public function getContent()
    {
        return $this->_content;
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
     *  Set Id of the Revision and check if it is correct
     *
     *  @param int $idr 
     *  @return bool
     *  @since 0.1
     */
    public function setIdr($idr){
        if (!preg_match("#^[\d]$#", $idr)) return false;
        $this->_idr = $idr;
        return true;
    }

    /**
     *  Set Title and Check if it is correct
     *  
     *  @param string $title title of the forum
     *  @return bool
     *  @since 0.1
     */
    public function setTitle($title){
        if (!preg_match("#^[\w\.\#\-\s]{5,}$#", $title)) return false;
        $this->_title = $title;
        return true;
    }

    /**
     *  Set Content and Check if it is correct
     *  
     *  @param string $content content of the forum
     *  @return bool
     *  @since 0.1
     */
    public function setContent($content){
       if (!preg_match("#^[\w\.\#\-\s]+$#", $content)) return false;
       $this->_description = $content;
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
     *  Insert the Title the Content in the DB as a new Category
     *
     *  @return bool
     *  @since 0.1
     */
    public function insert()
    {
        $req = "INSERT INTO forumRevision(title, content, idm, date) VALUES ('".$this->_title."', '".$this->_content."', '".$this->_idm."', '".$this->_date."')";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
        if(!$res) return false;
        return true;
    }


    /**
     *  Check if the Revision already exists
     *  
     *  @param mixed $u idf or name
     *  @return bool
     *  @since 0.1
     */
    static public function _exist($u = null) 
    {
        if (!is_null($u)) 
        {
            if (is_numeric($u)) $where = "idr = '" . intval($u) . "'";
            else return false;
            
            $req = "SELECT idr FROM forumRevision WHERE " . $where;
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
            if (mysqli_num_rows($res) > 0) return true;
            else return false;
        }
        return false;
    }
}