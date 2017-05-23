<?php
namespace Admin\Model;
use Think\Model;
class NoteModel extends Model{
    // protected $_validate = array(
    //     array('title','require','请填写攻略名称！'), //默认情况下用正则进行验证
    //     // array('type',array(1,2,3,4),'请勿恶意修改字段',3,'in'), // 当值不为空的时候判断是否在一个范围内
    // );
    protected function getUid(){
    	return session('adminId');
    }
    
}
