<?php
App::uses('AppModel', 'Model');
class Page extends AppModel {    
	public $tablePrefix = 'mc_';
	 public $hasMany = array(
        'Page_lang' => array(
            'className' => 'Page_lang',
            'foreignKey' => 'pg_id',
            'conditions' => array('Page_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        ),
        'Page_menu' => array(
            'className' => 'Menu',
            'foreignKey' => 'page_id',
            'conditions' => array('Page_menu.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
 
}
?>