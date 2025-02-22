<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

//App::import('Vendor', 'language');

/*App::uses('Folder', 'Vendor');
App::uses('File', 'language');*/

class TemplateHelper extends AppHelper 
{
    public $helpers = array('Html');      
    /** 
    * get template file name
    *  
    * @return template names for template folder.
    */ 
    public function getTemplateFilename(){ 
        $tempalate_name=array();
        $dir = new Folder(APP.'View/Templates');
        $files = $dir->find('.*\.ctp');
        foreach ($files as $file) {
            if(!stripos($file," "))
            {
        array_push($tempalate_name,array('Tname'=>ucfirst(str_replace("_"," ", str_replace(".ctp","",$file))),'Tfile'=>str_replace(".ctp","",$file)));
            }
            
        }      
        return   $tempalate_name; 

    }     
    /** 
    * Get selected="selected" in <select> or checked="checked" in checkbox or redio
    * 
    * @param $check - whcich you want to chack
    * @param $data- it is the dinamic data compare with $check parameter  
    * @param $cond- whchich type of option you want to selected 
    *               if you wantto selected="selected" then pass selected
    *               if you want checked="checked" then checked
    * @return return selected="selected" 
    *         or checked="checked" as per your condition by $cond param
    */ 
    public function Select($check,$data,$cond="selected"){
       
          $check=(isset($check) and $check!="")?$check:'';
          $data=(isset($data) and $data!="")?$data:"";
          if($check!="" and $data!="" and $check==$data)
           {
             if($cond=="selected")
             {
             return "selected='selected'";
             }
             else if($cond=="checked")
             {
                  return "checked='checked'";
             }
           }
        

    }
   
    /** 
    * URL creater (USED: Admin)
    *     
    * @return it will return the yourl as ur need
    */ 
    public function CreateParamJs($url,$params,$getdata,$val=""){       
        $getdata['msg']=$val;
        return $this->Html->url(array_merge($url, $params,array('?'=>$getdata)));
    }


    /** 
    * Get the selected language (ex. en or ar)
    *     
    * @return it return the current language if no language are there default language is English(en)
    */ 
    public function getLang() 
    {
         return empty($this->params['lang'])?"en":$this->params['lang'];      
    }

    /** 
    * create fronend language dependent URL
    *     
    * @return the url with language.
    */ 
    public function CreateParamLink($url,$params=array(),$getdata=array()){   
               $url['lang']=empty($this->params['lang'])?"en":$this->params['lang'];           
               return $this->Html->url(array_merge($url, $params,array('?'=>$getdata)),true);
               //return $this->Html->url("/".$url['lang']."/".$url['controller'].'/'.$url['action']);
    }
     public function CreateParamLink1($url,$params=array(),$getdata=array()){   
               $url['lang']=empty($this->params['lang'])?"en":$this->params['lang'];           
               //return $this->Html->url(array_merge($url, $params,array('?'=>$getdata)),true);
               return $this->Html->url("/".$url['lang']."/".$url['controller'].'/'.$url['action']);
    }

    /** 
    * create dinamic slug here 
    *     
    * @return 
    */ 
   public function toAscii($str, $replace=array(), $delimiter='-') {
     setlocale(LC_ALL, 'en_US.UTF8');
    if( !empty($replace) ) {
        $str = str_replace((array)$replace, ' ', $str);
    }

    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
   }

 /* 
    * Get summary text with "..."
    *     
    * @return it returns the string 
    */ 
 public function summary($str,$limit=100,$strip=false){
        if($this->getLang()!="en"){
          mb_internal_encoding("UTF-8");
           $str=($strip==true)?strip_tags($str):$str;    
          if(strlen($str)>$limit){     
           $str=mb_substr($str,0,$limit-3);     
           return(mb_substr($str,0,strrpos($str,' ')).'...');    
             }    return trim($str); 
        }else
        {
           $str=($strip==true)?strip_tags($str):$str;    
           if(strlen($str)>$limit){     
               $str=substr($str,0,$limit-3);     
               return(substr($str,0,strrpos($str,' ')).'...');    
           }   
           return trim($str); 
        }
 
       
     } 
  public function getControllerName($cond=""){
   
   return strtolower(str_replace('Controller', "", $cond));
  }
  
	
	
