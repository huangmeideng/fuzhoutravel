<?php
namespace Home\Model;
use Think\Model;
class StrategyModel extends Model{
    public function getStrategy(){
        $strategy=M('strategy');
        $data=$strategy->limit(4)->select();
        return $data;
    }
}