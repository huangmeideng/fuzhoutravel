<?php
function dd($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

/**
 * 获取排序后的分类
 * @param  [type]  $data  [description]
 * @param  integer $pid   [description]
 * @param  string  $html  [description]
 * @param  integer $level [description]
 * @return [type]         [description]
 */
function getSortedCategory($data,$pid=0,$html="|---",$level=0)
{
	$temp = array();
	foreach ($data as $k => $v) {
		if($v['pid'] == $pid){

			$str = str_repeat($html, $level);
			$v['html'] = $str;
			$temp[] = $v;

			$temp = array_merge($temp,getSortedCategory($data,$v['id'],'|---',$level+1));
		}

	}
	return $temp;
}

/**
 * 根据key，返回当前行的所有数据
 * @param  string  $key  字段key
 * @return array         当前行的所有数据
 */
function getSettingValueDataByKey($key)
{
	return M('setting')->getByKey($key);
}
/**
 * 发送验证邮件函数
 * @return [type] [description]
 */
/*function sendmail($address,$title,$message){
	require_once("./PHPMailer/class.phpmailer.php");
	$mail=new PHPMailer();
	// 设置PHPMailer使用SMTP服务器发送Email
	$mail->IsSMTP();
	// 设置邮件的字符编码，若不指定，则为'UTF-8'
	$mail->CharSet='UTF-8';
	// 添加收件人地址，可以多次使用来添加多个收件人
	$mail->AddAddress($address);
	// 设置邮件正文
	$mail->Body=$message;
	// 设置邮件头的From字段。
	$mail->From=C('MAIL_ADDRESS');
	// 设置发件人名字
	$mail->FromName='福州旅游网';
	// 设置邮件标题
	$mail->Subject=$title;
	// 设置SMTP服务器。
	$mail->Host=C('MAIL_SMTP');
	// 设置为“需要验证”
	$mail->SMTPAuth=true;
	// 设置用户名和密码。
	$mail->Username=C('MAIL_LOGINNAME');
	$mail->Password=C('MAIL_PASSWORD');
	// 发送邮件。
	return($mail->Send());
}*/
/**
 * 根据key返回field字段
 * @param  string $key   [description]
 * @param  string $field [description]
 * @return string        [description]
 */
function getSettingValueFieldByKey($key,$field)
{
	return M('setting')->getFieldByKey($key,$field);
}
/**
 * 分类信息
 * @param   $data [description]
 * @return [type]       [description]
 */
function getData($data){
	if($data=='area'){
		return array('鼓楼','台江','仓山','马尾','晋安','闽侯','连江','罗源','闽清','永泰','福清','长乐','平潭');
	}elseif ($data=='type') {
		return array('自由行','跟团游','自驾游','独立成团');
	}elseif($data=='days'){
		return array('一日','两日','三日','四日','五日','六日','七日','七日以上');
	}elseif($data=='star'){
		return array('5A','4A','3A','2A','1A','未评级');
	}
}
/**
 * 过滤项的routeURL生成
 * @param $type 生成的URL类型（cid, price, order)
 * @parma $data 相应的数据当前的值（为空表示清除该参数）
 * @return string 生成好的携带正确参数的URL
 */
function mkFilterURL($type, $data='') {
	$params = I('get.');
	if($data){   //添加到参数
		$params[$type] = $data;
	}else{       //$data为空时清除参数
		unset($params[$type]);
	}
	return U('Route/index',$params);
}
function mkFilterHotelsURL($area,$data='') {
	$params = I('get.');
	if($data){
		$params[$area]=$data;
	}else{
		unset($params[$area]);
	}
	return U('Hotels/index',$params);
}
/**
*生成产品编码
*/
function getCode(){
	$code='route'.date('YmdHis').rand(100000, 999999);
	return $code;
}
/**
*生成订单编号
*/
function orderCode($type){
	$code=$type.order.date('YmdHis').rand(100000,999999);
	return $code;
}

/**
*递归获取评论
*/
function getComment($parent_id=0,$product_id){
	// $strategy=M('strategy');
    //     $count=$strategy->count();// 查询满足要求的总记录数
    //     $Page=new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(2)
    //     $Page->setConfig('prev','上一页');
    //     $Page->setConfig('next','下一页');
    //     $show=$Page->show();// 分页显示输出
    //     // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    //     $list = $strategy->order('time')->limit($Page->firstRow.','.$Page->listRows)->select();
    //     $this->assign('list',$list);// 赋值数据集
    //     $this->assign('page',$show);// 赋值分页输出
	$where['parent_id']=$parent_id;
	$where['product_id']=$product_id;
	//$result=M('comment')->where($where)->order("time desc")->select();
	$result=M('comment as a')->join('user as b on b.id=a.user_id')->where($where)->order('time desc')->select();
	if($result){
		return $result;
	}else{
		return array();
	}
}
/**
*获取links
*/
function getLinks(){
	$links=M('links');
	$data=$links->select();
	return $data;
}
//  /**
// 	*递归获取评论列表
//     */
//     protected function getCommlist($parent_id = 0,&$result = array()){    	
//     	$arr = M('comment')->where("parent_id = '".$parent_id."'")->order("create_time desc")->select();   
//     	if(empty($arr)){
//     		return array();
//     	}
//     	foreach ($arr as $cm) {  
//     		$thisArr=&$result[];
//     		$cm["children"] = $this->getCommlist($cm["id"],$thisArr);    
//     		$thisArr = $cm; 				    	    		
//     	}
//     	return $result;
//     }