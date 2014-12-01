<?php 
App::uses('AdminController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
class CrawlController extends AdminController 
{  
   
     public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
   public $components = array('Session','Paginator','Cookie','Ctrl','RequestHandler');
   public $uses=array('Crawl_merchant_website');
   public function beforeFilter(){
                  // $this->set('_constants', array('this', 'that', 'the other'));
             
              parent::beforeFilter();
             


     }
    public function admin_index()  
    {  
       $this->set('menu_title','Crawl Merchant Websites');
      $crawl_data=  $this->Crawl_merchant_website->find('all');

      $this->set('crawl_data',$crawl_data);

    }  
    /*public function admin_exicute($id){
      shell_exec('start http://localhost/menacompare/admin/crawl/init/'.$id);
      $this->render('admin_init');
    }*/
     public function execInbg($cmd) { 
      if (substr(php_uname(), 0, 7) == "Windows"){ 
     // pclose(popen("start /B ". $cmd, "a")); 
       shell_exec("start /B ". $cmd);
      }else{ 
       exec($cmd . " > /dev/null &"); 
      } 
    }
    public function admin_init($id=""){
      //ini_set('memory_limit','5000000M');
      //ini_set('max_execution_time','10000');
      /*$crawl_data=  $this->Crawl_merchant_website->find('first',array('id'=>$id)); 
       $crawl_data=$crawl_data['Crawl_merchant_website'];
       $path=WWW_ROOT."crawl.php ".$crawl_data['merchant_id']." ".$crawl_data['merchant_url']." ".$crawl_data['merchant_paths'];
      $file = new File(WWW_ROOT.'/log.html', true, 0644);
      //$res=shell_exec("php -q ".$path);
      $cmd="php -q ".$path;      
      shell_exec("start /B ". $cmd);*/ 
     
     // $file->append($res);
      $file = new File(WWW_ROOT.'/log.html', true, 0644);
      $c = $file->read();
      echo $c;
       if($c==0)
       {       
         $crawl_data=  $this->Crawl_merchant_website->find('first',array('id'=>$id)); 
         $crawl_data=$crawl_data['Crawl_merchant_website'];
        // print_r($crawl_data);
         $path=WWW_ROOT."crawl.php ".$crawl_data['merchant_id']." ".$crawl_data['merchant_url']." ".$crawl_data['merchant_paths'];
        // print_r($path);exit();
         $this->execInbg("php -f ".$path);
         echo "start progress";
         $file->create();
         $file->append(1);
       }
       else
       {
         echo "under progress";
       }    
         
    }
}  
?>