<?php
namespace Home\Model;
use Think\Model;
class NoteModel extends Model{
      protected $_validate = array(
        array('title','require','请填写游记名称！'), //默认情况下用正则进行验证
        // array('type',array(1,2,3,4),'请勿恶意修改字段',3,'in'), // 当值不为空的时候判断是否在一个范围内
    );
    public function getNote(){
        $note=M('note');
        $data=$note->where('status=1')->limit(6)->select();
        return $data;
    }
}