<?php 
namespace Admin\Controller;
use Think\Controller;
class NoteController extends BaseController{
    /**
     * 游记列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('NoteView');
        }else{
            $where['note.title'] = array('like',"%$key%");
            $where['user.username'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('NoteView')->where($where);
        }
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $note = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('note.id DESC')->select();
        $test=D('note');
        $this->assign('model', $note);
        $this->assign('page',$show);
        $this->display();
    }
    /**
    *是否设置为hot
    */
    public function ishot($id){
        $id=intval($id);
        if(IS_GET){
            $ishot=M('note')->where("id= %d",$id)->getField('ishot');
            if($ishot==='0'){
                $data['ishot']=1;
            }elseif($ishot==='1'){
                $data['ishot']=0;
            }
            $result=M('note')->where("id= %d",$id)->save($data);
            if($result&&$data['ishot']===1){
                $this->success("设为热门成功",U('Note/index'));
            }elseif($result&&$data['ishot']===0){
                $this->success("撤销成功",U('Note/index'));
            }else{
                $this->error('操作失败');
            }
        }else{
            $this->error('提交错误');
        }
    }
    /**
    *是否审核
    */
    public function status($id){
        $id=intval($id);
        if(IS_GET){
            $status=M('note')->where("id= %d",$id)->getField('status');
            if($status==='0'){
                $data['status']=1;
            }elseif($status==='1'){
                $data['status']=0;
            }
            $result=M('note')->where("id= %d",$id)->save($data);
            if($result&&$data['status']===1){
                $this->success("审核成功",U('Note/index'));
            }elseif($result&&$data['status']===0){
                $this->success("禁用成功",U('Note/index'));
            }else{
                $this->error('操作失败');
            }
        }else{
            $this->error('提交错误');
        }
    }
    /**
    *查看操作
    */
    public function view($id){
        $id=intval($id);
        $data=M('note')->where("id=%d",$id)->find();
        $this->assign('data',$data);
        $this->display();
    }
}
?>