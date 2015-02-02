<?php
App::uses('AppModel', 'Model');
class Faq_category extends AppModel {
  public $actsAs = array('Tree');
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Parent' => array(
            'className' => 'Faq_category',
            'foreignKey' => 'parent_id'
        )
    );
    public $hasMany = array(
        'Faq_category_lang' => array(
            'className' => 'Faq_category_lang',
            'foreignKey' => 'cat_id',
            'conditions' => array('Faq_category_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
  
}
?>