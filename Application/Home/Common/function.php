<?php 
/**
 * 对象转数组
 * @param  [type] $obj [description]
 * @return [type]      [description]
 */
function objectToArray($obj){
    $arr = is_object($obj) ? get_object_vars($obj) : $obj;
    if(is_array($arr)){
        return array_map(__FUNCTION__, $arr);
    }else{
        return $arr;
    }
}

 ?>