<?php
class NewPosition{			   
	private static $newP; //新位置
	public function setNewPoistion($ThisId,$PrevId,$NextId,$table){			
		$mySql = new SqlHelper();		
		$PrevP = "";
		$NextP = "";
		if (empty($PrevId)&&empty($NextId)) {  	 //如果上下id都为空，则没变化
			$sql = "select position from ".$table." where id = ".$ThisId;
			$result = $mySql->execute_dml($sql);
			$ThisP  = $result['0']['position'];
			$ThisP = (int)$ThisP;
			$PrevP = $ThisP;
			$NextP = $ThisP;
		}
		elseif (empty($PrevId)&&!empty($NextId)) { //如果上id为空，下id不为空
			$sql = "select position from ".$table." where id =".$NextId;
			$result = $mySql->execute_dml($sql);
			$NextP  = $result['0']['position'];
			
			$sql = "select max(position) from ".$table." where position <".$NextP;
			$result = $mySql->execute_dml($sql);
			$PrevId  = $result['0']['max(position)'];	
		}
		elseif (!empty($PrevId)&&empty($NextId)) { //如果上id不为空，下id为空			
			$sql = "select position from ".$table." where id =".$PrevId;
			$result = $mySql->execute_dml($sql);
			$PrevP  = $result['0']['position'];
			$sql = "select min(position) from ".$table." where position >".$PrevP;
			$result = $mySql->execute_dml($sql);
			$NextP  = $result['0']['min(position)'];
			
		}
		else {											 //如果上id不为空，下id不为空 
			$sql = "select position from ".$table." where id =".$PrevId;
			$result = $mySql->execute_dml($sql);
			$PrevP  = $result['0']['position'];
			
			$sql = "select position from ".$table." where id =".$NextId;
			$result = $mySql->execute_dml($sql);
			$NextP  = $result['0']['position'];
		}
		//获取最新的位置
		if (empty($PrevP)&&empty($NextP)) {          //如果上下position都为空，则没变化
			return true;
		}
		elseif (empty($PrevP)&&!empty($NextP)) {		//如果上position为空，下position不为空，即放在本页第一位
			$this->newP =  $NextP/2;
		}
		elseif (!empty($PrevP)&&empty($NextP)){		//如果上position不为空，下postion为空，即放在本页末位
			$this->newP = $PrevP + 1000000;
		}
		else {
			$this->newP = ($PrevP + $NextP)/2;			//如果上position不为空，下position不为空 
		}
		//设置最新位置
		$sql = "update ".$table." set position = '".$this->newP."' where id = ".$ThisId;
		$mySql->execute_dql($sql);
		return true;
	}
	public function getNewPosition($id,$oldPo,$newPo,$table){
		$mySql = new SqlHelper();
		//获取当前表中的排序
		$sql = "select * from ".$table." order by position asc";
		$result = $mySql->execute_dml($sql);
		
		foreach ($result as $k=>&$v){
	    	$v['oldPo'] = $k+1;
	    	unset($v);
	    }
	    //查找出需要替换的顺序的id号
	    foreach ($result as $k=>$v){
	    	$replace_Id = $v['id'];
	    	if ($v['oldPo'] == $newPo) {
	    		$replace_Id = $v['id'];
	    		break;
	    	}
	    }
	    //如果修改的排序大于原有排序
	    if ($newPo > $oldPo) {	 
	    	//查找出需要替换的顺序的上一id号
	    	$PrevId = $replace_Id;
	    	
	    	//查找出需要替换的顺序的下一id号
	    	foreach ($result as $k=>$v){
	    		if ($v['oldPo'] == $newPo) {
	    			$NextId = $v['id'];
	    			break;
	    		}
	    	}    
	    } 
	    //如果修改的排序小于原有排序
	    elseif ($newPo < $oldPo){
	     	//查找出需要替换的顺序的上一id号
		    foreach ($result as $k=>$v){
		    	if ($v['oldPo'] == $newPo-1) {
		    		$PrevId = $v['id'];
		    		break;
		    	}
		    }
		    //查找出需要替换的顺序的下一id号
		   $NextId = $replace_Id; 	
	    }
	    $ThisId = $id;
	    self::setNewPoistion($ThisId, $PrevId, $NextId, $table);
	}
	public function insertPosition($id,$position,$table){
		$mySql = new SqlHelper();
		//获取当前表中的排序
		$sql = "select * from ".$table." where position != '' order by position asc";
		$result = $mySql->execute_dml($sql);
		
		foreach ($result as $k=>&$v){
			$v['oldPo'] = $k+1;
			unset($v);
		}
		//查找出需要替换的顺序的id号
		foreach ($result as $k=>$v){
			$replace_Id = $v['id']+1;
			if ($v['oldPo'] == $position) {
				$replace_Id = $v['id'];
				break;
			}
		}
		$ThisId = $id;
		$PrevId = $replace_Id-1;
		$NextId = $replace_Id;
		self::setNewPoistion($ThisId, $PrevId, $NextId, $table);
	}
}