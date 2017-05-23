<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class ComplainViewModel extends ViewModel {
   public $viewFields = array(
     'complain'=>array('id','user_id','cate_id','title','content','relcontent'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'complain.cate_id=category.id'),
     'user'=>array('username', '_on'=>'complain.user_id=user.id'),
   );
 }

?>