<?php
App::uses('AppModel', 'Model');
class Product_brand extends AppModel {    
	public $tablePrefix = 'mc_';
	 public $hasMany = array(
        'Product_brand_lang' => array(
            'className' => 'Product_brand_lang',
            'foreignKey' => 'brand_id',
            'conditions' => array('Product_brand_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
 
}
?>