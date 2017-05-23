<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class StrategyViewModel extends ViewModel {
   public $viewFields = array(
     'strategy'=>array('id','title','reason','cate_id','pic','content','spots','areas','time','user_id','ishot','praise'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'strategy.cate_id=category.id'),
     'member'=>array('username', '_on'=>'strategy.user_id=member.id'),
   );
 }

?>
