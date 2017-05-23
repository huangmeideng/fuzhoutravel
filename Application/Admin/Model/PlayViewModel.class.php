<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class PlayViewModel extends ViewModel {
   public $viewFields = array(
     'play'=>array('id','cate_id','title','descs','pic','content','type','ishot'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'play.cate_id=category.id'),
    //  'member'=>array('username', '_on'=>'post.user_id=member.id'),
   );
 }

?>
