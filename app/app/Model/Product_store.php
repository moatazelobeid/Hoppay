<?php
App::uses('AppModel', 'Model');
class Product_store extends AppModel {
	public $tablePrefix = 'mc_';
	
    
    public $hasMany = array(
        'Product_store_lang' => array(
            'className' => 'Product_store_lang',
            'foreignKey' => 'store_id',
            'conditions' => array('Product_store_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
  
     
}
?>