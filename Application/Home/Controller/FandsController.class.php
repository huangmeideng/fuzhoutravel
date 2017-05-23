<?php
namespace Home\Controller;
use Think\Controller;
class FandsController extends Controller{
  /**
   * 显示首页
   * @return [type] [description]
   */
  public function index(){
    $data=D('Fands');
    $food=$data->getIndexData(65);
    $techang=$data->getIndexData(66);
    $foodright=$data->getIndexData(65,1);
    $techangright=$data->getIndexData(66,1);
    $links=getLinks();
    $this->assign(array(
      'food'=>$food,
      'techang'=>$techang,
      'foodright'=>$foodright,
      'techangright'=>$techangright,
      'links'=>$links,
    ));
    $this->display();
  }
  /**
   * 显示美食页
   * @return [type] [description]
   */
  public function food(){
     $food = M('fands');
     $where['cate_id']=65;
     $count      = $food->where($where)->count();// 查询满足要求的总记录数
     $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(5)
     $Page->setConfig('prev','上一页');
     $Page->setConfig('next','下一页');
     $show       = $Page->show();// 分页显示输出
     //进行分页数据查询 注意limit方法的参数要使用Page类的属性
     $list = $food->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
     $links=getLinks();
     $this->assign('list',$list);// 赋值数据集
     $this->assign('page',$show);// 赋值分页输出
     $this->assign('links',$links);
     $this->display();
  }
  /**
   * 显示特产页
   * @return [type] [description]
   */
  public function techang(){
    $techang = M('fands');
    $where['cate_id']=66;
    $count      = $techang->where($where)->count();// 查询满足要求的总记录数
    $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(5)
    $Page->setConfig('prev','上一页');
    $Page->setConfig('next','下一页');
    $show       = $Page->show();// 分页显示输出
    // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $list = $techang->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
    $links=getLinks();
    $this->assign('list',$list);// 赋值数据集
    $this->assign('page',$show);// 赋值分页输出
    $this->assign('links',$links);
    $this->display();
  }
  /**
   * 显示详情页
   * @return [type] [description]
   */
  public function view(){
    $id=I('id');
    $fands=D('fands');
    $data=$fands->find($id);
    $right=D('Fands')->getFood(2);
    /*获取收藏信息*/
        $where['collection_id']=$id;
        $where['user_id']=intval(session('userinfo.id'));
        $where['cate_id']=M('fands')->where('id=%d',$id)->getField('cate_id');
        $result=M('collection')->where($where)->find();
        if($result){
            $ifcollection=1;
        }else{
            $ifcollection=0;
        }
        /*获取收藏数量*/
    $collectionwhere['collection_id']=$id;
    $collectionwhere['cate_id']=M('fands')->where('id=%d',$id)->getField('cate_id');
    $collection_number=M('collection')->where($collectionwhere)->count();
    $links=getLinks();
    $this->assign('ifcollection',$ifcollection);
    $this->assign('collection_number',$collection_number);
    $this->assign('data',$data);
    $this->assign('right',$right);
    $this->assign('links',$links);
    $this->display();
  }
  /**
    *点赞
    */
    public function fands_praise($id){
        $where['id']=intval($id);
        if(cookie('visitinfo')!=$id){
            //$data['praise']+=1;
            $result=M('fands')->where($where)->setInc('praise');
            if($result){
                $praise=M('fands')->where($where)->getField('praise');
                cookie('visitinfo',$id,3600);
                $data['praise']=$praise;
                $data['key']=1;
                $this->ajaxReturn($data);
            }else{
                $praise=M('fands')->where($where)->getField('praise');
                $data['praise']=$praise;
                $data['key']=0;
                $this->ajaxReturn($data);
            }
        }else{
            $praise=M('fands')->where($where)->getField('praise');
            $data['praise']=$praise;
            $data['key']=0;
            $this->ajaxReturn($data);
        }
    }
}
?>
