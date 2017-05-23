<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller{

    public function index(){
        //显示旅游资讯
        $post=D('Post');
        $play=D('Play');
        $data=$post->getPost(10,2);
        $data1=$post->getPost(3,3);
        $data2=$play->getPlay();
        //获取美食
        $fands=D('Fands');
        $food1=$fands->getFood(1,65);//普通
        $food2=$fands->getFood(2);//置顶
        $food3=$fands->getFood(3,65);//推荐
        //获取特产
        $techang1=$fands->getFood(1,66);
        $techang3=$fands->getFood(3,66);
        //获取景点信息
        $spot=D('Spot');
        $leftspot=$spot->getSpot(2);
        $hotspot=$spot->getSpot(4);
        $rightspot=$spot->getSpot(3);
        //获取游记与攻略
        $note=D('Note')->getNote();
        $strategy=D('Strategy')->getStrategy();
        //获取旅游线路
        $type=getData('type');
        $route=D('Route')->getIndexRoute();
        //获取links
        $links=getLinks();
        //var_dump($route);
        $this->assign(array(
          'data'=>$data,
          'data1'=>$data1,
          'data2'=>$data2,
          'food1'=>$food1,
          'food2'=>$food2,
          'food3'=>$food3,
          'techang1'=>$techang1,
          'techang3'=>$techang3,
          'leftspot'=>$leftspot,
          'hotspot'=>$hotspot,
          'rightspot'=>$rightspot,
          'note'=>$note,
          'strategy'=>$strategy,
          'type'=>$type,
          'route'=>$route,
          'links'=>$links,
        ));
        //$this->assign('data1',$data1);
        $this->display();
    }
    // public function mail(){
    //   $mail=sendMail('18362985537@163.com','test','test');
    //   var_dump($mail);
    // }
}
