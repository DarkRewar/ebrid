<?php

/**
 *  Class BlogRevision
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
            $this->idr = 0
            $this->ida = 0;
            $this->idc = 0;
            $this->uid = 0
            $this->titre = 0;
            $this->contenu = 0;
            $this->date = 0;
            $this->statut = 0;

        }
        
    }
}