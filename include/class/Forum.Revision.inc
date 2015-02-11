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
            }else if(isset($save['idm']) && ForumMessage:: _exist($save['idm'])){
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

    public function insertRevision(){
        $req = "INSERT INTO forum_revision(
                idm
                , idr
                , title
                , content
                , date

            ) VALUES(
                '" . $this->_idm .  "'
                , '" . $this->_idr . "'
                , '" . $this->_title . "'
                , '" . $this->_content . "'
                , NOW()
            )";
        return Database::_exec($req);
    }

    public function generateRevision($p){
        extract($p);

        $this
            ->setIdm($idm);
            ->setIdr($idr);
            ->setTitle($forum_title)
            ->setContent($forum_content)
    }

    static public function _exist($u = array()){
        if(!is_array($u)) return false;
        elseif (!isset($u['idm']) && !ForumMessage::_exist($u['idm']))
            return false;
        elseif(!isset($u['idr']) && !is_numeric($u['idr'])) 
            return false;

        $req = "
            SELECT COUNT(1) 
            FROM forum_revision 
            WHERE idm = '".$u['idm']."'
            AND idr = '".$u['idr']."'
        ";
        if(Database::_selectOne($req) > 0) return true;
        return false;
    }

    static public function _generateWith($post){
        if(isset($post['message'])){
            $revision = new ForumRevision(array('idm' => $post['message']));
        }else{
            $revision = new ForumRevision();
            $revision->generateMessage($post['uid']);
        
        $revision->generateRevision($post);

        $revision->insertRevision();

        return $revision;
    }
}