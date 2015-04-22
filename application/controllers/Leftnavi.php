<?php
class LeftnaviController extends Yaf_Controller_Abstract {  
    /*
     * 左屏导航父类别数据navicate
    * */
    public function navicateAction(){  
    		self::checkAction();
    		$mySql = new SqlHelper();
	    	$sql = "select * from navi_unit_cate order by position asc";
	    	$result = $mySql->execute_dml($sql);
	    	foreach ($result as $k=>&$v){
	    		$v['oldPo'] = $k+1;
	    		unset($v);
	    	}
	    	//获取当前页数、总页数、当前页数内容
	    	$pageClass = new page();
	    	$numPages = $pageClass->getPage($result, 8);
	    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
	    		$nav_cate = $pageClass->getPageArray($result, 8);
	    		$this->getView()->assign("nowPage",1);
	    		//var_dump($leftdata);exit;
	    	}
	    	else {
	    		$nav_cate = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
	    		$this->getView()->assign("nowPage",$_REQUEST['page']);
	    	}
	    	//得到视图并传值
	    	session_start();
	    	$userName = $_SESSION['user'];
	    	$this->getView()->assign("userName",$userName);
	    	$this->getView()->assign("AllNaviCate",$result);
	    	$this->getView()->assign("nav_cate",$nav_cate);
	    	$this->getView()->assign("numPages",$numPages);
	    	return array($userName,$nav_cate,$numPages);  
	    	
    }
    /*
     * 左屏导航父类别数据添加navicate
    * */
    public function addNaviCateAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page']; 
    	$title = $_REQUEST['title']; 
    	$mySql = new SqlHelper();
    	$sql = "select max(position) from navi_unit_cate";
    	$result = $mySql->execute_dml($sql);
    	$position = ($result['max(position)']+1000000);
    	$sql = "insert into navi_unit_cate values 
    			('','".$title."',$position)";
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$nav_cate,$numPages) = self::navicateAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("nav_cate",$nav_cate);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
     /*
     * 左屏导航父类别数据修改navicate
    * */
    public function updateNaviCateAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$title = $_REQUEST['title'];
    
    	$mySql = new SqlHelper();
    	$sql = "update navi_unit_cate set title='".$title."' where id =".$id;
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$nav_cate,$numPages) = self::navicateAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("nav_cate",$nav_cate);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
     /*
     * 左屏导航父类别数据删除navicate
    * */
    public function delNaviCateAction(){
    	self::checkAction();
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "select count(*) from navi_unit_subcate where cate_id = ".$id;
    	$reuslt = $mySql->execute_dml($sql);
    	if ($reuslt['0']['count(*)']==0) {
    		$sql = "delete from navi_unit_cate  where id =".$id;
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
     * 左屏导航父类别数据保存位置
     * */
    public function savePostionNaviCateAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$ThisId = $_REQUEST['ThisId'];
    	$PrevId = $_REQUEST['PrevId'];
    	$NextId = $_REQUEST['NextId'];	
    	//设置新的位置
    	$newPostion = new NewPosition();
    	$table = "navi_unit_cate";
    	$newPostion->setNewPoistion($ThisId, $PrevId, $NextId, $table);
    }
     /*
     * 左屏导航子类别数据navisubcate
    * */
    public function navisubcateAction(){
    	self::checkAction();
    	$cate_id = $_REQUEST['cate_id'];
    	$mySql = new SqlHelper();
    	$sql = "select * from navi_unit_subcate where cate_id = ".$cate_id." order by position asc";
    	$result = $mySql->execute_dml($sql);
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$navisubcate = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    		//var_dump($leftdata);exit;
    	}
    	else {
    		$navisubcate = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];   	
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("AllNaviSubCate",$result);
    	$this->getView()->assign("navisubcate",$navisubcate);
    	$this->getView()->assign("numPages",$numPages);
    	//获取关联父类
    	$sql = 'select * from navi_unit_cate';
    	$nav_cate = $mySql->execute_dml($sql);
    	$this->getView()->assign("cate_id",$cate_id);
    	$this->getView()->assign("nav_cate",$nav_cate);  	
    	return array($userName,$navisubcate,$numPages);
    }
    /*
     * 左屏导航子类别数据修改navisubcate
    * */
    public function updateNaviSubcateAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$title = $_REQUEST['title'];
    	$url = $_REQUEST['url'];
    	$cate_id = $_REQUEST['cate_id'];
    	$a_color = $_REQUEST['a_color'];
    	$b_color = $_REQUEST['b_color'];
    	$mySql = new SqlHelper();
    	$sql = "update navi_unit_subcate set title='".$title."',
    			 url='".$url."', cate_id=$cate_id, a_color='".$a_color."',
    			 b_color='".$b_color."'  where id =".$id;
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$navisubcate,$numPages,$nav_cate) = self::navisubcateAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("navisubcate",$navisubcate);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nav_cate",$nav_cate);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 左屏导航子类别数据添加navisubcate
    * */
    public function addNaviSubcateAction(){ 
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$title = $_REQUEST['title'];
    	$url = $_REQUEST['url'];
    	$cate_id = $_REQUEST['cate_id'];
    	$a_color = $_REQUEST['a_color'];
    	$b_color = $_REQUEST['b_color'];
    	$mySql = new SqlHelper();
    	$sql = "select max(position) from navi_unit_subcate where cate_id = ".$cate_id;
    	$result = $mySql->execute_dml($sql);
    	$position = ($result['max(position)']+1000000);
    	$sql = "insert into navi_unit_subcate values ('',$cate_id,'".$title."','".$url."',
    			'".$a_color."','".$b_color."',$position)";
    	//var_dump($sql);exit;
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$navisubcate,$numPages,$nav_cate) = self::navisubcateAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("navisubcate",$navisubcate);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nav_cate",$nav_cate);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 左屏导航子类别数据删除navisubcate
    * */
    public function delNaviSubcateAction(){
    	self::checkAction();
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "select count(*) from navi_unit_item where subcate_id = ".$id;
    	$reuslt = $mySql->execute_dml($sql);
    	if ($reuslt['0']['count(*)']==0) {
    		$sql = "delete from navi_unit_subcate  where id =".$id;
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
     * 左屏导航子类别数据保存位置
    * */
    public function savePostionNaviSubCateAction(){
    	self::checkAction();
    	$ThisId = $_REQUEST['ThisId'];
    	$PrevId = $_REQUEST['PrevId'];
    	$NextId = $_REQUEST['NextId'];
    	//设置新的位置
    	$newPostion = new NewPosition();
    	$table = "navi_unit_subcate";
    	$newPostion->setNewPoistion($ThisId, $PrevId, $NextId, $table);
    }
    /*
     * 左屏导航网址数据navi_item
     * */
    public function naviitemAction(){   
    	self::checkAction();
    	$subcate_id = $_REQUEST['subcate_id'];
    	$mySql = new SqlHelper();
    	$sql = "select * from navi_unit_item where subcate_id = ".$subcate_id." order by position asc";
    	$result = $mySql->execute_dml($sql);
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$naviitem = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    		//var_dump($leftdata);exit;
    	}
    	else {
    		$naviitem = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("naviitem",$naviitem);
    	$this->getView()->assign("numPages",$numPages);

    	
    	//获取父类目录
    	$sql = "select * from navi_unit_cate order by position asc";
	   	$navicate = $mySql->execute_dml($sql);
	   	$this->getView()->assign("navicate",$navicate);
	   	//获取关联父类
	   	$sql = "select cate_id from navi_unit_subcate where id =".$subcate_id;
	   	$result = $mySql->execute_dml($sql);
	   	$cate_id = $result['0']['cate_id'];
	   	$this->getView()->assign("cate_id",$cate_id);
	   	
	   	//获取关联子类目录
	   	$sql = 'select * from navi_unit_subcate where cate_id='.$cate_id;
	   	$navisubcate = $mySql->execute_dml($sql);
	   	$this->getView()->assign("navisubcate",$navisubcate);
	   	//获取关联子类
	   	$this->getView()->assign("subcate_id",$subcate_id);
	   	
    	return array($userName,$naviitem,$numPages);
    }
    /*
     * 左屏导航网址数据添加naviitem
    * */
    public function addNaviItemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$title = $_REQUEST['title'];
    	$url = $_REQUEST['url'];
    	$subcate_id = $_REQUEST['subcate_id'];
    	$a_color = $_REQUEST['a_color'];
    	$b_color = $_REQUEST['b_color'];
    	$mySql = new SqlHelper();
    	$sql = "select max(position) from navi_unit_item where subcate_id = ".$subcate_id;
    	$result = $mySql->execute_dml($sql);
    	$position = ($result['max(position)']+1000000);
    	$sql = "insert into navi_unit_item values ('',$subcate_id,'".$title."','".$url."',
    			'".$a_color."','".$b_color."',$position)";
    	//var_dump($sql);exit;
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$naviitem,$numPages,$navisubcate) = self::naviitemAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("navisubcate",$naviitem);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("navisubcate",$navisubcate);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 左屏导航网址数据修改navi_item
     * */
    public function updateNaviItemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$title = $_REQUEST['title'];
    	$url = $_REQUEST['url'];
    	$subcate_id = $_REQUEST['subcate_id'];
    	$a_color = $_REQUEST['a_color'];
    	$b_color = $_REQUEST['b_color'];
    	$mySql = new SqlHelper();
    	$sql = "update navi_unit_item set title='".$title."',
    			 url='".$url."', subcate_id=$subcate_id, a_color='".$a_color."',
    			 b_color='".$b_color."'  where id =".$id;
    	//var_dump($sql);exit;
    	$mySql->execute_dql($sql);   	
    	//获取数据库中的新数据
    	list($userName,$naviitem,$numPages,$navisubcate) = self::naviitemAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("navisubcate",$naviitem);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("navisubcate",$navisubcate);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 左屏导航网址数据删除navi_item
     * */
    public function delNaviItemAction(){
    	self::checkAction();
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "delete from navi_unit_item  where id =".$id;
    	$mySql->execute_dql($sql);
    	echo 'sucess';exit;
    }
    /*
     * 左屏导航子类别数据保存位置
    * */
    public function savePostionNaviItemAction(){
    	self::checkAction();
    	$ThisId = $_REQUEST['ThisId'];
    	$PrevId = $_REQUEST['PrevId'];
    	$NextId = $_REQUEST['NextId'];
    	//设置新的位置
    	$newPostion = new NewPosition();
    	$table = "navi_unit_item";
    	//var_dump($ThisId."/".$PrevId."/".$NextId);exit;
    	$newPostion->setNewPoistion($ThisId, $PrevId, $NextId, $table);
    }
    /*
     * 左屏导航左屏条幅数据
    * */
    public function leftdataAction(){ 
    	self::checkAction();
    	$mySql = new SqlHelper();
    	$sql = "select * from navi_banner order by id asc";
    	$result = $mySql->execute_dml($sql);
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$leftdata = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    		//var_dump($leftdata);exit;
    	}
    	else {
    		$leftdata = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("leftdata",$leftdata);
    	$this->getView()->assign("numPages",$numPages);
    	return array($userName,$leftdata,$numPages);
    }
    /*
     * 左屏导航左屏条幅数据添加
     * */
    public function addLeftdataAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$title = $_REQUEST['title'];
    	$url = $_REQUEST['url'];
    	$iconUrl = $_REQUEST['iconUrl'];
    	$mySql = new SqlHelper();
    	$sql = "insert into navi_banner values ('','".$title."','".$url."','".$iconUrl."')";    	
    	$mySql->execute_dql($sql);   	
    	//获取数据库中的新数据
    	list($userName,$leftdata,$numPages) = self::leftdataAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("leftdata",$leftdata);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 左屏导航左屏条幅数据下发修改
     * */
    public function updateLeftdataAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$title = $_REQUEST['title'];
    	$url = $_REQUEST['url'];
    	$iconUrl = $_REQUEST['iconUrl'];
    	$mySql = new SqlHelper();
    	$sql = "update navi_banner set title='".$title."',url='".$url."',img_url='".$iconUrl."' where id =".$id;
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$leftdata,$numPages) = self::leftdataAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("leftdata",$leftdata);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     * 左屏导航左屏条幅数据下发删除
     * */
    public function delLeftdataAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "delete from navi_banner  where id =".$id;
    	$mySql->execute_dql($sql);
    	$this->redirect('leftdata?page='.$nowPage);
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