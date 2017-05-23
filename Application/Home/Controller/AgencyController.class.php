<?php
namespace Home\Controller;
use Think\Controller;
class AgencyController extends Controller{
    /*
    *首页控制
    */
    public function index(){
        $agency = M('agency'); // 实例化User对象
        $count      = $agency->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $agency->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        //获取右侧热门景点
        $links=getLinks();
        $hotspot=M('spot')->where('type=3')->limit(4)->select();
        $this->assign('hotspot',$hotspot);
        $this->assign('links',$links);
        $this->display();
    }
    /*
    *详情控制
    */
    public function view($id){
        $id=intval($id);
        $agency=M('agency')->find($id);
        $hotspot=M('spot')->where('type=3')->limit(4)->select();
        $links=getLinks();
        $this->assign(array(
            'agency'=>$agency,
            'hotspot'=>$hotspot,
            'links'=>$links,
        ));
        $this->display();
    }
}
?>