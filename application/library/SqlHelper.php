<?php
class SqlHelper{

	private $mysqli;
	private static $host= '127.0.0.1';
	
	private static $user="root";
	
	private static $pwd="123456";
	
	private static $db="greentea";
	
	private static $port="3306";
	
	private $rowsArray = array();           //返回结果数组
	
	public function __construct(){
	
		//完成初始化任务
		
		$this->mysqli=new mysqli(self::$host,self::$user,self::$pwd,self::$db,self::$port);
		
		//connect_error代表mysqli面向对象实例 的属性
		if($this->mysqli->connect_error){
		
		die("连接失败".$this->mysqli->connect_error);
		
		}
		
		//设置访问数据库的字符集
		
		$this->mysqli->query("set names utf8");
		
		//这句话的作用是保证php是以utf8的方式来操作我们的mysql数据库
	}
	
	public function execute_dql($sql){
	
		$res=$this->mysqli->query($sql) or die("操作dql".$this->error);
		
		return ;
	
	}
	
	public function execute_dml($sql){
	
		$res=$this->mysqli->query($sql) or die("操作dml".$this->mysqli_error);
		
		if(!$res){
		
			return 0;//表示失败}
		
		}else{
		
			if($this->mysqli->affected_rows==1){
				//return mysqli_fetch_assoc($res); //返回一条数据 
				$this->rowsArray['0'] = mysqli_fetch_assoc($res);
				return $this->rowsArray;
			
			}
			elseif ($this->mysqli->affected_rows>1){
				unset($this->rowsArray);
				while($row = mysqli_fetch_array($res,MYSQL_ASSOC)) {
					$this->rowsArray[] = $row;
				}
				return $this->rowsArray;//多条返回值		
			}
		
		}
	
	}

	public function getInsertId() {
		return $this->mysqli->insert_id;
	}
	public function __destruct(){
		$this->mysqli->close();
	}
}

 

?>
