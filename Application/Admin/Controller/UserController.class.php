<?php
namespace Admin\Controller;
use Admin\Controller;
/**
*用户管理界面
**/
class UserController extends BaseController{
    /**
    *默认显示
    **/
    public function index($key=""){
        if($key === ""){
            $model = M('user');  
        }else{
            $where['username'] = array('like',"%$key%");
            $where['email'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('user')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $user = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
        $this->assign('user', $user);
        $this->assign('page',$show);
        $this->display();     
    }
}
?>