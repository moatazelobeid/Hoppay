<?php
App::uses('AppModel', 'Model');
class Merchant_login extends AppModel {
	public $tablePrefix = 'mc_';

	 public $hasOne = array(
        'Profile' => array(
            'className' => 'Merchant',
            'conditions' => array(),
            'foreignKey' => 'merchant_id',
            'dependent' => true
        )
    );
}
?>