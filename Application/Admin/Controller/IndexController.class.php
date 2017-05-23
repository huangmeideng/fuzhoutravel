<?php
namespace Admin\Controller;
use Admin\Controller;

class IndexController extends BaseController{

    public function index(){
        //获取留言数量
        $complainnum=M('complain')->count();
        //获取用户数量
        $usernum=M('user')->count();
        //游记数量
        $notenum=M('note')->count();
        $linksnum=M('links')->count();
        $this->assign(array(
            'complainnum'=>$complainnum,
            'usernum'=>$usernum,
            'notenum'=>$notenum,
            'linksnum'=>$linksnum,
        ));
        $this->display();
    }
}