	public function getChidren($result='')
	{
		$data = '';	$i =0;
		$total = count($result);
		if(!empty($result))
		{
			foreach($result as $rescat)
			{
				$i++;
				$countprod="(".$this->GetProductCountBycategory($rescat['Product_category']['id']).")";
				if($i == 1)
				{
					if($rescat['Parent']['parent_id'] == 0)
					{
						$data .= '<ul>';	
					}
					else
					{
						$data .= '<ul class="hidepanel">';	
					}
				}
					
				$catname = stripslashes($rescat['Product_category_lang'][0]['category_name']);
				$catslug = $rescat['Product_category']['slug'];
				
				if(strlen($catname) > 30) 
					$dcatname = substr($catname,0,30).'..';
				else
					$dcatname = $catname;
					
				$ctitle_link = '<a href="'.$this->webroot.'products/category-'.$catslug.'" >
                                                          '.$catname.' '.$countprod.'</a>';

        //$this->Html->link($dcatname,array('controller' => 'homes','action' => 'productlist','type'=>$catslug,'full_base' => true));
				
				if(!empty($rescat['children'])) 
				{
					
					$data .= '<li class="has_child"><span></span>';
					$data .= '<a href="javaScript:void(0);">'.$dcatname.' '.$countprod.'</a>';
					$data .= $this->getChidren($rescat['children']);
					$data .= '</li>';	
				}	
				else
				{
					$data .= '<li>'.$ctitle_link.'</li>';	
				}
				if($i == $total)
					$data .= '</ul>';	
			}
		}
		return $data;
	}
	public function menuCreater($menuList=array(),$auth="")
  {
    $data = ''; 
    $total = count($menuList);
    if(!empty($menuList))
    {
      
      foreach ($menuList as $key => $value) {
        $i=$key+1;
        if($i==1)
        {         
            $data .= '<ul>';
         
        }
        $active="";
        if(($this->params['controller']==$value['Menu']['menu_controller']) and ($this->params['action']==$value['Menu']['menu_action']))
        {
          $active="active";
        }
          $ctitle_link = "<a class='".$active."' href='".$this->webroot.$this->getLang().'/'.$value['Menu']['menu_controller'].'/'.$value['Menu']['menu_action'] ."'>".$value['Menu_lang'][0]['menu_title']."</a>";
          if(((!in_array($value['Menu']['menu_access'],array(1,4))) and $auth=="") or ($value['Menu']['menu_access']==4 and $auth!=""))
            continue;
            if(!empty($value['children'])) 
            {
              
              $data .= '<li>';
              $data .= $ctitle_link;
              $data .= $this->menuCreater($value['children'],$auth);
              $data .= '</li>'; 
            } 
            else
            {
              $data .= '<li>'.$ctitle_link.'</li>'; 
            }
          

        if($i == $total)
          $data .= '</ul>';

      }
    }
    return $data;
  }
  
	public function getProductPrice($price='',$offer)
	{
		$result = '';
		$cdate = date('Y-m-d');
		//print_r($offer);exit;
		
		if(!empty($price))
		{
			if(!empty($offer))
			{
				if(($offer['status'] == 1) && ($offer['end_date']!='0000-00-00 00:00:00') && ($offer['end_date'] >= $cdate)) 
				{
					if(!empty($offer['discount']))
					{
						$discount_price	= ($price*$offer['discount'])/100; 
						$sell_price = $price - $discount_price;
						if($sell_price < 0)
						{
							$sell_price = '0.00';	
						}
						$result .= '<s>'.$this->getPriceFormat(number_format($price,2)).'</s>'; 	
						$result .= '<b>'.$this->getPriceFormat(number_format($sell_price,2)).'</b>'; 	
					}
					else
					{
						$result .= '<b>'.$this->getPriceFormat(number_format($price,2)).'</b>'; 	
					}
				}
				else
				{
					$result .= '<b>'.$this->getPriceFormat(number_format($price,2)).'</b>'; 	
				}
			}
			else
			{
				$result .= '<b>'.$this->getPriceFormat(number_format($price,2)).'</b>'; 		
			}
		}
		else
		{
			$result .= '<b>'.$this->getPriceFormat(number_format($price,2)).'</b>'; 	
		}
		
		echo $result; 
	}
	
 
public function getProductPriceList($price='',$offer)
  {
    $result = '';
    $cdate = date('Y-m-d');
    //print_r($offer);exit;
    
    if(!empty($price))
    {
      if(!empty($offer))
      {
        if(($offer['status'] == 1) && ($offer['end_date']!='0000-00-00 00:00:00') && ($offer['end_date'] >= $cdate)) 
        {
          if(!empty($offer['discount']))
          {
            $discount_price = ($price*$offer['discount'])/100; 
            $sell_price = $price - $discount_price;
            if($sell_price < 0)
            {
              $sell_price = '0.00'; 
            }
            $result .= '<span class="msrp-value" style="position:inherit!important; float:left;padding-left: 0; padding-top:7px;background-image: url('.$this->webroot.'images/front-end/pricetotal.png);
background-repeat: no-repeat;padding-left: 31px;background-size: 21px;background-position: 5px 4px;
">'.$this->getPriceFormat(number_format($price,2)).'</span>';   
            $result .= '<div class="listprice" style="float:left;margin-top: 3px;"><b>'.$this->getPriceFormat(number_format($sell_price,2)).'</b></div>';  
          }
          else
          {
            $result .= '<div class="listprice" style="float:left;margin-top: 3px;"><b>'.$this->getPriceFormat(number_format($price,2)).'</b></div>';   
          }
        }
        else
        {
          $result .= '<div class="listprice" style="float:left;margin-top: 3px;"><b>'.$this->getPriceFormat(number_format($price,2)).'</b></div>';   
        }
      }
      else
      {
        $result .= '<div class="listprice" style="float:left;margin-top: 3px;"><b>'.$this->getPriceFormat(number_format($price,2)).'</b></div>';     
      }
    }
    else
    {
      $result .= '<div class="listprice" style="float:left;margin-top: 3px;"><b>'.$this->getPriceFormat(number_format($price,2)).'</b></div>';   
    }
    
    echo $result; 
  }
  
