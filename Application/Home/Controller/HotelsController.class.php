<?php
namespace Home\Controller;
use Think\Controller;
class HotelsController extends Controller{
    /*
    *首页控制
    */
    public function index(){
        $area=getData('area');
        $getarea=I('get.area');
        $data=D('Hotels')->getList($getarea);
        //获取热门线路
        $hotroute=D('route')->getHot();
        $links=getLinks();
        //var_dump($where);
        $this->assign(array(
            'area'=>$area,
            'data'=>$data,
            'hotroute'=>$hotroute,
            'links'=>$links,
        ));
        $this->display();
    }
    /*
    *详情页
    */
    public function view($id){
        $id=intval($id);
        $hotelview=M('hotels')->where('id=%d',$id)->find();
        $spotwhere['area']=$hotelview['area'];
        $spots=M('spot')->where($spotwhere)->limit(4)->select();
        $links=getLinks();
        $this->assign(array(
            'hotelview'=>$hotelview,
            'spots'=>$spots,
            'links'=>$links,
        ));
        $this->display();
    }
}
?>