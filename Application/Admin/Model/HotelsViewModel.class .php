<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class HotelsViewModel extends ViewModel {
   public $viewFields = array(
     'hotels'=>array('id','name','address','pic','content','cate_id','area'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'hotels.cate_id=category.id'),
     // 'member'=>array('username', '_on'=>'post.user_id=member.id'),
   );
 }

?>
