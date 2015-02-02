<?php
App::uses('AppModel', 'Model');
class Reviewed_user extends AppModel {
	public $tablePrefix = 'mc_';
	public $hasMany = array(
        'Product_review' => array(
            'className' => 'Product_review',
            'foreignKey' => 'user_id'
        ),
        'Merchant_rating' => array(
            'className' => 'Merchant_rating',
            'foreignKey' => 'user_id'
        )		
    );
}
?>