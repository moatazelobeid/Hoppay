<?php
App::uses('AppModel', 'Model');
class Offer extends AppModel {
	public $tablePrefix = 'mc_';    
    public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'offer_id',
            'conditions' => array('Product.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
  
     
}
?>