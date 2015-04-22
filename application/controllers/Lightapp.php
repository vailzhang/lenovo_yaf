<?php
class LightappController extends Yaf_Controller_Abstract {

    /*
     *轻应用游戏数据lite_category表
    * */
    public function litecategoryAction(){
    	self::checkAction();
    	$mySql = new SqlHelper();
    	$sql = "select * from lite_category order by position asc";
    	$result = $mySql->execute_dml($sql);
    	foreach ($result as $k=>&$v) {
    		$v['oldP'] = $k+1;
    		unset($v);
    	}
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$lite_category = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    	}
    	else {
    		$lite_category = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("AllCategory",$result);
    	$this->getView()->assign("lite_category",$lite_category);
    	$this->getView()->assign("numPages",$numPages);
    	return array($userName,$lite_category,$numPages);
    }
    /*
     *轻应用游戏数据lite_category表添加
    * */
    public function addLitecategoryAction(){
    	$nowPage = $_REQUEST['page'];
    	$title = $_REQUEST['title'];
    	$dcrp = $_REQUEST['dcrp'];
    	$mySql = new SqlHelper();
    	if ($_FILES ["iconInput"] ["error"] > 0) {
    		//return  "Return Code: " . $_FILES ["iconInput"] ["error"];
    	}
    	else {
    		if (file_exists ( "../public/uploads/images/" . $_FILES ["iconInput"] ["name"] )) {
    			//return true;
    		} else {
    			move_uploaded_file ( $_FILES ["iconInput"] ["tmp_name"], "../public/uploads/images/" . $_FILES ["iconInput"] ["name"] );
    			//此处需要移动文件到指定位置
    		}
    	}
    	$sql = "insert into lite_category values
    			('','','".$title."','category/".$_FILES ["iconInput"] ["name"]."','".$dcrp."','','','')";
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$lite_category,$numPages) = self::litecategoryAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("lite_category",$lite_category);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     *轻应用游戏数据lite_category表修改
    * */
    public function updateLitecategoryAction(){
    	self::checkAction();
      	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$title = $_REQUEST['title'];
    	$dcrp = $_REQUEST['dcrp'];
    	$mySql = new SqlHelper();
    	    
    	if ($_FILES ["iconInput"] ["error"] > 0) {
    			//return  "Return Code: " . $_FILES ["iconInput"] ["error"];
    	} 
    	else {
    		if (file_exists ( "../public/uploads/images/" . $_FILES ["iconInput"] ["name"] )) {
    			//return true;
    		} else {
    			move_uploaded_file ( $_FILES ["iconInput"] ["tmp_name"], "../public/uploads/images/" . $_FILES ["iconInput"] ["name"] );
    			//此处需要移动文件到指定位置  
    			//return true;
    		}
    	}
    	    	  	
    	$sql = "update lite_category set title='".$title."',img='category/".$_FILES ["iconInput"] ["name"]."',dcrp='".$dcrp."'  where id =".$id;
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$lite_category,$numPages) = self::litecategoryAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("lite_category",$lite_category);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("nowPage",$nowPage);
    }
   /*
     *轻应用游戏数据lite_category表删除记录
    * */
    public function delLitecategoryAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();    	
    	$sql = "select count(*) from lite_item where category = ".$id;
    	$reuslt = $mySql->execute_dml($sql);
    	if ($reuslt['0']['count(*)']==0) {
    		$sql = "delete from lite_category  where id =".$id;
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
     * 轻应用游戏数据lite_category表保存位置
     * */
    public function savePostionLiteCategoryAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$ThisId = $_REQUEST['ThisId'];
    	$PrevId = $_REQUEST['PrevId'];
    	$NextId = $_REQUEST['NextId'];
    	//设置新的位置
    	$newPostion = new NewPosition();
    	$table = "lite_category";
    	$newPostion->setNewPoistion($ThisId, $PrevId, $NextId, $table);
    }
    /*
     * 轻应用游戏类别的暂时下线和上线
    * */
    public function changeLiteCategoryOpensAction() {
    	self::checkAction();
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "select opens from lite_category where id = ".$id;
    	$result = $mySql->execute_dml($sql);
    	$opens = $result['0']['opens'];
    	if ($opens == 0) {
    		$sql = "update lite_category set opens = 1 where id = ".$id;
    	}
    	else {
    		$sql = "update lite_category set opens = 0 where id = ".$id;
    	}
    	$mySql->execute_dql($sql);
    }
    /*
     * lite_item表
    * */
    public function liteitemAction(){
    	self::checkAction();
    	$category = $_REQUEST['category'];
    	$mySql = new SqlHelper();
    	$sql = "select * from lite_item where category = ".$category." order by position asc";
    	$result = $mySql->execute_dml($sql);
    	foreach ($result as $k=>&$v) {
    		$v['oldP'] = $k+1;
    		unset($v);
    	}
    	//获取当前页数、总页数、当前页数内容
    	$pageClass = new page();
    	$numPages = $pageClass->getPage($result, 8);
    	if (empty($_REQUEST['page'])||$_REQUEST['page']>$numPages||$_REQUEST['page']<=0) {
    		$lite_item = $pageClass->getPageArray($result, 8);
    		$this->getView()->assign("nowPage",1);
    		//var_dump($leftdata);exit;
    	}
    	else {
    		$lite_item = $pageClass->getPageArray($result, 8,$_REQUEST['page']);
    		$this->getView()->assign("nowPage",$_REQUEST['page']);
    	}
    	//得到视图并传值
    	session_start();
    	$userName = $_SESSION['user'];
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("lite_item",$lite_item);
    	$this->getView()->assign("numPages",$numPages); 
    	$this->getView()->assign("category",$category);
    	//获取关联父类
    	$sql = 'select * from lite_category';
    	$lite_category = $mySql->execute_dml($sql);
    	$this->getView()->assign("lite_category",$lite_category);
    	return array($userName,$lite_item,$numPages);
    }
    /*
     *轻应用游戏数据lite_item表添加
    * */
    public function addliteitemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$title = $_REQUEST['title'];
    	$category = $_REQUEST['category'];
    	$url = $_REQUEST['url'];
    	$dcrp = $_REQUEST['dcrp'];
    	$downloads = $_REQUEST['downloads'];
    	$mySql = new SqlHelper();
    	if ($_FILES ["iconInput"] ["error"] > 0) {
    		//return  "Return Code: " . $_FILES ["iconInput"] ["error"];
    	}
    	else {
    		if (file_exists ( "../public/uploads/images/" . $_FILES ["iconInput"] ["name"] )) {
    			//return true;
    		} else {
    			move_uploaded_file ( $_FILES ["iconInput"] ["tmp_name"], "../public/uploads/images/" . $_FILES ["iconInput"] ["name"] );
    			//需要移动文件到制定位置
    			//return true;
    		}
    	}
    	$sql = "insert into lite_item values('','".$category."','','".$title."',
    			'".$url."','item/".$_FILES ["iconInput"] ["name"]."','".$dcrp."','','','','".$downloads."','','','','','')";
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$lite_item,$numPages,$lite_category) = self::liteitemAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("lite_item",$lite_item);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("lite_category",$lite_category);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     *轻应用游戏数据lite_item表修改
    * */
    public function updateliteitemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$title = $_REQUEST['title'];
    	$category = $_REQUEST['category'];
    	$url = $_REQUEST['url'];
    	$dcrp = $_REQUEST['dcrp'];
    	$downloads = $_REQUEST['downloads'];
    	$mySql = new SqlHelper();
    	
    	if ($_FILES ["iconInput"] ["error"] > 0) {
    		//return  "Return Code: " . $_FILES ["iconInput"] ["error"];
    	}
    	else {
    		if (file_exists ( "../public/uploads/images/" . $_FILES ["iconInput"] ["name"] )) {
    			//return true;
    		} else {
    			move_uploaded_file ( $_FILES ["iconInput"] ["tmp_name"], "../public/uploads/images/" . $_FILES ["iconInput"] ["name"] );
    			//此处需要移动文件到指定位置
    			//return true;
    		}
    	}	
    	$sql = "update lite_item set title='".$title."',category='".$category."',
    			url='".$url."',img='item/".$_FILES ["iconInput"] ["name"]."',dcrp='".$dcrp."',downloads='".$downloads."'  where id =".$id;
    	$mySql->execute_dql($sql);
    	//获取数据库中的新数据
    	list($userName,$lite_item,$numPages,$lite_category) = self::liteitemAction();
    	//传值并渲染视图
    	$this->getView()->assign("userName",$userName);
    	$this->getView()->assign("lite_item",$lite_item);
    	$this->getView()->assign("numPages",$numPages);
    	$this->getView()->assign("lite_category",$lite_category);
    	$this->getView()->assign("nowPage",$nowPage);
    }
    /*
     *轻应用游戏数据lite_item表删除记录
    * */
    public function delliteitemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "delete from lite_item  where id =".$id;
    	$mySql->execute_dql($sql);
    	$this->redirect('liteitem?page='.$nowPage);
    }
    /*
     * 轻应用游戏数据lite_item表保存位置
    * */
    public function savePostionLiteItemAction(){
    	self::checkAction();
    	$nowPage = $_REQUEST['page'];
    	$ThisId = $_REQUEST['ThisId'];
    	$PrevId = $_REQUEST['PrevId'];
    	$NextId = $_REQUEST['NextId'];
    	//设置新的位置
    	$newPostion = new NewPosition();
    	$table = "lite_item";
    	$newPostion->setNewPoistion($ThisId, $PrevId, $NextId, $table);
    }
    /*
     * 轻应用游戏类别的暂时下线和上线
    * */
    public function changeLiteItemOpensAction() {
    	self::checkAction();
    	$id = $_REQUEST['id'];
    	$mySql = new SqlHelper();
    	$sql = "select opens from lite_item where id = ".$id;
    	$result = $mySql->execute_dml($sql);
    	$opens = $result['0']['opens'];
    	if ($opens == 0) {
    		$sql = "update lite_item set opens = 1 where id = ".$id;
    	}
    	else {
    		$sql = "update lite_item set opens = 0 where id = ".$id;
    	}
    	$mySql->execute_dql($sql);
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
