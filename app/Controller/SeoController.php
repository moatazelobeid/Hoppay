<?php 
App::uses('AppController', 'Controller');
class SeoController extends AppController  
{  
    var $uses = array();  
    var $components = array('RequestHandler');  
  
    function robots()  
    {  
        // $this->loadmodel('Seo_setting');
        // $data=$this->Seo_setting->find('first');   
        if (Configure::read('debug'))  
        {  
            Configure::write('debug', 0);  
        }  
        /*if($data['Seo_setting']['allow_robert']==1){*/
        $urls = array();  
  
        // ...snip...  
        // fill the $urls array with those you don't  
        // want to be indexed/crawled  
        // for example  
        $urls[] = '/';  
  
        $this->set(compact('urls'));  
        $this->RequestHandler->respondAs('text');  
        $this->viewPath .= '';  
        $this->layout = 'ajax'; 
       /* }
        else
        {
          $this->layout = 'ajax';
          $this->render('/Errors/error400'); 
       }*/
        

    }  
}  
?>