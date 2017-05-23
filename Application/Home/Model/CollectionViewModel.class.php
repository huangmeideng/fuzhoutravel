<?php
namespace Home\Model;
use Think\Model\ViewModel;
class CollectionViewModel extends ViewModel{
    public $viewFields = array(
     'collection'=>array('id','user_id','collection_id','cate_id'),
     'user'=>array('username', '_on'=>'collection.user_id=user.id'),
     'category'=>array('name'=>'category_name','title'=>'category_title', '_on'=>'collection.cate_id=category.id'),
   );
}
?>