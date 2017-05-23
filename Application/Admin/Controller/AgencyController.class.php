<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 旅行社管理
 */
class AgencyController extends BaseController
{
    /**
     * 旅行社列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('AgencyView');
        }else{
            $where['agency.name'] = array('like',"%$key%");
            // $where['member.username'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('AgencyView')->where($where);
        }

        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $show = $Page->show();// 分页显示输出
        $Play = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('agency.id DESC')->select();
        $this->assign('model', $Play);
        $this->assign('page',$show);
        $this->display();
    }
    /**
     * 添加旅行社
     */
    public function add()
    {
        //默认显示添加表单

        if (!IS_POST) {
          // print_r($area);
          $this->assign("category",getSortedCategory(M('category')->select()));
          $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $model = D("agency");
            $data=$model->create();
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
                    $this->success("添加成功", U('Agency/index'));
                    // var_dump($data);
                } else {
                    $this->error("添加失败");
                }
            }
        }

    }
    /**
     * 更新旅行社信息
     * @param  [type] $id [玩转福州ID]
     * @return [type]     [description]
     */
    public function update($id)
    {
    		$id = intval($id);
        //默认显示添加表单
        if (!IS_POST) {
            $model = M('agency')->where("id= %d",$id)->find();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('agency',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("agency");
            $data=$model->create();
            if (!$data) {
                $this->error($model->getError());
            }else{
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
                    $this->success("更新成功", U('Agency/index'));
                } else {
                    $this->error("更新失败");
                }
            }
        }
    }
    /**
     * 删除玩转福州
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    		$id = intval($id);
        $model = M('agency');
        $result = $model->where("id= %d",$id)->delete();
        if($result){
            $this->success("删除成功", U('Agency/index'));
        }else{
            $this->error("删除失败");
        }
    }
}
