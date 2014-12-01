<?php
App::uses('AppModel', 'Model');
class Product_brand_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Product_brand' => array(
            'className' => 'Product_brand',
            'foreignKey' => 'brand_id'
        )	
    );
}
?>