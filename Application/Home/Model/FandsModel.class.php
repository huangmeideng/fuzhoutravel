<?php
namespace Home\Model;
use Think\Model;
class FandsModel extends Model{
  //获取特定美食与特产
  public function getFood($condition,$cate_id=0){
    $food=D('fands');
    //$where['cate_id']=65;
    //按条件获取不同类型的数据
    //$condition:1=>普通，2=>获取置顶，3=>获取推荐
    //$cate_id:65美食，66特产，0不限
    if($condition==1){
        $where['type']=1;
        $limit=4;
      if($cate_id==65){
        $where['cate_id']=65;
      }else{
        $where['cate_id']=66;
      }
      $data=$food->where($where)->limit($limit)->select();
    }elseif ($condition==2) {
      $where['type']=2;
      $limit=6;
      $data=$food->where($where)->limit($limit)->select();
    }elseif ($condition==3) {
      $where['type']=3;
      $limit=1;
      if($cate_id==65){
        $where['cate_id']=65;
      }else{
        $where['cate_id']=66;
      }
      $data=$food->where($where)->limit($limit)->find();
    }
    return $data;
  }
  /**
   * 首页数据
   * @param  [type] $cate_id [description]
   * @return [type]          [description]
   */
  public function getIndexData($cate_id,$right=0){
    $food=D('fands');
    if($right==1){
      if($cate_id==65){
        $where['cate_id']=65;
        $where['type']=2;
      }elseif ($cate_id==66) {
        $where['cate_id']=66;
        $where['type']=2;
      }
    }else{
      if($cate_id==65){
          $where['cate_id']=65;
      }elseif ($cate_id==66) {
          $where['cate_id']=66;
      }
    }
    $data=$food->where($where)->limit(4)->select();
    return $data;
  }
  /**
   * 获取首页置顶数据
   * @param  [type] $cate_id [description]
   * @return [type]          [description]
   */
  public function getIndexPost($cate_id){
    $food=D('fands');
    if($cate_id==65){
      $where['cate_id']=65;
      $where['type']=2;
    }elseif ($cate_id==66) {
      $where['cate_id']=66;
      $where['type']=2;
    }
    $data=$food->where($where)->limit(4)->select();
    return $data;
  }
}
?>
