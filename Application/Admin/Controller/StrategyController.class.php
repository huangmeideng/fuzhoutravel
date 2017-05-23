<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 攻略管理
 */
class StrategyController extends BaseController
{
    /**
     * 攻略列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('StrategyView');
        }else{
            $where['strategy.name'] = array('like',"%$key%");
            $where['member.username'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('StrategyView')->where($where);
        }
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $strategy = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('strategy.id DESC')->select();
        $test=D('strategy');
        $this->assign('model', $strategy);
        $this->assign('page',$show);
        $this->display();
    }
    /**
     * 添加攻略
     */
    public function add()
    {
        //默认显示添加表单
        if (!IS_POST) {
            $spots=M('spot')->select();
            $areas=getData('area');
            $this->assign('areas',$areas);
            $this->assign('spots',$spots);
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $member=D('member');
            $map['username']=session('username');
            $memdata=$member->where($map)->find();
            $model = D("strategy");
            $data=$model->create();
            $spots=I('post.spots');
            $spots=implode(',',$spots);/*获取途经景点数据*/
            $data['spots']=$spots;
            $areas=I('post.areas');
            $areas=implode(',',$areas);/*获取地区数据*/
            $data['areas']=$areas;
            $data['time']=date('Y-m-d');
            $data['user_id']=$memdata['id'];
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
                    $this->success("添加成功", U('strategy/index'));
                    // var_dump($data);
                } else {
                    $this->error("添加失败");
                }
            }
        }

    }
    /**
     * 更新攻略信息
     * @param  [type] $id [攻略ID]
     * @return [type]     [description]
     */
    public function update($id)
    {
    	$id = intval($id);
        //默认显示添加表单
        if (!IS_POST) {
            //获取线路途经景点的id数组
            $spots=M('spot')->select();
            $spotsids=M('strategy')->where("id=$id")->field('spots')->find();
            $areaids=M('strategy')->where("id=$id")->field('areas')->find();
            $areaids=explode(',',$areaids['areas']);
            $spotsids=explode(',',$spotsids['spots']);
            //var_dump($areaids);
            $this->assign('spotsids',$spotsids);
            $this->assign('areaids',$areaids);
            $this->assign('spots',$spots);
            $areas=getData('area');
            $this->assign('areas',$areas);
            $model = M('strategy')->where("id= %d",$id)->find();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('strategy',$model);
            $this->display();
        }
        if (IS_POST) {
            $member=D('member');
            $map['username']=session('username');
            $memdata=$member->where($map)->find();
            $model = D("Strategy");
            //$data=$model->create();
            $data['time']=date('Y-m-d');
            $data['user_id']=$memdata['id'];
            $model = D("strategy");
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
                    $this->success("更新成功", U('strategy/index'));
                } else {
                    $this->error("更新失败");
                }
            }
        }
    }
    /**
     * 删除攻略
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    	$id = intval($id);
        $model = M('strategy');
        $result = $model->where("id= %d",$id)->delete();
        if($result){
            $this->success("删除成功", U('strategy/index'));
        }else{
            $this->error("删除失败");
        }
    }
}
