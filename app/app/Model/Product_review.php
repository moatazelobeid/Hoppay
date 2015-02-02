<?php
App::uses('AppModel', 'Model');
class Product_review extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Reviewed_user' => array(
            'className' => 'Reviewed_user',
            'foreignKey' => 'user_id'
        ),	
         'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id'
        )	
    );
}
?>