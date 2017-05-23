<?php
namespace Home\Controller;
use Think\Controller;
class PageController extends Controller{
    public function index(){
        $P=D('page');
        $page=$P->where('id=1')->find();
        //$page=htmlspecialchars_decode($page);
        $links=getLinks();
        $this->assign('page',$page);
        $this->assign('links',$links);
        $this->display();
    }
}
