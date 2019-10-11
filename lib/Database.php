<?php

// Diclare a Database class======================

 class Database {
 	
 	// Diclare some private properties

 	private $hostdb = "localhost";
 	private $userdb = "root";
 	private $passdb = "";
 	private $namedb = "db_students";
 	private $pdo; 

 	public function __construct(){ 
 		if (!isset($this->pdo)) {
 			try
 			{
 				$link = new PDO("mysql:host=".$this->hostdb.";dbname=".$this->namedb,$this->userdb,$this->passdb);

 				$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 				$link->exec("SET CHARACTER SET utf8");

 				$this->pdo = $link;
 			}
 			catch(PDOException $e){

 				die("Failed to connect with Database ". $e->getMessage());
 			}
 		}
 	}



// ==========This function using for read Data==========

 	/* 
 	$sql= "SELECT * FROM tablename WHERE id=:id and email=:email LIMIT 5, 2";
 	$query = $this->pdo->prepare($sql);
 	$query->bindValue(':id', $id);
 	$query->bindValue(':email', $email);
  	$query->execute();
  	*/

 	public function select($table, $data = array())
 	{
 		$sql = 'SELECT ';

 		$sql .= array_key_exists("select", $data) ? $data['select']: '*';

 		$sql .= ' FROM ' .$table;

 		if(array_key_exists('where', $data) )
 		{
 			$sql .= ' WHERE ';

 			$i = 0;

 			foreach($data['where'] as $key => $value)
 			{
 				$add = ($i > 0) ? ' AND ':'';
 				$sql .= "$add"."$key = :$key";
 				$i++;
 			}
 		}

 		if (array_key_exists("order_by", $data) ) 
 		{
 			$sql .= ' ORDER BY '.$data['order_by'];
 		}

 		// if (array_key_exists("start", $data) && array_key_exists("limit", $data)) {
 		// 	$sql .= ' LIMIT '.$data['start'] .','.$data['limit'];
 		// }elseif(!array_key_exists("start", $data) && array_key_exists("limit", $data)){
 		// 	$sql .= ' LIMIT '.$data['limit'];
 		// }
 		
 		$query = $this->pdo->prepare($sql);

 		if (array_key_exists("where", $data)) 
 		{
 			foreach ($data['where'] as $key => $value) 
 			{
 				$query->bindValue(":$key", $value);
 			}
 		}

 		$query->execute();

 		if (array_key_exists("return_type", $data)) 
 		{
 			switch ($data['return_type']) 
 			{
 				case 'count':
 					$value = $query->rowCount();
 					break;

				case 'single':
					$value = $query->fetch(PDO::FETCH_ASSOC);
					break;
 				
 				default:
 					$value = "";
 					break;
 			}

 		}else
 			{
 				if ($query->rowCount() > 0) 
 				{
 					$value = $query->fetchAll(); 
 				}
 		}
 		return !empty($value) ? $value:false;

 	}

// ==========This function using for insert Data==========
 	/*
 	$sql = "INSERT INTO tablename (name, email) VAKUES (:name, :email)";
 	$query = $this->pdo->prepare($sql);
 	$query->bindValue(':name', $name);
 	$query->bindValue(':email', $email);
 	$query->execute();
	*/
 	public function insert($table, $data)
 	{
 		if (!empty($data) && is_array($data)) 
 		{
 			$keys   = '';
 			$values = '';
 			$i      = 0;

 			$keys   = implode(',', array_keys($data));

 			$values = ":".implode(', :', array_keys($data));

 			$sql    = "INSERT INTO ".$table." (".$keys.") VALUES (".$values.")";

 			$query  = $this->pdo->prepare($sql);

 			foreach ($data as $key => $val) 
 			{
 				$query->bindValue(":$key", $val);
 			}

 			$insertdata = $query->execute();

 			if ($insertdata) 
 			{
 				$lastId = $this->pdo->lastInsertId();

 				return $lastId;

 			}else
 			{
 				return false;
 			}
 		}
 	}



 // ==========This function using for update Data==========
 	/*
 	$sql = "UPDATE tableName SET name=:name, email=:email, WHERE id=:id";
 	$query = $this->pdo->prepare($sql);
 	$query->bindValue(':name', $name);
 	$query->bindValue(':email', $email);
 	$query->bindValue(':id', $id);
 	$query->execute();
	*/
 	public function update($table, $data, $cond)
 	{

 		if (!empty($data) && is_array($data)) 
 		{

 			$keyValue      = '';

 			$whereCond = '';

 			$i         = 0;

		foreach($data as $key => $value)
		{

			$add = ($i > 0) ? ' , ':'';

			$keyValue .= "$add"."$key = :$key";

			$i++;
 		}

 		if (!empty($cond) && is_array($cond)) 
 		{
			$whereCond .=" WHERE ";

			$i = 0;

			foreach($cond as $key => $value)
			{

				$addVal = ($i > 0) ? ' AND  ':'';

				$whereCond .= "$addVal"."$key = :$key";

				$i++;
			}
 		}

 		$sql = "UPDATE ".$table." SET ".$keyValue.$whereCond;

 		$query  = $this->pdo->prepare($sql);

 			foreach ($data as $key => $val) 
 			{
 				$query->bindValue(":$key", $val);
 			}

 			foreach ($cond as $key => $val) 
 			{
 				$query->bindValue(":$key", $val);
 			}


 			$updatedata = $query->execute();

 			return $updatedata?$query->rowCount():false;

 		}else
	 		{
	 			return false;
	 		}	
 	}




//==========This function using for delete Data==========
 	/*
 	$sql = "DELETE tableName WHERE id=:id";
 	$query = $this->pdo->prepare($sql);
 	$query->bindValue(':id', $id);
 	$query->execute();
	*/ 	
 	public function delete($table, $data)
 	{

 		if (!empty($data) && is_array($data)) {

			$whereCond .=" WHERE ";

			$i = 0;

			foreach($data as $key => $val)
			{

				$addVal = ($i > 0) ? ' AND  ':'';

				// if use exec() method
				//$whereCond .= $addVal.$key." = '"$val."'";

				// if use notexec() method

				$whereCond .= "$addVal"."$key = :$key";

				$i++;
			}
 		}

 		$sql = "DELETE FROM ".$table.$whereCond;

 			// if use this===============
 		 	$query  = $this->pdo->prepare($sql);

 			foreach ($data as $key => $val) {
 				$query->bindValue(":$key", $val);
 			}

 			$delete = $query->execute();

 			return $delete?true:false;


			// or use this===============

 			//$delete = $this->pdo->exec($sql);
 
 			return $delete?true:false;

	}

 } 

?>

