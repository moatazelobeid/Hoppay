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
    public function getMerchantDetailsByProduct($id="",$slug="",$type="count",$lang_id=1)/*(all|count)*/
{
  $this->Product = ClassRegistry::init('Product');
  $product=$this->Product->Product_lang->find('first',array('conditions'=>array('Product.id'=>$id,'Product.slug like '=>$slug,'Product_lang.lang_id'=>$lang_id)));
  $cond=array('Product.slug like'=>"%". str_replace('-','%',$slug)."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']);
 /*  $slug_split=explode("-",$slug);
            $sluges=array();
              if(!empty($slug_split))
              {
                $cond=array_merge($cond,array('or'=>array()));
                 foreach ($slug_split as $key => $value) {
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'],array('Product.slug like'=>"%". $sluges."%"));
                 }
            }
  */

  $merchant=$this->Product->find($type,array('conditions'=>$cond ));
       if($type=="all")
       {
       $cdate=date('Y-m-d');
       foreach($merchant as $key=>$val)
           {
              if(($val['Offer']['status'] == 1) && ($val['Offer']['end_date']!='0000-00-00 00:00:00') && ($val['Offer']['end_date'] >= $cdate)) 
              {
               $merchant[$key]['Product']['offer_price']=($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100));
                $merchant[$key]['Product']['offer_percent']=isset($val['Offer']['discount'])?$val['Offer']['discount']:0;
              }
              else{
                $merchant[$key]['Product']['offer_price']=$val['Product']['price'];
                $merchant[$key]['Product']['offer_percent']=0;
              } 
              
               if(!empty($val['Product_review']))
               {
                $res=Hash::extract($val['Product_review'], '{n}.rating'); 
               // print_r($res);            
                $merchant[$key]['Product']['reate_count']= (array_sum($res)/count($res));
               }else
               {
                $merchant[$key]['Product']['reate_count']=0;
               }

           }
       $results = Hash::extract($merchant, '{n}.Product.offer_price');
     }
     
      return $merchant;
     
      //echo "<pre>";print_r($merchant);echo "</pre>";
        //$this->set('merchantids',$merchant);
}
public function GetProductCountBycategory($cat_id="",$search="",$type=""){
    $this->Product_category = ClassRegistry::init('Product_category'); 
    $this->Product = ClassRegistry::init('Product');
    //echo "sdkfjhsdkjfh";
    $chield=$this->Product_category->children($cat_id) ;
  //  print_r($chield);
    $results = Hash::extract($chield, '{n}.Product_category.id');
    array_push($results,$cat_id);
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
      if( isset($search['brand']))
      {
         $cond=array_merge($cond,array('Product_brand'=>$search['brand']));
      }
      $slug_split=explode("-",$search['slug']);
            $sluges=array();
              if(!empty($slug_split))
              {
                $cond=array_merge($cond,array('or'=>array()));
                 foreach ($slug_split as $key => $value) {
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'],array('Product.slug like'=>"%". $sluges."%"));
                 }
            }
         if(!empty($results))
        {
          $count=$this->Product->find('count',array('conditions'=>$cond));
         // print_r($cond);
         // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));
        }else
        {
          $cond=array('Product.category_id !='=>"",'Product.category_id'=>$cat_id,'Product.brand !='=>'','Product.status'=>1);
            $slug_split=explode("-",$search['slug']);
            $sluges=array();
              if(!empty($slug_split))
              {
                $cond=array_merge($cond,array('or'=>array()));
                 foreach ($slug_split as $key => $value) {
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'],array('Product.slug like'=>"%". $sluges."%"));
                 }
            }
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
		// To send HTML mail, the Content-type header must be set
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= 'From: '.$from . "\r\n";
		$headers .= "From: Broker Vision <".$from.">\r\n";
	
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
        return $price.' SR';
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
}