<?php

/**
 *  Class Revision
 *
 */
class BlogRevision extends BlogArticle
{
    private $idr;
    private $idc;
    private $uid;
    private $title;
    private $content;
    private $date;
    private $status;

    public function __construct($revision = array('idr' => 0  , 'ida' => 0 ))
    {
        if(is_array($revision)){
            extract($revision);

            if( isset($ida) && parent::_exist($ida)
                && isset($idr) && self::_exist($revision) ){
                parent::__construct($ida);
                $this->setIdr($idr); 
                $req = "
                    SELECT *
                    FROM blog_revision 
                    WHERE idr = '$idr'
                    AND ida = '$ida'";
                foreach(Database::_query($req) as $a){
                    $this->idr = $a['idr'];
                    $this->setIda($a['ida']);
                    $this->idc = $a['idc'];
                    $this->uid = $a['uid'];
                    $this->title = $a['title'];
                    $this->content = $a['content'];
                    $this->date = $a['date'];
                    $this->status = $a['status'];
                }
            }else if( isset($ida) && parent::_exist($ida) ){
                var_dump("$idr");
                parent::__construct($ida);
                $req = "SELECT idr 
                    FROM blog_revision 
                    WHERE ida = '$ida'
                    ORDER BY idr DESC
                    LIMIT 0,1";
                $this->idr = intval(Database::_selectOne($req))+1;
                $this->setIda($ida);
                $this->idc = 0;
                $this->uid = 0;
                $this->title = null;
                $this->content = null;
                $this->date = date();
                $this->status = 0;
            }else{
                $this->idr = 1;
                $this->setIda(0);
                $this->idc = 0;
                $this->uid = 0;
                $this->title = null;
                $this->content = null;
                $this->date = 0;
                $this->status = 0;
            }      
        }else{
            $this->idr = 1;
            $this->setIda(0);
            $this->idc = 0;
            $this->uid = 0;
            $this->title = null;
            $this->content = null;
            $this->date = 0;
            $this->status = 0;
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

    public function getTitle()
    {
        return stripslashes($this->title);
    }

    public function setTitle($title)
    {
        //if(preg_match('#^[\w\s\.\,\:\?\!\(\)]+$#', $title))
            $this->title = addslashes($title);
        return $this;
    }

    public function getContent()
    {
        return stripslashes($this->content);
    }

    public function setContent($content)
    {
        //if(preg_match('#^[\w\s\.\,\:\?\!\(\)]+$#', $content))
            $this->content = addslashes($content);
        return $this;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('#^[\d]+$#', $status))
            $this->status = $status;
        return $this;
    }

    public function insertRevision(){
        $this->pushCategories();
        $req = "INSERT INTO blog_revision(
                idr
                , ida
                , uid
                , idc
                , title
                , content
                , status
                , date
            ) VALUES(
                '" . $this->idr  .  "'
                , '" . $this->getIda() . "'
                , '" . $this->uid . "'
                , '" . $this->idc . "'
                , '" . $this->title . "'
                , '" . $this->content . "'
                , '" . $this->status . "'
                , NOW()
            )";
        return Database::_exec($req);
    }

    public function generateRevision($p){
        extract($p);

        $this
            ->setTitle($article_title)
            ->setContent($article_content)
            ->setUid($uid);
    }

    static public function _exist($u = array()){
        if(!is_array($u)) return false;
        elseif (!isset($u['ida']) && !BlogArticle::_exist($u['ida']))
            return false;
        elseif(!isset($u['idr']) && !is_numeric($u['idr'])) 
            return false;

        $req = "
            SELECT COUNT(1) 
            FROM blog_revision 
            WHERE ida = '".$u['ida']."'
            AND idr = '".$u['idr']."'
        ";

        if(Database::_selectOne($req) > 0) return true;
        return false;
    }

    static public function _generateWith($post){
        if(isset($post['article'])){
            $revision = new BlogRevision(array('ida' => $post['article']));
        }else{
            $revision = new BlogRevision();
            $revision->generateArticle($post['uid']);
        }

        if(isset($post['categories']))
            $revision->setCategories($post['categories']);       
        
        $revision->generateRevision($post);
        $revision->insertRevision();

        return $revision;
    }
}