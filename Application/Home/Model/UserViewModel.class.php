<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class UserViewModel extends ViewModel {
   public $viewFields = array(
     'user'=>array('id','username','email','password','avatar','create_at','update_at','login_ip','status'),
   );
 }

?>