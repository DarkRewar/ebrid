<?php
/**
 * Fichier Blog.Category.php
 *
 * PHP version 5
 *
 * @category Blog
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com
 * @since Version 0.1
 */

/**
 * Class Category
 *
 * @category Blog
 * @package Ebrid
 * @since Version 0.1
 */
class BlogCategory
{
    private $idc;
    private $name;
    private $description;
    private $access;
    private $level;
    private $idcParent;

    public function __construct($idc = 0) {
        if (self::_exist($idc)) {
            if (is_numeric($idc)) {
                $req = "SELECT * FROM blog_category WHERE idc = '$idc'";
            }
            else {
                $req = "SELECT * FROM blog_category WHERE name = '$idc'";
            }
            foreach (Database::_query($req) as $a) {
                $this->idc = $a['idc'];
                $this->idcParent = $a['idc_parent'];
                $this->name = $a['name'];
                $this->description = $a['description'];
                $this->access = $a['access'];
                $this->level = $a['level'];
            }
        } 
        else {
            $this->idc = 0;
            $this->idcParent = 0;
            $this->name = 0;
            $this->description = 0;
            $this->access = 0;
            $this->level = 0;
        }
    }
    
    /**
     * Get Idc
     *
     * @return int
     * @since 0.1
     */
    public function getIdc() {
        return $this->idc;
    }
    
    /**
     * Get Name
     *
     * @return string
     * @since 0.1
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Get Description.
     *
     * @return string
     * @since 0.1
     */
    public function getDescription() {
        return $this->description;
    }
    
    /**
     * Get Access
     *
     * @return string
     * @since 0.1
     */
    public function getAccess() {
        return $this->access;
    }
    
    /**
     * Get Level
     *
     * @return int
     * @since 0.1
     */
    public function getLevel() {
        return $this->level;
    }
    
    /**
     * Set Name and Check if it is correct
     *
     * @param string $name name of the forum
     * @return bool
     * @since 0.1
     */
    public function setName($name) {
        if (!preg_match("#^[\w\.\#\-\s]+$#", $name)) return $this;
        $this->name = $name;
        return $this;
    }
    
    /**
     * Set Description and Check if it is correct
     *
     * @param string $description description of the forum
     * @return bool
     * @since 0.1
     */
    public function setDescription($description) {
        if (!preg_match("#^[\w\.\#\-\s]+$#", $description)) return $this;
        $this->description = $description;
        return $this;
    }
    
    /**
     * Set Access and Check if it is correct
     *
     * @param string $access access of the forum
     * @return bool
     * @since 0.1
     */
    public function setAccess($access) {
        if (!preg_match("#^[\w]$#", $access)) return $this;
        $this->access = $access;
        return $this;
    }
    
    /**
     * Set Level and Check if it is correct
     *
     * @param int $level level of display
     * @return self
     * @since 0.1
     */
    public function setLevel($level) {
        if (!preg_match("#^[\d]$#", $level)) return $this;
        $this->description = $level;
        return $this;
    }
    
    /**
     * Set the id category of the parent
     *
     * @param int $idc id category parent
     * @return self
     * @since 0.1
     */
    public function setIdcParent($idc) {
        if (!is_numeric($idc)) return $this;
        $this->idcParent = $idc;
        return $this;
    }
    
    /**
     * Insert the Name and the Description in the DB as a new Category
     *
     * @return bool
     * @since 0.1
     */
    public function insert() {
        $req = "INSERT INTO blog_category(
                idc_parent
                , name
                , description
                , access
                , level
            ) VALUES (
                '" . $this->idcParent . "'
                , '" . $this->name . "'
                , '" . $this->description . "'
                , '" . $this->access . "'
                , '" . $this->level . "'
            )";
        return Database::_exec($req);
    }
    /**
    *   Delete the Name and the Description in the DB
    *  @return bool
    *  @since 0.1
    */
    
    public function deleteCategory()
    {   
        Database::_beginTransaction();
        $req = "DELETE FROM blog_category
                WHERE idc = '".$this->idc."'";
        $res = Database::_exec($req);
        if(!$res){
            Database::_rollBack();
        } else {
            Database::_commit();
        }
    }

    /**
     * Generate a category with the POST form
     *
     * @param array $post the $_POST[] form
     * @return array
     * @since 0.1
     */
    public function generateWith($post) {
        $return = array(
            "e" => "info",
            "message" => "Processing..."
        );
        $this->setName($post['cat-name'])->setDescription($post['cat-desc'])->setIdcParent($post['cat-parent']);
        
        if (!$this->insert()) {
            $return["e"] = "error";
            $return["message"] = Database::_lastError();
        } 
        else {
            $return["e"] = "success";
            $return["message"] = "The category have been created";
        }
        return $return;
    }
    
    /**
     * Check if the Category already exists
     *
     * @param mixed $u idf or name
     * @return bool
     * @since 0.1
     */
    static public function _exist($u = null) {
        if (!is_null($u)) {
            if (is_numeric($u)) $where = "idc = '" . intval($u) . "'";
            else if (is_string($u)) $where = "name = '$u'";
            else return false;
            
            $req = "SELECT COUNT(1) FROM blog_category WHERE " . $where;
            if (Database::_selectOne($req) > 0) return true;
        }
        return false;
    }
    public static function afficherDerniereCategories() {
        echo '<p>Les 10 dernières categories: </p>';
        $r = array();
        $req = "SELECT * FROM blog_category ORDER BY idc DESC LIMIT 0,10";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__ . ' avec la requete : ' . $req);
        while ($a = mysqli_fetch_assoc($res)) {
            $r[] = $a;
        }
        
        foreach ($r as $index => $value) {
            echo '<p><a href="affichage_category.php?idc=' . $value['idc'] . '">' . $value['name'] . '</a></br>' . $value['description'] . '</p>';
        }
    }
    
    /**
     * Get in a big array, the tree of all categories
     *
     * @param int $id the id of the parent category
     * @return array
     * @since 0.1
     */
    static public function _getTree($id = 0) {
        $req = "SELECT * FROM blog_category WHERE idc_parent = '$id'";
        $array = array();
        foreach (Database::_query($req) as $k => $v) {
            $v['leafs'] = self::_getTree($v['idc']);
            $array[] = $v;
        }
        return $array;
    }

    static public function _deleteCategory($idc) {
        $c = new BlogCategory($idc);
        $c->deleteCategory();
    }

    /**
     *
     *Search and order the category with revisions
     *
     * @since 0.1
     */
    static public function _getCategory() {
        $req = "SELECT bc.idc,
                (SELECT title
                FROM blog_revision br
                WHERE br.idc = bc.idc
                ORDER BY idr
                DESC LIMIT 0,1) title
            FROM blog_category bc
            ORDER BY bc.idc
            LIMIT 0,5";
        return Database::_query($req);
    }
}
