<?php
App::uses('AppModel', 'Model');
class Product_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id'
        )
    );
    
}
?>