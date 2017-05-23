<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class AgencyViewModel extends ViewModel {
   public $viewFields = array(
     'agency'=>array('id','cate_id','name','people','telephone','license','address','pic','content'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'agency.cate_id=category.id'),
     // 'member'=>array('username', '_on'=>'post.user_id=member.id'),
   );
 }

?>
