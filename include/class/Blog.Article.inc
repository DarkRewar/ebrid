<?php

/**
 *  Class Article
 *
 */
class BlogArticle {
    
    private $ida;
    private $uid;
    private $date;
    private $statut;
    
    function __construct($ida = 0) 
    {
        if ($ida > 0) {
            $this->setIdt($idt);
            $req = " SELECT * FROM blog_article WHERE ida = $ida ";
           foreach (Database::_query($req) as $a) {

                $this->ida = $a['ida'];
                $this->uid = $a['uid'];
                $this->date = $a['date'];
                $this->statut = $a['statut'];
            }
        } 
        else
        {
            $this->ida = 0;
            $this->uid = 0;
            $this->date = 0;
            $this->statut = 0;
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
        return $this->_ida;
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
        return $this->_uid;
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
        return $this->_date;
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
    public function getStatut()
    {
        return $this->_istatut;
    }

    /**
     * Sets the value of statut.
     *
     * @param int
     * @package Ebrid
     * @return self 
     * @since 0.1
    */
    public function setStatut($statut) 
    {
        if (!preg_match("#^[\d]+$#", $statut)) 
        {
            return false;
        }
        $this->statut = $statut;
        return true;
    }

    public function insert()
    {
        $req = "INSERT INTO blog_article(date, uid, statut) VALUES ('".$this->date."', '".$this->uid."', '".$this->statut."')";
        $res = Database::_exec($req);
        if(!$res) return false;
        return true;
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
}
