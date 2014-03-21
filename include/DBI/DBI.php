<?php

class DBIStatement extends \PDOStatement
{
    public function fetchrow_hash()
    {
        return $this->fetch();
        
      //$rows = $this->fetchAll();
      //return (count($rows) == 1) ? new DBIDataRow($rows[0]) : new DBIDataRow(array());
    }
    public function fetchrow_array()
    {
        return $this->fetch(\PDO::FETCH_NUM);
        
      //$rows = $this->fetchAll(\PDO::FETCH_NUM);
      //return (count($rows) == 1) ? $rows[0] : array();
    }
    public function fetchOne()
    {
        $rows = $this->fetchAll();
      
        if (count($rows) != 1) throw new \Exception('Expected one row');
      
        return $rows[0];
    }
    public function finish() { }
}
class DBI
{
    public $dbh;
    
    public function __construct($type, $host, $name, $user, $pass)
    {   
        $dsn = sprintf('%s:host=%s;dbname=%s',$type,$host,$name);
        $this->dbh = $dbh = new \PDO($dsn,$user,$pass);
        $dbh->setAttribute(\PDO::ATTR_ERRMODE,           PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        $dbh->setAttribute(\PDO::ATTR_STATEMENT_CLASS,array('DBIStatement'));
        $dbh->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 1);
    }
    public function prepare($sql)
    {
        return $this->dbh->prepare($sql);
    }
    public function dbh_do($sql)
    {
        return $this->dbh->exec($sql);
    }
}
class DBIDataRow implements \ArrayAccess,\Countable
{
    protected $container;
    
    public function __construct(Array $data) { $this->container = $data; }
    
    public function __get($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
    public function __set($offset,$value)
    {
        $this->container[$offset] = $value;
        return $this;
    }
    public function offsetSet($offset, $value) 
    {    
        $this->container[$offset] = $value;
        return $this;
    }
    public function offsetExists($offset) 
    {
        return isset($this->container[$offset]);
    }
    public function offsetUnset($offset) 
    {
        unset($this->container[$offset]);
    }
    public function offsetGet($offset) 
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
    public function count() 
    { 
        return count($this->container); 
    }
}

?>