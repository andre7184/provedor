<?php
/**
 * simpleCRUD v0.1
 *
 * @author Fredi Machado <fredisoft at gmail dot com>
 * @link http://fredimachado.com.br
 * @date 25/08/2009
 */
class simpleCRUD{
	protected $__table   = "";
	protected $__id   = "id";
	protected $__data    = array();
	protected $__deleted = false;

	public static function find_by_sql($query, $class = null){
		if (is_null($class))
			$class = get_called_class();

		self::checkConnection();

		$r = mysql_query($query);

		$objects = array();

		while ($l = mysql_fetch_assoc($r)){
			$objects[] = self::instantiate($class, $l);
		}

		mysql_free_result($r);

		return $objects;
	}
	public static function find_by_sql_field($query, $class = null){
		if (is_null($class))
			$class = get_called_class();
		self::checkConnection();
		$r = mysql_query($query);
		$objects = array();
		while ($l = mysql_fetch_assoc($r)){
			$id=$l[Field];
			$objects[$id] = $id;//self::instantiateField($class, $l);
		}
		mysql_free_result($r);
		return $objects;
	}
	public static function find_all($order = ""){
		$class = get_called_class();
		$object = new $class();

		if (!empty($order))
			$order = " ORDER BY {$order}";

		return self::find_by_sql("SELECT * FROM ".$object->__table.$order, $class);
	}

	public static function find_by_id($id = 0){
		$class = get_called_class();
		$object = new $class();
		//echo $object->__id."<br>";
		$r = self::find_by_sql("SELECT * FROM ".$object->__table." WHERE ".$object->__id." = {$id} LIMIT 1", $class);
		return !empty($r) ? array_shift($r) : false;
	}
	public static function find_by_codigo($col_codigo,$codigo = 0){
		$class = get_called_class();
		$object = new $class();
		//echo $object->__id."<br>";
		$r = self::find_by_sql("SELECT * FROM ".$object->__table." WHERE ".$col_codigo." = {$codigo} LIMIT 1", $class);
		return !empty($r) ? array_shift($r) : false;
	}
	public static function find_by_field(){
		$class = get_called_class();
		$object = new $class();
		return self::find_by_sql_field("SHOW COLUMNS FROM ".$object->__table, $class);
	}
	public function insert()
	{
		self::checkConnection();

		if ($this->__deleted)
			return false;
		//echo "okk"; 
		$fields = $this->fields_sql();
		$query  = "INSERT INTO ".$this->__table." (".join(", ", array_keys($fields)).") ";
		$query .= "VALUES ('".join("', '", array_values($fields))."')";
		//echo $query;
		if ($r = @mysql_query($query)){
			$this->id = mysql_insert_id();
			return true;
		}else
			return false;
		
	}

	public function update(){
		self::checkConnection();

		if ($this->__deleted)
			return false;

		$fields = $this->fields_sql();
		$fields_update = array();

		foreach ($fields as $key => $value)
		{
			$fields_update[] = "`{$key}`='{$value}'";
		}
		$query  = "UPDATE ".$this->__table." SET ".join(", ", $fields_update)." ";
		$query .= "WHERE ".$this->__id." = ".self::quote($this->{$this->__id});
		echo $query."<br>";
		$r = mysql_query($query);
		echo mysql_affected_rows()."<br>";
		return mysql_affected_rows() == 1 ? true : false;
	}

	public function delete($id = null)
	{
		self::checkConnection();

		if ($this->__deleted)
			return false;

		if (is_null($id))
			$id = $this->{$this->__id};

		$query = "DELETE FROM ".$this->__table." WHERE ".$this->__id." = ".self::quote((int) $id)." LIMIT 1";

		$r = mysql_query($query);

		if (mysql_affected_rows() == 1)
		{
			$this->__deleted = true;
			return true;
		}
		else
			return false;
	}

	public static function num_rows($query = "")
	{
		$class = get_called_class();
		$object = new $class();

		self::checkConnection();

		if (empty($query))
			$query = "SELECT COUNT(*) FROM ".$object->__table;

		$r = mysql_query($query);

		$l = mysql_fetch_assoc($r);

		return array_shift($l);
	}

	private static function instantiate($class, $l){
		$object = new $class();

		foreach ($l as $key => $value){
			$key = strtolower($key);
			$object->$key = $value;
		}

		return $object;
	}
	private static function instantiateField($class, $l){
		$object = new $class();
		foreach ($l as $key => $value){
			if($key=="Field"){
				$key = strtolower($key);
				echo "key:".$key.":".$value."<br>";
				$object->$value = $value;
			}
		}
		return $object;
	}
	public function __set($key, $value){
		$this->__data[$key] = $value;
	}

	public function __get($key){
		$key = strtolower($key);
		return $this->__data[$key];
	}

	private function fields_sql(){
		$fields = array();
		foreach ($this->__data as $key => $value){
			$fields[$key] = self::quote($value);
		}
		return $fields;
	}

	public function toArray(){
		return (array) $this->__data;
	}

	private function checkConnection(){
		if (!@mysql_ping())
			die("Unable to connect to Mysql database.");
	}

	private function quote($value){
		$magic_quotes_active = get_magic_quotes_gpc();

		if (function_exists("mysql_real_escape_string")){
			if ($magic_quotes_active)
				$value = stripslashes($value);
			$value = mysql_real_escape_string($value);
		}else // Older PHP versions
			if (!$magic_quotes_active)
				$value = addslashes($value);

		return $value;
	}
}

/**
 * This function is native in PHP 5.3.0
 */
if (!function_exists('get_called_class')){
	function get_called_class(){
		$bt = debug_backtrace();
		$lines = file($bt[1]['file']);
		preg_match('/([a-zA-Z0-9\_]+)::'.$bt[1]['function'].'/',
			$lines[$bt[1]['line']-1],
			$matches);
		return $matches[1];
	}
}
?>
