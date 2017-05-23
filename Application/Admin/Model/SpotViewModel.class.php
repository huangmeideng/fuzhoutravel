<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class SpotViewModel extends ViewModel {
   public $viewFields = array(
     'spot'=>array('id','cate_id','name','descs','pic','content','type','area','star','ticket','address','telephone','opentime','playtime','goodtime','praise'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'spot.cate_id=category.id'),
     // 'member'=>array('username', '_on'=>'post.user_id=member.id'),
   );
 }

?>
