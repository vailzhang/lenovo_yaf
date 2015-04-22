<?php
class IndexController extends Yaf_Controller_Abstract {
	/*
	 * 登陆页面
	 * */
    public function loginAction() {//默认Action 
    	//判断是否有session中用户存在
    	session_start();
    	//unset($_SESSION['user']);
    	if (!empty($_SESSION['user'])) {
    		$this->redirect('/core/version');
    	}
    	//判断是否有session中用户不存在
    	else{
    		$this->getView();
    	}  	
    }   
}