<?php
class page{				  //传入总记录
	private static $num;   				  //总记录数
	private static $page;           	  //总页数
	private static $pageArray = array(); //每页数据
	public function getPage($result,$pageSize) {	
		$this->num = count ( $result);
		if ($this->num % $pageSize) {
			$this->page = ( int ) ($this->num / $pageSize )+ 1;
		} else {
			$this->page = $this->num / $pageSize;
		}
		return $this->page;
	}
	public function getPageArray($result,$pageSize,$nowPage=1){
		$this->pageArray = array_slice($result, ($nowPage-1)*$pageSize,$pageSize);
		return $this->pageArray;
	}
}