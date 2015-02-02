<?php
App::uses('AppModel', 'Model');
class Banner extends AppModel {
	public $tablePrefix = 'mc_';
	
    
    public $hasMany = array(
        'Banner_lang' => array(
            'className' => 'Banner_lang',
            'foreignKey' => 'banner_id',
            'conditions' => array('Banner_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
  
     
}
?>