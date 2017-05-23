<?php
namespace Home\Controller;
use Think\Controller;
class ComplainController extends Controller{
    /**
    *处理留言
    */
    public function complain(){
         $data=$this->iflogin();
       if($data['key']==2){
           $this->ajaxReturn($data);
       }elseif($data['key']==3){
            $commentdata=I('getdata');
            $commentdata['user_id']=session('userinfo.id');
            $commentdata['cate_id']=72;
            $result=M('complain')->add($commentdata);
        if($result){
            $data['key']=1;
            //$data['content']=htmlspecialchars_decode($commentdata['content']);
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