<?php 
App::uses('AppController', 'Controller');
class CommonFunction
{
  private $merchant_id="";
  public function __construct($merchant_id=""){
  	if($merchant_id!="")
  	$this->merchant_id=$merchant_id;
  }

//slug creater  
	public function slugCreater($str, $replace=array(), $delimiter='-') {
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
	 //check json array
	public function is_json($string) {
		return is_array(json_decode($string));
	}

	  //For Feed filter
	 public function filterMyFeed($data,$type="id"){
	            switch ($type) {
	                case "id":
	                       $filtered=Hash::extract($data, '{n}.A');
	                       $filtered= Hash::filter($filtered);      
	                    
	                       foreach($data as $key=>$val)
	                       {
	                            if(!isset($filtered[$key-1]))
	                            {
	                                 unset($data[$key]);
	                            }
	                           
	                       }  
	                       if(count($data)==3)
	                       {
	                         return false;
	                       }
	                       else
	                       {
	                          return array_values($data);
	                       }
	                   
	                    break;
	                
	                case "unique":
	                    $filtered=Hash::extract($data, '{n}.A');
	                 
	                    $filtered=array_unique($filtered,SORT_STRING);
	                 
	                     foreach($data as $key=>$val)
	                       {
	                            if(!isset($filtered[$key]))
	                            {
	                                unset($data[$key]);
	                            }
	                           
	                       }  
	                       if(count($data)==3)
	                       {
	                         return false;
	                       }
	                       else
	                       {
	                          return array_values($data);
	                       }
	                break;	                
	                case 'required':
	                     $data_val=$data;
	                     $data_key=$data[1];
	                     $data_specify=array(
							    'A' => 'Required',
							    'B' => 'Required',
							    'C' => 'Recommended',
							    'D' => 'Required',
							    'E' => 'Recommended',
							    'F' => 'Required',
							    'G' => 'Required',
							    'H' => 'Recommended',
							    'I' => 'Required',
							    'J' => 'Required',
							    'K' => 'Recommended for Books',
							    'L' => 'Recommended',
							    'M' => 'Recommended',
							    'N' => 'Recommended',
							    'O' => 'Recommended',
							    'P' => 'Recommended',
							    'Q' => 'Required',
							    'R' => 'Required',
							    'S' => 'Recommended',
							    'T' => 'Recommended',
							    /* New code */
							    'U' => 'Required',
							    'V' => 'Recommended',
							    'W' => 'Recommended',
							    'X' => 'Recommended',
							   
							);
	                      unset($data[0]);
	                      unset($data[1]);
	                      unset($data[2]);
			              $final_array=array();
			              $final_data=$data;
			              foreach ($final_data as $k => $val) {			           
			              
				              foreach ($data_specify as $key => $value) {
				              	if($value=="Required")
				              	{
				              		if($data_val[$k][$key]=="")
				              		{
				              			
				              			unset($data_val[$k]);
				              		    break;
				              		}
				              	}
				              }
			              }

			             
			                if(!empty($data_val))
		                     return $data_val;
		                    else
		                     return false;
	                    	break; 
	                case "filter":
	                //print_r($data);
	              foreach ($data as $key => $value) {
		              	if($key>2)
		              	{
		              		foreach ($value as $k => $val) {
		              			
			                 	if($k=='F')
			                 	{
			                 		//echo $val;
					                if(!filter_var($val, FILTER_VALIDATE_URL))
					                {
					                	unset($data[$key]);
					                	break;
					                }else
					                {
					                	$data[$key][$k]=filter_var($val, FILTER_SANITIZE_URL);
					                }

				                }elseif ($k=='A')
				                {
				                	if(!filter_var($val, FILTER_VALIDATE_INT))
				                	{
				                		
				                		unset($data[$key]);
				                		break;
				                	}
				                }
				                elseif ($k=='G')
				                {
				                	if(!filter_var($val, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>'/(?P<digit>\d+) (?P<name>\w+)/'))))
				                	{
				                		//unset($data[$key]);
				                	}

				                } elseif ($k=='J')
				                {
				                	$images_array=json_decode($val);
				                	if(is_array($images_array))
				                	{
				                		$images_array=json_encode(array_values(array_unique($images_array)));
				                		$data[$key][$k]=$images_array;
				                	}

				                }
				                /* New Code*/
				               elseif ($k=='U')
				                {
				                	//print_r($val);
				                	$prod_details_array=json_decode($val);
				                	//print_r($prod_details_array);
				                	if(is_object($prod_details_array))
				                	{
				                		$prod_details_array=json_encode($prod_details_array);
				                		//print_r($prod_details_array);
				                		$data[$key][$k]=$prod_details_array;
				                	}
				                	else
				                	{
				                		$data[$key][$k]="";
				                	}

				                }
				                 elseif ($k=='V')
				                {
				                	$prod_details_array=json_decode($val);
				                	if(is_object($prod_details_array))
				                	{
				                		$prod_details_array=json_encode($prod_details_array);
				                		$data[$key][$k]=$prod_details_array;
				                	}else
				                	{
				                		$data[$key][$k]="";
				                	}

				                }
				                 elseif ($k=='W')
				                {
				                	//print_r($val);
				                	$prod_details_array=json_decode($val);
				                	//print_r($prod_details_array);
				                	if(is_object($prod_details_array))
				                	{
				                		$prod_details_array=json_encode($prod_details_array);
				                		//print_r($prod_details_array);
				                		$data[$key][$k]=$prod_details_array;
				                	}
				                	else
				                	{
				                		$data[$key][$k]="";
				                	}

				                }
				                 elseif ($k=='X')
				                {
				                	$prod_details_array=json_decode($val);
				                	if(is_object($prod_details_array))
				                	{
				                		$prod_details_array=json_encode($prod_details_array);
				                		$data[$key][$k]=$prod_details_array;
				                	}else
				                	{
				                		$data[$key][$k]="";
				                	}

				                }
			                }
			            }
			            //echo "<Pre>"; print_r($data); echo "</Pre>";
		            }
		            //print_r($data);
		                 if(!empty($data))
		                     return $data;
		                    else
		                     return false;
	                  
	                		break;    	  
	                case "assembele":
	                $data_key=$data[1];
	                foreach ($data_key as $key => $value) {
	                   if($value=="id")
	                   {
	                    $data_key[$key]="merchant_product_id";
	                   }
	                   else if($value=="link")
	                   {
	                     $data_key[$key]="product_url";
	                   }
	                   else if($value=="image_link")
	                   {
	                     $data_key[$key]="image_url";
	                   }
	                   else if($value=="category")
	                   {
	                     $data_key[$key]="category_id";
	                   }
	                  
	                }
	                //print_r($data_key);

	                $data_specify=$data[2];
	                //print_r($data_specify);
	                unset($data[0]);
	                unset($data[1]);
	                unset($data[2]);
	                $final_array=array();
	                $final_data=$data;
	                $slug="";
	                    foreach ($data as $key => $value) {
	                        $array=array();
	                        foreach ($value as $k => $val) {
	                            if(in_array($data_key[$k],array('title','description','product_details','seo_details')))
	                            {
	                                $data[$key]['Product_lang']['en'][$data_key[$k]]=htmlspecialchars($val);
	                                $data[$key]['Product_lang']['en']['lang_id']=1;
	                                if($data_key[$k]=="title")
	                                {
	                                	if($val!="")
	                                     $slug=$this->slugCreater($val);
	                                }
	                                if($data_key[$k]=="product_details")
	                                {
	                                	$attdata=json_decode(strtolower($val),true);
	                                	$data[$key]['Product']['color']=isset($attdata['color'])?$attdata['color']:(isset($attdata['colour'])?$attdata['colour']:"");
	                                }
	                            }
	                            
	                            elseif (in_array($data_key[$k],array('title_ar','description_ar','product_details_ar','seo_details_ar'))) {
	                               if($val!="")
	                               {
	                               	if($data_key[$k]=='title_ar')
	                               	{
	                                $data[$key]['Product_lang']['ar']['title']=htmlspecialchars($val);
	                                }
	                                else if($data_key[$k]=='description_ar')
	                                {
	                                	$data[$key]['Product_lang']['ar']['description']=htmlspecialchars($val);
	                                }
	                                else if($data_key[$k]=='product_details_ar')
	                                {
	                                	$data[$key]['Product_lang']['ar']['product_details']=htmlspecialchars($val);
	                                }
	                                else if($data_key[$k]=='seo_details_ar')
	                                {
	                                	$data[$key]['Product_lang']['ar']['seo_details']=htmlspecialchars($val);
	                                }
	                                $data[$key]['Product_lang']['ar']['lang_id']=2;
	                               }else
	                               {
	                               	unset($data[$key]['Product_lang']['ar']);
	                               }
	                            }
	                           
	                            else if($data_key[$k]=="price")
	                            {
	                            	$exp=explode(" ", trim($val));
	                            	$data[$key]['Product'][$data_key[$k]]=$exp[0];
	                            	if(!isset($exp[1]))
	                            	  $data[$key]['Product']['price_type']="USD";
	                            	else
                            		  $data[$key]['Product']['price_type']=$exp[1];
	                            }
	                            else if($data_key[$k]=="category_id")
	                            {
	                            	//$this->categoryCheckAndGetId($val);
	                            	
	                            	 $data[$key]['Product'][$data_key[$k]]=$val;
	                            }
	                            else
	                            {
	                                 $data[$key]['Product'][$data_key[$k]]=$val;
	                            }
	                      
	                           unset($data[$key][$k]);
	                        }
	                        $results = Hash::extract($data, '{n}.Product.slug');
	                       // print_r($results);
	                        $data[$key]['Product']['retailer_id']=$this->merchant_id;
	                        if(!in_array($slug,$results)){
	                        	$data[$key]['Product']['slug']=$slug;
	                        }	                      
	                   		else
	                   		{
	                   			unset($data[$key]);
	                   		}
	                        //$final_array,
	                    }
	                   // print_r($data);
	                    if(!empty($data))
	                     return $data;
	                    else
	                     return false;
	                break;
	                default:
	                    # code...
	                    break;
	      }

	 }
	 public function summary($str,$limit=100,$strip=false){
	    $str=($strip==true)?strip_tags($str):$str;    
	    if(strlen($str)>$limit){     
	     $str=substr($str,0,$limit-3);     
	     return(substr($str,0,strrpos($str,' ')).'...');    
	    }    return trim($str); 
	 } 
	 public function getSecureString($data="",$type="")
	 {

	 }
}
?>