<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 线路管理
 */
class RouteController extends BaseController
{
    /**
     * 线路列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('RouteView');
        }else{
            $where['route.name'] = array('like',"%$key%");
            // $where['member.username'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('RouteView')->where($where);
        }

        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $route = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('route.id DESC')->select();
        $this->assign('model', $route);
        $this->assign('page',$show);
        $this->display();
    }
    /**
     * 添加线路
     */
    public function add()
    {
        //默认显示添加表单

        if (!IS_POST) {
          $type=getData('type');
          $this->assign('type',$type);
          $days=getData('days');
          $this->assign('days',$days);
          $spots=M('spot')->select();
          // print_r($area);
          $this->assign('spots',$spots);
          $this->assign("category",getSortedCategory(M('category')->select()));
          $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $model = D("route");
            $data=$model->create();
            if (!$data) {
                // 如果创建失败 表示验证没有通过 输出错误提示信息
                $this->error($model->getError());
                exit();
            } else {
                $spots=I('post.spots');
                //var_dump($spots);
                $spots=implode(',',$spots);/*获取途经景点数据*/
                $data['spots']=$spots;
                $data['code']=getCode();
                //var_dump($data['spots']);
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
                    $this->success("添加成功", U('route/index'));
                    // var_dump($data);
                } else {
                    $this->error("添加失败");
                }
            }
        }

    }
    /**
     * 更新线路信息
     * @param  [type] $id [线路ID]
     * @return [type]     [description]
     */
    public function update($id)
    {
    		$id = intval($id);
        //默认显示添加表单
        if (!IS_POST) {
            $type=getData('type');
            $this->assign('type',$type);
            $days=getData('days');
            //获取线路途经景点的id数组
            $spots=M('spot')->select();
            $spotsids=M('route')->where("id=$id")->field('spots')->find();
            $spotsids=explode(',',$spotsids['spots']);
            //var_dump($spotsids);
            $this->assign('spotsids',$spotsids);
            $this->assign('days',$days);
            $model = M('route')->where("id= %d",$id)->find();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('route',$model);
            $this->assign('spots',$spots);
            $this->display();
        }
        if (IS_POST) {
            $model = D("Route");
            $data=$model->create();
            if (!$data) {
                $this->error($model->getError());
            }else{
                $spots=I('post.spots');
                $spots=implode(',',$spots);
                $data['spots']=$spots;
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
                    $this->success("更新成功", U('route/index'));
                } else {
                    $this->error("更新失败");
                }
            }
        }
    }
    /**
     * 删除线路
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    		$id = intval($id);
        $model = M('route');
        $result = $model->where("id= %d",$id)->delete();
        if($result){
            $this->success("删除成功", U('route/index'));
        }else{
            $this->error("删除失败");
        }
    }
}
