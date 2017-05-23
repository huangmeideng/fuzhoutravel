<?php
namespace Home\Controller;
use Think\Controller;
class NoteController extends BaseController{
    public function _initialize() {
		if(session('userinfo')==NULL){
			$this->error('请先登录。',U('User/login'));
		}
	}
    /**
    *默认页面
    */
    public function index(){
        $this->display();
    }
    /**
    *添加游记
    */
    public function add(){
        if(!IS_POST){
            $id=session('userinfo.id');
            $where['user_id']=$id;
            $note=M('note')->where($where)->select();
            //var_dump($note);
            $spots=M('spot')->select();
            $areas=getData('area');
            $this->assign('note',$note);
            $this->assign('areas',$areas);
            $this->assign('spots',$spots);
            $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $model = D("note");
            $data=$model->create();
            $spots=I('post.spots');
            $spots=implode(',',$spots);/*获取途经景点数据*/
            $data['spots']=$spots;
            $areas=I('post.areas');
            $areas=implode(',',$areas);/*获取地区数据*/
            $data['areas']=$areas;
            $data['time']=date('Y-m-d');
            $data['user_id']=session('userinfo.id');
            $data['cate_id']=70;
            if (!$data) {
                // 如果创建失败 表示验证没有通过 输出错误提示信息
                $this->error($model->getError());
                exit();
            } else {
                 if ($_FILES['pic']['tmp_name'] != '') {
                    $upload = new \Think\Upload();
                    $upload->maxSize = 3145728;
                    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                    $upload->rootPath = './';
                    $upload->savePath = './Public/Uploads/';
                    $info = $upload->uploadOne($_FILES['pic']);
                        if (!$info) {
                            $this->error($upload->getError());
                } else {
                        $data['pic'] = $info['savepath'].$info['savename'];
                  }
                 }
                if ($model->add($data)) {
                    $this->success("添加成功", U('Note/add'));
                    // var_dump($data);
                } else {
                    $this->error("添加失败");
                }
            }
        }
    }
    /**
    *编辑操作
    */
    public function update($id){
        $id=intval($id);
        if(!IS_POST){
            $where['user_id']=session('userinfo.id');
            $mynote=M('note')->find($id);
            $note=M('note')->where($where)->select();
            $spots=M('spot')->select();
            $spotsids=M('note')->where("id=$id")->field('spots')->find();
            $areaids=M('note')->where("id=$id")->field('areas')->find();
            $areaids=explode(',',$areaids['areas']);
            $spotsids=explode(',',$spotsids['spots']);
            $areas=getData('area');
            $this->assign('areaids',$areaids);
            $this->assign('spotsids',$spotsids);
            $this->assign('mynote',$mynote);
            $this->assign('note',$note);
            $this->assign('areas',$areas);
            $this->assign('spots',$spots);
            $this->display();
        }
        if(IS_POST){
            $data['cate_id']=70;
            $data['time']=date('Y-m-d');
            $data['user_id']=session('userinfo.id');
            $model = D("note");
            $data=$model->create();
            if (!$data) {
                $this->error($model->getError());
            }else{
                 $spots=I('post.spots');
                 $spots=implode(',',$spots);
                 $data['spots']=$spots;
                 $areas=I('post.areas');
                 $areas=implode(',',$areas);
                 $data['areas']=$areas;
                if ($_FILES['pic']['tmp_name'] != '') {
                    $upload = new \Think\Upload();
                    $upload->maxSize = 3145728;
                    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                    $upload->rootPath = './';
                    $upload->savePath = './Public/Uploads/';
                    $info = $upload->uploadOne($_FILES['pic']);
                        if (!$info) {
                            $this->error($upload->getError());
                } else {
                        $data['pic'] = $info['savepath'].$info['savename'];
                  }
                 }
                if ($model->save($data)) {
                    $this->success("更新成功", U('note/add'));
                } else {
                    $this->error("更新失败");
                }
            }
        }
    }
    /**
    *删除操作
    */
    public function delete(){
        // $id = intval($id);
        // $model = M('note');
        // $result = $model->where("id= %d",$id)->delete();
        // if($result){
        //     $this->success("删除成功", U('note/add'));
        // }else{
        //     $this->error("删除失败");
        // }
        $id=I('get.id');
        $model=M('note');
        $result=$model->where('id= %d',$id)->delete();
        if($result){
            $data=1;
            $this->ajaxReturn($data);
        }else{
            $data=0;
            $this->ajaxReturn($data);
        }
    }
}
?>