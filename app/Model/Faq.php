<?php
App::uses('AppModel', 'Model');
class Faq extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Faq_category' => array(
            'className' => 'Faq_category',
            'foreignKey' => 'category_id'
        )
    );
    
    public $hasMany = array(
        'Faq_lang' => array(
            'className' => 'Faq_lang',
            'foreignKey' => 'faq_id',
            'conditions' => array('Faq_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
  
     
}
?>