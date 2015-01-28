<?php

/**
 *  Class Revision
 *
 */
class BlogRevision extends BlogArticle
{
    private $idr;
    private $ida;
    private $idc;
    private $uid;
    private $titre;
    private $contenu;
    private $date;
    private $statut;
    public function __construct($revision = array('$idr' => 0  , '$ida' => 0 ))
    {
        if(is_array($revision)){
            if(isset($save["idr"]) && self::_exist($save['idr']) ){
                $this->setIdr($idr); 
                $req = "
                    SELECT *
                    FROM blog_revision 
                    WHERE idr = '".$revision['id_com']."'";
                $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__ . ' avec la requete : ' . $req);
                while($a = mysqli_fetch_assoc($res)){
                    $this->idr = $a['idr'];
                    $this->ida = $a['ida'];
                    $this->idc = $a['idc'];
                    $this->uid = $a['uid'];
                    $this->titre = $a['titre'];
                    $this->contenu = $a['contenu'];
                    $this->date = $a['date'];
                    $this->statut = $a['statut'];
                }
            }else if(isset($revision['idr']) && BlogArticle:: _exist($revision['idr'])){
                $req = "SELECT COUNT(1) FROM blog_revision WHERE ida = '".$revision['idr']."'";
                $this->idr = intval(Database::_selectOne($req))+1;
                $this->ida = $revision['ida'];
                $this->idc = 0;
                $this->uid = 0;
                $this->titre = 0;
                $this->contenu = 0;
                $this->date = 0;
                $this->statut = 0;
            }            
        }else{
            $this->idr = 0;
            $this->ida = 0;
            $this->idc = 0;
            $this->uid = 0;
            $this->titre = 0;
            $this->contenu = 0;
            $this->date = 0;
            $this->statut = 0;

        }
        
    }

    public function getIdr()
    {
        return $this->idr;
    }

    public function setIdr($idr)
    {
        if(!preg_match('#^[\d]+$#', $idr)) return false;
        $this->idr = $idr;
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

    public function getIdc()
    {
        return $this->idc;
    }

    public function setIdc($idc)
    {
        if(!preg_match('#^[\d]+$#', $idc)) return false;
        $this->idc = $idc;
    }

     public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        if(!preg_match('#^[\d]+$#', $uid)) return false;
        $this->uid = $uid;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        if(!preg_match('#^[\w\s\.\,\:\?\!\(\)]+$#', $titre)) return false;
        $this->titre = $titre;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu($contenu)
    {
        if(!preg_match('#^[\w\s\.\,\:\?\!\(\)]+$#', $contenu)) return false;
        $this->contenu = $contenu;
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

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($statut)
    {
        if(!preg_match('#^[\d]+$#', $statut)) return false;
        $this->statut = $statut;
    }
    public function insert(){
        $req = "INSERT INTO blogRevision(idr,ida,uid,idc,titre,contenu,statut) VALUES('".$this->idr."','".$this->ida."','".$this->uid."','".$this->idc."','".$this->titre."','".$this->contenu."','".$this->statut."',)";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__ . ' avec la requete : ' . $req);
        return true;
    }

    static public function _exist($u = array()){
        if(!is_array($u)) return false;
        elseif (!isset($u['ida']) && !BlogArticle::_exist($u['ida']))
            return false;
        elseif(!isset($u['idr']) && !is_numeric($u['idr'])) 
            return false;

        $req = "
            SELECT COUNT(1) 
            FROM blog_article 
            WHERE ida = '".$u['ida']."'
            AND idr = '".$u['idr']."'
        ";

        if(Database::_selectOne($req) > 0) return true;
        return false;
    }
}