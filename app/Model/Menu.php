<?php
App::uses('AppModel', 'Model');
class Menu extends AppModel {
  public $actsAs = array('Tree');
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Parent' => array(
            'className' => 'Menu',
            'foreignKey' => 'parent_id'
        ),
        'Menu_position'=>array(
            'className' => 'Menu_position',
            'foreignKey'=> 'menu_position_id'
        ),
        'Page'=>array(
            'className' => 'Page',
            'foreignKey'=> 'page_id'
        )

    );
     
    public $hasMany = array(
        'Menu_lang' => array(
            'className' => 'Menu_lang',
            'foreignKey' => 'menu_id',
            'conditions' => array('Menu_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
  
}
?>