<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/02/24
 * Time: 18:32
 */
class MonthlyExpense extends AppModel {
    //table指定
    public $useTable = "monthly_expenses";

    //アソシエーション
    public $belongsTo = array(
        'Type' => array(
            'className' => 'MonthlyExpenseType',
            'foreignKey' => 'type_id'
        )
    );

}