<?php
namespace Home\Model;
use Think\Model\ViewModel;
class NoteViewModel extends ViewModel {
   public $viewFields = array(
     'note'=>array('id','cate_id','title','pic','content','spots','areas','time','user_id','ishot','status'),
     //'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'strategy.cate_id=category.id'),
     'user'=>array('username', '_on'=>'note.user_id=user.id'),
   );
 }

?>
