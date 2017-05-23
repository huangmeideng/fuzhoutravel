<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends BaseController{
    public function _initialize() {
		$allow_action = array( //指定不需要检查登录的方法列表
			'login','getVerify','logout','register','check_verify'
		);
		if(session('userinfo')==NULL && !in_array(ACTION_NAME,$allow_action)){
			$this->error('请先登录。',U('User/login'));
		}
	}
  /**
   * 用户登录操作
   * @return [type] [description]
   */
  public function login(){
     if(!IS_POST){
         $links=getLinks();
         $this->assign('links',$links);
         $this->display();
         }
         if(IS_POST){
        $userinfo = M('user');
        $username =I('username','','addslashes');
        $password =I('password','','md5');
        $code = I('verify','','strtolower');
        //验证验证码是否正确
        if(!($this->check_verify($code))){
            $this->error('验证码错误');
        }
        //验证账号密码是否正确
        $user = $userinfo->where("username = '%s' and password= '%s'",array($username,$password))->find();

        if(!$user) {
            $this->error('账号或密码错误 :(') ;
        }
        //验证账户是否被禁用
        if($user['status'] == 0){
            $this->error('账号被禁用，请联系管理员 :(') ;
        }
        // //更新登陆信息
        // $data =array(
        //     'id' => $user['id'],
        //     'username' =>$userinfo['username'],
        // );
            session('userinfo',array('id'=>$user['id'],'username'=>$user['username']));
            $this->success("登陆成功",U('Index/index'));
         }
        //定向之后台主页
  }
  /**
   * 用户注册操作
   * @return [type] [description]
   */
  public function register(){
    if (!IS_POST) {
        $links=getLinks();
         $this->assign('links',$links);
        $this->display();
    }
    if (IS_POST) {
        //如果用户提交数据
        $model = D("User");
        if (!$model->create()) {
            // 如果创建失败 表示验证没有通过 输出错误提示信息
            $this->error($model->getError());
            exit();
        } else {
            if ($model->add()) {
                $member=M('user');
                $where['username']=I('username');
                $data=$member->field('id,username')->where($where)->find();
                session('userinfo',array('id'=>$data['id'],'username'=>$data['username']));
                //var_dump(session('userinfo'));
                $this->success("用户注册成功", U('Index/index'));
            } else {
                $this->error("用户注册失败");
            }
        }
    }
  }
  /**
  *用户退出
  **/
  public function logout(){
      session('userinfo',null);
      redirect(U('Index/index'));
  }
  /**
   * 生成验证码
   * @return [type] [description]
   */
    public function getVerify() {
      $Verify = new \Think\Verify();
      $Verify->codeSet = '0123456789';
      $Verify->fontSize = 13;
      $Verify->length = 4;
      $Verify->entry();
    }
    protected function check_verify($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }
    /**
    *菜单界面控制
    */
    public function menu(){
        if(session('userinfo')){
            $id=session('userinfo.id');
            $user=M('user');
            $data=$user->find($id);
            $this->assign('data',$data);
            $this->display();
        }
    }
    /**
    *默认界面
    */
    public function user(){
        $id=session('userinfo.id');
        $data=M('user')->find($id);
        $this->assign('data',$data);
        $this->display();
    }
    /**
    *用户信息显示
    **/
    public function message(){
        if(session('userinfo')){
            $id=session('userinfo.id');
            $user=M('user');
            $data=$user->find($id);
            $this->assign('data',$data);
            $this->display();
        }
    }
    /**
    *用户信息修改
    **/
    public function edit($id){
        $id=intval($id);
        if(!IS_POST){
            $data=M('user')->find($id);
            $this->assign('data',$data);
            $this->display();
        }
        if(IS_POST){
            $model = D("User");
            $data=$model->create();
            if (!$data) {
                $this->error($model->getError());
            }else{
                if ($_FILES['avatar']['tmp_name'] != '') {
                    $upload = new \Think\Upload();
                    $upload->maxSize = 3145728;
                    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                    $upload->rootPath = './';
                    $upload->savePath = './Public/Uploads/';
                    $info = $upload->uploadOne($_FILES['avatar']);
                        if (!$info) {
                            $this->error($upload->getError());
                } else {
                    $original=$info['savepath'].$info['savename'];
                    $avatar=$info['savepath'].'avatar'.$info['savename'];
                    $image = new \Think\Image(); 
                    $image->open($original);
                    $image->thumb(100, 100)->save($avatar);
                    $data['avatar'] = $avatar;
                  }
                 }
                if ($model->save($data)) {
                    $this->success("更新成功", U('User/message'));
                } else {
                    $this->error("更新失败");
                }
            }
        }
    }
    /**
    *修改密码
    */
    public function password(){
        //$id=intval($id);
        $id=session('userinfo.id');
        if(!IS_POST){
            $data=M('user')->find($id);
            $this->assign('data',$data);
            $this->display();
        }
        if(IS_POST){
            $oldpassword=I('post.oldpassword');
            $data=M('user')->field('password')->find($id);
            if($data['password']!=md5($oldpassword)){
                $this->error('原密码不正确',U('User/password'));
            }else{
                $user=D('User');
                $data['password']=md5(I('password'));
                if($user->where("id=$id")->save($data)){
                    $this->success('更新密码成功',U('User/message'));
                }else{
                    $this->error('更新失败',U('User/password'));
                }    
            }
        }
    }
    /**
    *收藏列表
    */
    public function collection(){
        $id=session('userinfo.id');
        $data=M('user')->find($id);
        $collection=D('Collection');
        $collectionnote=$collection->getCollection($id,70);
        $collectionstrategy=$collection->getCollection($id,69);
        $collectionspot=$collection->getCollection($id,40);
        $collectionfood=$collection->getCollection($id,65);
        $collectiontechang=$collection->getCollection($id,66);
        $noteid=array();
        $note=array();
        foreach($collectionnote as $v){
            $noteid[]=$v['collection_id'];
        }
        foreach($noteid as $v){
            // $note[]=M('note as a')->join('user as b on a.user_id=b.id')->where('a.id=%d',$v)->find();
            $note[]=D('NoteView')->find($v);
        }
        $strategyid=array();
        $strategy=array();
        foreach($collectionstrategy as $v){
            $strategyid[]=$v['collection_id'];
        }
        foreach($strategyid as $v){
            $strategy[]=M('strategy')->find($v);
        }
        //var_dump($noteid);
        $spotid=array();
        $spot=array();
        foreach($collectionspot as $v){
            $spotid[]=$v['collection_id'];
        }
        foreach($spotid as $v){
            $spot[]=M('spot')->find($v);
        }
        $foodid=array();
        $food=array();
        foreach($collectionfood as $v){
            $foodid[]=$v['collection_id'];
        }
        foreach($foodid as $v){
            $food[]=M('fands')->find($v);
        }
        $techangid=array();
        $techang=array();
        foreach($collectiontechang as $key=>$v){
            $techangid[]=$v['collection_id'];
        }
        foreach($techangid as $v){
            $techang[]=M('fands')->find($v);
        }
        //var_dump($techangid);
        $this->assign(array(
            'data'=>$data,
            'note'=>$note,
            'spot'=>$spot,
            'food'=>$food,
            'techang'=>$techang,
            'strategy'=>$strategy,
        ));
        $this->display();
    }
    /**
    *我的游记
    */
    public function mynote(){
        $id=session('userinfo.id');
        $data=M('user')->find($id);
        $note=D('NoteView')->where('user_id=%d',$id)->select();
        $this->assign(array(
            'data'=>$data,
            'note'=>$note,
        ));
        $this->display();
    }
    /**
    *线路订单
    */
    public function cart(){
        $id=session('userinfo.id');
        $data=M('user')->find($id);
        $cart=M('cart as a')->join('route as b on a.product_id=b.id')->where('a.user_id=%d',$id)->select();
        $this->assign(array(
            'data'=>$data,
            'cart'=>$cart,
        ));
        $this->display();
    }
    /**
    *酒店订单
    */
    public function hotelorder(){
        $id=session('userinfo.id');
        $data=M('user')->find($id);
        $order=M('hotelorder as a')->join('hotels as b on a.hotel_id=b.id')->where('a.user_id=%d',$id)->select();
        $this->assign(array(
            'data'=>$data,
            'order'=>$order,
        ));
        $this->display();
    }
    /**
    *我的投诉
    */
    public function complain(){
        $id=session('userinfo.id');
        $data=M('user')->find($id);
        $complain=M('complain as a')->join('user as b on a.user_id=b.id')->where('a.user_id',$id)->select();
        $this->assign(array(
            'data'=>$data,
            'complain'=>$complain,
        ));
        $this->display();
    }
}
?>
