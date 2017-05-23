<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class FandssViewModel extends ViewModel {
   public $viewFields = array(
     'fands'=>array('id','cate_id','name','descs','pic','content','cate_id','type','area','praise'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'fands.cate_id=category.id'),
     // 'member'=>array('username', '_on'=>'post.user_id=member.id'),
   );
 }

?>
