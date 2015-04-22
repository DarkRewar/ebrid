<?php
/**
 * Fichier Forum.Revision.php
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
 * Class Revision
 *
 * @category Forum
 * @package Ebrid
 * @since Version 0.1
 */
class ForumRevision extends ForumMessage
{
    private $idr;
    private $idm;
    private $title;
    private $content;
    private $date;

    /**
     *  Construct
     *
     *  @param int $idc id of category
     *  @since 0.1
     */

    public function __construct($save = array("idr"=>0, "idm"=>0)){
        if(is_array($save)){
            if(isset($save["idr"]) && self::_exist($save['idr']) ){
                $this->setIdr($idr);  
                $req = "
                    SELECT *
                    FROM forum_revision 
                    WHERE idr = '".$save['idr']."'";
                foreach (Database::_query($req) as $a){
                    $this->idm = $a['idm'];
                    $this->idr = $a['idr'];
                    $this->title = $a['title'];
                    $this->content = $a['content'];
                    $this->date = $a['date'];
                }
            }else if(isset($save['idm']) && ForumMessage:: _exist($save['idm'])){
                $req = "SELECT COUNT(1) FROM forum_revision WHERE idm = '".$save['idm']."'";
                $this->idm = $save['idm'];
                $this->idr = intval(Database::_selectOne($req))+1;
                $this->title = 0;
                $this->content = 0;
                $this->date = 0;
            }            
        }else{
            $this->idm = 0;
            $this->idr = 0;
            $this->title = 0;
            $this->content = 0;
            $this->date = 0;
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
        return $this->idr;
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
     *  Get Content
     *
     *  @return string
     *  @since 0.1
     */
    public function getContent()
    {
        return $this->content;
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
     *  Set Id of the Revision and check if it is correct
     *
     *  @param int $idr 
     *  @return bool
     *  @since 0.1
     */
    public function setIdr($idr){
        if (!preg_match("#^[\d]$#", $idr)) return false;
        $this->idr = $idr;
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
        $this->title = $title;
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
        $this->date = date('Y-m-d H:i:s', $d);
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
                '" . $this->idm .  "'
                , '" . $this->idr . "'
                , '" . $this->title . "'
                , '" . $this->content . "'
                , NOW()
            )";
        return Database::_exec($req);
    }

    public function generateRevision($p){
        extract($p);

        $this->setIdm($idm)
            ->setTitle($forumtitle)
            ->setContent($forumcontent);
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
}