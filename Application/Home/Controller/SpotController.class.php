<?php
namespace Home\Controller;
use Think\Controller;
class SpotController extends Controller{
  /**
   * 控制首页
   * @return [type] [description]
   */
  public function index(){
    $spot=D('Spot');
    $data=$spot->getIndexSpot();
    $top=$spot->getSpot(3);
    //var_dump($data);
    $total=count($data);//获取数据总数
    //var_dump($total);
    $links=getLinks();
    $this->assign('links',$links);
    $this->assign(array(
      'data'=>$data,
      'total'=>$total,
      'top'=>$top,
    ));
    $this->display();
  }
  /**
   * 获取地区景点信息
   * @return [type] [description]
   */
  public function areaview(){
    $areaid=I('areaid');
    $area=getData('area');
    //var_dump($areaid);
    $spot=D('Spot');
    $data=$spot->getSpotByArea($areaid);
    $top=$spot->getSpot(3);
    //var_dump($data);
    $links=getLinks();
    $this->assign('links',$links);
    $this->assign(array(
      'data'=>$data,
      'area'=>$area[$areaid],
      'top'=>$top,
    ));
    $this->display();
  }
  /**
   * 控制详情页
   * @return [type] [description]
   */
  public function view(){
    $id=I('id');
    $spot=M('spot');
    $hot=D('Spot');
    $viewdata=$spot->find($id);
    $fjsdata=$hot->getView($viewdata['area']);
    $fjdata=array();
    /*
      获取附近的景点
     */
    foreach ($fjsdata as $v) {
      if($v['id']!=$viewdata['id']){
        $fjdata[]=$v;
      }
      continue;
    }
      /*获取收藏信息*/
        $where['collection_id']=$id;
        $where['user_id']=intval(session('userinfo.id'));
        $where['cate_id']=$spot->where('id=%d',$id)->getField('cate_id');
        $result=M('collection')->where($where)->find();
        if($result){
            $ifcollection=1;
        }else{
            $ifcollection=0;
        }
        /*获取收藏数量*/
        $collectionwhere['collection_id']=$id;
        $collectionwhere['cate_id']=$spot->where('id=%d',$id)->getField('cate_id');
        $collection_number=M('collection')->where($collectionwhere)->count();
        /*获取附近酒店*/
        $hotelwhere['area']=$viewdata['area'];
        $hotel=M('hotels')->where($hotelwhere)->limit(4)->select();
        $links=getLinks();
        $this->assign('links',$links);
        $this->assign(array(
          'viewdata'=>$viewdata,
          'fjdata'=>$fjdata,
          'ifcollection'=>$ifcollection,
          'collection_number'=>$collection_number,
          'hotel'=>$hotel,
       ));
    $this->display();
  }
  /**
    *攻略点赞
    */
    public function spot_praise($id){
        $where['id']=intval($id);
        if(cookie('visitinfo')!=$id){
            //$data['praise']+=1;
            $result=M('spot')->where($where)->setInc('praise');
            if($result){
                $praise=M('spot')->where($where)->getField('praise');
                cookie('visitinfo',$id,3600);
                $data['praise']=$praise;
                $data['key']=1;
                $this->ajaxReturn($data);
            }else{
                $praise=M('spot')->where($where)->getField('praise');
                $data['praise']=$praise;
                $data['key']=0;
                $this->ajaxReturn($data);
            }
        }else{
            $praise=M('spot')->where($where)->getField('praise');
            $data['praise']=$praise;
            $data['key']=0;
            $this->ajaxReturn($data);
        }
    }
}
?>
