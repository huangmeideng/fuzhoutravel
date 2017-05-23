<?php
namespace Home\Model;
use Think\Model;
class PostModel extends Model{
  //获取指定条数与条件的资讯
  public function getPost($limit,$type){
    $post=D('post');
    $where['type']=$type;
    $datas=$post->where($where)->limit($limit)->order('time desc')->select();
    return $datas;
  }
  //获取推荐资讯
  public function getTop(){
    $where['type']=4;
    $post=D('post');
    $data=$post->where($where)->order('time desc')->select();
    return $data;
  }
}
 ?>