  public function GetTagesByKey($key="",$class="",$language=1)
  {
     $this->Tag = ClassRegistry::init('Tag');
     $data= $this->Tag->Tag_lang->find('first',array('conditions'=>array('Tag.slug'=>$key)));   
     $array_data=json_decode(stripslashes($data['Tag_lang']['tags']));   
      foreach ($array_data as $key => $value) {
        echo "<li>".$value."</li>";
      }
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
    $count=$this->Product->find('count',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.brand'=>$search,'Product.brand !='=>'','Product.status'=>1)));
   // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));
  }else
  {
    $count=$this->Product->find('count',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$cat_id,'Product.brand'=>$search,'Product.brand !='=>'','Product.status'=>1)));
   // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));

  }
    }
    else
    {
   if(!empty($results))
  {
    $count=$this->Product->find('count',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));
   // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));
  }else
  {
    $count=$this->Product->find('count',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$cat_id,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));
   // $count1=$this->Product->find('all',array('conditions'=>array('Product.category_id !='=>"",'Product.category_id'=>$results,'Product.slug like'=>'%'.str_replace("-", "%", $search).'%','Product.brand !='=>'','Product.status'=>1)));

  }
    }

  //print_r($count1);
    return $count;
  }
public function getTagLine($class="")
{
   $lang = $this->getLang();
   $this->Tagline = ClassRegistry::init('Tagline');
   $res= $this->Tagline->findByStatus(1);
   
   if($lang == 'en')
   {
	   return "<span class='".$class."' style='color:#".$res['Tagline']['color_code']."'> ".$res['Tagline']['tag_line']."</span>";
   }
   else
   {
	   if(!empty($res['Tagline']['tag_line_ar']))
	  	 return "<span class='".$class."' style='color:#".$res['Tagline']['color_code']."'> ".$res['Tagline']['tag_line_ar']."</span>";
   }
}

