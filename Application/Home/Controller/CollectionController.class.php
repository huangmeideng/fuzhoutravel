<?php
namespace Home\Controller;
use Think\Controller;
class CollectionController extends BaseController{
    public function _initialize() {
		if(session('userinfo')==NULL){
			$this->error('请先登录。',U('User/login'));
		}
	}
    /**
    *添加收藏
    */
    public function add($id,$cate_id){
        $data['collection_id']=intval($id);
        $data['user_id']=intval(session('userinfo.id'));
        $data['cate_id']=intval($cate_id);
        //var_dump($data['$collection_id']);
        if(IS_GET){
            $collection=M('collection');
            $result=$collection->add($data);
            if($result){
                $collection_number=$collection->where('collection_id=%d',$data['collection_id'])->count();
                $key=1;
                $data['collection_number']=$collection_number;
                $data['key']=1;
                $this->ajaxReturn($data);
            }else{
                $collection_number=$collection->where('collection_id=%d',$data['collection_id'])->count();
                $data['collection_number']=$collection_number;
                $data['key']=0;
                $this->ajaxReturn($data);
            }
        }else{
            $this->error('参数错误');
        }
    }
    /**
    *删除收藏
    */
    public function reduce($id,$cate_id){
        $where['collection_id']=intval($id);
        $where['user_id']=intval(session('userinfo.id'));
        $where['cate_id']=intval($cate_id);
        $collection=M('collection');
        $result=$collection->where($where)->delete();
        if($result){
            $collection_number=$collection->where('collection_id=%d',$where['collection_id'])->count();
            $data['collection_number']=$collection_number;
            $data['key']=1;
            $this->ajaxReturn($data);
        }else{
            $collection_number=$collection->where('collection_id=%d',$where['collection_id'])->count();
            $data['collection_number']=$collection_number;
            $data['key']=0;
            $this->ajaxReturn($data);
        }
    }
} 
?>