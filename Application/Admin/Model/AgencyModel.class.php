<?php
namespace Admin\Model;
use Think\Model;
class AgencyModel extends Model{
    protected $_validate = array(
        array('name','require','请填写旅行社名称！'), //默认情况下用正则进行验证
        array('people','require','请填写联系人！'),
        array('telephone','require','请填写联系电话'),
        array('license','require','请填写许可证'),
        array('address','require','请填写地址'),
    );
    protected function getUid(){
    	return session('adminId');
    }
}