public function getMerchantDetailsByProduct($id="",$slug="",$type="count",$lang_id=1)/*(all|count)*/
{
  $this->Product = ClassRegistry::init('Product');
  $product=$this->Product->Product_lang->find('first',array('conditions'=>array('Product.id'=>$id,'Product.slug'=>$slug,'Product_lang.lang_id'=>$lang_id),'recursive' => -1 ));

  $merchant=$this->Product->find($type,array('conditions'=>array('Product.slug like'=>$slug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand'])));
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

	public function getCategoryChidren($id)
	{
		$this->Product_category = ClassRegistry::init('Product_category');	
		$product_categories = $this->Product_category->Find('all', 
								array(
								'conditions'=>array(
									'Product_category.parent_id'=>$id,
									/*'Product_category.status'=>1,*/
									//'Product_brand_lang.lang_id'=> $langid
								),
								'order' => array('Product_category.cat_order'=>'asc'),
								//'limit'=>9
							)
						); 
		return $product_categories;
	}
  
	public function getAdminCategoryChidren($id,$lang_id)
	{
		$this->Product_category = ClassRegistry::init('Product_category');	
		//$this->Product_category = ClassRegistry::init('Product_category');	
		$product_categories = $this->Product_category->Product_category_lang->Find('all',
		
								array(
								'conditions'=>array(
									'Product_category.parent_id'=>$id,
									//'Product_category.status'=>1,
									//'Product_category_lang.lang_id'=> $langid
								),
								'order' => array('Product_category.cat_order'=>'asc'),
								//'limit'=>9
							)
						); 
		//print_r($product_categories);
		return $product_categories;
	}
  
	public function getOfferProductPrice($price='',$offer)
	{
		$result = '';
		$cdate = date('Y-m-d');
		//print_r($offer);exit;
		
		if(!empty($price))
		{
			if(!empty($offer))
			{
					if(!empty($offer['discount']))
					{
						$discount_price	= ($price*$offer['discount'])/100; 
						$sell_price = $price - $discount_price;
						if($sell_price < 0)
						{
							$sell_price = '0.00';	
						}
						
						$result_price = $sell_price; 	
					}
					else
					{
						$result_price = $price; 	
					}
			}
			else
			{
				$result_price = $price; 	
			}
		}
		else
		{
			$result_price = $price; 	
		}
		
		$result .= '<b>'.$this->getPriceFormat(number_format($result_price)).'</b>'; 
		
		return $result; 
	}
	
	public function getRivewUserDetails($user_id)
	{
		$this->Reviewed_user = ClassRegistry::init('Reviewed_user');	
		$result = $this->Reviewed_user->Find('first', 
								array(
								'conditions'=>array(
									'Reviewed_user.id'=>$user_id
								)
							)
						); 
		return $result;
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
		//print_r($pid);
		
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
	public function getBrandName($brand_id)
	{
		$this->Product_brand_lang = ClassRegistry::init('Product_brand_lang');	
		$result = $this->Product_brand_lang->Find('first', 
								array(
								'conditions'=>array(
									'Product_brand_lang.brand_id'=>$brand_id
								)
							)
						); 
		//echo '<pre>'; print_r($result); echo '</pre>';
		
		if(!empty($result))
			return stripslashes($result['Product_brand_lang']['brand_title']);
	}
	
	
	
	
	
	
	
    public function getProductMerchantCount($id="",$slug="",$type="count",$lang_id=1)/*(all|count)*/
	{
		
	  $this->Product = ClassRegistry::init('Product');
	  $product=$this->Product->Product_lang->find('first',array('conditions'=>array('Product.id'=>$id,'Product.slug'=>$slug,'Product_lang.lang_id'=>$lang_id)));
	
	  $merchant=$this->Product->find($type,array('conditions'=>array('Product.slug like'=>$slug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']) ));
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
		 
		  return $merchant; //exit;
		 
		  //echo "<pre>";print_r($merchant);echo "</pre>";
			//$this->set('merchantids',$merchant);
	}
	
	
	public function getPriceFormat($price)
	{
		$price_symbol = ' SR';
		
		if(strpos($price,$price_symbol) === FALSE)
			return 'SAR '.$price;
		else	
			return $price;	
	}
	
	public function getMerchantDetails($id)
	{
		$this->Merchant = ClassRegistry::init('Merchant');
		$result = $this->Merchant->find('first', array(
										
											'conditions' => array(
											
												'Merchant.id' => $id
											
											)
										
										));
		if(!empty($result))
			return $result['Merchant'];
	}
	
	
	public function getProductCategoryTitle($pid)
	{
		$this->Product_category_lang = ClassRegistry::init('Product_category_lang');	
		$result = $this->Product_category_lang->Find('first', 
								array(
								'conditions'=>array(
									'Product_category_lang.cat_id'=>$pid
								)
							)
						); 
						
		//echo '<pre>';print_r($result);	exit;	
		
		return stripslashes($result['Product_category_lang']['category_name']); 
	}

  public function languageChanger($prodLang){
    if(count($prodLang)==1)
    {
      $data = $prodLang[0];
	   return $data;
    }
    else
    {
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
		//echo '<pre>'; print_r($data); echo '</pre>';
        return $data;
      }

    }

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
	public function getHeaderOffers()
	{
		$this->Product = ClassRegistry::init('Product');
    $this->Product_category = ClassRegistry::init('Product_category');
		$date=date('Y-m-d');	
		/*$offer=$this->Product->find('all',
									array(
										'conditions'=>array(
											'Offer.start_date <= ' => $date,
                              				'Offer.end_date	 >= ' => $date,
											'Product.category_id !='=>''
										 ),
										 'limit'=>13
							 ));*/
				
		//echo '<pre>'; print_r($product_cats); echo '</pre>';
    $cats=$this->Product_category->find('all',array('conditions'=>array('Product_category.status'=>1,'Product_category.parent_id'=>0),'order'=>array('Product_category.cat_order'=>'asc')));
	
  	//echo '<pre>'; print_r($cats); echo '</pre>';
    ?>
    <script type="text/javascript">
    $(function(){
      $('.offers_tabs>li').click(function(){
        var index=$(this).index();
        $('.offers_tabs>li').removeClass('active');
        $(this).addClass('active');
        $('.offers_tab_content>li').hide();
        $('.offers_tab_content>li:nth-child('+(index+1)+')').show();
      })
    })

    </script>
    <div class="drop3"></div>
    <ul class="offers_tabs">
      <?php
        $i=0;
       foreach ($cats as $key => $value) { 
        if($i==5)
        {
          break;
        }
 $value['Product_category_lang']=$this->languageChanger($value['Product_category_lang']);
 $child_cats=$this->Product_category->children($value['Product_category']['id']);
 $child_ids=Hash::extract($child_cats,'{n}.Product_category.id');
 $child_ids=array_merge($child_ids,array($value['Product_category']['id']));
  $offer_count=$this->Product->find('count',
                  array(
                    'fields'=> array(
                      'Product.*','Offer.*'
                    ),
                    'conditions'=>array(
                      'Offer.start_date <= ' => $date,
                                      'Offer.end_date  >= ' => $date,
                      'Offer.status' => 1,
                      'Product.category_id'=>$child_ids,
                      'Product.offer_id !='=>''
                     ),
                    'order'=>'Product.id desc',
                    
               ));
  //print_r($offer_count);
          if($offer_count>0)
          {
            
          ?>
        <li <?=($i==0)?"class='active'":""?>><?=$value['Product_category_lang']['category_name']?></li>
     <?php $i++; }
          else
          {
            unset($cats[$key]);
          }

      }?>
      
    </ul>
    <ul class="offers_tab_content">
      <?php foreach ($cats as $key => $value) { 
 $value['Product_category_lang']=$this->languageChanger($value['Product_category_lang']);
 $child_cats=$this->Product_category->children($value['Product_category']['id']);
 $child_ids=Hash::extract($child_cats,'{n}.Product_category.id');
 $child_ids=array_merge($child_ids,array($value['Product_category']['id']));
 //print_r($child_ids);
        ?>
        <li>
          <?php 
                $offer=$this->Product->find('all',
                  array(
                    'fields'=> array(
                      'Product.*','Offer.*'
                    ),
                    'conditions'=>array(
                      'Offer.start_date <= ' => $date,
                                      'Offer.end_date  >= ' => $date,
                      'Offer.status' => 1,
                      'Product.category_id'=>$child_ids,
                      'Product.offer_id !='=>''
                     ),
                    'order'=>'Product.id desc',
                    'limit'=>13
               ));
              // print_r($offer); 
          echo "<ul>";
            if(!empty($offer))
          {
            //print_r($offer);
            foreach ($offer as $key => $value) 
            {
              $image=json_decode($value['Product']['image_url']);
              $offer_price=($value['Product']['price']-($value['Product']['price']*$value['Offer']['discount']/100));
    
              $product_lang_data = $this->languageChanger($value['Product_lang']);
              ?>
              <li>
                <a href="<?=$this->webroot.$this->getLang()."/products/".$value['Product']['id']?>-<?=$value['Product']['slug']?>" style="text-decoration:none;">
                <div class="gimage">
                  <h2><?=(strlen($product_lang_data['title'])>10)?substr($product_lang_data['title'],0,18).'..':$product_lang_data['title']?></h2>
                
                  <div class="img_cover">
                     <img src="<?=$image[0]?>" alt="">
                  </div>
                  <div class="gap_hight" style="height:20px"></div>
               <div class="g-offers"><span class="dsntnew1"><?=$value['Offer']['offer_desc']?></span><br><s><?=$this->getPriceFormat(number_format($value['Product']['price'],2));?></s><br /><b><?=$this->getPriceFormat(number_format($offer_price,2));?></b><br><?php if($value['Offer']['offer_image']!=""){?><!--<img src="<?=$this->webroot?><?=$value['Offer']['offer_image']?>" style="height:30px;float:left;margin-top:1px;width:auto" alt="">--><?php } ?></div>
                </div>
                </a>
              </li>
              <?php 
            }?>
            <li class="last">
                <div class="gimage">
                    <a href="<?=$this->webroot.$this->getLang()?>/homes/offers">
                      <!-- <div style="height:20px"></div>-->
                          <div class="img_cover">
                        <?php echo $this->Html->image('seeall.png', array('alt' => ''));?>
                    </div>
                    </a>

                </div>
            </li> 
         <?php } ?>
           </ul>
        </li>
     <?php  }?>
    <?php /* ?></ul>
        <ul>
            <div class="drop3"></div>
            <div id="about" class="nano offor_nano" style="/*width:1330px; height:320px;">
                <div class="nano-content">
            <?php
            if(!empty($product_cats))
            {
				foreach ($product_cats as $key => $value)  
				{
					$this->Product_category = ClassRegistry::init('Product_category');
					$cat_lang_data = $this->Product_category->find('first',
																			array(
																				'conditions'=> array(
																					'Product_category.id' => $value['Product']['catid']
																				)
																			)
																		);
					$catname = $this->languageChanger($cat_lang_data['Product_category_lang']);
					echo '<li class="heading_cat" style="width: 100%; min-height:0; margin-bottom:10px;"><h2 style="color: #FFAD1B; font-weight:bold;">'.stripslashes($catname['category_name']).'</h2></li>';
					$offer = '';
					$offer=$this->Product->find('all',
									array(
										'fields'=> array(
											'Product.*','Offer.*'
										),
										'conditions'=>array(
											'Offer.start_date <= ' => $date,
                              				'Offer.end_date	 >= ' => $date,
											'Offer.status' => 1,
											'Product.category_id'=>$value['Product']['catid'],
											'Product.offer_id !='=>''
										 ),
										'order'=>'Product.id desc',
							 ));
					if(!empty($offer))
					{
            //print_r($offer);
						foreach ($offer as $key => $value) 
						{
							$image=json_decode($value['Product']['image_url']);
							$offer_price=($value['Product']['price']-($value['Product']['price']*$value['Offer']['discount']/100));
		
							$product_lang_data = $this->languageChanger($value['Product_lang']);
							?>
							<li>
								<a href="<?=$this->webroot.$this->getLang()."/products/".$value['Product']['id']?>-<?=$value['Product']['slug']?>" style="text-decoration:none;">
								<div class="gimage">
                  <h2><?=(strlen($product_lang_data['title'])>10)?substr($product_lang_data['title'],0,18).'..':$product_lang_data['title']?></h2>
								
									<div class="img_cover">
									   <img src="<?=$image[0]?>" alt="">
									</div>
                  <div style="height:20px"></div>
							 <div class="g-offers"><span class="dsntnew1"><?=$value['Offer']['offer_desc']?></span><br><s><?=$this->getPriceFormat(number_format($value['Product']['price'],2));?></s><br /><b><?=$this->getPriceFormat(number_format($offer_price,2));?></b><br><?php if($value['Offer']['offer_image']!=""){?><!--<img src="<?=$this->webroot?><?=$value['Offer']['offer_image']?>" style="height:30px;float:left;margin-top:1px;width:auto" alt="">--><?php } ?></div>
								</div>
								</a>
							</li>
							<?php 
						}
					}
				}
			}
			?>
            <?php if(!empty($product_cats)){ ?>
            <li class="last">
                <div class="gimage">
                    <a href="<?=$this->webroot.$this->getLang()?>/homes/offers">
                      <!-- <div style="height:20px"></div>-->
                          <div class="img_cover">
                        <?php echo $this->Html->image('seeall.png', array('alt' => ''));?>
                    </div>
                    </a>

                </div>
            </li> 
            <?php }else{ ?>
                <h1 style="width: 100%"><center>No offers found.</center></h1>
            <?php } ?>
            </div></div>
        </ul><?php */ ?>
        <?Php 
	}
  public function GetPageAttrByActionKey($slug,$pageId){
    $this->Page = ClassRegistry::init('Page');
    $data=$this->Page->findById($pageId);
    $langData=$this->languageChanger($data['Page_lang']);
    $attr=json_decode(htmlspecialchars_decode($langData['page_attrs']));
    if(!empty($attr))
    {
      foreach ($attr as $key => $value) {
        if($value->slug!=$slug)
        {
          unset($attr[$key]);
        }
      }
    }
    return $attr;
  }

  public function getMultiLang(){
    $lang = $this->getLang();
   ?> 
<style type="text/css">
.choos_lang_top{
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    /*border: 1px solid;*/
    
    /*background: #3E4644;*/
}
.choos_lang_top a#ar,.choos_lang_top a#en{
  padding: 3px 10px 3px 23px;
background-repeat: no-repeat;
background-position: 2px;
}
.choos_lang_top a{
  color: #fff;
  text-decoration: none;
}
</style>

   <?php 
$url=$this->here;
            if($lang=="en")
            {
              if(strpos($url,'/en/')>-1 )
              {
                  $url=str_replace("/en/","/ar/", $url);

              }
              elseif(strpos($url,'/en')>-1)
              {
                 $url=str_replace("/en","/ar/", $url);
              }
              else
              {
                  $url=str_replace($this->webroot,'',$url);
                  $url=$this->webroot."ar/".$url;

              }
              //echo $url;
              echo "<span class='choos_lang_top'><a id='ar' href='".$url."'>".$this->getWord('arabic')."</a></span>";
            }
            else
            {
               if(strpos($url,'/ar/')>-1)
              {
                  $url=str_replace("/ar/","/en/", $url);

              }
              elseif(strpos($url,'/ar')>-1)
              {
                 $url=str_replace("/ar","/en/", $url);
              }
              else
              {
                  $url=str_replace($this->webroot,'',$url);
                  $url=$this->webroot."en/".$url;

              }
              //echo $url;
              echo "<span class='choos_lang_top' ><a id='en' href='".$url."'>".$this->getWord('english')."</a></span>";
            }
            
  }

  public function getBrandOnTop(){
    $lang=$this->getLang();
    $this->Product = ClassRegistry::init('Product');
    $this->Product_brand = ClassRegistry::init('Product_brand');
    $this->Product_category = ClassRegistry::init('Product_category');
     $product_brands = $this->Product_brand->Find('all', 
                    array(
                    'conditions'=>array(
                      
                      'Product_brand.status'=>1
                    ),
                    'order' => array('Product_brand.order'=>'asc'),
                    'limit'=>13
                  )
                ); 
      ?>
      <div class="grid">
                  <div class="listdata">
                      <ul>
                          <div class="drop2"></div>
                          <?php 
              if(!empty($product_brands))
              {
                foreach($product_brands as $product_brand)
                {
                  $catids=$this->Product->find('all',array('fields'=>array('Product.category_id'),'conditions'=>array('Product.brand'=>$product_brand['Product_brand']['id'],'Product.status'=>1,'Product.category_id !='=>"",'Product.brand !='=>""),'recursive'=>-1));
                 $cat_ids= Hash::extract($catids,'{n}.Product.category_id');
                 $cat_ids=array_unique($cat_ids);
                  //echo '<pre>'; print_r( $cat_ids); echo '</pre>'; 

                  $brand_slug=$product_brand['Product_brand']['slug']; 
                   $product_brand_lang_data = $this->languageChanger($product_brand['Product_brand_lang']);
                      $brand_title = stripslashes($product_brand_lang_data['brand_title']);
                  ?>
                                    <li style="position:relative">
                                        <div class="gimage" onmouseover="">
                                            <h2>
                                                <a href="<?=$this->webroot.$lang?>/brand-<?=$brand_slug?>"><?=$brand_title?></a>
                                                <?php //echo $this->Html->link($brand_title,array('brand-'.$brand_slug,'full_base' => true));?>
                                            </h2>
                                              <div class="img_cover">
                                                 <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                             <td valign="middle" style="height:100%;vertical-align: middle;">
                                          <?php 
                      if(!empty($product_brand['Product_brand']['image_url']))
                      {
                                                ?>
                                                <a href="<?=$this->webroot.$lang?>/brand-<?=$brand_slug?>">
                                                <?php
                        echo $this->Html->image('../'.$product_brand['Product_brand']['image_url'], array('alt' => '', 'class'=>'img_thumbnail_image'));
                                                ?>
                                                </a>
                                                <?php
                      }
                      else
                      {
                                                ?>
                                                <a href="<?=$this->webroot.$lang?>/brand-<?=$brand_slug?>">
                                                <?php
                        echo $this->Html->image('no-image.png', array('alt' => '', 'class'=>'img_thumbnail_image'));
                                                ?>
                                                </a>
                                                <?php
                      }
                     

                      if($lang == 'en')
                      {
                        if(strlen($brand_title)>20)
                          $brand_title = substr($brand_title,0,20).'...';
                      }
                      $brand_slug = $product_brand['Product_brand']['slug'];?>
                                        </td></tr></table>
                                        </div>

                                          
                                        </div>
                                        <div class="related_cat_over">
                                          <ul>
                                            <?php
                                            if(count($cat_ids)<=0)
                                            {
                                              echo "<li class='not_found'>No Related Department Found.</li>";
                                            }
                                            else
                                            {
                                              $cat_ids=array_values($cat_ids);
                                             foreach ($cat_ids as $key => $value) {
                                             //echo  $key;
                                              if($key==3)
                                              {
                                                break;
                                              }
                                              $category=$this->Product_category->find('first',array('fields'=>array('Product_category.*'),'conditions'=>array('Product_category.id'=>$value)));
                                              $category['Product_category_lang']= $this->languageChanger($category['Product_category_lang']);
                                              echo"<li><a href='".$this->webroot.$lang."/category-".$category['Product_category']['slug']."#cat:".$category['Product_category']['id'].",brand:".$product_brand['Product_brand']['id']."'>".$this->summary($category['Product_category_lang']['category_name'],15,true)."</a></li>";
                                            }}?>
                                           <?php if(count($cat_ids)>4){?>
                                            <li class='more'><a href="<?=$this->webroot.$lang?>/brand-<?=$brand_slug?>"><?=$this->getWord('more');?></a></li>
                                          <?php } ?>
                                          </ul>
                                        </div>
                                    </li>
                                    <?php 
                } 
              }?>
              <li class="see_all_all">
                              <div class="gimage">
                                  <a href="<?=$this->webroot.$lang?>/homes/shopbybrand">
                                          <div class="img_cover">
                                  <?php echo $this->Html->image('seeall.png', array('alt' => ''));?>
                                    </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                 <div class="icon_close" onclick="hide_brand()">&nbsp;</div>
                 <?php
  }
  public function getDepartMentTop(){
    $this->Product_category = ClassRegistry::init('Product_category');
    $product_categories = $this->Product_category->Find('all', 
                  array(
                  'conditions'=>array(
                    'Product_category.parent_id'=>0,
                    'Product_category.status'=>1,
                    //'Product_brand_lang.lang_id'=> $langid
                  ),
                  'order' => array('Product_category.cat_order'=>'asc')
                  
                )
              ); 
    ?>
    <div class="grid">
                  <div class="listdata">
                      <ul>
                          <div class="drop1"></div>
                          <?php 
              if(!empty($product_categories))
              {
                foreach($product_categories as $key=>$product_category)
                {
                                    if($key<13)
                                    {
                     //echo '<pre>'; print_r($product_categories); echo '</pre>'; exit;?>
                                       <li>
                                        <div class="gimage" onmouseover="">
                        <h2>
                                              <?php 
                        
                        $product_lang_data = $this->languageChanger($product_category['Product_category_lang']);
                        
                        $catname = stripslashes($product_lang_data['category_name']);
                        $lang = $this->getLang();
                        if($lang == 'en')
                        {
                          if(strlen($catname)>18)
                                                            $catname = substr($catname,0,18).'...';
                        }
                        $catslug = $product_category['Product_category']['slug'];
                        
                        //echo $this->Html->link($catname,array('controller' => 'homes','action' => 'productlist','full_base' => true));?>
                                                <a href="<?=$this->webroot.$lang?>/products/category-<?=$catslug?>" >
                                                  <?php echo $catname;?>
                                                </a>
                                            </h2>
                                            <div class="img_cover">
                                                 <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                          <tr>
                               <td valign="middle" style="height:100%;vertical-align: middle;">
                                          <?php 
                      if(!empty($product_category['Product_category']['image_url']))
                      {
                        echo $this->Html->image('../'.$product_category['Product_category']['image_url'], array('alt' => '', 'class'=>'img_thumbnail_image'));
                      }
                      else
                      {
                        echo $this->Html->image('no-image.png', array('alt' => '', 'class'=>'img_thumbnail_image'));  
                      }?>
                                              </td></tr></table>
                                        </div>
                                  
                                         
                                            <?php 
                      $this->Product_category = ClassRegistry::init('Product_category');
                      $subcats=$this->Product_category->find('all', array(
                                'conditions' => array(
                                'Product_category.status' => 1, 
                                'Product_category.parent_id' => $product_category['Product_category']['id']
                                ),
                                //'limit'=>4
                              ));
                          //print_r($subcats);    
                      if(!empty($subcats))
                                            {?>
                                                <div class="hover-text">
                                                   <!--  <div class="title2"> -->
                                                      <!--  <a href="<?=$this->webroot.$lang?>/products/category-<?=$catslug?>" >
                                                          <?=$catname?>
                                                           </a> -->
                            <?php //echo $this->Html->link($catname,array('controller' => 'homes','action' => 'productlist','type'=>$catslug,'full_base' => true));?>
                         <!--  </div> -->
                                                        <ul>
                                                            <?php $i = 0;
                              foreach($subcats as $k=>$subcat)
                                                            {
                                                                //print_r();
                   $subcats[$k]['Product_category']['product_count']=$this->GetProductCountBycategory($subcat['Product_category']['id']);
                                                            }
                 $subcats=Hash::sort($subcats, '{n}.Product_category.product_count', 'desc');
                           foreach ($subcats as $subcat) {
                              
                                                               
                                if($i<3)
                                {?>
            <li>
             <?php 
       $product_category_lang_data = $this->languageChanger($subcat['Product_category_lang']);
            $subcatname = stripslashes($product_category_lang_data['category_name']);
            
      if($lang == 'en')
      {
        if(strlen($subcatname)>20)
          $subcatname = substr($subcatname,0,20).'...';
      }
                $subcatslug = $subcat['Product_category']['slug'];?>
                    <a href="<?=$this->webroot.$lang?>/products/category-<?=$subcatslug?>" >
                        <?=$subcatname?>
                    </a>
                <?php
                                                                       // echo $this->Html->link($subcatname,array('controller' => 'homes','action' => 'productlist','type'=>$subcatslug,'full_base' => true));?>
                                                                    </li>
                                                            <?php } $i++;
                              }?>
                                                        </ul>
                                                        <?php if(count($subcats)>4)
                            {?>
                                                            <div class="clear"></div>
                                                            <a href="<?=$this->webroot.$lang?>/products/category-<?=$catslug?>" class = 'more'>
                                                           <?php echo $this->getWord('more');?>
                                                           </a>
                                                            <?php //echo $this->Html->link('More...',array('controller' => 'homes','action' => 'productlist','type'=>$catslug,'full_base' => true),array('class'=>'more'));?>
                                                        <?php }?>
                                                    </div>
                                                </div>

                                            <?php }
                                            else
                                            {
                                                echo '<font color="#FFFFFF">No sub categories found.</font>'; 
                                            }?>
                                    </li>

                                    <?php 
                                     }
                } 
              }?>
              <li class="see_all_all"> 
                              <div class="gimage">

                                  <a href="<?=$this->webroot.$lang?>/homes/categorylist">
                                          <div class="img_cover">
                                    <?php echo $this->Html->image('seeall.png', array('alt' => ''));?>
                                    </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                 <div class="icon_close" onclick="hide_department()">&nbsp;</div>
                 <?php
  }
}  



?>