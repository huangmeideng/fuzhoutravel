<?php
namespace Home\Model;
use Think\Model;
class RouteModel extends Model{
   /**
   *根据条件获取线路数据
   **/ 
    public function getList($type='',$days=''){
        $route=M('route');
        if($type!=''){
            $where['type']=$type;
        }
        if($days!=''){
            $where['days']=$days;
        }
        $data=$route->where($where)->select();
        return $data;
    }
    /**
    *获取热门线路
    **/
    public function getHot(){
        $route=M('route');
        $where['ishot']=1;
        $data=$route->where($where)->select();
        return $data;
    }
    /**
    *获取相关线路
    **/
    public function getRecommend($type='',$days=''){
        $route=M('route');
        if($type!=''){
            $where['type']=$type;
        }
        if($days!=''){
            $where['days']=$days;
        }
        $where['_logic']='or';
        //$where['_complex']=$where;
        $data=$route->where($where)->select();
        return $data;
    }
    /**
    *获取首页数据
    **/
    public function getIndexRoute(){
        $route=M('route');
        $where['ishot']=1;
        $data=$route->where($where)->limit(5)->select();
        return $data;
    }
}
?>