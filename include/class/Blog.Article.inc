<?php

/**
 *  Class Article
 *
 */
class BlogArticle {
    
    private $ida;
    private $uid;
    private $date;
    private $status;
    private $url;
    
    function __construct($ida = 0) 
    {
        if ($ida > 0) {
            $this->setIda($ida);
            $req = " SELECT uid, date, status, url FROM blog_article WHERE ida = '$ida' ";
           foreach (Database::_query($req) as $a) {
                $this->uid = $a['uid'];
                $this->date = $a['date'];
                $this->status = $a['status'];
                $this->url = $a['url'];
            }
        } 
        else
        {
            $this->ida = 0;
            $this->uid = 0;
            $this->date = 0;
            $this->status = 0;
        }
    }

    /**
     *  Get Ida
     *
     *  @return int
     *  @since 0.1
     */
    public function getIda()
    {
        return $this->ida;
    }

    /**
     * Sets the value of Ida .
     *
     * @param mixed $ida the ida
     * @return self
     * @package Ebrid
     * @since 0.1
    */
    public function setIda($ida) 
    {
        if (!preg_match("#^[\d]+$#", $ida)) 
        {
            return false;
        }
        $this->ida = $ida;
        return true;
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
     * Sets the value of Uid .
     *
     * @param mixed $uid the uid
     * @return self
     * @package Ebrid
     * @since 0.1
    */
    public function setUid($uid) 
    {
        if (!preg_match("#^[\d]+$#", $uid)) 
        {
            return false;
        }
        $this->uid = $uid;
        return true;
    }

    /**
     *  Get Date
     *
     *  @return int
     *  @since 0.1
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the value of date.
     *
     * @param int date
     * @package Ebrid
     * @return self 
     * @since 0.1
    */
    public function setDate($date) 
    {
        $this->date = $date;
        return true;
    }

    /**
     *  Get Ida
     *
     *  @return int
     *  @since 0.1
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the value of statut.
     *
     * @param int
     * @package Ebrid
     * @return self 
     * @since 0.1
    */
    public function setStatus($status) 
    {
        $this->status = $status;
        return true;
    }

    public function insertArticle()
    {
        $req = "INSERT INTO blog_article(date, uid, status) VALUES (NOW(), '".$this->uid."', '".$this->status."')";
        $res = Database::_exec($req);
        if($res){
            $this->ida = Database::_lastInsertId();
        }
        return $this;
    }

    public function generateArticle($uid){
        $this->uid = $uid;
        $this->insertArticle();
    }

    static public function _exist($u = null) 
    {
        if (!is_null($u)) 
        {
            if (is_numeric($u)) $where = "ida = '" . intval($u) . "'";
            else if (is_string($u)) $where = "url = '$u'";
            else return false;
            
            $req = "SELECT COUNT(1) FROM blog_article WHERE " . $where;
            if (Database::_selectOne($req) > 0) return true;
        }
        return false;
    }

    static public function _getArticles(){
        $req = "SELECT ba.ida, (SELECT title FROM blog_revision br WHERE br.ida = ba.ida ORDER BY idr DESC LIMIT 0,1) title
            FROM blog_article ba
            ORDER BY ba.ida 
            LIMIT 0,5";
        return Database::_query($req);
    }

    static public function _getLastRevision($ida){
        $req = "SELECT idr FROM blog_revision WHERE ida = '$ida' ORDER BY idr DESC LIMIT 0,1";

        $revision = new BlogRevision(array('ida'=>$ida, 'idr'=>Database::_selectOne($req)));
        return $revision;
    }

    static public function _getRevisions($ida, $param = array()){
        $list = array();

        if(self::_exist($ida)){
            $req = "SELECT ida, idr, title, content, date, nickname
                FROM blog_revision br, user u 
                WHERE br.ida = '$ida' 
                AND u.uid = br.uid";

            $list = Database::_query($req);
        }

        return $list;
    }
}
