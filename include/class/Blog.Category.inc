<?php
/**
*  Class BlogCategory
*  @package Ebrid;
*/
class BlogCategory
{
    private $_idc;
    private $_name;
    private $_description;
    private $_access;
    private $_level;
    private $idcParent;

    public function __construct($idc = 0)
    {
        if(self::_exist($idc)) {
            if (is_numeric($idc)) {
                $req = "SELECT * FROM forum WHERE id = '$idf'";
            }else {
                            $req = "SELECT * FROM forum WHERE nom = '$idf'";
            }
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
            while($a = mysqli_fetch_assoc($res)){
                $this->_idc = $a['idc'];
                $this->idcParent = $a['idc_parent'];
                $this->_name= $a['name'];
                $this->_description = $a['description'];
                $this->_access = $a['access'];
                $this->_level = $a['level'];
            }
        }else {
            $this->_idc = 0;
            $this->idcParent = 0;
            $this->_name = 0;
            $this->_description = 0;
            $this->_access = 0;
            $this->_level = 0;
        }
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
    *  Get Description.
    *
    *  @return string
    *  @since 0.1
    */
    public function getDescription()
    {
        return $this->_description;
    }
    /**
    *  Get Access
    *
    *  @return string
    *  @since 0.1
    */
    public function getAccess()
    {
        return $this->_access;
    }
    /**
    *  Get Level
    *
    *  @return int
    *  @since 0.1
    */
    public function getLevel()
    {
        return $this->_level;
    }
    /**
    *  Set Name and Check if it is correct
    *
    *  @param string $name name of the forum
    *  @return bool
    *  @since 0.1
    */
    public function setName($name){
        if (!preg_match("#^[\w\.\#\-\s]+$#", $name)) return $this;
        $this->_name = $name;
        return $this;
    }
    /**
    *  Set Description and Check if it is correct
    *
    *  @param string $description description of the forum
    *  @return bool
    *  @since 0.1
    */
    public function setDescription($description){
    if (!preg_match("#^[\w\.\#\-\s]+$#", $description)) return $this;
    $this->_description = $description;
    return $this;
    }
    /**
    *  Set Access and Check if it is correct
    *
    *  @param string $access access of the forum
    *  @return bool
    *  @since 0.1
    */
    public function setAccess($access){
    if (!preg_match("#^[\w]$#", $access)) return $this;
    $this->_access = $access;
    return $this;
    }
    /**
    *  Set Level and Check if it is correct
    *
    *  @param int $level level of display
    *  @return self
    *  @since 0.1
    */
    public function setLevel($level){
    if (!preg_match("#^[\d]$#", $level)) return $this;
    $this->_description = $level;
    return $this;
    }
    /**
    *  Set the id category of the parent
    *
    *  @param int $idc id category parent
    *  @return self
    *  @since 0.1
    */
    public function setIdcParent($idc){
        if(!is_numeric($idc)) return $this;
        $this->idcParent = $idc;
        return $this;
    }
    /**
    *  Insert the Name and the Description in the DB as a new Category
    *
    *  @return bool
    *  @since 0.1
    */
    public function insert()
    {
        $req = "INSERT INTO blog_category(
                idc_parent
                , name
                , description
                , access
                , level
            ) VALUES (
                '".$this->idcParent."'
                , '".$this->_name."'
                , '".$this->_description."'
                , '".$this->_access."'
                , '".$this->_level."'
            )";
        return Database::_exec($req);
    }
    /**
    *  Generate a category with the POST form
    *
    *  @param array $post the $_POST[] form
    *  @return array
    *  @since 0.1
    */
    public function generateWith($post){
        $return = array(
            "e" => "info",
            "message" => "Processing..."
        );
        $this
            ->setName($post['cat-name'])
            ->setDescription($post['cat-desc'])
            ->setIdcParent($post['cat-parent']);
        
        if(!$this->insert()) {
            $return["e"] = "error";
            $return["message"] = Database::_lastError();
        } else {
            $return["e"] = "success";
            $return["message"] = "The category have been created";
        }
        return $return;
    }
    /**
    *  Check if the Category already exists
    *
    *  @param mixed $u idf or name
    *  @return bool
    *  @since 0.1
    */
    static public function _exist($u = null)
    {
        if (!is_null($u))
        {
            if (is_numeric($u)) $where = "idc = '" . intval($u) . "'";
            else if (is_string($u)) $where = "name = '$u'";
            else return false;
            
            $req = "SELECT COUNT(1) FROM blog_category WHERE " . $where;
            if(Database::_selectOne($req) > 0) return true;
        }
        return false;
    }
    public static function afficherDerniereCategories()
    {
        echo '<p>Les 10 dernières categories: </p>';
        $r=array();
        $req = "SELECT * FROM blog_category ORDER BY idc DESC LIMIT 0,10";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__ . ' avec la requete : ' . $req);
        while($a = mysqli_fetch_assoc($res))
        {
            $r[] = $a;
        }
        
        foreach ($r as $index => $value)
        {
            echo '<p><a href="affichage_category.php?idc='.$value['idc'].'">'.$value['name'].'</a></br>'.$value['description'].'</p>';
        }
    }
    /**
    *  Get in a big array, the tree of all categories
    *
    *  @param int $id the id of the parent category
    *  @return array
    *  @since 0.1
    */
    static public function _getTree($id = 0){
        $req = "SELECT * FROM blog_category WHERE idc_parent = '$id'";
        $array = array();
        foreach (Database::_query($req) as $k => $v) {
            $v['leafs'] = self::_getTree($v['idc']);
            $array[] = $v;
        }
        return $array;
    }
}