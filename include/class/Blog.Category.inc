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
                $this->_name= $a['name'];
                $this->_description = $a['description'];
                $this->_access = $a['access'];
                $this->_level = $a['level'];
            }
        }else {
            $this->_idc = 0;
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
        if (!preg_match("#^[\w\.\#\-\s]{5,}$#", $name)) return false;
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
     *  Set Access and Check if it is correct
     *  
     *  @param string $access access of the forum
     *  @return bool
     *  @since 0.1
     */
    public function setAccess($access){
       if (!preg_match("#^[\w]$#", $access)) return false;
       $this->_access = $access;
       return true;
    }

    /**
     *  Set Level and Check if it is correct
     *  
     *  @param int $level level of display
     *  @return bool
     *  @since 0.1
     */
    public function setLevel($level){
       if (!preg_match("#^[\d]$#", $level)) return false;
       $this->_description = $level;
       return true;
    }

    /**
     *  Insert the Name and the Description in the DB as a new Category
     *
     *  @return bool
     *  @since 0.1
     */
    public function insert()
    {
        $req = "INSERT INTO blogCategory(name, description, access, level) VALUES ('".$this->_name."', '".$this->_description."', '".$this->_access."', '".$this->_level."')";
        $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . FILE . ' at the line ' . LINE . ' with the request : ' . $req);
        if(!$res) return false;
        return true;
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
            
            $req = "SELECT idc FROM blogCategory WHERE " . $where;
            $res = mysqli_query($GLOBALS['db'], $req) or die(mysql_error() . '<br />Error in the file ' . __FILE__ . ' at the line ' . __LINE__ . ' with the request : ' . $req);
            if (mysqli_num_rows($res) > 0) return true;
            else return false;
        }
        return false;
    }

    

}