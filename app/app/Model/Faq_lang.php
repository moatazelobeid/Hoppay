<?php
App::uses('AppModel', 'Model');
class Faq_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Faq' => array(
            'className' => 'Faq',
            'foreignKey' => 'faq_id'
        )	
    );
}
?>