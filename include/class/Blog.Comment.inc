<?php

/**
 *  Class Comment
 *
 */
class BlogComment extends BlogArticle
{
    private $ida;
    private $id_com;
    private $uid;
    private $message;
    private $date;

    public function __construct($save = array("id_com"=>0, "ida"=>0)){
        if(is_array($save)){
            if(isset($save["id_com"]) && self::_exist($save['id_com']) ){
                $this->setId_com($id_com); 
                $req = "
                    SELECT *
                    FROM blog_comment 
                    WHERE id_com = '".$save['id_com']."'";
                $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__ . ' avec la requete : ' . $req);
                while($a = mysqli_fetch_assoc($res)){
                    $this->ida = $a['ida'];
                    $this->id_com = $a['id_com'];
                    $this->uid = $a['uid'];
                    $this->message = $a['message'];
                    $this->date = $a['date'];
                }
            }else if(isset($save['ida']) && BlogArticle:: _exist($save['ida'])){
                $req = "SELECT COUNT(1) FROM blog_comment WHERE ida = '".$save['ida']."'";
                $this->ida = $save['ida'];
                $this->id_com = intval(Database::_selectOne($req))+1;
                $this->uid = 0;
                $this->message = 0;
                $this->date = 0;
            }            
        }else{

            $this->ida = 0;
            $this->id_com = 0;
            $this->uid = 0;
            $this->message = 0;
            $this->date = 0;

        }
        
    }

    public function getIda()
    {
        return $this->ida;
    }

    public function setIda($ida)
    {
        if(!preg_match('#^[\d]+$#', $ida)) return false;
        $this->ida = $ida;

    }

    public function getId_com()
    {
        return $this->id_com;
    }

    public function setId_com($id_com)
    {
        if(!preg_match('#^[\d]+$#', $id_com)) return false;
        $this->id_com = $id_com;

    }

    public function getUid()
    {
        return $this->Uid;
    }

    public function setUid($uid)
    {
        if(!preg_match('#^[\d]+$#', $uid)) return false;
        $this->uid = $uid;

    }

    public function getMessage()
    {
        return stripslashes($this->message);
    }

    public function setMessage($message)
    {
        if(!preg_match('#^[\w\s\.\,\:\?\!\(\)]+$#', $message))return false;
        $this->message = addslashes($message);
        return $this->message;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function insert(){
        $req = "INSERT INTO blogComment(ida,uid,message) VALUES('".$this->ida."','".$this->uid."','".$this->message."')";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__ . ' avec la requete : ' . $req);
        return true;
    }

    static public function _exist($u = array()){
        if(!is_array($u)) return false;
        elseif (!isset($u['ida']) && !BlogArticle::_exist($u['ida']))
            return false;
        elseif(!isset($u['id_com']) && !is_numeric($u['id_com'])) 
            return false;

        $req = "
            SELECT COUNT(1) 
            FROM blog_comment 
            WHERE ida = '".$u['ida']."'
            AND id_com = '".$u['id_com']."'
        ";

        if(Database::_selectOne($req) > 0) return true;
        return false;
    }

}