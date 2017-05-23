<?php
namespace Home\Controller;
use Think\Controller;
class HotelorderController extends Controller{
    /**
    *添加酒店订单
    **/
    public function add(){
        $data=$this->iflogin();
        if($data['key']==2){
            $this->ajaxReturn($data);
        }else{
            $hotelorderdata=I('getdata');
            $hotelorderdata['user_id']=session('userinfo.id');
            $hotelorderdata['code']=orderCode('hotel');
            $result=M('hotelorder')->add($hotelorderdata);
            if($result){
                $data['key']=1;
                $this->ajaxReturn($data);
            }else{
                $data['key']=0;
                $this->ajaxReturn($data);
            }
        }
    }
    /**
    *判断是否登录
    */
    public function iflogin(){
        if(session('userinfo')==NULL){
			// $this->error('请先登录。',U('User/login'));
            $data['key']=2;
			return $data;
		}else{
            $data['key']=3;
			return $data;
        }
    }
}
?>