<?php
namespace Admin\Controller;
use Admin\Controller;

class TestController extends BaseController{
	public function index(){
		$member=D('member');
		$map['username']=session('username');
		$data=$member->where($map)->find();
		//$data=session('username');
		$this->assign('data',$data);
		$this->display();
	}
}
