<?php
App::uses('AppModel', 'Model');
class Product_store_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Product_store' => array(
            'className' => 'Product_store',
            'foreignKey' => 'store_id'
        )	
    );
}
?>