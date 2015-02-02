<?php
App::uses('AppModel', 'Model');
class Merchant_rating extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Reviewed_user' => array(
            'className' => 'Reviewed_user',
            'foreignKey' => 'user_id'
        ),	
         'Merchant_login' => array(
            'className' => 'Merchant_login',
            'foreignKey' => 'merchant_id'
        ),
           
         'Merchant' => array(
            'className' => 'Merchant',
            'foreignKey' => 'merchant_id'
        )
    );
}
?>