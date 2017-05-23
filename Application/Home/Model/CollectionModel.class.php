<?php 
namespace Home\Model;
use Think\Model;
class CollectionModel extends Model{
    /**
    *依据不同条件寻找收藏
    */
    public function getCollection($userid,$cateid){
        $where['user_id']=$userid;
        $where['cate_id']=$cateid;
        $collection=M('collection');
        $data=$collection->where($where)->select();
        return $data;
    }
}
?>