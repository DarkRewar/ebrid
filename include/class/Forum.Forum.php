<?php
/**
 * Fichier Forum.Forum.php
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
 * Class Forum
 *
 * @category Forum
 * @package Ebrid
 * @since Version 0.1
 */
class ForumForum extends ForumCategory
{
    private $idf;
    private $name;
    private $description;

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
                $req = "SELECT * FROM forum_forum WHERE id = '$idf'";
            }else {
                $req = "SELECT * FROM forum_forum WHERE nom = '$idf'";            
            }
            foreach (Database::_query($req) as $a){
                $this->idf = $a['idf'];
                $this->idc = $a['idc'];
                $this->name= $a['name'];
                $this->description = $a['description'];
            }
        }else {
            $this->idf = 0;
            $this->idc = 0;
            $this->name = 0;
            $this->description = 0;
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
        return $this->idf;
    }

    /**
     *  Get Idc
     *
     *  @return int
     *  @since 0.1
     */
    public function getIdc()
    {
        return $this->idc;
    }

    /**
     *  Get Name
     *
     *  @return string
     *  @since 0.1
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *  Get Description
     *
     *  @return string
     *  @since 0.1
     */
    public function getDescription()
    {
        return $this->description;
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
        $this->name = $name;
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
       $this->description = $description;
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
        $req = "INSERT INTO forum_forum(
            name,
            description
            ) VALUES (
            '".$this->name."',
            '".$this->description."'
            )";
        return Database::_exec($req);
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
            
            $req = "SELECT COUNT(1) FROM forum_forum WHERE " . $where;
            if (Database::_selectOne($req) > 0) return true;
        }
        return false;
    }
}