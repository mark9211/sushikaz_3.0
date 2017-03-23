<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/04
 * Time: 2:40
 */
class Target extends AppModel {
	//table指定
	public $useTable="targets";

	public function getTargetByDay($location_id, $working_day){
		$target = $this->find('first', array(
			'conditions' => array('location_id' => $location_id)
		));
		if($target!=null){
			#曜日で返す
			if(date('w', strtotime($working_day))==0){
				return $target['Target']['target_three'];
			}elseif(date('w', strtotime($working_day))==5||date('w', strtotime($working_day))==6){
				return $target['Target']['target_two'];
			}else{
				return $target['Target']['target_one'];
			}
		}else{
			return null;
		}
	}

	#20160622
	public function returnNumDay($working_day, $datas){
		$result = array_key_exists($working_day, $datas);
		if($result==true){
			return "target_five";
		}else{
			$w = date('w', strtotime($working_day));
			if($w==0){
				return "target_four";
			}
			elseif($w==6){
				return "target_three";
			}
			elseif($w==5){
				return "target_two";
			}
			else{
				return "target_one";
			}
		}
	}

	#20160622
	public function getTargetByMonth($location_id, $working_month, $target_col){
		$targets = $this->find('all', array(
			'conditions' => array('Target.location_id' => $location_id, 'Target.working_month' => $working_month)
		));
		$target_sum=0;
		if($targets!=null){
			foreach($targets as $target){
				$target_sum += $target['Target'][$target_col];
			}
		}
		return $target_sum;
	}

}
