<?php
App::uses('AppModel', 'Model');
class Unique_visitor extends AppModel {
	public $tablePrefix = 'mc_';  
	 public $belongsTo = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id'
        )	
        
    );   
}
?>