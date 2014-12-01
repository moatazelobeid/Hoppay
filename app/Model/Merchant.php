<?php
App::uses('AppModel', 'Model');
class Merchant extends AppModel {
	public $tablePrefix = 'mc_';

	 public $belongsTo = array(
        'User' => array(
            'className' => 'Merchant_login',
            'foreignKey' => 'merchant_id'
        )
    );
	 public $hasOne = array(
        'Product_store' => array(
            'className' => 'Product_store',
            'foreignKey' => 'merchant_id',
            'conditions' => array(),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
	public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'retailer_id',
            'conditions' => array('Product.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        ),'Merchant_rating' => array(
            'className' => 'Merchant_rating',
            'foreignKey' => 'merchant_id',
            'conditions' => array('Merchant_rating.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
}
?>