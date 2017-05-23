<?php
namespace Admin\Controller;
use Think\Controller;
class CartController extends BaseController{
    /**
     * 订单列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('CartView');
        }else{
            $where['user.username'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('PostView')->where($where);
        }
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        $show = $Page->show();// 分页显示输出
        $post = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('cart.id DESC')->select();
        $this->assign('model', $post);
        $this->assign('page',$show);
        $this->display();
    }
    /**
    *确认订单
    */
    public function change($id){
        $id=intval($id);
        if(IS_GET){
            $status=M('cart')->where('id=%d',$id)->getField('status');
        if($status==0){
            $data['status']=1;
        }else{
            $data['status']=0;
        }
        $result=M('cart')->where('id=%d',$id)->save($data);
        if($result&&$data['status']==1){
            $this->success('确认订单成功',U('Cart/index'));
        }elseif($result&&$data['status']==0){
            $this->success('取消订单成功',U('Cart/index'));
        }else{
            $this->error('操作失败',U('Cart/index'));
        }
        }else{
            $this->error('参数错误',U('Cart/index'));
        }
    }
}
?>