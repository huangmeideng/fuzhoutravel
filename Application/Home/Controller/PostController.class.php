<?php
namespace Home\Controller;
use Think\Controller;
class PostController extends Controller{

    public function index(){
        $post = D('post'); // 实例化User对象
        $count      = $post->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(5)
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $post->order('time')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $top=D('Post')->getTop();
        $this->assign('top',$top);
        $links=getLinks();
        $this->assign('links',$links);
        //var_dump($show);
        //$post=D('post');
        //$data=$post->select();
        //$this->assign('data',$data);
        $this->display();
    }

    public function view(){
        $id=I('id');
        $post = M('post')->find($id);
        $top=D('Post')->getTop();
         $links=getLinks();
    $this->assign('links',$links);
        $this->assign('post', $post);
        $this->assign('top',$top);
        $this->display();
    }
}
