<?php
namespace Home\Model;
use Think\Model;
class HotelsModel extends Model{
   /**
   *根据条件获取酒店数据
   **/ 
    public function getList($area=''){
        $hotels=M('hotels');
        if($area!=''){
            $where['area']=$area;
        }
        $data=$hotels->where($where)->select();
        return $data;
    }
}
?>