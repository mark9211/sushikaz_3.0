<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/10/04
 * Time: 13:34
 */
App::uses('Security', 'Utility');

class MemberProfile extends AppModel {
    //table指定
    public $useTable="member_profiles";

    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        )
    );

    #パスワードハッシュ化
    public function beforeSave($options = array()){
        if(isset($this->data['MemberProfile']['password'])){
            $this->data['MemberProfile']['password'] = Security::hash($this->data['MemberProfile']['password'], 'sha1', true);
        }
        return true;
    }

}
