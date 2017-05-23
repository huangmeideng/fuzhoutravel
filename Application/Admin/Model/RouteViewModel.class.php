<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class RouteViewModel extends ViewModel {
   public $viewFields = array(
     'route'=>array('id','name','cate_id','descs','content','pic','price','days','type','ishot','spots','code'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'route.cate_id=category.id'),
    //  'member'=>array('username', '_on'=>'post.user_id=member.id'),
   );
 }

?>
