<?php
/**
 * Fichier Forum.Category.php
 *
 * PHP version 5
 *
 * @category Forum
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com
 * @since Version 0.2
 */

/**
 * Class Category
 *
 * @category Forum
 * @package Ebrid
 * @since Version 0.2
 */
class ForumCategory
{
    private $idc;
    private $name;
    private $description;
    private $access;
    private $level;

    /**
     *  Construct
     *
     *  @param int $idc id of category
     *  @since 0.2
     */
    public function __construct($idc = 0)
    {
        if(self::_exist($idc)) {
            if (is_numeric($idc)) {
                $req = "SELECT * FROM forum_category WHERE idc = $idc";
            }else {
                $req = "SELECT * FROM forum_category WHERE name = '$idc'";            
            }
            foreach (Database::_query($req) as $a){
                $this->idc = $a['idc'];
                $this->name= $a['name'];
                $this->description = $a['description'];
            }
            
        }else {
            $this->idc = 0;
            $this->name = 0;
            $this->description = 0;
        }
    }

    /**
     *  Get Idc
     *
     *  @return int
     *  @since 0.2
     */
    public function getIdc()
    {
        return $this->idc;
    }

    /**
     *  Get Name
     *
     *  @return string
     *  @since 0.2
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *  Get Description
     *
     *  @return string
     *  @since 0.2
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *  Get Access
     *
     *  @return string
     *  @since 0.2
     */
    public function getAccess()
    {
        return $this->access;
    }
    /**
     *  Get Level
     *
     *  @return int
     *  @since 0.2
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     *  Set Name and Check if it is correct
     *
     *  @param string $name name of the forum
     *  @return bool
     *  @since 0.2
     */
    public function setName($name){
        if (!preg_match("#^[\w\.\#\-\s -à]{5,}$#", $name)) return false;
        $this->name = $name;
        return true;
    }

    /**
     *  Set Description and Check if it is correct
     *  
     *  @param string $description description of the forum
     *  @return bool
     *  @since 0.2
     */
    public function setDescription($description){
       if (!preg_match("#^[\w\.\#\-\s -à]+$#", $description)) return false;
       $this->description = $description;
       return true;
    }

    /**
     *  Set Access and Check if it is correct
     *  
     *  @param string $access access of the forum
     *  @return bool
     *  @since 0.2
     */
    public function setAccess($access){
       if (!preg_match("#^[\w]$#", $access)) return false;
       $this->access = $access;
       return true;
    }

    /**
     *  Set Level and Check if it is correct
     *  
     *  @param int $level level of display
     *  @return bool
     *  @since 0.2
     */
    public function setLevel($level){
       if (!preg_match("#^[\d]$#", $level)) return false;
       $this->description = $level;
       return true;
    }

    /**
     *  Insert the Name and the Description in the DB as a new Category
     *
     *  @return bool
     *  @since 0.2
     */
    public function insert()
    {
        $req = "INSERT INTO forum_category(
            name,
            description,
            access,
            level
            )VALUES (
            '".$this->name."',
            '".$this->description."',
            '".$this->access."',
            '".$this->level."')";
        return Database::_exec($req);
    }

    /**
     * Update function
     *
     * @return self
     * @since Version 0.2
     */
    final public function updateCategory() {
        $req = "UPDATE forum_category
            SET 
                name = '". $this->getName() ."'
                , description = '". $this->getDescription() ."'
                , access = '". $this->getAccess() ."'
                , level = '". $this->getLevel() ."'
            WHERE idc = '". $this->getIdc() ."'
        ";
        Database::_exec($req);
        return $this;
    }

    /**
    * Delete function
    *
    *@since Version 0.2
    */
    public function deleteCategory() {        
        $req = "DELETE FROM forum_category
                WHERE idc = '" . $this->idc . "'";
        
        $req1 = "SELECT idf
            FROM forum_forum   
            WHERE idc = :idc";
        Database::_prepare($req1);
        Database::_bindParam(':idc', $this->idc, PDO::PARAM_INT);

        foreach (Database::_execute() as $f) {
            //$forum = new ForumForum($f['idf']);
            //$forum->deleteForum();
        }

        Database::_beginTransaction();
        if ( Database::_exec($req) == 0 ) {
            Database::_rollBack();
        } else {
            Database::_commit();
        }
    }

    /**
     *
     *Search all categories' forum
     * @return array
     *
     * @since 0.2
     */
    static public function _getCategories() {
        $req = "SELECT idc,name,description
            FROM forum_category 
            ORDER BY idc DESC
            LIMIT 0,5";
        $categories = array();
        $categories = Database::_query($req);

        return $categories;
    }

    static public function _deleteCategory($idc) {
        $a = new ForumCategory($idc);
        $a->deleteCategory();
    }
    
    /**
     *  Check if the Category already exists
     *  
     *  @param mixed $u idf or name
     *  @return bool
     *  @since 0.2
     */
    static public function _exist($u = null) 
    {
        if (!is_null($u)) 
        {
            if (is_numeric($u)) $where = "idc = '" . intval($u) . "'";
            else if (is_string($u)) $where = "name = '$u'";
            else return false;
            
            $req = "SELECT COUNT(1) FROM forum_category WHERE " . $where;
            if (Database::_selectOne($req) > 0) return true;
        }
        return false;
    }
}