<?php
namespace Home\Controller;
use Think\Controller;
class CommentController extends Controller{
    /**
    *添加评论
    */
    public function addComment(){
        $data=$this->iflogin();
       if($data['key']==2){
           $this->ajaxReturn($data);
       }elseif($data['key']==3){
            $commentdata=I('getdata');
            $commentdata['user_id']=session('userinfo.id');
            $commentdata['time']=date("Y-m-d H:i:s",time());
            $result=M('comment')->add($commentdata);
        if($result){
            $data['key']=1;
            $data['content']=htmlspecialchars_decode($commentdata['content']);
            $data['time']=$commentdata['time'];
            $data['username']=M('user')->where('id=%d',$commentdata['user_id'])->getField('username');
            $data['avatar']=M('user')->where('id=%d',$commentdata['user_id'])->getField('avatar');
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