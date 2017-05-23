<?php 
namespace Admin\Model;
use Think\Model\ViewModel;
class CartViewModel extends ViewModel{
     public $viewFields = array(
     'cart'=>array('id','user_id','product_id','cate_id','totalprice','status','time','code'),
     'category'=>array('title', '_on'=>'cart.cate_id=category.id'),
     'user'=>array('username', '_on'=>'cart.user_id=user.id'),
     'route'=>array('name','_on'=>'cart.product_id=route.id'),
   );
}
?>