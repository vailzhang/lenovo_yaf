<?php
class HomeController extends Yaf_Controller_Abstract {  
    /*
     * 首页运营数据
    * */
    public function HomeAction(){    	  	
    	self::checkAction();
    	$mySql = new SqlHelper();
    	$sql = "select * from home_operation order by id asc";
    	$result = $mySql->execute_dml($sql);
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$homeoperation = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    	}
    	else {
    		$homeoperation = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("homeoperation",$homeoperation);
    	$this->getView()->assign("numPages",$numPages);
    	return array($userName,$homeoperation,$numPages);
    }
    /*
     * 首页运营数据添加
    * */
    public function addHomeAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$version = $_REQUEST['version'];
    	$version_min = $_REQUEST['version_min'];
    	$version_max = $_REQUEST['version_max'];
    	$command = $_REQUEST['command'];
    	$old_url = $_REQUEST['old_url'];
    	$url = $_REQUEST['url'];
    	$src = $_REQUEST['src'];
    	$color = $_REQUEST['color'];
    	$mySql = new SqlHelper();
    	$sql = "insert into home_operation values ('','".$version."','','".$version_min."','".$version_max."','".$command."',
    			'','','".$old_url."','','".$url."','".$src."','','".$color."')";
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$homeoperation,$numPages) = self::HomeAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("homeoperation",$homeoperation);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 首页运营数据修改
     * */
    public function updateHomeAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$version = $_REQUEST['version'];
    	$version_min = $_REQUEST['version_min'];
    	$version_max = $_REQUEST['version_max'];
    	$command = $_REQUEST['command'];
    	$old_url = $_REQUEST['old_url'];
    	$url = $_REQUEST['url'];
    	$src = $_REQUEST['src'];
    	$color = $_REQUEST['color'];
    	$mySql = new SqlHelper();
    	$sql = "update home_operation set version='".$version."',version_min='".$version_min."', 
    			version_max='".$version_max."',command='".$command."',old_url='".$old_url."',
    			url='".$url."',src='".$src."',color='".$color."' where id =".$id;
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$homeoperation,$numPages) = self::HomeAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("homeoperation",$homeoperation);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 首页运营数据删除
     * */
    public function delHomeAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "delete from home_operation  where id =".$id;
    	$mySql->execute_dql($sql);
    	$this->redirect('home?page='.$nowPage);
    }
 
    /*
     * session过期返回登陆页面
     * */
    public function checkAction(){
    	session_start();
    	if(empty($_SESSION['user'])){
    		$this->redirect('/');
    	}
    }
    /*
     * 注销登陆
    * */
    public function exitAction(){
    	//启动session注销登陆用户
    	session_start();
    	unset($_SESSION['user']);
    	//返回根登陆页面
    	$this->redirect('/');
    }
}