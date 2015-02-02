<?php
App::uses('AppModel', 'Model');
class Tag extends AppModel {
	public $tablePrefix = 'mc_';
	
    
    public $hasMany = array(
        'Tag_lang' => array(
            'className' => 'Tag_lang',
            'foreignKey' => 'tag_id',
            'conditions' => array('Tag_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
  
     
}
?>