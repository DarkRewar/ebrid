<?php


/**
 *  Class ForumForum
 *  @package Ebrid;
 */
class ForumForum
{
    private $_idf;
    private $_idc;
    private $_name;
    private $_description;

    /**
     *  Construct
     *
     *  @param int $idf id of forum
     *  @since 0.1
     */
    public function __construct($idf = 0)
    {
        if(self::exist($idf)) {
            if (is_numeric($idf)) {
                $req = "SELECT * FROM forum WHERE id = '$idf'";
            }else {
                $req = "SELECT * FROM forum WHERE nom = '$idf'";            
            }
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
            while($a = mysqli_fetch_assoc($res)){
                $this->_idf = $a['idf'];
                $this->_idc = $a['idc'];
                $this->_name= $a['name'];
                $this->_description = $a['description'];
            }
        }else {
            $this->_idf = 0;
            $this->_idc = 0;
            $this->_name = 0;
            $this->_description = 0;
        }
    }
    /**
     *  Get Idf
     *
     *  @return int
     *  @since 0.1
     */
    public function getIdf()
    {
        return $this->_idf;
    }

    /**
     *  Get Idc
     *
     *  @return int
     *  @since 0.1
     */
    public function getIdc()
    {
        return $this->_idc;
    }

    /**
     *  Get Name
     *
     *  @return string
     *  @since 0.1
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     *  Get Description
     *
     *  @return string
     *  @since 0.1
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     *  Set Name and Check if it is correct
     *
     *  @param string $name name of the forum
     *  @return bool
     *  @since 0.1
     */
    public function setName($name){
        if (!preg_match("#^[\w]+$#", $name)) return false;
        $this->_name = $name;
        return true;
    }

    /**
     *  Set Description and Check if it is correct
     *  
     *  @param string $description description of the forum
     *  @return bool
     *  @since 0.1
     */
    public function setDescription($description){
       if (!preg_match("#^[\w\.\#\-\s]+$#", $description)) return false;
       $this->_description = $description;
       return true;
    }

    /**
     *  Insert the Name and the Description in the DB as a new Forum in the Category choosen
     *
     *  @return bool
     *  @since 0.1
     */
    public function insert()
    {
        $req = "INSERT INTO forum(name, description) VALUES ('".$this->_name."', '".$this->_description."')";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
        if(!$res) return false;
        return true;
    }

    /**
     *  Check if the Forum already exists
     *  
     *  @param mixed $u idf or name
     *  @return bool
     *  @since 0.1
     */
    static public function _exist($u = null) 
    {
        if (!is_null($u)) 
        {
            if (is_numeric($u)) $where = "idf = '" . intval($u) . "'";
            else if (is_string($u)) $where = "name = '$u'";
            else return false;
            
            $req = "SELECT idf FROM forum WHERE " . $where;
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
            if (mysqli_num_rows($res) > 0) return true;
            else return false;
        }
        return false;
    }
}