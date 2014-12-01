<?php
App::uses('Controller', 'Controller');
  App::uses('Folder', 'Utility');
  App::uses('File', 'Utility');
  App::uses('TemplateHelper', 'View/Helper');
class CrawlsController extends AppController{
   public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
   public $components = array('Session','Paginator','Cookie','Ctrl','RequestHandler');

   public function beforeFilter(){
      /* $this->layout = 'admin';
       $il=$this->Session->read('Admin');
      if($il["id"] == NULL || $il["id"] == ""){
          $url=$this->webroot."admin/logout";
          header("Location:$url");
      }*/
       
   }

   public function souq(){
        $this->layout = 'admin';
   
        $this->loadmodel('Product_category');
        $this->loadmodel('Product_category_lang'); 
        
        mysql_connect("localhost","menacompare_demo","nEPQX.BBTEqd");
        mysql_select_db("menacompare_demo1");
        
        mysql_query("delete from mc_products_temp where category_name = ''")or die(mysql_error());
        mysql_query("update mc_products_temp set 
        department='Car Electronics and Accessories' 
        where category_name like '%Car Audio%' 
        or category_name like '%GPS accessories%'
        or category_name like '%Keys & Key Chains%'
        or category_name like '%Car Care Products%'
        or category_name like '%Car Navigation%'
        or category_name like '%Car Video%'
        or category_name like '%Car Navigators%'
        or category_name like '%Car Navigation%'
        or category_name like '%GPS Receiver%'
        ")or die(mysql_error());
        
        mysql_query("update mc_products_temp set 
        department='Computers and Networking' 
        where category_name like '%Computer%' 
        or category_name like '%Networking%'
        or category_name like '%Printer%'
        or category_name like '%Software%'
        or category_name like '%Media Gateways%'
        or category_name like '%Tablets%'
        or category_name like '%Netbooks%' 
        or category_name like '%Scanner%'
        or category_name like '%UPS%' 
        or category_name like '%Networks%' 
        or category_name like '%Server%' or category_name like '%Desktop%' or category_name like '%Docking%' 
        or category_name like '%Webcams%' or category_name like '%Power Supplies%' or category_name like '%Videocards%' 
        or category_name like '%Optical Drives%' or category_name like '%Memory Modules%' or category_name like '%Card Reader%' 
        or category_name like '%PC Media%' or category_name like '%Mouse%' or category_name like '%Mouse%' 
        or category_name like '%Motherboards%' or category_name like '%MIcrophones%' or category_name like '%Memory cards%'  
        or category_name like '%Keyboards%' or category_name like '%Headsets%'   or category_name like '%Charger%' 
        or category_name like '%Hard Disks%' or category_name like '%Barcode%' or category_name like '%Bags & Carry Cases%' 
        or category_name like '%USB Drives%'   
        ")or die(mysql_error());
		
		mysql_query("update mc_products_temp set 
        department='Health and Beauty' 
        where category_name like '%Beauty%' 
        or category_name like '%Dental Care%'
        or category_name like '%Food Supplements%'
        or category_name like '%Hair Electronics%'
        or category_name like '%Grooming%'
        or category_name like '%Natural Nutrition Products%'
        or category_name like '%Personal Care%'
        or category_name like '%Personal Scales%'
        or category_name like '%Hair Removals%' or category_name like '%Skin Care%' 
        or category_name like '%Vitamins & Minerals%'  or category_name like 'wigs'  or category_name like '%Bath & Body%' 
        or category_name like '%Beauty Gifts%'  or category_name like '%Hair Care%'  or category_name like 'Makeup' 
        or category_name like '%Perfumes%'  or category_name like '%Sports Nutrition%'  
        or category_name like '%Small Medical Equipment%'  or category_name like '%Digital Fever%'
        ")or die(mysql_error());

       
		mysql_query("update mc_products_temp set 
        department='Music and Movies' where  
        category_name like '%CDs%'
        or category_name like '%Movies%'
        or category_name like '%Musical Instruments%'
        ")or die(mysql_error());
		
		mysql_query("update mc_products_temp set 
        department='Sports and Outdoors' where 
        category_name like '%Sporting Goods%'
        or category_name like '%Camping Goods%'
        or category_name like '%Fitness Technology%'
        ")or die(mysql_error());

 		mysql_query("update mc_products_temp set 
        department='Baby' 
        where category_name like '%Baby%'
        or category_name like '%Diapers%'
        or category_name like '%Feeding%'
        ")or die(mysql_error());
        
        mysql_query("update mc_products_temp set 
        department='Clothing and Accessories' 
        where category_name like '%Athletic Wear%'
        or category_name like '%Dresses%'
        or category_name like '%Eyewear%'
        or category_name like '%Jackets%' 
		or category_name like '%Pants%'
		or category_name like '%Skirts%'
		or category_name like '%Sleepwear%'
		or category_name like '%Swimwear%'
		or category_name like '%Tops%' or category_name like '%Underwear%' or category_name like '%Lingeries%' 
		or category_name like '%Uniforms%' 
		or category_name like '%Maternity Wear%' 
        ")or die(mysql_error());
        
         mysql_query("update mc_products_temp set 
        department='Electronics' 
        where category_name like '%Audio Accessories%'
        or category_name like '%CD Players%'
        or category_name like '%DVD%'
        or category_name like '%Portable Cassette%' 
		or category_name like '%MP3%'
		or category_name like '%Amplifiers%'
		or category_name like '%Camcorders%'
		or category_name like '%Digital Camers%'
		or category_name like '%Binocular%' or category_name like '%Digital Photo%' or category_name like '%Electronic%'  
		or category_name like '%Electric%' 
		or category_name like '%Fans%' or category_name like '%Heaters%' or category_name like '%Ironing%'  
		or category_name like '%Irons%' or category_name like '%Juice Extractor%' or category_name like '%Kettles%'	
		or category_name like '%Rice Cookers%' or category_name like '%Sandwich%' or category_name like '%Grills%'	
		or category_name like '%Floor Care%' or category_name like '%Food Preparation%' or category_name like '%Toaster%' 
		or category_name like '%Home Theatre%' or category_name like '%Projectors%' or category_name like '%Panel Display%'
		or category_name like '%Television%' or category_name like '%Plasma TV%' or category_name like '%Portable TV%' 
		or category_name like '%Satellite%' or category_name like '%Universal Remote%' or category_name like '%Clock Radio%' 
		or category_name like '%E-Book Reader%' or category_name like '%Surveillance System%' 
		or category_name like '%Stereo System%' 
		 ")or die(mysql_error());
		
		mysql_query("update mc_products_temp set 
        department='Home, Garden and Kitchen' 
        where category_name like '%Furniture%'
        or category_name like '%Decor%'
        or category_name like '%Chairs%'
        or category_name like '%lamps%' 
		or category_name like '%Decoration%'
		or category_name like '%Carpets%'
		or category_name like '%Bedding Supplies%'
		or category_name like '%Bathroom Supplies%'
		or category_name like '%Garden%' or category_name like '%Pet Supplies%' or category_name like '%Compasses%' 
		or category_name like '%Home Appliances%' 
		or category_name like '%Vacuum cleaners%' or category_name like '%Beverage Makers%' 
		or category_name like '%Kitchen%' or category_name like '%Cooling sets%' or category_name like '%Air Treatment%' 
		or category_name like '%Steam Cleaner%' or category_name like '%Small Appliances%' or category_name like '%Powertools%' 
		or category_name like '%Smoking%' or category_name like '%Hand tools%' or category_name like '%Barbecue Tools%'         
        ")or die(mysql_error());
		
		mysql_query("update mc_products_temp set 
        department='Office Products' 
        where category_name like '%Office%'
        or category_name like '%Stationary%'        
        ")or die(mysql_error());
        
        mysql_query("update mc_products_temp set 
        department='Watches and Accessories' 
        where category_name like '%Watch%'
        or category_name like '%Watches%'        
        ")or die(mysql_error());

		mysql_query("update mc_products_temp set 
        department='Books' 
        where category_name like 'Books%'
        or category_name like '%Comic%'  or category_name like '%Educational Books%'  or category_name like '%Fiction%' 
        or category_name like '%General Books%' or category_name like '%Kids Books%'           
        ")or die(mysql_error());
		
		mysql_query("update mc_products_temp set 
        department='Coins, Stamps and Paper Money' 
        where category_name like '%Coins%'
        or category_name like '%Stamps%'        
        ")or die(mysql_error());
        
        mysql_query("update mc_products_temp set 
        department='Games and Toys' 
        where category_name like '%Game Console%'
        or category_name like '%Game Gadget%' or category_name like '%Toys%' or category_name like '%Video Games%'        
        ")or die(mysql_error());

		mysql_query("update mc_products_temp set 
        department='Mobiles and Accessories' 
        where category_name like '%Mobile%'
        ")or die(mysql_error());
        
        mysql_query("update mc_products_temp set 
        department='Shoes and Bags' 
        where category_name like '%Backpacks%' or category_name like '%Boots%' or category_name like '%Business Bags%' 
        or category_name like '%Handbags%' or category_name like '%Formal Shoes%' or category_name like '%Luggage%' 
        or category_name like '%Messenger Bags%' or category_name like '%Sandals%' or category_name like '%School Bags%' 
        or category_name like '%Slippers%'
        ")or die(mysql_error()); 
        
        mysql_query("update mc_products_temp set 
        department='Jewelry and Accessories' 
        where category_name like '%Necklaces%' or category_name like '%Rings%' or category_name like '%Earrings%' 
        or category_name like '%Bracelets%' or category_name like '%Jewelry%' or category_name like '%Diamonds%' 
        ")or die(mysql_error());


 		
       // $rs=$this->Product_category->query("select * from mc_products_temp");
        $rs=mysql_query("select * from mc_products_temp where marchant_url like '%souq.com%'")or die(mysql_error());
  $row_id="";
    //DEPARTMENT///////////////
   // foreach($rs as $row){
	 
	   
	   
       while($row=mysql_fetch_array($rs)){
       $row_id=$row["id"];
           unset($value);
           unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
    $parent_id=0;
	$cat_id="";
	$department_id="";
	$category_name=addslashes($row["category_name"]);
	$lang=$row["lang"];
	$department=addslashes($row["department"]);
   $value['category_name']=$department;
   $slug=$department;
   $slug=$this->toAscii("souq-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."'");  
                      
                      if(mysql_num_rows($rs1) > 0)
                   {
               
                    if($row1=mysql_fetch_array($rs1)){
                    $parent_id=$row1["id"];
                    }
                 
                     
                   }else{
                    
                       $value['parent_id']=0;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                           $fcatid=$row2[0];
                           $parent_id=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                   }
      ////CATEGORY//////////////////////
     
      unset($value);
      unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
	$cat_id="";
	$department_id="";
	$category_name=addslashes($row["category_name"]);
	$lang=$row["lang"];
	$department=addslashes($row["department"]);
   $value['category_name']=$category_name;
   $slug=$category_name;
   $slug=$this->toAscii("souq-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."'");  
                   
                   if(mysql_num_rows($rs1) > 0)
                   {
                    if($row1=mysql_fetch_array($rs1)){
                    $fcatid=$row1["id"];
                    }
                 
                     
                   }else{ 
                  
                       $value['parent_id']=$parent_id;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                       $fcatid=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                  } 
                  
      ///////////PRODUCTS////////////////////////
     
    $product_id="";
	$product_name="";
	$product_slug="";
	$brand=null;
    $cat_id="";
	$retailer_id=23;
    $price=0;
    $price=round(1.02 * ($row["price"]));
	$product_name=addslashes($row["product_name"]);
	$product_slug=$row["slug"];
    $slug=$this->toAscii('alsouq-'.$department."-".$category_name.'-'.$product_name); 
    $cat_id=$fcatid;

	if($lang == 1){
	$brand = 113;
	}
	if($lang == 2){
	$brand = 113;
	}


    $rs2=mysql_query("select * from mc_products where category_id = '".$fcatid."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
       
	if(mysql_num_rows($rs2) <= 0){
   
      mysql_query("insert into mc_products(slug,product_url,category_id,retailer_id,price,price_type,image_url,brand,status,deleted,created_date) values(
	'".$slug."',
	'".$row["product_url"]."',
	'".$cat_id."','".$retailer_id."','".$price."','SAR',
	'".$row["image_url"]."','".$brand."',1,0,now())")or die(mysql_error());
   
    $product_id="";

    $rs3=mysql_query("select max(id) from mc_products");
    if($row3=mysql_fetch_row($rs3)){
        $product_id=$row3[0];
    }

    mysql_query("insert into mc_product_langs values(
	null,
	'".$product_id."',$lang,
	'".$product_name."',
	'".$row["product_description"]."',
	'','',1)")or die(mysql_error());

    }else{
         
        $price=round(1.02 * ($row["price"]));
        
        
        if($lang == 1){
	$brand = 113;
	}
	if($lang == 2){
	$brand = 113;
	}

        
        mysql_query("update mc_products set 
	slug= '".$slug."',
	product_url='".$row["product_url"]."',
	category_id='".$cat_id."',
	retailer_id=$retailer_id,
	price='".$price."',
	price_type='SAR',
	image_url='".$row["image_url"]."',
	brand='".$brand."',
	status=1,
	deleted=0,
	last_modified=now() where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
    
    $rs3=mysql_query("select id from mc_products where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if($row3=mysql_fetch_row($rs3)){
	$product_id=$row3[0];
	}
    
    mysql_query("update mc_product_langs set 
	title='".$product_name."',
	description='".$row["product_description"]."',
	status=1 where product_id = '".$product_id."' and lang_id='".$lang."'")or die(mysql_error());

    }
    mysql_query("delete from mc_products_temp where id='".$row_id."'");
       }
      /////////////////////////////////
     //echo "Saved.....";
     mysql_query("truncate table mc_products_temp");
   }
   ///////////////////////////////////////////////////////////////
   
   public function markavip(){
        $this->layout = 'admin';
   
        $this->loadmodel('Product_category');
        $this->loadmodel('Product_category_lang'); 
        
        mysql_connect("localhost","menacompare_demo","nEPQX.BBTEqd");
        mysql_select_db("menacompare_demo1");
		mysql_query("delete from mc_products_temp where category_name = ''")or die(mysql_error());
       // $rs=$this->Product_category->query("select * from mc_products_temp");
        $rs=mysql_query("select * from mc_products_temp where marchant_url like '%markavip.com%'")or die(mysql_error());
  		$row_id="";
    //DEPARTMENT///////////////
   // foreach($rs as $row){
       while($row=mysql_fetch_array($rs)){   
	   
           unset($value);
           unset($value1);
           $row_id=$row["id"];
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
    $parent_id=0;
	$cat_id="";
	$department_id="";
	$category_name=$row["category_name"];
	$lang=$row["lang"];
	$department=$row["department"];
   $value['category_name']=$department;
   $slug=$department;
   $slug=$this->toAscii("markavip-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=0");  
                      
                      if(mysql_num_rows($rs1) > 0)
                   {
               
                    if($row1=mysql_fetch_array($rs1)){
                    $parent_id=$row1["id"];
                    }
                 
                     
                   }else{
                    
                       $value['parent_id']=0;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                           $fcatid=$row2[0];
                           $parent_id=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                   }
      ////CATEGORY//////////////////////
     
      unset($value);
      unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
	$cat_id="";
	$department_id="";
	$category_name=$row["category_name"];
	$lang=$row["lang"];
	$department=$row["department"];
   $value['category_name']=$category_name;
   $slug=$category_name;
   $slug=$this->toAscii('markavip-'.$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=$parent_id");  
                   
                   if(mysql_num_rows($rs1) > 0)
                   {
                    if($row1=mysql_fetch_array($rs1)){
                    $fcatid=$row1["id"];
                    }
                 
                     
                   }else{ 
                  
                       $value['parent_id']=$parent_id;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                       $fcatid=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                  } 
                  
      ///////////PRODUCTS////////////////////////
     
    $product_id="";
	$product_name="";
	$product_slug="";
	$brand=null;
    $cat_id="";
	$retailer_id=18;
    $price=0;
    $price=$row["price"];
	$product_name=$row["product_name"];
	$product_slug=$row["slug"];
    $slug=$this->toAscii("markavip-".$department."-".$category_name."-".$product_name); 
    $cat_id=$fcatid;

	if($lang == 1){
	$brand = 113;
	}
	if($lang == 2){
	$brand = 113;
	}


    $rs2=mysql_query("select * from mc_products where category_id = '".$fcatid."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
       
	if(mysql_num_rows($rs2) <= 0){
   
      mysql_query("insert into mc_products(slug,product_url,category_id,retailer_id,price,price_type,image_url,brand,status,deleted,created_date) values(
	'".$slug."',
	'".$row["product_url"]."',
	'".$cat_id."','".$retailer_id."','".$price."','SAR',
	'".$row["image_url"]."','".$brand."',1,0,now())")or die(mysql_error());
   
    $product_id="";

    $rs3=mysql_query("select max(id) from mc_products");
    if($row3=mysql_fetch_row($rs3)){
        $product_id=$row3[0];
    }

    mysql_query("insert into mc_product_langs values(
	null,
	'".$product_id."',$lang,
	'".$product_name."',
	'".$row["product_description"]."',
	'','',1)")or die(mysql_error());

    }else{
         
        $price=$row["price"];
        
        
        if($lang == 1){
	$brand = 113;
	}
	if($lang == 2){
	$brand = 113;
	}

        
        mysql_query("update mc_products set 
	slug= '".$slug."',
	product_url='".$row["product_url"]."',
	category_id='".$cat_id."',
	retailer_id=$retailer_id,
	price='".$price."',
	price_type='SAR',
	image_url='".$row["image_url"]."',
	brand='".$brand."',
	status=1,
	deleted=0,
	last_modified=now() where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
    
    $rs3=mysql_query("select id from mc_products where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if($row3=mysql_fetch_row($rs3)){
	$product_id=$row3[0];
	}
    
    mysql_query("update mc_product_langs set 
	title='".$product_name."',
	description='".$row["product_description"]."',
	status=1 where product_id = '".$product_id."' and lang_id='".$lang."'")or die(mysql_error());

    }
    mysql_query("delete from mc_products_temp where id='".$row_id."'");

       }
      /////////////////////////////////
     //echo "Saved.....";
     mysql_query("truncate table mc_products_temp");

   }
   /////////NAMSHI//////////////////////////////////////////////
    public function namshi(){
        $this->layout = 'admin';
   
        $this->loadmodel('Product_category');
        $this->loadmodel('Product_category_lang'); 
        
        mysql_connect("localhost","menacompare_demo","nEPQX.BBTEqd");
        mysql_select_db("menacompare_demo1");
        
        mysql_query("delete from mc_products_temp where category_name = ''")or die(mysql_error());
		$row_id="";
       // $rs=$this->Product_category->query("select * from mc_products_temp");
        $rs=mysql_query("select * from mc_products_temp where marchant_url like '%namshi.com%'")or die(mysql_error());
  	
    //DEPARTMENT///////////////
   // foreach($rs as $row){
       while($row=mysql_fetch_array($rs)){
       $row_id=$row[0];
           unset($value);
           unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
    $parent_id=0;
	$cat_id="";
	$department_id="";
	$category_name=addslashes($row["category_name"]);
	$lang=$row["lang"];
	$department=addslashes($row["department"]);
   $value['category_name']=$department;
   $slug=$department;
   $slug=$this->toAscii("namshi-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=0");  
                      
                      if(mysql_num_rows($rs1) > 0)
                   {
               
                    if($row1=mysql_fetch_array($rs1)){
                    $parent_id=$row1["id"];
                    }
                 
                     
                   }else{
                    
                       $value['parent_id']=0;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                           $fcatid=$row2[0];
                           $parent_id=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                   }
      ////CATEGORY//////////////////////
     
      unset($value);
      unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
	$cat_id="";
	$department_id="";
	$category_name=$row["category_name"];
	$lang=$row["lang"];
	$department=$row["department"];
   $value['category_name']=$category_name;
   $slug=$category_name;
   $slug=$this->toAscii("namshi-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=$parent_id");  
                   
                   if(mysql_num_rows($rs1) > 0)
                   {
                    if($row1=mysql_fetch_array($rs1)){
                    $fcatid=$row1["id"];
                    }
                 
                     
                   }else{ 
                  
                       $value['parent_id']=$parent_id;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                       $fcatid=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                  } 
                  
      ///////////PRODUCTS////////////////////////
     
    $product_id="";
	$product_name="";
	$product_slug="";
	$brand=null;
    $cat_id="";
	$retailer_id=13;
    $price=0;
    $price=$row["price"];
	$product_name=addslashes($row["product_name"]);
	$product_slug=$row["slug"];
    $slug=$this->toAscii("namshi-".$product_name."-".$department."-".$category_name); 
    $cat_id=$fcatid;

	if($lang == 1){
	$brand = 113;
	}
	
	if($lang == 2){
	$brand = 113;
	}


    $rs2=mysql_query("select * from mc_products where category_id = '".$fcatid."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
       
	if(mysql_num_rows($rs2) <= 0){
   
      mysql_query("insert into mc_products(slug,product_url,category_id,retailer_id,price,price_type,image_url,brand,status,deleted,created_date) values(
	'".$slug."',
	'".$row["product_url"]."',
	'".$cat_id."','".$retailer_id."','".$price."','SAR',
	'".$row["image_url"]."','".$brand."',1,0,now())")or die(mysql_error());
   
    $product_id="";

    $rs3=mysql_query("select max(id) from mc_products");
    if($row3=mysql_fetch_row($rs3)){
        $product_id=$row3[0];
    }

    mysql_query("insert into mc_product_langs values(
	null,
	'".$product_id."',$lang,
	'".$product_name."',
	'".$row["product_description"]."',
	'','',1)")or die(mysql_error());

    }else{
         
        $price=$row["price"];
        
        
        if($lang == 1){
	$brand = 113;
	}
	if($lang == 2){
	$brand = 113;
	}

        
        mysql_query("update mc_products set 
	slug= '".$slug."',
	product_url='".$row["product_url"]."',
	category_id='".$cat_id."',
	retailer_id=$retailer_id,
	price='".$price."',
	price_type='SAR',
	image_url='".$row["image_url"]."',
	brand='".$brand."',
	status=1,
	deleted=0,
	last_modified=now() where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
    
    $rs3=mysql_query("select id from mc_products where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if($row3=mysql_fetch_row($rs3)){
	$product_id=$row3[0];
	}
    
    mysql_query("update mc_product_langs set 
	title='".$product_name."',
	description='".$row["product_description"]."',
	status=1 where product_id = '".$product_id."' and lang_id='".$lang."'")or die(mysql_error());

    }
    mysql_query("delete from mc_products_temp where id='".$row_id."'");

       }
      /////////////////////////////////
     //echo "Saved.....";
     mysql_query("truncate table mc_products_temp");

   }
	/////////////IKEA/////////////////
	 public function ikea(){
        $this->layout = 'admin';
   
        $this->loadmodel('Product_category');
        $this->loadmodel('Product_category_lang'); 
        
        mysql_connect("localhost","menacompare_demo","nEPQX.BBTEqd");
        mysql_select_db("menacompare_demo1");

       // $rs=$this->Product_category->query("select * from mc_products_temp");
        $rs=mysql_query("select * from mc_products_temp where marchant_url  like '%ikea.com%'")or die(mysql_error());
  
    //DEPARTMENT///////////////
   // foreach($rs as $row){
       while($row=mysql_fetch_array($rs)){
           unset($value);
           unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
    $parent_id=0;
	$cat_id="";
	$department_id="";
	$category_name=$row["category_name"];
	$lang=$row["lang"];
	$department=$row["department"];
   $value['category_name']=$department;
   $slug=$department;
   $slug=$this->toAscii("ikea-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=0");  
                      
                      if(mysql_num_rows($rs1) > 0)
                   {
               
                    if($row1=mysql_fetch_array($rs1)){
                    $parent_id=$row1["id"];
                    }
                 
                     
                   }else{
                    
                       $value['parent_id']=0;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                           $fcatid=$row2[0];
                           $parent_id=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                   }
      ////CATEGORY//////////////////////
     
      unset($value);
      unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
	$cat_id="";
	$department_id="";
	$category_name=$row["category_name"];
	$lang=$row["lang"];
	$department=$row["department"];
   $value['category_name']=$category_name;
   $slug=$category_name;
   $slug=$this->toAscii("ikea-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=$parent_id");  
                   
                   if(mysql_num_rows($rs1) > 0)
                   {
                    if($row1=mysql_fetch_array($rs1)){
                    $fcatid=$row1["id"];
                    }
                 
                     
                   }else{ 
                  
                       $value['parent_id']=$parent_id;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                       $fcatid=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                  } 
                  
      ///////////PRODUCTS////////////////////////
     
    $product_id="";
	$product_name="";
	$product_slug="";
	$brand=null;
    $cat_id="";
	$retailer_id=34;
    $price=0;
    $price=$row["price"];
	$product_name=$row["product_name"];
	$product_slug=$row["slug"];
    $slug=$this->toAscii("ikea-".$department."-".$category_name.'-'.$product_name); 
    $cat_id=$fcatid;

	if($lang == 1){
	$brand = 113;
	}
	
	if($lang == 2){
	$brand = 113;
	}


    $rs2=mysql_query("select * from mc_products where category_id = '".$fcatid."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
       
	if(mysql_num_rows($rs2) <= 0){
   
      mysql_query("insert into mc_products(slug,product_url,category_id,retailer_id,price,price_type,image_url,brand,status,deleted,created_date) values(
	'".$slug."',
	'".$row["product_url"]."',
	'".$cat_id."','".$retailer_id."','".$price."','SAR',
	'".$row["image_url"]."','".$brand."',1,0,now())")or die(mysql_error());
   
    $product_id="";

    $rs3=mysql_query("select max(id) from mc_products");
    if($row3=mysql_fetch_row($rs3)){
        $product_id=$row3[0];
    }

    mysql_query("insert into mc_product_langs values(
	null,
	'".$product_id."',$lang,
	'".$product_name."',
	'".$row["product_description"]."',
	'','',1)")or die(mysql_error());

    }else{
         
        $price=$row["price"];
        
        
        if($lang == 1){
	$brand = 113;
	}
	if($lang == 2){
	$brand = 113;
	}

        
        mysql_query("update mc_products set 
	slug= '".$slug."',
	product_url='".$row["product_url"]."',
	category_id='".$cat_id."',
	retailer_id=$retailer_id,
	price='".$price."',
	price_type='SAR',
	image_url='".$row["image_url"]."',
	brand='".$brand."',
	status=1,
	deleted=0,
	last_modified=now() where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
    
    $rs3=mysql_query("select id from mc_products where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if($row3=mysql_fetch_row($rs3)){
	$product_id=$row3[0];
	}
    
    mysql_query("update mc_product_langs set 
	title='".$product_name."',
	description='".$row["product_description"]."',
	status=1 where product_id = '".$product_id."' and lang_id='".$lang."'")or die(mysql_error());

    }
       }
      /////////////////////////////////
     //echo "Saved.....";
     mysql_query("truncate table mc_products_temp");

   }
	//////SUKAR//////////////
	 public function sukar(){
        $this->layout = 'admin';
   
        $this->loadmodel('Product_category');
        $this->loadmodel('Product_category_lang'); 
        
        mysql_connect("localhost","root","");
        mysql_select_db("mena1");

       // $rs=$this->Product_category->query("select * from mc_products_temp");
        $rs=mysql_query("select * from mc_products_temp where marchant_url  like '%sukar.com%'")or die(mysql_error());
  
    //DEPARTMENT///////////////
   // foreach($rs as $row){
       while($row=mysql_fetch_array($rs)){
           unset($value);
           unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
    $parent_id=0;
	$cat_id="";
	$department_id="";
	$category_name=addslashes($row["category_name"]);
	$lang=$row["lang"];
	$department=addslashes($row["department"]);
   $value['category_name']=$department;
   $slug=$department;
   $slug=$this->toAscii("sukar-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=0");  
                      
                      if(mysql_num_rows($rs1) > 0)
                   {
               
                    if($row1=mysql_fetch_array($rs1)){
                    $parent_id=$row1["id"];
                    }
                 
                     
                   }else{
                    
                       $value['parent_id']=0;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                           $fcatid=$row2[0];
                           $parent_id=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                   }
      ////CATEGORY//////////////////////
     
      unset($value);
      unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
	$cat_id="";
	$department_id="";
	$category_name=addslashes($row["category_name"]);
	$lang=$row["lang"];
	$department=addslashes($row["department"]);
   $value['category_name']=$category_name;
   $slug=$category_name;
   $slug=$this->toAscii("sukar-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=$parent_id");  
                   
                   if(mysql_num_rows($rs1) > 0)
                   {
                    if($row1=mysql_fetch_array($rs1)){
                    $fcatid=$row1["id"];
                    }
                 
                     
                   }else{ 
                  
                       $value['parent_id']=$parent_id;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                       $fcatid=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                  } 
                  
      ///////////PRODUCTS////////////////////////
     
    $product_id="";
	$product_name="";
	$product_slug="";
	$brand=null;
    $cat_id="";
	$retailer_id=19;
    $price=0;
    $price=($row["price"] * 1.02);
	$product_name=addslashes($row["product_name"]);
	$product_slug=$row["slug"];
    $slug=$this->toAscii("sukar-".$department."-".$category_name.'-'.$product_name); 
    $cat_id=$fcatid;

	if($lang == 1){
	$brand = 113;
	}
	
	if($lang == 2){
	$brand = 113;
	}


    $rs2=mysql_query("select * from mc_products where category_id = '".$fcatid."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
       
	if(mysql_num_rows($rs2) <= 0){
   
      mysql_query("insert into mc_products(slug,product_url,category_id,retailer_id,price,price_type,image_url,brand,status,deleted,created_date) values(
	'".$slug."',
	'".$row["product_url"]."',
	'".$cat_id."','".$retailer_id."','".$price."','SAR',
	'".$row["image_url"]."','".$brand."',1,0,now())")or die(mysql_error());
   
    $product_id="";

    $rs3=mysql_query("select max(id) from mc_products");
    if($row3=mysql_fetch_row($rs3)){
        $product_id=$row3[0];
    }

    mysql_query("insert into mc_product_langs values(
	null,
	'".$product_id."',$lang,
	'".$product_name."',
	'".$row["product_description"]."',
	'','',1)")or die(mysql_error());

    }else{
         
        $price=($row["price"] * 1.02);
        
        
        if($lang == 1){
	$brand = 113;
	}
	if($lang == 2){
	$brand = 113;
	}

        
        mysql_query("update mc_products set 
	slug= '".$slug."',
	product_url='".$row["product_url"]."',
	category_id='".$cat_id."',
	retailer_id=$retailer_id,
	price='".$price."',
	price_type='SAR',
	image_url='".$row["image_url"]."',
	brand='".$brand."',
	status=1,
	deleted=0,
	last_modified=now() where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
    
    $rs3=mysql_query("select id from mc_products where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if($row3=mysql_fetch_row($rs3)){
	$product_id=$row3[0];
	}
    
    mysql_query("update mc_product_langs set 
	title='".$product_name."',
	description='".$row["product_description"]."',
	status=1 where product_id = '".$product_id."' and lang_id='".$lang."'")or die(mysql_error());

    }
       }
      /////////////////////////////////
     //echo "Saved.....";
     mysql_query("truncate table mc_products_temp");

   }
	////EXTRA STORES////////////////////////////////////////////
	 public function extrastores(){
        $this->layout = 'admin';
   
        $this->loadmodel('Product_category');
        $this->loadmodel('Product_category_lang'); 
        
        mysql_connect("localhost","root","");
        mysql_select_db("mena1");

       // $rs=$this->Product_category->query("select * from mc_products_temp");
        $rs=mysql_query("select * from mc_products_temp where marchant_url  like '%extrastores.com%'")or die(mysql_error());
  
    //DEPARTMENT///////////////
   // foreach($rs as $row){
       while($row=mysql_fetch_array($rs)){
           unset($value);
           unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
    $parent_id=0;
	$cat_id="";
	$department_id="";
	$category_name=addslashes($row["category_name"]);
	$lang=$row["lang"];
	$department=addslashes($row["department"]);
   $value['category_name']=$department;
   $slug=$department;
   $slug=$this->toAscii("extrastores-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=0");  
                      
                      if(mysql_num_rows($rs1) > 0)
                   {
               
                    if($row1=mysql_fetch_array($rs1)){
                    $parent_id=$row1["id"];
                    }
                 
                     
                   }else{
                    
                       $value['parent_id']=0;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                           $fcatid=$row2[0];
                           $parent_id=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                   }
      ////CATEGORY//////////////////////
     
      unset($value);
      unset($value1);
        $fcatid="";
    $category_name="";
	$lang="";
	$department="";
	$cat_id="";
	$department_id="";
	$category_name=addslashes($row["category_name"]);
	$lang=$row["lang"];
	$department=addslashes($row["department"]);
   $value['category_name']=$category_name;
   $slug=$category_name;
   $slug=$this->toAscii("extrastores-".$slug); 
   $value['slug']=$slug;
   $this->loadmodel('Product_category');
   $rs1=mysql_query("select * from mc_product_categories where slug = '".$slug."' and parent_id=$parent_id");  
                   
                   if(mysql_num_rows($rs1) > 0)
                   {
                    if($row1=mysql_fetch_array($rs1)){
                    $fcatid=$row1["id"];
                    }
                 
                     
                   }else{ 
                  
                       $value['parent_id']=$parent_id;
                       $value['created_date']=date('Y-m-d');
                       $value['cat_order']=20;
                       $this->loadmodel('Product_category');
                       $this->Product_category->create();
                       $rt=$this->Product_category->save($value);
                      
                       $rs2=mysql_query("select max(id) from  mc_product_categories");
                       if($row2=mysql_fetch_row($rs2)){
                       $fcatid=$row2[0];
                       }

                      
                       $value1['cat_id']=$fcatid;
                       $value1['lang_id']=$lang;
                       $value1['status']=1;
                       $value1['category_name']= strip_tags(trim($value['category_name']));
                       $value1['description']=htmlspecialchars(strip_tags($value['category_name']));
                       $this->loadmodel('Product_category_lang'); 
                       $this->Product_category_lang->create();
                       $this->Product_category_lang->save($value1);
                  } 
                  
      ///////////PRODUCTS////////////////////////
     
    $product_id="";
	$product_name="";
	$product_slug="";
	$brand=null;
    $cat_id="";
	$retailer_id=19;
    $price=0;
    $price=$row["price"];
	$product_name=addslashes($row["product_name"]);
	$product_slug=$row["slug"];
    $slug=$this->toAscii("extrastores-".$department.'-'.$category_name.'-'.$product_name); 
    $cat_id=$fcatid;

	if($lang == 1){
	$brand = 113;
	}
	
	if($lang == 2){
	$brand = 113;
	}


    $rs2=mysql_query("select * from mc_products where category_id = '".$fcatid."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
       
	if(mysql_num_rows($rs2) <= 0){
   
      mysql_query("insert into mc_products(slug,product_url,category_id,retailer_id,price,price_type,image_url,brand,status,deleted,created_date) values(
	'".$slug."',
	'".$row["product_url"]."',
	'".$cat_id."','".$retailer_id."','".$price."','SAR',
	'".$row["image_url"]."','".$brand."',1,0,now())")or die(mysql_error());
   
    $product_id="";

    $rs3=mysql_query("select max(id) from mc_products");
    if($row3=mysql_fetch_row($rs3)){
        $product_id=$row3[0];
    }

    mysql_query("insert into mc_product_langs values(
	null,
	'".$product_id."',$lang,
	'".$product_name."',
	'".$row["product_description"]."',
	'','',1)")or die(mysql_error());

    }else{
         
        $price=$row["price"];
        
        
        if($lang == 1){
	$brand = 113;
	}
	if($lang == 2){
	$brand = 113;
	}

        
        mysql_query("update mc_products set 
	slug= '".$slug."',
	product_url='".$row["product_url"]."',
	category_id='".$cat_id."',
	retailer_id=$retailer_id,
	price='".$price."',
	price_type='SAR',
	image_url='".$row["image_url"]."',
	brand='".$brand."',
	status=1,
	deleted=0,
	last_modified=now() where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
    
    $rs3=mysql_query("select id from mc_products where category_id = '".$cat_id."' and slug = '".$slug."' and retailer_id = '".$retailer_id."'")or die(mysql_error());
	if($row3=mysql_fetch_row($rs3)){
	$product_id=$row3[0];
	}
    
    mysql_query("update mc_product_langs set 
	title='".$product_name."',
	description='".$row["product_description"]."',
	status=1 where product_id = '".$product_id."' and lang_id='".$lang."'")or die(mysql_error());

    }
       }
      /////////////////////////////////
     //echo "Saved.....";
     mysql_query("truncate table mc_products_temp");

   }

   /////////////////////////////////////////////////////////////
      

    /*-----------------------------COMMON CODES-----------------------------------------------*/
      public function toAscii($str, $replace=array(), $delimiter='-') {
        $str1=$str;
       //setlocale(LC_ALL, 'en_US.UTF8');
       
       $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $str);
      // $slug = mb_convert_case($slug, MB_CASE_LOWER, "UTF-8");
       $slug =  mb_strtolower($slug,'UTF-8');

        $slug1=str_replace('-','',$slug);
      if($slug1 == ""){
        $slug=$str1;
      }

       return $slug;
       }
     /*-----------------------------COMMON CODES-----------------------------------------------*/
} 
?>
