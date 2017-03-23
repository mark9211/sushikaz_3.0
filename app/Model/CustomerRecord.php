<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/09/11
 * Time: 11:04
 */
class CustomerRecord extends AppModel {
    //table指定
    public $useTable="customer_records";

    public $belongsTo = array(
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'location_id'
        )
    );

    public function judgeLunchDinner($customer_record){
        $working_day = $customer_record['CustomerRecord']['working_day'];
        $time = $working_day.' 16:00';
        if($customer_record['CustomerRecord']['visit_time']!=null){
            if(strtotime($customer_record['CustomerRecord']['visit_time']) > strtotime($time)){
                return 'dinner';
            }
            else{
                return 'lunch';
            }
        }
        else{
            return null;
        }
    }

}
