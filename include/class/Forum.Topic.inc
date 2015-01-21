<?php

/**
 *  Class Topic
 *
 */

class ForumTopic extends ForumForum
{
    private $idt;
    private $idf;
    private $uid;
    private $title;
    private $description;
    private $date;
    
    function __construct($idt = 0) 
    {
        if ($idt > 0) {
            $this->setIdt($idt);
            $req = " SELECT * FROM forum_topic WHERE idt = $idt ";
           foreach (Database::_query($req) as $a) {

                $this->idt = $a['idt'];
                $this->idf = $a['idf'];
                $this->uid = $a['uid'];
                $this->nom = $a['nom'];
                $this->description = $a['description'];
                $this->date= $a['date'];
            }
        } 
        else
        {
            $this->idt = 0;
            $this->idf = 0;
            $this->uid = 0;
            $this->nom = 0;
            $this->description = 0;
            $this->date = 0;
        }
    }
    
   /**
     * Gets the value of idt (id topic).
     *
     * @return mixed
     * @package Ebrid
     * @since 0.1
    */
    public function getIdt() 
    {
        return $this->idt;
    }
    
    /**
     * Sets the value of idt (id topic).
     *
     * @param mixed $idt the idt
     * @return self
     * @package Ebrid
     * @since 0.1
    */
    public function setIdt($idt) 
    {
        if (!preg_match("#^[\d]+$#", $idt)) 
        {
            return false;
        }
        $this->idt = $idt;
        return true;
    }

    /**
    *  Gets the value of idf (id forum).
     *
     * @return mixed
     * @package Ebrid
     * @since 0.1
    */
    public function getIdf() 
    {
        return $this->idf;
    }
    
    /**
     * Sets the value of idf (id forum).
     *
     * @param mixed $idf the idf
     * @return self
     * @package Ebrid
     * @since 0.1
    */
    public function setIdf($idf) 
    {
        if (!preg_match("#^[\d]+$#", $idf)) 
        {
            return false;
        }
        $this->idf = $idf;
        return true;
    }

    /**
     * Gets the value of uid (user id).
     *
     * @return mixed
     * @package Ebrid
     * @since 0.1
    */
    public function getUid() 
    {
        return $this->uid;
    }
    
    /**
     * Sets the value of uid (user id).
     *
     * @param mixed $uid the uid
     * @return self
     * @package Ebrid
     * @since 0.1
    */
    public function setIdf($uid) 
    {
        if (!preg_match("#^[\d]+$#", $uid)) 
        {
            return false;
        }
        $this->uid = $uid;
        return true;
    }
    /**
     * Gets the value of title.
     *
     * @return String
     * @package Ebrid
     * @since 0.1
    */
    public function getTitle() 
    {
        return $this->title;
    }
    
    /**
     * Sets the value of title.
     *
     * @param String title
     * @package Ebrid
     * @return self 
     * @since 0.1
    */
    public function _setTitle($title) 
    {
        if (!preg_match("#^[\w\s\.\,\:\?\!\(\)]{1,50}+$#", $title)) 
        {
            return false;
        }
        $this->title = $title;
        return true;
    }

    /**
     * Sets the value of description.
     *
     * @package Ebrid
     * @return String 
     * @since 0.1
    */
    public function getDescription() 
    {
        return $this->description;
    }
    
    /**
     * Sets the value of description.
     *
     * @param String description
     * @package Ebrid
     * @return self 
     * @since 0.1
    */
    public function _setDescription($description) 
    {
        if (!preg_match("#^[\w\s\.\,\:\?\!\(\)]{1,5000}+$#", $description))
        {
            return false;
        }
        $this->description = $description;
        return true;
    }

    /**
     * Sets the value of date.
     *s
     * @package Ebrid
     * @return int 
     * @since 0.1
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

    public static function _ShowLastTopic($idf)
    {   
        $t=array();
        $req = "SELECT * 
                FROM topic t, forum f
                WHERE s.idf='$idf'
                AND s.idf = g.id
                ORDER BY s.id DESC";
        foreach (Database::_query($req) as $a) 
        {
            $t[] = $a;
        }
        foreach ($t as $index => $value) 
        {
            echo '<p><a href="............................?id='.$value['idt'].'">'.$value['title'].'</a></br></p>';
        }
    }

} //End