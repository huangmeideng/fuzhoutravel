<?php
namespace Home\Model;
use Think\Model;
class SpotModel extends Model{
  /**
   * 获取特定景点信息
   * @return $type 景点类型1.普通，2.置顶,3.热门,4.推荐
   */
  public function getSpot($type){
    $spot=D('spot');
    $where['type']=$type;
    if($type==2){
      $limit=6;
      $data=$spot->where($where)->limit($limit)->select();
    }elseif($type==4){
      $data=$spot->where($where)->select();
    }elseif($type==3){
      $limit=4;
      $data=$spot->where($where)->limit($limit)->select();
    }
    return $data;
  }
  /**
   * 详情页数据模型,获取附近景点
   * @return [type] [description]
   */
  public function getView($area){
    $spot=M('spot');
    $where['area']=$area;
    $data=$spot->where($where)->select();
    return $data;
  }
  /**
   * 获取景点首页显示景点,5A,4A景点
   * @return [type] [description]
   */
  public function getIndexSpot(){
    $spot=M('spot');
    $star=array('5A','4A');
    $where['star']=array('in',$star);
    $data=$spot->where($where)->select();
    return $data;
  }
  /**
   * 通过areaid获取对应地区的景点信息
   * @param  [type] $areaid [description]
   * @return [type]         [description]
   */
  public function getSpotByArea($areaid){
    $area=getData('area');
    $spot=M('spot');
    switch ($areaid) {
      case '0':
        $where['area']=$area[0];
        break;
      case '1':
        $where['area']=$area[1];
        break;
      case '2':
        $where['area']=$area[2];
        break;
      case '3':
        $where['area']=$area[3];
        break;
      case '4':
        $where['area']=$area[4];
        break;
      case '5':
        $where['area']=$area[5];
        break;
      case '6':
        $where['area']=$area[6];
        break;
      case '7':
        $where['area']=$area[7];
        break;
      case '8':
        $where['area']=$area[8];
        break;
      case '9':
        $where['area']=$area[9];
        break;
      case '10':
        $where['area']=$area[10];
        break;
      case '11':
        $where['area']=$area[11];
        break;
      case '12':
        $where['area']=$area[12];
        break;
    }
    $data=$spot->where($where)->select();
    return $data;
  }
  /**
   * 筛选功能函数
   * @return [type] [description]
   */
 /* public function getList($area=0,$star=0){
    if($area==1){
      $where['area']='鼓楼';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif($area==2){
      $where['area']='台江';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif($area==3){
      $where['area']='仓山';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif($area==4){
      $where['area']='马尾';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif($area==5){
      $where['area']='晋安';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif($area==6){
      $where['area']='闽侯';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif($area==7){
      $where['area']='连江';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif($area==8){
      $where['area']='罗源';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif($area==9){
      $where['area']='闽清';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif ($area==10) {
      $where['area']='永泰';
      if($star==1){
        $where['star']='5A';
      }elseif($star==2){
        $where['star']='4A';
      }elseif($star==3){
        $where['star']='3A';
      }elseif($star==4){
        $where['star']='2A';
      }elseif($star==5){
        $where['star']=='1A';
      }elseif($star==6){
        $where['star']=='未评级';
      }
    }elseif ($area==11) {
        $where['area']='福清';
        if($star==1){
          $where['star']='5A';
        }elseif($star==2){
          $where['star']='4A';
        }elseif($star==3){
          $where['star']='3A';
        }elseif($star==4){
          $where['star']='2A';
        }elseif($star==5){
          $where['star']=='1A';
        }elseif($star==6){
          $where['star']=='未评级';
        }
      }elseif ($area==12) {
          $where['area']='长乐';
          if($star==1){
            $where['star']='5A';
          }elseif($star==2){
            $where['star']='4A';
          }elseif($star==3){
            $where['star']='3A';
          }elseif($star==4){
            $where['star']='2A';
          }elseif($star==5){
            $where['star']=='1A';
          }elseif($star==6){
            $where['star']=='未评级';
          }
      }elseif ($area=13) {
            $where['area']='平潭';
            if($star==1){
              $where['star']='5A';
            }elseif($star==2){
              $where['star']='4A';
            }elseif($star==3){
              $where['star']='3A';
            }elseif($star==4){
              $where['star']='2A';
            }elseif($star==5){
              $where['star']=='1A';
            }elseif($star==6){
              $where['star']=='未评级';
            }
      }
      else{
        $where=array();
      }
      $spot=M('spot');
      $data=$spot->where($where)->select();
      return $data;
  }*/
}
?>
