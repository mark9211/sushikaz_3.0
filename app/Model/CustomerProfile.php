<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/09/10
 * Time: 0:27
 */
App::uses('Security', 'Utility');

class CustomerProfile extends AppModel {
    //table指定
    public $useTable="customer_profiles";

    #パスワードハッシュ化
    public function beforeSave($options = array()){
        if(isset($this->data['CustomerProfile']['password'])){
            $this->data['CustomerProfile']['password'] = Security::hash($this->data['CustomerProfile']['password'], 'sha1', true);
        }
        return true;
    }

}
