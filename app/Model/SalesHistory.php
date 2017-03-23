<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/12/15
 * Time: 23:50
 */
class SalesHistory extends AppModel {
    //table指定
    public $useTable="sales_histories";

    //アソシエーション
    public $belongsTo = array(
        'Attribute' => array(
            'className' => 'SalesAttribute',
            'foreignKey' => 'attribute_id'
        )
    );

}
