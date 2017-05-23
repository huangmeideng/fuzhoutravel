<?php
namespace Admin\Controller;
use Think\Controller;
class HotelorderController extends BaseController{
    /**
     * 订单列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('HotelorderView');
        }else{
            $where['user.username'] = array('like',"%$key%");
            $where['hotels.name'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('HotelorderView')->where($where);
        }
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        $show = $Page->show();// 分页显示输出
        $post = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('hotelorder.id DESC')->select();
        $this->assign('model', $post);
        $this->assign('page',$show);
        $this->display();
    }
    /**
    *确认订单
    */
    public function change($id){
        $this->success('由于无法获取酒店的api，该功能暂时无法实现，请谅解！');
    }
}
?>