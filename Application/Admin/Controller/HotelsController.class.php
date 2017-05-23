<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 酒店管理
 */
class HotelsController extends BaseController
{
    /**
     * 酒店列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('Hotels');
        }else{
            $where['hotels.name'] = array('like',"%$key%");
            // $where['member.username'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('HotelsView')->where($where);
        }

        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $hotels = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('hotels.id DESC')->select();
        $this->assign('model', $hotels);
        $this->assign('page',$show);
        $this->display();
    }
    /**
     * 添加酒店
     */
    public function add()
    {
        //默认显示添加表单

        if (!IS_POST) {
          $area=getData('area');
          $this->assign('area',$area);
          // print_r($area);
          $this->assign("category",getSortedCategory(M('category')->select()));
          $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $model = D("hotels");
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
                    $this->success("添加成功", U('hotels/index'));
                    // var_dump($data);
                } else {
                    $this->error("添加失败");
                }
            }
        }

    }
    /**
     * 更新酒店信息
     * @param  [type] $id [酒店ID]
     * @return [type]     [description]
     */
    public function update($id)
    {
    		$id = intval($id);
        //默认显示添加表单
        if (!IS_POST) {
            $area=getData('area');
            $this->assign('area',$area);
            $model = M('hotels')->where("id= %d",$id)->find();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('hotels',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("hotels");
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
                    $this->success("更新成功", U('hotels/index'));
                } else {
                    $this->error("更新失败");
                }
            }
        }
    }
    /**
     * 删除酒店
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    		$id = intval($id);
        $model = M('hotels');
        $result = $model->where("id= %d",$id)->delete();
        if($result){
            $this->success("删除成功", U('hotels/index'));
        }else{
            $this->error("删除失败");
        }
    }
	// public function push($id) {//hotels到前台
	// 	$id = intval($id);
	// 	if (IS_GET) {
	// 		$status = M('hotels') -> where("id= %d",$id) -> getField('status');
	// 		if ($status === '0') {
	// 			$data['status'] = 1;
	// 		} else {
	// 			$data['status'] = 0;
	// 		}
	// 		$result = M('hotels') -> where("id= %d",$id) -> save($data);
	// 		if ($result && $data['status'] === 1) {
	// 			$this -> success("发布成功", U('hotels/index'));
	// 		} elseif ($result && $data['status'] === 0) {
	// 			$this -> success("撤销成功", U('hotels/index'));
	// 		} else {
	// 			$this -> error("操作失败");
	// 		}
	// 	} else {
	// 		pass;
  //
	// 	}
	// }
}
