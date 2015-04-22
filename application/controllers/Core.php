<?php
class CoreController extends Yaf_Controller_Abstract {
	/*
	 * 网址下发类别
	 * */
    public function UrlissueCateAction() { 
    	self::checkAction();
    	$mySql = new SqlHelper();
    	$sql = "select * from core_urlissue_cate  order by id asc";
    	$result = $mySql->execute_dml($sql);
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$urlissueCate = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    	}
    	else {
    		$urlissueCate = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("AllUrlissueCate",$result);
    	$this->getView()->assign("urlissueCate",$urlissueCate);
    	$this->getView()->assign("numPages",$numPages);
    	return array($userName,$urlissueCate,$numPages);
    }  
    /*
     * 网址下发类别添加
    * */
    public function addUrlissueCateAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$key = $_REQUEST['key'];
    	$describe = $_REQUEST['describe'];
    	$mySql = new SqlHelper();
    	$sql = "insert into core_urlissue_cate values ('','".$key."','".$describe."')";
    	//var_dump($sql);exit;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$urlissueCate,$numPages) = self::UrlissueCateAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("urlissueCate",$urlissueCate);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
	 * 网址下发类别修改
	 * */ 
    public function updateUrlissueCateAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$key = $_REQUEST['key'];
    	$describe = $_REQUEST['describe'];
    	$mySql = new SqlHelper();
    	$sql = "update core_urlissue_cate set cate_key = '".$key."',`describe` = '".$describe."'  where id = ".$id;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$urlissueCate,$numPages) = self::UrlissueCateAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("urlissueCate",$urlissueCate);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 网址下发类别删除
    * */
    public function delUrlissueCateAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
	  	$sql = "select count(*) from core_urlissue_item where cate_key = ".$id;
    	$reuslt = $mySql->execute_dml($sql);
    	if ($reuslt['0']['count(*)']==0) {
    		$sql = "delete from core_urlissue_cate  where id =".$id;
    		$mySql->execute_dql($sql);
    		$msg = 'sucess';
    	}
    	else {
    		$msg = 'error';
    	}
    	echo $msg;
    	exit;
    }
    /*
     * 网址下发
    * */
    public function UrlissueItemAction() {
    	self::checkAction();
    	$cate_key = $_REQUEST['cate_key'];
    	$mySql = new SqlHelper();
    	$sql = "select * from core_urlissue_item  where cate_key = ".$cate_key." order by id asc";
    	$result = $mySql->execute_dml($sql);
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$urlissueItem = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    	}
    	else {
    		$urlissueItem = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("urlissueItem",$urlissueItem);
    	$this->getView()->assign("numPages",$numPages);
    	//获取关联网址下发类别
    	$sql = 'select * from core_urlissue_cate';
    	$urlissueCate = $mySql->execute_dml($sql);
    	$this->getView()->assign("cate_key",$cate_key);
    	$this->getView()->assign("urlissueCate",$urlissueCate);
    	return array($userName,$urlissueItem,$numPages,$urlissueCate);
    }
    /*
     * 网址下发添加
    * */
    public function addUrlissueItemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$cate_key = $_REQUEST['cate_key'];
    	$item_key = $_REQUEST['item_key'];
    	$link = $_REQUEST['link'];
    	$describe = $_REQUEST['describe'];
    	$mySql = new SqlHelper();
    	$sql = "insert into core_urlissue_item values ('','".$cate_key."','".$item_key."','".$link."','','".$describe."')";
    	//var_dump($sql);exit;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$urlissueItem,$numPages,$urlissueCate) = self::UrlissueItemAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("urlissueItem",$urlissueItem);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("urlissueCate",$urlissueCate);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 网址下发修改
    * */
    public function updateUrlissueItemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$cate_key = $_REQUEST['cate_key'];
    	$item_key = $_REQUEST['item_key'];
    	$link = $_REQUEST['link'];
    	$describe = $_REQUEST['describe'];
    	$mySql = new SqlHelper();
    	$sql = "update core_urlissue_item set cate_key = '".$cate_key."',item_key = '".$item_key."',
    			link = '".$link."',`describe` = '".$describe."'  where id = ".$id;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$urlissueItem,$numPages,$urlissueCate) = self::UrlissueItemAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("urlissueItem",$urlissueItem);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("urlissueCate",$urlissueCate);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 网址下发删除
    * */
    public function delUrlissueItemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "delete from core_urlissue_item  where id =".$id;
    	$mySql->execute_dql($sql);
    	$this->redirect('UrlissueItem?page='.$nowPage);
    }
    /*
     * 字符串下发
    * */
    public function StrissueAction() {
    	self::checkAction();
    	$mySql = new SqlHelper();
    	$sql = "select * from  core_strissue  order by id asc";
    	$result = $mySql->execute_dml($sql);
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$strIssue = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    	}
    	else {
    		$strIssue = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("strIssue",$strIssue);
    	$this->getView()->assign("numPages",$numPages);
    	return array($userName,$strIssue,$numPages);
    }
    /*
     * 字符串下发添加
    * */
    public function addStrissueAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$key = $_REQUEST['key'];
    	$main = $_REQUEST['main'];
    	$expand = $_REQUEST['expand'];
    	$other = $_REQUEST['other'];
    	$mySql = new SqlHelper();
    	$sql = "insert into core_strissue values ('','".$key."','".$main."','".$expand."','".$other."')";
    	//var_dump($sql);exit;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$strIssue,$numPages) = self::StrissueAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("strIssue",$strIssue);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     *字符串下发修改
    * */
    public function updateStrissueAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$key = $_REQUEST['key'];
    	$main = $_REQUEST['main'];
    	$expand = $_REQUEST['expand'];
    	$other = $_REQUEST['other'];
    	$mySql = new SqlHelper();
    	$sql = "update core_strissue set `key` = '".$key."',main = '".$main."',
    			expand = '".$expand."',other = '".$other."'  where id = ".$id;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$strIssue,$numPages) = self::StrissueAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("strIssue",$strIssue);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 字符串下发删除
    * */
    public function delStrissueAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "delete from core_strissue  where id =".$id;
    	$mySql->execute_dql($sql);
    	$this->redirect('Strissue?page='.$nowPage);
    }
    /*
     * 网址推荐
    * */
    public function UrlReCommendAction() {
    	self::checkAction();
    	$mySql = new SqlHelper();
    	$sql = "select * from  core_urlrecommend  order by position asc";
    	$result = $mySql->execute_dml($sql);
    	foreach ($result as $k=>&$v){
    		$v['oldPo'] = $k+1;
    		unset($v);
    	}
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$UrlRecommend = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    	}
    	else {
    		$UrlRecommend = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("UrlRecommend",$UrlRecommend);
    	$this->getView()->assign("numPages",$numPages);
    	return array($userName,$UrlRecommend,$numPages);
    }
    /*
     * 网址推荐添加
    * */
    public function addUrlReCommendAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$name = $_REQUEST['name'];
    	$link = $_REQUEST['link'];
    	$position = $_REQUEST['position'];
    		
    	$mySql = new SqlHelper();
    	$sql = "insert into  core_urlrecommend values ('','".$name."','".$link."','')";   	
    	$mySql->execute_dql($sql); 
    	
		//给新加的网址推荐添加position值
		if(empty($position)){
			$position = 1;
		}
    	$id = $mySql->getInsertId();
    	$table = 'core_urlrecommend';
    	$newPosition = new NewPosition();
    	$newPosition->insertPosition($id, $position, $table);
    	
    	//获取最新数据
    	list($userName,$UrlRecommend,$numPages) = self::UrlReCommendAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("UrlRecommend",$UrlRecommend);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     *网址推荐修改
    * */
    public function updateUrlReCommendAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$name = $_REQUEST['name'];
    	$link = $_REQUEST['link'];
    	$oldPo = $_REQUEST['oldPo'];
    	$newPo = $_REQUEST['newPo'];
    	if ($oldPo != $newPo) {
    		$newPosition = new NewPosition();
	    	$table = 'core_urlrecommend';
	    	$newPosition->getNewPosition($id,$oldPo,$newPo, $table);
    	}
    	
    	$mySql = new SqlHelper();
    	$sql = "update core_urlrecommend set name = '".$name."',
    			link = '".$link."' where id = ".$id;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$UrlRecommend,$numPages) = self::UrlReCommendAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("UrlRecommend",$UrlRecommend);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 网址推荐删除
    * */
    public function delUrlReCommendAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "delete from core_urlrecommend  where id =".$id;
    	$mySql->execute_dql($sql);
    	$this->redirect('UrlReCommend?page='.$nowPage);
    }
    
    /*
     * 网址推荐保存位置
    * */
    public function savePostionUrlRecommendAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$ThisId = $_REQUEST['ThisId'];
    	$PrevId = $_REQUEST['PrevId'];
    	$NextId = $_REQUEST['NextId'];	
    	//设置新的位置
    	$newPostion = new NewPosition();
    	$table = "core_urlrecommend";
    	$newPostion->setNewPoistion($ThisId, $PrevId, $NextId, $table);
    }
    /*
     * 版本号统一升级
    * */
    public function VersionAction() {
    	if (!empty($_REQUEST['username'])) {
    		$userName = $_REQUEST['username'];
    		$userPasswd = $_REQUEST['userpasswd'];
    	}

    	session_start();
    	//判断用户信息正确
    	if (!empty($_SESSION['user'])||($userName == 'zhangtang'&&$userPasswd == '123456')) {
    		$_SESSION['user'] =  'zhangtang';
    		$userName = $_SESSION['user'];
	    	$mySql = new SqlHelper();
	    	$sql = "select * from  core_version  order by id asc";
	    	$result = $mySql->execute_dml($sql);
	    	//获取当前页数、总页数、当前页数内容
	    	$pageClass = new page();
	    	$numPages = $pageClass->getPage($result, 8);
	    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
	    		$version = $pageClass->getPageArray($result, 8);
	    		$this->getView()->assign("nowPage",1);
	    	}
	    	else {
	    		$version = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
	    		$this->getView()->assign("nowPage",$_REQUEST['page']);
	    	}
	    	//得到视图并传值
	    	session_start();
	    	$userName = $_SESSION['user'];
	    	$this->getView()->assign("userName",$userName);
	    	$this->getView()->assign("version",$version);
	    	$this->getView()->assign("numPages",$numPages);
	    	return array($userName,$version,$numPages);
    	}
    	//判断用户信息正确
    	else {
    	$this->redirect('/error/error?message=用户名或者密码错误');
    	}
    }
    /*
     * 版本号统一升级添加
    * */
    public function addVersionAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$key = $_REQUEST['key'];
    	$version = $_REQUEST['version'];
    	$description = $_REQUEST['description'];
    	$issue_time = time();
    	$mySql = new SqlHelper();
    	$sql = "insert into core_version values ('','".$key."','".$version."',
    			'".$description."','".$issue_time."')";
    	//var_dump($sql);exit;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$version,$numPages) = self::VersionAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("version",$version);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     *版本号统一升级修改
    * */
    public function updateVersionAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$key = $_REQUEST['key'];
    	$version = $_REQUEST['version'];
    	$description = $_REQUEST['description'];
    	$issue_time = time();
    	$mySql = new SqlHelper();
    	$sql = "update core_version set `key` = '".$key."',version = '".$version."',
    			description = '".$description."',issue_time = '".$issue_time."'  where id = ".$id;
    	//var_dump($sql);exit;
    	$mySql->execute_dql($sql);
    	//获取最新数据
    	list($userName,$version,$numPages) = self::VersionAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("version",$version);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 版本号统一升级删除
    * */
    public function delVersionAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "delete from core_version  where id =".$id;
    	$mySql->execute_dql($sql);
    	$this->redirect('Version?page='.$nowPage);
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