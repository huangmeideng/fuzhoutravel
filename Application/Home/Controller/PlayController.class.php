<?php
namespace Home\Controller;
use Think\Controller;
class PlayController extends Controller{
  public function index(){
    $play=D('Play');
    $top=$play->getPlay();
    $hot=$play->getHotPlay();
    $spring=$play->getPlayByType(1,4);
    $summer=$play->getPlayByType(2,4);
    $autumn=$play->getPlayByType(3,4);
    $winter=$play->getPlayByType(4,4);
    $links=getLinks();
    $this->assign(array(
      'spring'=>$spring,
      'summer'=>$summer,
      'autumn'=>$autumn,
      'winter'=>$winter,
      'top'=>$top,
      'hot'=>$hot,
      'links'=>$links,
    ));
    $this->display();
  }
  //活动详情
  public function view(){
    $id=I('id');
    $play=M('play')->find($id);
    $hot=D('Play')->getHotPlay();
    $top=D('Play')->getPlay();
    $links=getLinks();
    $this->assign(array(
      'play'=>$play,
      'hot'=>$hot,
      'top'=>$top,
      'links'=>$links,
    ));
    $this->display();
  }
  //热门活动
  public function hot(){
    $play = D('play'); // 实例化User对象
    $count      = $play->count();// 查询满足要求的总记录数
    $Page       = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(5)
    $show       = $Page->show();// 分页显示输出
    // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $where['ishot']=1;
    $list = $play->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
    $this->assign('list',$list);// 赋值数据集
    $this->assign('page',$show);// 赋值分页输出
    $links=getLinks();
    //$hot=D('Play')->getHotPlay();
    $top=D('Play')->getPlay();
    $this->assign('top',$top);
    $this->assign('links',$links);
    $this->display();
  }
  //春季活动
  public function spring(){
    $p=D('Play');
    $spring=$p->getPlayByType1(1);
    //$hot=$p->getHotPlay();
    $top=$p->getPlay();
    $links=getLinks();
    $this->assign('links',$links);
    $this->assign('spring',$spring);
    //$this->assign('hot',$hot);
    $this->assign('top',$top);
    $this->display();
  }

  //夏季活动
  public function summer(){
    $p=D('Play');
    $summer=$p->getPlayByType1(2);
    //$hot=$p->getHotPlay();
    $top=$p->getPlay();
     $links=getLinks();
    $this->assign('links',$links);
    $this->assign('summer',$summer);
    //$this->assign('hot',$hot);
    $this->assign('top',$top);
    $this->display();
  }

  //秋季活动
  public function autumn(){
    $p=D('Play');
    $autumn=$p->getPlayByType1(3);
    //$hot=$p->getHotPlay();
    $top=$p->getPlay();
     $links=getLinks();
    $this->assign('links',$links);
    $this->assign('autumn',$autumn);
    //$this->assign('hot',$hot);
    $this->assign('top',$top);
    $this->display();
  }

  //冬季季活动
  public function winter(){
    $p=D('Play');
    $winter=$p->getPlayByType1(4);
    //$hot=$p->getHotPlay();
    $top=$p->getPlay();
     $links=getLinks();
    $this->assign('links',$links);
    $this->assign('winter',$winter);
    //$this->assign('hot',$hot);
    $this->assign('top',$top);
    $this->display();
  }
}
?>
