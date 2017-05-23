<?php
namespace Home\Model;
use Think\Model;
class PlayModel extends Model{
  //获取活动
  public function getPlay(){
    $play=D('play');
    $where['cate_id']=57;
    //根据当前季节选择出相应的活动
    switch(date('m')){
      case '03':
      case '04':
      case '05':
        $where['type']=1;
        break;
      case '06':
      case '07':
      case '08':
        $where['type']=2;
        break;
      case '09':
      case '10':
      case '11':
        $where['type']=3;
        break;
      case '12':
      case '01':
      case '02':
        $where['type']=4;
        break;
    }
    $data=$play->where($where)->limit(4)->select();
    return $data;
  }
  //通过季节获取活动
  public function getPlayByType($type,$limit){
    $play=D('play');
    $where['type']=$type;
    $data=$play->where($where)->limit($limit)->select();
    return $data;
  }
  public function getPlayByType1($type){
    $play=D('play');
    $where['type']=$type;
    $data=$play->where($where)->select();
    return $data;
  }
  //获取热门活动
  public function getHotPlay(){
    $play=D('play');
    $where['ishot']=1;
    $data=$play->where($where)->limit(6)->select();
    return $data;
  }
}
?>
