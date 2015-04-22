<?php

/**
 * Fichier Blog.Article.php
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
 * Class Article
 *
 * @category Blog
 * @package Ebrid
 * @since Version 0.1
 */
class BlogArticle
{
    
    private $ida;
    private $uid;
    private $date;
    private $status;
    private $url;
    private $categories;
    
    public function __construct($ida = 0) {
        $this->categories = array();
        
        if ($ida > 0) {
            $this->setIda($ida);
            $req = " SELECT uid, date, status, url FROM blog_article WHERE ida = '$ida' ";
            foreach (Database::_query($req) as $a) {
                $this->uid = $a['uid'];
                $this->date = $a['date'];
                $this->status = $a['status'];
                $this->url = $a['url'];
            }
            $this->pullCategories();
        } 
        else {
            $this->ida = 0;
            $this->uid = 0;
            $this->date = 0;
            $this->status = 0;
            $this->url = null;
        }
    }
    
    /**
     *  Get Ida
     *
     * @return int
     * @since 0.1
     */
    public function getIda() {
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
    public function setIda($ida) {
        if (!preg_match("#^[\d]+$#", $ida)) {
            return false;
        }
        $this->ida = $ida;
        return true;
    }
    
    /**
     *  Get Uid
     *
     * @return int
     * @since 0.1
     */
    public function getUid() {
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
    public function setUid($uid) {
        if (!preg_match("#^[\d]+$#", $uid)) {
            return false;
        }
        $this->uid = $uid;
        return true;
    }
    
    /**
     *  Get Date
     *
     * @return int
     * @since 0.1
     */
    public function getDate() {
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
    public function setDate($date) {
        $this->date = $date;
        return true;
    }
    
    public function getUrl() {
        return $this->url;
    }
    
    public function setUrl($url) {
        if (preg_match("#^[\w\-]+$#", $url)) {
            $this->url = $url;
        }
        return $this;
    }
    
    /**
     *  Get Ida
     *
     * @return int
     * @since 0.1
     */
    public function getStatus() {
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
    public function setStatus($status) {
        $this->status = $status;
        return true;
    }
    
    /**
     *  Set the categories in the instance
     *
     * @return self
     * @since 0.1
     */
    public function setCategories() {
        $argc = func_num_args();
        $argv = func_get_args();
        
        $this->categories = array();
        
        if ($argc > 1) {
            foreach ($argv as $k => $v) {
                if (!is_numeric($v)) continue;
                $this->categories[] = intval($v);
            }
        } 
        elseif ($argc == 1) {
            $argv = $argv[0];
            if (is_numeric($argv)) $this->categories[] = intval($argv);
            elseif (is_array($argv)) {
                foreach ($argv as $k => $v) {
                    if (!is_numeric($v)) continue;
                    $this->categories[] = intval($v);
                }
            }
        }
        
        return $this;
    }
    
    /**
     *  Get the categories array
     *
     * @return array
     * @since 0.1
     */
    public function getCategories() {
        return $this->categories;
    }
    
    /**
     * Get the categories from the database
     *
     * @since Version 0.1
     */
    public function pullCategories() {
        $req = "SELECT idc FROM blog_article_category WHERE ida = '" . $this->ida . "'";
        foreach (Database::_query($req) as $k => $v) {
            $this->categories[] = $v['idc'];
        }
    }
    
    /**
     * Set the categories in the database
     *
     * @return boolean
     * @since Version 0.1
     */
    public function pushCategories() {
        Database::_beginTransaction();
        var_dump($this->cleanCategories());
        
        foreach ($this->categories as $k => $v) {
            $insert = "INSERT INTO blog_article_category(ida, idc) VALUES('$this->ida','$v')";
            if (Database::_exec($insert) == 0) {
                Database::_rollBack();
                return false;
            };
        }
        Database::_commit();
        return true;
    }
    
    /**
     * Clean the categories links in the database
     *
     * @since 0.1
     */
    public function cleanCategories() {
        $req = "DELETE FROM blog_article_category WHERE ida = '" . $this->ida . "'";
        return Database::_exec($req);
    }
    
    /**
     * Insert datas of this article
     * in database.
     *
     * @return self
     * @since 0.1
     */
    final public function insertArticle() {
        $req = "INSERT INTO blog_article(
                uid
                , url
                , date
                , status
            ) VALUES (
                '" . $this->uid . "'
                , '" . $this->url . "'
                , NOW()
                , '" . $this->status . "'
            )";
        $res = Database::_exec($req);
        if ($res) {
            $this->ida = Database::_lastInsertId();
        }
        return $this;
    }
    
    /**
     * Update function
     *
     * @return self
     * @since Version 0.1
     */
    final public function updateArticle() {
        $req = "UPDATE blog_article
            SET uid = '" . $this->getUid() . "'
                , url = '" . $this->getUrl() . "'
                , status = '" . $this->getStatus() . "'
            WHERE ida = '" . $this->getIda() . "'
        ";

        $res = Database::_exec($req);
        return $this;
    }
    
    /**
     * Generate an article
     *
     * @since Version 0.1
     */
    
    public function generateArticle($uid) {
        $this->uid = $uid;
        $this->insertArticle();
    }
    
    /**
     * Modify the data champ status to 1
     *
     * @since 0.1
     */
    
    public function activate() {
        $req = "UPDATE blog_article
                SET  status = '1'
                WHERE ida = '" . $this->ida . "'";
        $res = Database::_exec($req);
        return $this;
    }
    
    /**
     * Modify the data champ status to 0
     *
     * @since 0.1
     */
    
    public function desactivate() {
        $req = "UPDATE blog_article
                SET  status = '0'
                WHERE ida = '" . $this->ida . "'";
        $res = Database::_exec($req);
        return $this;
    }
    
    /**
     *
     * Delete an article with his comments
     *
     * @since 0.1
     */
    public function deleteArticle() {
        Database::_beginTransaction();
        
        $req = "DELETE FROM blog_article
                WHERE ida = '" . $this->ida . "'";
        $res = Database::_exec($req);
        
        $req1 = "DELETE FROM blog_article_category
                 WHERE ida='" . $this->ida . "'";
        $res1 = Database::_exec($req1);
        
        if (!$res) {
            Database::_rollBack();
        } 
        elseif (!$res1) {
            Database::_rollBack();
        } 
        else {
            Database::_commit();
        }
    }
    
    /**
     * Get the table of object
     *
     * @return array
     * @since Version 0.1
     */
    public function toArray() {
        $array = array();
        
        $array['ida'] = $this->getIda();
        $array['uid'] = $this->getUid();
        $array['date'] = $this->getDate();
        $array['url'] = $this->getUrl();
        $array['status'] = $this->getStatus();
        $array['categories'] = $this->getCategories();
        
        return $array;
    }
    
    /**
     *
     * Verify in database if an article exist or not
     *
     * @since 0.1
     */
    static public function _exist($u = null) {
        if (!is_null($u)) {
            if (is_numeric($u)) $where = "ida = '" . intval($u) . "'";
            else if (is_string($u)) $where = "url = '$u'";
            else return false;
            
            $req = "SELECT COUNT(1) FROM blog_article WHERE " . $where;
            if (Database::_selectOne($req) > 0) return true;
        }
        return false;
    }
    
    /**
     * Search and order the article with revisions
     *
     * @since 0.1
     */
    static public function _getArticles() {
        $req = "SELECT ida
            FROM blog_article 
            ORDER BY ida DESC
            LIMIT 0,5";
        $articles = array();
        foreach (Database::_query($req) as $v) {
            $articles[] = self::_getLastRevision($v['ida'])->toArray();
        }
        return $articles;
    }
    
    /**
     * Search the last revision of the article choosen
     *
     * @since 0.1
     */
    static public function _getLastRevision($ida) {
        $req = "SELECT idr FROM blog_revision WHERE ida = '$ida' ORDER BY idr DESC LIMIT 0,1";
        $revision = new BlogRevision(array(
            'ida' => $ida,
            'idr' => Database::_selectOne($req)
        ));
        return $revision;
    }
    
    /**
     *
     *Search all revisions with date and user's name
     * @return array
     *
     * @since 0.1
     */
    static public function _getRevisions($ida, $param = array()) {
        $list = array();
        if (self::_exist($ida)) {
            $req = "SELECT ida, idr, title, content, date, nickname
                FROM blog_revision br, user u
                WHERE br.ida = '$ida'
                AND u.uid = br.uid
                ORDER BY br.idr DESC";
            $list = Database::_query($req);
        }
        return $list;
    }
    
    /**
     *
     * Create a new blogArticle and use the function activate
     * @param $ida
     *
     * @since 0.1
     */
    static public function _activate($ida) {
        $a = new BlogArticle($ida);
        $a->activate();
    }
    
    /**
     * Create a new BlogArticle and use the function desactivate
     * @param $ida
     *
     * @since 0.1
     */
    static public function _desactivate($ida) {
        $a = new BlogArticle($ida);
        $a->desactivate();
    }
    
    /**
     * Delete an article and his commments
     * @param $ida
     *
     * @since 0.1
     */
    static public function _deleteArticle($ida) {
        $a = new BlogArticle($ida);
        $a->deleteArticle();
    }
    
    /**
     * Select an article with "WHERE" options
     * you could use in SQL request
     *
     * @param array $argv all the informations passed
     * @return object|null
     * @since Version 0.1
     */
    static public function _query($argv = array()) {
        $where = null;
        
        $i = 0;
        foreach ($argv as $k => $v) {
            $where.= ($i == 0) ? "WHERE" : "AND";
            switch ($k) {
                case 'article_year':
                    $where.= " date LIKE '$v-%'";
                    break;

                case 'article_month':
                    $where.= " date LIKE '%-$v-%'";
                    break;

                case 'article_day':
                    $where.= " date LIKE '%-$v %'";
                    break;

                case 'article_id':
                    $where.= " ida = '$v'";
                    break;

                case 'article_name':
                    $where.= " url = '$v'";
                    break;
            }
            $where.= " ";
            ++$i;
        }
        unset($i);
        
        $req = "SELECT ida FROM blog_article $where";
        $id = Database::_selectOne($req);
        if ($id > 0) {
            $return = self::_getLastRevision($id);
        } 
        else {
            $return = null;
        }
        
        return $return;
    }
}
