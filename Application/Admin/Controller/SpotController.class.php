<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 景点管理
 */
class SpotController extends BaseController
{
    /**
     * 景点列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('SpotView');
        }else{
            $where['spot.name'] = array('like',"%$key%");
            $where['member.descs'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('SpotView')->where($where);
        }

        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(8)
        $show = $Page->show();// 分页显示输出
        $post = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('spot.id DESC')->select();
        $this->assign('model', $post);
        $this->assign('page',$show);
        $this->display();
    }
    /**
     * 添加景点
     */
    public function add()
    {
        //默认显示添加表单
        if (!IS_POST) {
            $area=getDATA('area');
            $star=getDATA('star');
            $this->assign('area',$area);
            $this->assign('star',$star);
        	  $this->assign("category",getSortedCategory(M('category')->select()));
            $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $model = D("Spot");
           /* $model->time = time();
            $model->user_id = 1;*/
            $data=$model->create();
            /*$data['time'] = date('Y-m-d');
            $data['user_id'] = 1;*/
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
                    $this->success("添加成功", U('spot/index'));
                    // var_dump($data);
                } else {
                    $this->error("添加失败");
                }
            }
        }
    }
    /**
     * 更新景点信息
     * @param  [type] $id [景点ID]
     * @return [type]     [description]
     */
    public function update($id)
    {
    		$id = intval($id);
        //默认显示添加表单
        if (!IS_POST) {
            $area=getDATA('area');
            $star=getDATA('star');
            $this->assign('area',$area);
            $this->assign('star',$star);
            $model = M('spot')->where("id= %d",$id)->find();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('spot',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("Spot");
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
                    $this->success("更新成功", U('spot/index'));
                } else {
                    $this->error("更新失败");
                }
            }
        }
    }
    /**
     * 删除景点
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    		$id = intval($id);
        $model = M('spot');
        $result = $model->where("id= %d",$id)->delete();
        if($result){
            $this->success("删除成功", U('spot/index'));
        }else{
            $this->error("删除失败");
        }
    }
	/*public function push($id) {//post到前台
		$id = intval($id);
		if (IS_GET) {
			$status = M('post') -> where("id= %d",$id) -> getField('status');
			if ($status === '0') {
				$data['status'] = 1;
			} else {
				$data['status'] = 0;
			}
			$result = M('post') -> where("id= %d",$id) -> save($data);
			if ($result && $data['status'] === 1) {
				$this -> success("发布成功", U('post/index'));
			} elseif ($result && $data['status'] === 0) {
				$this -> success("撤销成功", U('post/index'));
			} else {
				$this -> error("操作失败");
			}
		} else {
			pass;

		}
	}*/
}
