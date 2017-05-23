<?php 
namespace Admin\Model;
use Think\Model\ViewModel;
class HotelorderViewModel extends ViewModel{
     public $viewFields = array(
     'hotelorder'=>array('id','user_id','hotel_id','indate','outdate','type','beizhu','code','isdone'),
     'user'=>array('username', '_on'=>'hotelorder.user_id=user.id'),
     'hotels'=>array('name','_on'=>'hotelorder.hotel_id=hotels.id'),
   );
}
?>