<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 留言管理
 */
class ComplainController extends BaseController
{
    /**
     * 留言列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('ComplainView');
        }else{
            $where['complain.name'] = array('like',"%$key%");
            $where['user.username'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('ComplainView')->where($where);
        }

        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $show = $Page->show();// 分页显示输出
        $Play = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('complain.id DESC')->select();
        $this->assign('model', $Play);
        $this->assign('page',$show);
        $this->display();
    }
    /**
     * 回复留言
     * @param  [type] $id [玩转福州ID]
     * @return [type]     [description]
     */
    public function update($id)
    {
    		$id = intval($id);
        //默认显示添加表单
        if (!IS_POST) {
            $model = M('complain')->where("id= %d",$id)->find();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('complain',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("complain");
            $data=$model->create();
            if (!$data) {
                $this->error($model->getError());
            }else{
                if ($model->save($data)) {
                    $this->success("回复成功", U('Complain/index'));
                } else {
                    $this->error("回复失败");
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
        $model = M('complain');
        $result = $model->where("id= %d",$id)->delete();
        if($result){
            $this->success("删除成功", U('Complain/index'));
        }else{
            $this->error("删除失败");
        }
    }
}
