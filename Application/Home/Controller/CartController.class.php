<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller{
    /**
    *购买操作
    */
    public function buy(){
        $data=$this->iflogin();
        if($data['key']==2){
            $this->ajaxReturn($data);
        }elseif($data['key']==3){
            $cartdata=I('getdata');
            $cartdata['user_id']=session('userinfo.id');
            $cartdata['time']=date("Y-m-d H:i:s",time());
            $cartdata['code']=orderCode('route');
            $result=M('cart')->add($cartdata);
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
*判断登录
*/
function iflogin(){
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