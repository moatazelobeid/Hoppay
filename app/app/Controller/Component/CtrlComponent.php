<?php

//
//File: application/Controller/Component/CtrlComponent.php
// Component rewritten, original from : http://cakebaker.42dh.com/2006/07/21/how-to-list-all-controllers/
//
class CtrlComponent extends Component {

    /**
     * Return an array of user Controllers and their methods.
     * The function will exclude ApplicationController methods
     * @return array
     */
    public function get() {

        $aCtrlClasses = App::objects('controller');

        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));

                // Load its methods / actions
                $aMethods = get_class_methods($controller);
                if(!empty($aMethods)){
                    foreach ($aMethods as $idx => $method) {

                        if ($method{0} == '_') {
                            unset($aMethods[$idx]);
                        }
                    }


                // Load the ApplicationController (if there is one)
                App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');

                $controllers[$controller] = array_diff($aMethods, $parentActions);
                 }
            }
        }

        return $controllers;
    }
  public function getMerchantDetailsByProduct($id="",$slug="",$type="count",$lang_id=1,$merchant_id="")/*(all|count)*/
	{
	 // $slug3=str_replace('-','* +',$slug);
	 // echo $slug."<br>";
	 //$slug = explode("&@#merchant#@&",$slug);
	 //$slug = $slug[0];
	 //$retailer_id  = $slug[1];
	  $this->Product = ClassRegistry::init('Product');
	  $product=$this->Product->Product_lang->find('first',array('conditions'=>array('Product.id'=>$id,'Product.slug like '=>$slug,'Product_lang.lang_id'=>$lang_id)));
	  $merchant_id = $product['Product']['retailer_id'];
	  /*if($product['Product']['mpn']=="" and $product['Product']['isbn']==""){
		 $cond=array('Product.id'=>$product['Product']['id']);
	  }else{
		$cond=array('Product.mpn'=>$product['Product']['mpn'],'Product.isbn'=>$product['Product']['isbn'],'Product.color'=>$product['Product']['color'],'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']);
	  }*/ 
	   //$cond=array( 'MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)','Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']);
	 /* $slug_split=explode("-",$slug);
		$sluges=array();
		if(!empty($slug_split)){
			$cond=array_merge($cond,array('or'=>array()));
			foreach ($slug_split as $key => $value) {
			   $sluges=array_merge((array)$sluges,(array)$value);
			   $sluges=implode("%", $sluges);
			   array_push($cond['or'],array('Product.slug like'=>"%". $sluges."%"));  
			}
		}
	  */
	/*if($type == 'all'){
		$merchant=$this->Product->find($type,array('conditions'=>array('Product.slug like'=>$slug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']) ));
	}else{
		$merchant=$this->Product->find($type,array('conditions'=>array('Product.retailer_id !='=>$retailer_id,'Product.slug like'=>$slug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']) ));
	}*/   
	  //$merchant=$this->Product->find($type,array('conditions'=>array('Product.retailer_id !='=>$product['Product']['retailer_id'],'Product.slug like'=>$slug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']) ));
	 //$merchant=$this->Product->find($type,array('conditions'=>$cond )); //echo $merchant;exit;
		if($type=="all"){
			$merchant=$this->Product->find($type,array('conditions'=>array('Product.slug like'=>$slug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']) ));
			$cdate=date('Y-m-d');
			foreach($merchant as $key=>$val){
				if($merchant_id!="" and $val['Merchant']['id']==$merchant_id && $val['Product']['id'] !=$id ){
				  unset($merchant[$key]);
				  continue;
				}
				if(($val['Offer']['status'] == 1) && ($val['Offer']['end_date']!='0000-00-00 00:00:00') && ($val['Offer']['end_date'] >= $cdate)){
					$merchant[$key]['Product']['offer_price']=($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100));
					$merchant[$key]['Product']['offer_percent']=isset($val['Offer']['discount'])?$val['Offer']['discount']:0;
				}else{
					$merchant[$key]['Product']['offer_price']=$val['Product']['price'];
					$merchant[$key]['Product']['offer_percent']=0;
				}
				if(!empty($val['Product_review'])){
					$res=Hash::extract($val['Product_review'], '{n}.rating'); 
					// print_r($res);            
					$merchant[$key]['Product']['reate_count']= (array_sum($res)/count($res));
				}else{
					$merchant[$key]['Product']['reate_count']=0;
				}
			}
			$results = Hash::extract($merchant, '{n}.Product.offer_price');
		}else{
			$merchant = $this->Product->find($type,array('conditions'=>array('Product.retailer_id !='=>$product['Product']['retailer_id'],'Product.slug like'=>$slug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']) ));
			$merchant = $merchant + 1;
		}
		if(is_array($merchant))
		  return array_values($merchant);
		else
		  return $merchant;
		//$this->set('merchantids',$merchant);
	}
public function GetProductCountBycategory($cat_id="",$search="",$type="",$sort=""){
//echo $cat_id; print_r($search); echo $type;echo $sort; 
    $this->Product_category = ClassRegistry::init('Product_category'); 
    $this->Product = ClassRegistry::init('Product');
    //echo "sdkfjhsdkjfh";
    $chield=$this->Product_category->children($cat_id) ;
    //print_r($chield);
    $results = Hash::extract($chield, '{n}.Product_category.id');
    array_push($results,$cat_id);
   // print_r($results);
    if($type=="brand")
    {
      if(!empty($results))
      {
        $count=$this->Product->find('count',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.brand'=>$search['slug'],'Product.brand !='=>'','Product.status'=>1)));
       // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));
      }else
      {
        $count=$this->Product->find('count',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$cat_id,'Product.brand'=>$search['slug'],'Product.brand !='=>'','Product.status'=>1)));
       // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));

      }
    }
    else
    {
      $cond=array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.brand !='=>'','Product.status'=>1);
    // echo $sort;

      if(in_array($sort,array('hdiscount','ldiscount')))
      {
         $cond['Product.offer_id !=']=0;
          $cond['Offer.discount !='] = 0;
          //$cond['Offer.discount !=']  = "";
          $cond['Offer.status'] = '1';
          $cond['Offer.end_date >= '] = date('Y-m-d');
      }
      if( isset($search['brand']))
      {
         $cond=array_merge($cond,array('Product_brand'=>$search['brand']));
      }
      if($search['slug']!="")
            {
          
            $slug2=str_replace('-',' ',$search['slug']);
            $slug3=str_replace('-','* ',$search['slug']);
            $slug4="%".str_replace('-','%',$search['slug'])."%";
            $data_cat=$this->getCatIdsBYSlug($slug2);
            $data_brand=$this->getBrandIdsBYSlug1($slug2);
            if(empty($data_brand) and empty($data_cat))
            {
                //$cond['or'][0]=array('Product.brand'=>$data_brand);
                //$cond['or'][1]=array('Product.category_id'=>$data_cat);            
              //  $cond['or'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
              // $cond=array_merge($cond,array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)'));
               $cond['Product.slug like']=$slug4;
            }
            else
            {
              
                   //echo count($countdata);
               /*  function trimssss123($n)
                  {
                      return rtrim($n,'-');
                  }
*/              if(empty($data_brand) and empty($data_cat))
                  {
                    array_push($cond,array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)'));
                  }
                  else
                  {
                    if(!empty($data_brand))
                {
                  $cond['and'][0]=array('Product.brand'=>array_keys($data_brand));
                }
                if(!empty($data_cat))
                {
                   $cond['and'][1]=array('Product.category_id'=>$data_cat);    
                }
                   $countdata=explode(' ', $search['slug']);
                   $slug1=str_replace(' ','-', strtolower(trim($search['slug'])));
                $brandas= array_map("trimssss123", array_values($data_brand));
                if(count($countdata)>1 and !empty($data_brand) and !in_array($slug1,$brandas))
                {
                 $cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                }
                if(count($countdata)>1 and !empty($data_cat))
                {
                   $cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                }
              }
            }
          }
      		/*$slug_split=explode("-",$search['slug']);
              //print_r($slug_split);        
            $sluges=array();
              if(isset($slug_split[0]) and $slug_split[0]!="")
              {
                  
                 $cond=array_merge($cond,array('or'=>array(array('or'=>array()),array('or'=>array()),array('or'=>array()))));
                 
                if(count($slug_split)==1)
                {
                  foreach ($slug_split as $key => $value) {
                   
				   $sluges= '';                
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));   
					//array_push($cond['or'][1]['or'],array('Product_brand.slug like'=>"%". $sluges."%"));  
					//array_push($cond['or'][0]['or'],array('Product_category.slug like'=>"%". $sluges."%"));                   
                	
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
                 }
                }
                else
                {

                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                  // $data_cat=$this->getCatIdsBYSlug($slug);
                //  array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
				
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				
                  }
                 }
                 $slug_split=array_reverse($slug_split);
                 $sluges="";
                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                   //$data_cat=$this->getCatIdsBYSlug($slug);
                  // array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
				  
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				  
                  }
                 }

                }
            }*/

         if(!empty($results))
        {
          $count=$this->Product->find('count',array('conditions'=>$cond));
      // echo "<pre>";print_r($cond); echo $count; echo"</pre>";
         // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));
        }else
        {
          $cond=array('Product.category_id !='=>"",'Product.category_id'=>$cat_id,'Product.brand !='=>'','Product.status'=>1);
            
             $slug2=str_replace('-',' ',$search['slug']);
            $slug3=str_replace('-','* ',$search['slug']);
            $data_cat=$this->getCatIdsBYSlug($slug2);
            $data_brand=$this->getBrandIdsBYSlug1($slug2);
             if(empty($data_brand) and empty($data_cat))
            {
                $cond['or'][0]=array('Product.brand'=>$data_brand);
                $cond['or'][1]=array('Product.category_id'=>$data_cat);            
                $cond['or'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
            }
            else
            {
              if(!empty($data_brand))
                {
                  $cond['and'][0]=array('Product.brand'=>array_keys($data_brand));
                }
                if(!empty($data_cat))
                {
                   $cond['and'][1]=array('Product.category_id'=>$data_cat);    
                }
                   $countdata=explode(' ', $slug);
                   $slug1=str_replace(' ','-', strtolower(trim($slug)));
                   //echo count($countdata);
                   function trimss1($n)
                  {
                      return ltrim(rtrim($n,'-'),'-');
                  }


$brandas= array_map("trimss1", array_values($data_brand));
                if(count($countdata)>1 and !empty($data_brand) and !in_array($slug1,$brandas))
                {
                 $cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                }

                if(count($countdata)>1 and !empty($data_cat))
                {
                   $cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                }
            }
           /* $slug_split=explode("-",$search['slug']);
                
            $sluges=array();
              if(!empty($slug_split))
              {
                 $cond=array_merge($cond,array('or'=>array(array('or'=>array()),array('or'=>array()),array('or'=>array()))));
                if(count($slug_split)==1)
                {
                  foreach ($slug_split as $key => $value) {
                   
				   $sluges= '';                
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));   
					//array_push($cond['or'][1]['or'],array('Product_brand.slug like'=>"%". $sluges."%"));  
					//array_push($cond['or'][0]['or'],array('Product_category.slug like'=>"%". $sluges."%"));                   
                	
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
                 }
                }
                else if(count($slug_split)>1)
                {

                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                  // $data_cat=$this->getCatIdsBYSlug($slug);
                //  array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
				
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				
                  }
                 }
                 $slug_split=array_reverse($slug_split);
                 $sluges="";
                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                   //$data_cat=$this->getCatIdsBYSlug($slug);
                  // array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
				  
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				  
                  }
                 }

                }
            }*/

         if( isset($search['brand']))
          {
             $cond=array_merge($cond,array('Product_brand'=>$search['brand']));
          }
          $count=$this->Product->find('count',array('conditions'=>$cond));
         // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));

        }
    }

  //print_r($count1);
    return $count;
  }
  
  

	// send mail
	public function sendMail($to,$subject,$message,$from)
	{
		// header
		$headers = "From: Hoppay <".$from . ">\r\n"; 
		$headers.= "MIME-Version: 1.0\r\n"; 
		$headers.= "Content-Type: text/html; charset=utf-8\r\n"; 
		$headers.= "X-Priority: 1\r\n"; 
	
		//$content=ereg_replace('{content}',$message,$email_temp);
		$content = $message;
	
		// send mail
		$flag = (mail($to,$subject,$content,$headers) == true)?1:0;
		return $flag;	
	}
	
	public function getUserType($id)
	{
		 $this->Newsletter = ClassRegistry::init('Newsletter');
		 $details = $this->Newsletter->find('first',array('conditions'=>array('Newsletter.id'=>$id)));
		 //echo '<pre>'; print_r($details); echo '</pre>';
		 
		 return $details['Newsletter'];
	}

  /* 
    * Get summary text with "..."
    *     
    * @return it returns the string 
    */ 
 public function summary($str,$limit=100,$strip=false){
        $str=($strip==true)?strip_tags($str):$str;    
        if(strlen($str)>$limit){     
         $str=substr($str,0,$limit-3);     
         return(substr($str,0,strrpos($str,' ')).'...');    
        }    return trim($str); 
     } 
/**
    * Pluralizes English nouns.
    *
    * @access public
    * @static
    * @param    string    $word    English noun to pluralize
    * @return string Plural noun
    */
    function pluralize($word)
    {
        $plural = array(
        '/(quiz)$/i' => '1zes',
        '/^(ox)$/i' => '1en',
        '/([m|l])ouse$/i' => '1ice',
        '/(matr|vert|ind)ix|ex$/i' => '1ices',
        '/(x|ch|ss|sh)$/i' => '1es',
        '/([^aeiouy]|qu)ies$/i' => '1y',
        '/([^aeiouy]|qu)y$/i' => '1ies',
        '/(hive)$/i' => '1s',
        '/(?:([^f])fe|([lr])f)$/i' => '12ves',
        '/sis$/i' => 'ses',
        '/([ti])um$/i' => '1a',
        '/(buffal|tomat)o$/i' => '1oes',
        '/(bu)s$/i' => '1ses',
        '/(alias|status)/i'=> '1es',
        '/(octop|vir)us$/i'=> '1i',
        '/(ax|test)is$/i'=> '1es',
        '/s$/i'=> 's',
        '/$/'=> 's');

        $uncountable = array('equipment', 'information', 'rice', 'money', 'species', 'series', 'fish', 'sheep');

        $irregular = array(
        'person' => 'people',
        'man' => 'men',
        'child' => 'children',
        'sex' => 'sexes',
        'move' => 'moves');

        $lowercased_word = strtolower($word);

        foreach ($uncountable as $_uncountable){
            if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
                return $word;
            }
        }

        foreach ($irregular as $_plural=> $_singular){
            if (preg_match('/('.$_plural.')$/i', $word, $arr)) {
                return preg_replace('/('.$_plural.')$/i', substr($arr[0],0,1).substr($_singular,1), $word);
            }
        }

        foreach ($plural as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }
        return false;

    }

// }}}
    // {{{ singularize()

    /**
    * Singularizes English nouns.
    *
    * @access public
    * @static
    * @param    string    $word    English noun to singularize
    * @return string Singular noun.
    */
  public function singularize($word)
    {
        $singular = array (
        '/(quiz)zes$/i' => '\1',
        '/(matr)ices$/i' => '\1ix',
        '/(vert|ind)ices$/i' => '\1ex',
        '/^(ox)en/i' => '\1',
        '/(alias|status)es$/i' => '\1',
        '/([octop|vir])i$/i' => '\1us',
        '/(cris|ax|test)es$/i' => '\1is',
        '/(shoe)s$/i' => '\1',
        '/(o)es$/i' => '\1',
        '/(bus)es$/i' => '\1',
        '/([m|l])ice$/i' => '\1ouse',
        '/(x|ch|ss|sh)es$/i' => '\1',
        '/(m)ovies$/i' => '\1ovie',
        '/(s)eries$/i' => '\1eries',
        '/([^aeiouy]|qu)ies$/i' => '\1y',
        '/([lr])ves$/i' => '\1f',
        '/(tive)s$/i' => '\1',
        '/(hive)s$/i' => '\1',
        '/([^f])ves$/i' => '\1fe',
        '/(^analy)ses$/i' => '\1sis',
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
        '/([ti])a$/i' => '\1um',
        '/(n)ews$/i' => '\1ews',
        '/s$/i' => '',
        );

        $uncountable = array('equipment', 'information', 'rice', 'money', 'species', 'series', 'fish', 'sheep');

        $irregular = array(
        'person' => 'people',
        'man' => 'men',
        'child' => 'children',
        'sex' => 'sexes',
        'move' => 'moves');

        $lowercased_word = strtolower($word);
        foreach ($uncountable as $_uncountable){
            if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
                return $word;
            }
        }

        foreach ($irregular as $_plural=> $_singular){
            if (preg_match('/('.$_singular.')$/i', $word, $arr)) {
                return preg_replace('/('.$_singular.')$/i', substr($arr[0],0,1).substr($_plural,1), $word);
            }
        }

        foreach ($singular as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }

        return $word;
    }
    /* @access public
    * @static
    * @param    string    $word    Word to format as tile
    * @param    string    $uppercase    If set to 'first' it will only uppercase the
    * first character. Otherwise it will uppercase all
    * the words in the title.
    * @return string Text formatted as title
    */
    function titleize($word, $uppercase = '')
    {
        $uppercase = $uppercase == 'first' ? 'ucfirst' : 'ucwords';
        return $uppercase($this->humanize($this->underscore($word)));
    }

    // }}}
    // {{{ camelize()

    /**
    * Returns given word as CamelCased
    *
    * Converts a word like "send_email" to "SendEmail". It
    * will remove non alphanumeric character from the word, so
    * "who's online" will be converted to "WhoSOnline"
    *
    * @access public
    * @static
    * @see variablize
    * @param    string    $word    Word to convert to camel case
    * @return string UpperCamelCasedWord
    */
    function camelize($word)
    {
        return str_replace(' ','',ucwords(preg_replace('/[^A-Z^a-z^0-9]+/',' ',$word)));
    }

    // }}}
    // {{{ underscore()

    /**
    * Converts a word "into_it_s_underscored_version"
    *
    * Convert any "CamelCased" or "ordinary Word" into an
    * "underscored_word".
    *
    * This can be really useful for creating friendly URLs.
    *
    * @access public
    * @static
    * @param    string    $word    Word to underscore
    * @return string Underscored word
    */
    function underscore($word)
    {
        return  strtolower(preg_replace('/[^A-Z^a-z^0-9]+/','_',
        preg_replace('/([a-zd])([A-Z])/','1_2',
        preg_replace('/([A-Z]+)([A-Z][a-z])/','1_2',$word))));
    }

    // }}}
    // {{{ humanize()

    /**
    * Returns a human-readable string from $word
    *
    * Returns a human-readable string from $word, by replacing
    * underscores with a space, and by upper-casing the initial
    * character by default.
    *
    * If you need to uppercase all the words you just have to
    * pass 'all' as a second parameter.
    *
    * @access public
    * @static
    * @param    string    $word    String to "humanize"
    * @param    string    $uppercase    If set to 'all' it will uppercase all the words
    * instead of just the first one.
    * @return string Human-readable word
    */
    function humanize($word, $uppercase = '')
    {
        $uppercase = $uppercase == 'all' ? 'ucwords' : 'ucfirst';
        return $uppercase(str_replace('_',' ',preg_replace('/_id$/', '',$word)));
    }

    public function getPriceFormat($price)
  {
    $price_symbol = ' SR';
    
    if(strpos($price,$price_symbol) === FALSE)
      return 'SAR '.$price;
    else  
      return $price;  
  }
  
/** 
    * Get the selected language (ex. en or ar)
    *     
    * @return it return the current language if no language are there default language is English(en)
    */ 
    public function getLang() 
    {
         $lang_data=Router::getParams(); 
         return empty($lang_data['lang'])?"en":$lang_data['lang'];      
    }

	public function languageChanger($prodLang)
	{
		if(count($prodLang)==1)
		{
		  $data = $prodLang[0];
		   return $data;
		}
		else
		{
      // print_r($this->here);
		  $lang=$this->getLang();
		 // echo  $lang.'===';
		  if($lang=='en')
		  {
			$data = $prodLang[0];
			return $data;
		  }
		  else
		  {
			$data = $prodLang[1];
		//	echo '<pre>'; print_r($data); echo '</pre>';
			return $data;
		  }
	
		}
	}
	public function getProductTitle($pid)
	{
		$this->Product = ClassRegistry::init('Product');	
		$result = $this->Product->Find('first', 
								array(
								'conditions'=>array(
									'Product.id'=>$pid
								)
							)
						); 
		if(isset($result['Product_lang'][0]))
			return stripslashes($result['Product_lang'][0]['title']);
			
		if(isset($result['Product_lang']) && empty($result['Product_lang'][0]))
			return stripslashes($result['Product_lang']['title']);
	}
	public function getMerchantName($mid)
	{
		$this->Merchant = ClassRegistry::init('Merchant');	
		$result = $this->Merchant->Find('first', 
								array(
								'conditions'=>array(
									'Merchant.id'=>$mid
								)
							)
						); 
						
		//echo '<pre>'; print_r($result); echo '</pre>';				
		return stripslashes($result['Merchant']['first_name']).' '.stripslashes($result['Merchant']['last_name']);
	}
	
	public function getProductBrands($cond,$select_brand)
	{
		$this->Product = ClassRegistry::init('Product');
		$this->Product_brand = ClassRegistry::init('Product_brand');
		
		$brandids = '';
			
		$brandids = $this->Product->find('all', array(	  
					
									   
						'conditions' => $cond ,
						//'group' =>'Product.brand',
						//'order' =>array('product_count'=>'desc')
						
					));			
					//print_r( $cond );
    //echo count($brandids);
           if(!empty($brandids))
      {
         $data=array();
         foreach($brandids  as $key=>$brandid)
         {
          if(!isset($data[$brandid['Product_brand']['slug']]))
          {
            $data[$brandid['Product_brand']['slug']]=array();
            $data[$brandid['Product_brand']['slug']]['id']=$brandid['Product_brand']['id'];
            $data[$brandid['Product_brand']['slug']]['products']=array();
           $data[$brandid['Product_brand']['slug']]['detail']=array();
            
          }
          $data[$brandid['Product_brand']['slug']]['products']=array_merge($data[$brandid['Product_brand']['slug']]['products'],array($brandid['Product']['id']));
          $data[$brandid['Product_brand']['slug']]['detail']=array_merge($data[$brandid['Product_brand']['slug']]['detail'],array($brandid['Product_brand']));
         }
       }
       //print_r($data);
		  $brandlist = '';			
		  if(!empty($data))
		  {
			   $i = 0;
			   foreach($data  as $key=>$val)
			   {
					$brandlist[$i] = $val['detail'][0];
					$brandlist[$i]['product_count'] = count($val['products']); 
					
					$product_brand_lang =  $this->Product_brand->Product_brand_lang->find('all', array(
												'fields' => 'Product_brand_lang.*', 
												'conditions'=>array(
													'Product_brand.id'=>$val['id']
												)
											)); 
					if(count($product_brand_lang)>1)
					{
						$brand_lang[0] = $product_brand_lang[0]['Product_brand_lang'];
						$brand_lang[1] = $product_brand_lang[1]['Product_brand_lang'];
					}
					else
					{
						$brand_lang[0] = $product_brand_lang[0]['Product_brand_lang'];
					}
					$brand_name = $this->languageChanger($brand_lang);
					$brandlist[$i]['brand_name'] = $brand_name['brand_title'];;
					if($select_brand==$val['id'])
					{
						$brandlist[$i]['checked']=true;
					}
					else
					{
						$brandlist[$i]['checked']=false;
					}
					$i++;
			   }
		  }	
     // print_r($brandlist);
		  return $brandlist;		
	}
	
	
	public function getProductSellers($cond,$select_merchant)
	{
		$this->Product = ClassRegistry::init('Product');
		
		$merchant_ids = '';
			
		$merchant_ids = $this->Product->find('all', array(
	  
						'fields' => array(
						
							'Merchant.*',
							
						),
									   
						'conditions' => $cond ,
						'group' =>'Product.retailer_id',
						//'order' =>array('product_count'=>'desc')
						
					));			

		  $merchant_list = '';			
		  if(!empty($merchant_ids))
		  {
			   $i = 0;
			   foreach($merchant_ids  as $merchant_id)
			   {
					$merchant_list[$i] = $merchant_id['Merchant'];
					
					if($select_merchant==$merchant_id['Merchant']['id'])
					{
						$merchant_list[$i]['checked']=true;
					}
					else
					{
						$merchant_list[$i]['checked']=false;
					}
					$i++;
			   }
		  }	
		  return $merchant_list;		
	}
	public function getProductMinMaxPrice($cond)
	{
		$this->Product = ClassRegistry::init('Product');
		
		$cdate = date('Y-m-d');
		
		$minmaxprice = $this->Product->find('all', array(
						'fields' => array(
						
							'(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then min(Product.price-((Product.price * Offer.discount)/100)) else min(Product.price) end) as min',
							'(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then max(Product.price-((Product.price * Offer.discount)/100)) else max(Product.price) end) as max',
						),
						'conditions' => $cond 
					));
		return  $minmaxprice[0][0];
	}
	public function getDiscountAndNondiscountCounts($cond)
	{
		$this->Product = ClassRegistry::init('Product');
		
		$cdate = date('Y-m-d');
		
		$result = $this->Product->find('all', array(
						'fields' => array(
						
							//'count(Product.id) as total',
							'sum(case when (Product.offer_id = 0 or Offer.end_date < "'.$cdate.'" or Offer.status=0) then 1 else 0 end) noncount',
							'sum(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then 1 else 0 end) count',
						),
						'conditions' => $cond 
					));
					
		//echo '<pre>'; print_r($result); exit;			
		return  $result[0][0];
	}
	
	public function getAttributes($cond,$lang=0)
	{
		$this->Product = ClassRegistry::init('Product');
		$products = $this->Product->find('all', array(
	  
						'fields' => array(
						
							'Product.id',							
							//'count(Product.id) as product_count'
							
						),
									   
						'conditions' => $cond ,
						//'group' =>'Product.category_id',
						//'order' =>array('product_count'=>'desc')
						
					));	
					//print_r($cond);
         $attr_prod_details=array();
         $lang=$this->getLang();
         foreach ($products as $key => $value) {
         // $product_details_first=trim('"',);
         // $prod_details=$this->languageChanger($value['Product_lang']);
          $attr_prod=$value['Product_lang'][0]['product_details'];
         // echo $attr_prod;
            if($attr_prod)
            {
              if($lang!="en")
              {
                $attr_prod_ar=isset($value['Product_lang'][1])?$value['Product_lang'][1]['product_details']:"";
              }
              if($attr_prod_ar!="")
              {
                 $product_details_ar=htmlspecialchars_decode($attr_prod_ar); 
                 $product_details_ar=json_decode($product_details_ar);
              }
              $product_details=htmlspecialchars_decode($attr_prod);             
              $product_details=json_decode($product_details);
              /*echo"---Eng----<br>";
              echo "<pre>";print_r($product_details);echo "</pre>";
              echo"---Arabic----<br>";
              echo "<pre>";print_r($product_details_ar);echo "</pre>";
              echo"-------<br>";*/
             foreach ($product_details as $k => $val) {

                 $attr=strtolower(trim($k));
                 //echo $val."-<br>";
                 //$attr=$this->pluralize($attr);
                // $attr=str_replace(" ", "%20",$attr);
                 $path=array('color'=>'اللون','size'=>'حجم','memorie'=>'الذاكرة','screen'=>"الشاشة",'ram'=>"رام",'resolution'=>'قرار','cpu'=>'وحدة المعالجة المركزية','megapixel'=>"ميجابيكسل",'screen size'=>'حجم الشاشة','hard disk'=>'القرص الثابت','digital camera'=>"كاميرا رقمية",'optical zoom'=>'زوم بصري','type'=>'نوع');
                   if($attr!="Brand")
                   {
                      if(in_array($attr,array('color','size','memorie','screen','ram','resolution','cpu','megapixel','screen size','hard disk capacitie','digital camera type','optical zoom','type')))
                     {

                       if(!isset($attr_prod_details[$attr]))
                       {
                         $attr_prod_details[$attr]=array();
                       }   
                       $sort_val=strtolower(trim(is_numeric($val)?"'".$val."'":$val));
                      // echo $sort_val;
                       if(!isset($attr_prod_details[$attr][$sort_val]))
                       {
                        //echo $sort_val."-<br>";
                        $attr_prod_details[$attr]=array_merge($attr_prod_details[$attr],array($sort_val=>array('ar'=>isset($product_details_ar->$k)?$product_details_ar->$k:"",'count'=>0,'product_id'=>array())));

                       }
                       array_walk($attr_prod_details[$attr],array($this,"sortUniceAndGetCount"),array($sort_val,$value['Product_lang'][0]['product_id']));
                       // echo "<pre>";print_r($attr_prod_details);echo "</pre>";
                       $attr_prod_details[$attr]=array_filter($attr_prod_details[$attr]);
                     }  
                  }  
               
             }
           }
        }
        
     // echo "<pre>";print_r($attr_prod_details);echo "</pre>";
        $new_sort_data=array();
        $i=0;
        foreach ($attr_prod_details as $key => $value) {
          if(!empty($value))
          {
            $j=0;
          $new_sort_data[$i]=array('tslug'=>$this->camelize(ucfirst(str_replace("'",'',trim($key)))),'title'=>($lang=="en")?ucfirst(str_replace("'",'',trim($key))):$path[str_replace("'",'',trim($key))],'children'=>array());
          foreach ($value as $k => $val) {
              if($val['count']!=0)
              {             
                 array_push($new_sort_data[$i]['children'],array('id'=>($i.$j),'item'=>($lang=="en")?str_replace("'",'',trim($k)):$val['ar'],'slug'=>$this->camelize(str_replace(' ','_',$k)),'checked'=>false,'count'=>$val['count'],'product_id'=>$val['product_id']));
                //print_r($new_sort_data[$i]['children']);
                 
              }
              if(empty($new_sort_data[$i]['children']))
                 {
                    unset($new_sort_data[$i]);
                 }
               $j++;
          }
          $i++;

          }
        }
	// echo '<pre>'; print_r($new_sort_data); 
		return $new_sort_data;
	}
	
      private function sortUniceAndGetCount(&$v,$k,$cond){
         // print_r($v);
          if($k==$cond[0])
          {
            ++$v['count'];
              $v['product_id']=array_merge($v['product_id'],(array)$cond[1]);
          }
          //echo $cond;
      }
         private function getBrandIdsBYSlug($slug)
		 {
			$this->Product_brand = ClassRegistry::init('Product_brand'); 
			$data_brand_id = '';
			  
			  $data_brand_id=$this->Product_brand->find('list',
													  array(
														  'conditions'=>array(
															  'TRIM(BOTH "-" FROM Product_brand.slug) like'=>"%".str_replace(' ','%',$slug)."%",
                               /* array('MATCH (Product_brand.slug) AGAINST ("+'.$slug.'" IN BOOLEAN MODE)'),*/
															  'Product_brand.status'=>1
														  ),
													  	'fields'=>array(
													  		'Product_brand.id'
													  
													  	)
													  ));
				return $data_brand_id;									  
		 }
     private function getDirectBrandId($slug)
     {
    
      $this->Product_brand = ClassRegistry::init('Product_brand'); 
       $data_brand_id=$this->Product_brand->Product_brand_lang->find('all',
                            array('fields'=>array('Product_brand_lang.brand_id'),
                              'conditions'=>array(

                              ' TRIM(BOTH " " FROM Product_brand_lang.brand_title) like'=>trim($slug),

                              $cond,
                                'Product_brand.status'=>1
                              )
                             
                            ));
       $data_brand_id=Hash::extract($data_brand_id,'{n}.Product_brand_lang.brand_id');

        return array_values(array_unique($data_brand_id)); 

     }
        private function getBrandIdsBYSlug1($slug)
     {
      $this->Product_brand = ClassRegistry::init('Product_brand'); 
     
         $data_brand_id = '';
        //echo $slug;
             
                $cond['or']=array('MATCH (Product_brand_lang.brand_title) AGAINST ("+'.$slug.'*" IN BOOLEAN MODE)');
              
                $cond['or']['TRIM(BOTH "-" FROM Product_brand_lang.brand_title) like']="".str_replace(' ','%',$slug)."%";
              
              
        $data_brand_id=$this->Product_brand->Product_brand_lang->find('all',
                            array('fields'=>array('Product_brand_lang.brand_id'),
                              'conditions'=>array(

                               //' TRIM(BOTH "-" FROM Product_brand.slug) like'=>"".str_replace(' ','%',$slug)."%",

                              $cond,
                                'Product_brand.status'=>1
                              )
                             
                            ));
       /* $data_brand_id=$this->Product_brand->find('list',
                            array(
                              'conditions'=>array(
                                'TRIM(BOTH "-" FROM Product_brand.slug) like'=>"".str_replace(' ','%',$slug)."%",
                                array('MATCH (Product_brand.slug) AGAINST ("+'.$slug.'" IN BOOLEAN MODE)'),
                                'Product_brand.status'=>1
                              ),
                              'fields'=>array(
                                'Product_brand.id',
                                'Product_brand.slug'
                            
                              )
                            ));*/ 
$data_brand_id=Hash::extract($data_brand_id,'{n}.Product_brand_lang.brand_id');
//print_r($data_brand_id);
        return array_values($data_brand_id);                   
     }
		 
         private function getCatIdsBYSlug($slug)
		 {
			  $this->Product_category = ClassRegistry::init('Product_category'); 
			  $data_cat_id=$this->Product_category->find('all',
													  array(
														  'conditions'=>array(
															 'TRIM(BOTH "-" FROM Product_category.slug) like'=>"".str_replace(' ','%',$slug)."%",
                                //'MATCH (TRIM(BOTH "-" FROM Product_category.slug)) AGAINST ("+'.$slug.'" IN BOOLEAN MODE)',
															  'Product_category.status'=>1
														  ),
													  	'fields'=>array(
													  		'Product_category.id'
													  
													  	)
													  ));
                 $data_cat_ids=Hash::extract($data_cat_id,'{n}.Product_category.id');
                
                 $data_cat=array();
                 foreach ($data_cat_ids as $key => $value) {
                    $data_id = $this->Product_category->children($value);
                    // print_r($data_id);
                   $cat_ids= Hash::extract($data_id,'{n}.Product_category.id');
                   array_push($cat_ids,$value);
                    $data_cat= array_merge($data_cat,$cat_ids);
                 }
               
                 $data_cat=array_values(array_unique($data_cat));
				 return $data_cat;
         }
    		 public function getWord($word)
          {
           include('../Vendor/language.php');
            $lang=$this->getLang();
            if($lang=='en')
            {
              $data = $english_data[$word];  
            }
            else
            {
              $data = $arabic_data[$word];  
            }
            if(!empty($data))
            {
            return $data;  
            }
            else
            {
              return $word;
            }
          }
          public function getReviewText($count){
            if($count<=1)
            {
              return $count." ".$this->getWord('review');
            }
            else
            {
              return $count." ".$this->getWord('reviews');
            }
          }
           public function getSellerText($count){
              if($count<=1)
              {
                return $count." ".$this->getWord('seller');
              }
              else
              {
                return $count." ".$this->getWord('sellers');
              }
           }
           public function createConditions($slug="",$list_data="",$cats=array()){
            $list_data=array_values(array_unique($list_data));
            $cond=array('Product.category_id !='=>'',
                      'Product.brand !='=>'',
                      'Product.status'=>1
                    );
            if(!empty($cats))
            {
              $cond['Product.category_id']=$cats;
            }
            
           // $slug3=preg_replace('/*/', '', $slug3, 1);
              $data=explode("-",$slug);
            // print_r( $data);
            $direct_brand_id=$this->getDirectBrandId($data[0]);

           //print_r($direct_brand_id);
            if(empty($direct_brand_id))
            {
              //echo $data[count($data)-1];
              $direct_brand_id=$this->getDirectBrandId($data[count($data)-1]);
            //  print_r($direct_brand_id);
              if(empty($direct_brand_id))
              {
                $slug2=str_replace('-',' ',$slug);
                $slug3=str_replace('-','* ',$slug);
               $data_cat=$this->getCatIdsBYSlug($slug);
               $data_brand=$this->getBrandIdsBYSlug1($slug2);
             //  print_r($data_brand);
                if(empty($data_brand) and empty($data_cat))
                {
                    $cond['or'][0]=array('Product.brand'=>$data_brand);
                    $cond['or'][1]=array('Product.category_id'=>$data_cat);            
                    //$cond['or'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                    $cond['or'][2]=array('Product.id'=>$list_data);
                }
               else if(!empty($data_brand))
                    {
                      $cond['or'][0]=array('Product.brand'=>$data_brand);
                      $cond['or'][1]=array('Product.id'=>$list_data);  
                    }
               else if(!empty($data_cat))
                  {
                     $cond['or'][0]=array('Product.category_id'=>$data_cat); 
                     $cond['or'][1]=array('Product.id'=>$list_data);   
                  }
               else
                {

                      $countdata=explode(' ', $slug);
                      $slug1=str_replace(' ','-', strtolower(trim($slug)));
                       //echo count($countdata);
                      function trims($n)
                      {
                          return ltrim(rtrim($n,'-'),'-');
                      }


                     $brandas= array_map("trims", array_values($data_brand));
                     //print_r($brandas);
                    if(!empty($data_brand) and !in_array($slug1,$brandas))
                    {
                     //$cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                      $cond['and'][2]=array('Product.id'=>$list_data);
                    }
                     if(count($countdata)>1 and !empty($data_cat))
                    {
                       //$cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                      $cond['and'][2]=array('Product.id'=>$list_data);
                    }
                }
              }
              else
              {
                unset($data[count($data)-1]);
                $data=implode("-", $data);
               // $slug2=str_replace(" ", '-', $data);
                $cond['Product.brand']=$direct_brand_id;
                 $data_cat=$this->getCatIdsBYSlug($data);
                 if(!empty($data_cat))
                $cond['Product.category_id']=$data_cat;
                if(!empty($list_data))
                $cond['or']=array('Product.id'=>$list_data);   
               
              }
            }else
            {
               unset($data[0]);
                $data=implode("-", $data);
               // $slug2=str_replace(" ", '-', $data);
                $cond['Product.brand']=$direct_brand_id;
                $data_cat=$this->getCatIdsBYSlug($data);
                if(!empty($data_cat))
                $cond['Product.category_id']=$data_cat;
                if(!empty($list_data))
                $cond['or']=array('Product.id'=>$list_data);  
              // $data_cat=$this->getCatIdsBYSlug($slug2);

            }
          // print_r($cond);
            
return $cond;
           }
}