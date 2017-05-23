<?php
namespace Home\Controller;
use Think\Controller;
class RouteController extends Controller{
    /**
    *控制首页方法
    **/
    public function index(){
        $type=getData('type');
        $days=getData('days');
        $gettype=I('get.type');
        $getdays=I('get.days');
        $route=D('Route');
        $data=$route->getList($gettype,$getdays);
        $hot=$route->getHot();
        $links=getLinks();
        $this->assign('links',$links);
        $this->assign(array(
            'type'=>$type,
            'days'=>$days,
            'data'=>$data,
            'hot'=>$hot,
        ));
        $this->display();
    }
    /**
    *控制具体页面方法
    **/
    public function view(){
        $id=I('get.id');
        $route=M('route')->find($id);
         /*获取相关景点*/
        $spots=explode(',',$route['spots']);
        $count=count($spots);
        $spot=M('spot');
        $spotsname=array();
        //$spotsaddress=array();
        for($i=0;$i<$count;$i++){
            $id=intval($spots[$i]);
            $spotsname[]=$spot->where('id=%d',$id)->getField('name');
           // $spotsaddress[]=$spot->where('id=%d',$id)->getField('address');
        }
        //var_dump($route);
        $recommend=D('Route')->getRecommend($route['type'],$route['days']);
        //$code=D('Route')->getCode($id);
        $links=getLinks();
        $this->assign('links',$links);
        $this->assign('route',$route);
        $this->assign('recommend',$recommend);
        $this->assign('spotsname',$spotsname);
        //$this->assign('code',$code);
        $this->display();
    }
}
?>