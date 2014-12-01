<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Hoppay | Admin Section');
$param=$this->params['action'];
?>
<!DOCTYPE html>
<html class="no-js" lang="en" >

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php //echo $this->Html->charset(); ?>
	<title>
    Hoppay | Admin Section
		<?php //echo $cakeDescription ?>:
		<?php //echo $title_for_layout; ?>
	</title>
  
  
	<?php
		echo $this->Html->meta('icon');		
		echo $this->Html->css('layout');
    echo $this->Html->css('foundation-icons/foundation-icons');
    echo $this->Html->css('front-end/jquery-ui-1.10.4.custom.min');
    echo $this->Html->css('colpick');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		
	?>
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
  <?php echo $this->Html->script('front-end/jquery.min.js'); ?>
  <?php echo $this->Html->script('hideshow'); ?>
  <?php //echo $this->Html->script('jquery.tablesorter.min'); ?>
  <?php echo $this->Html->script('jquery.equalHeight'); ?>
  <?php //echo $this->Html->script('jquery.samplepagination'); ?>
  <?php //echo $this->Html->script('tinymce/js/tinymce/tinymce.min'); ?>
    <?php echo $this->Html->script('front-end/jquery-ui-1.10.4.custom'); ?>
    <?php echo $this->Html->script('colpick'); ?>
 <?php echo $this->fetch('script'); ?>
 <link rel="stylesheet" type="text/css" href="<?=$this->webroot?>rating/rating.css">
 <!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>-->
  <script type="text/javascript" src="<?=$this->webroot?>js/front-end/jquery.validater.js"></script>
  <script type="text/javascript" src="<?=$this->webroot?>js/front-end/mustache.js"></script>
  <script type="text/javascript" src="<?=$this->webroot?>js/print.js"></script>
  <!--[if lt IE 9]>
  <link rel="stylesheet" href="<?=$this->webroot?>css/ie.css" type="text/css" media="screen" />
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script type="text/javascript">
  $(document).ready(function() 
      { 
          jQuery.validator.setDefaults({
              debug: false,
              success: "valid"
            });   
             $("#validates_email").validate({
                 
              submitHandler: function() {
                //console.log($('form#validates_login').serialize());
                $('.loader_img_sign_up').show();
   $.post('<?=$this->webroot?>admin/send_mail',$('form#validates_email').serialize() , 
                        function(r){
                           console.log(r);
                           if(r==1)
                           {
                              $('.loader_img_sign_up').hide();
                              alert('Message sent Successfully');
                           }
                           else
                           {
                              alert('Message sent Unsuccessfully');
                              $('.loader_img_sign_up').hide();
                           }
                        }
                        );
                    
              }
             });         
            $(".validate").validate({rules: {
                  phone: {
                    required: true,
                    digits: true
                  },

              }
             });
     } 
  );
  function sendMail(){
     $.post('<?=$this->webroot?>admin/send_mail',$('form#validates_email').serialize() , 
                        function(r){
                           console.log(r);
                           if(r==1)
                           {
                              $('.loader_img_sign_up').hide();
                              alert('Message sent Successfully');
                           }
                           else
                           {
                              alert('Message sent Unsuccessfully');
                              $('.loader_img_sign_up').hide();
                           }
                        }
                        );
  }
/*tinymce.init({
    selector: "#textarea",
    theme: "modern",
    plugins:[],
    add_unload_trigger: false,
    schema: "html5",
    inline: false,
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image     | print preview media",
    statusbar: false
 }); */

  $(document).ready(function() {

   $(function(){
    //$("#table1").dataTable();
     //$("#table2").dataTable();
      //$("#table3").dataTable();
   })
  //When page loads...
  $(".tab_content").hide(); //Hide all content
  $("ul.tabs li:first").addClass("active").show(); //Activate first tab
  $(".tab_content:first").show();
 //Show first tab content

  //On Click Event
  $("ul.tabs li").click(function() {

    $("ul.tabs li").removeClass("active"); //Remove any "active" class
    $(this).addClass("active"); //Add "active" class to selected tab
    $(".tab_content").fadeOut('slow'); //Hide all tab content

    var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
    $(activeTab).fadeIn(); //Fade in the active ID content
    return false;
  });

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
    
$(function() {
  
  $( ".date_picker" ).datepicker({dateFormat: 'dd-mm-yy'});
  
});
</script>
<style>
#stylized label.error{
    color: #f00;
display: inline-flex;
clear: both;
margin-left: 10px;
font-weight: 500;
}
</style>
</head>
<body>
  <div class="wraper">
  <header id="header">
    <hgroup>
      <h1 class="site_title"><a href="<?=$this->webroot?>admin"><img src="<?=$this->webroot?>img/logo_white.png" style="margin-top: 5px;" width="156" height="40" alt="" /></a></h1>
      <h2 class="section_title"><?=@$menu_title?></h2><div class="btn_view_site"><a href="<?=$this->webroot?>">View Site</a></div>
    </hgroup>
  </header> <!-- end of header bar -->
	 <section id="secondary_bar">
    <div class="user">
      <p><?= @strtoupper($admin_name)?><!--(<a href="#">3 Messages</a>)--></p>
      <!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
    </div>
    <div class="breadcrumbs_container">
      <article class="breadcrumbs"><a href="<?=$this->webroot?>admin">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current"><?= @$menu_title?></a>    
      </article>
    
      
    </div>
  </section><!-- end of secondary bar -->
  
  <aside id="sidebar" class="column">
   <!--  <form class="quick_search">
      <input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
    </form> -->
    <hr/>
    <h3>CMS</h3>
    <ul class="toggle">
      <li class="icn_new_article"><a href="<?=$this->webroot?>admin/banner_manager">Banner Manager</a></li>
      <li class="icn_edit_article"><a href="<?=$this->webroot?>admin/page_manager">Page Manager</a></li>
       <li class="icn_edit_article"><a href="<?=$this->webroot?>admin/menu">Menu Manager</a></li>
      <li class="icn_categories"><a href="<?=$this->webroot?>admin/faq_manager">FAQ's Manager</a></li>
      <!-- <li class="icn_categories"><a href="<?=$this->webroot?>admin/tagmanager">Tag Manager</a></li> -->
      <!-- <li class="icn_categories"><a href="<?=$this->webroot?>admin/newsletter">NewsLetter Manager</a></li> -->
      
      <!--<li class="icn_tags"><a href="#">Social Buttons</a></li>-->
    </ul>
    <h3>Products</h3>
    <ul class="toggle">
      <li class="icn_new_article"><a href="<?=$this->webroot?>admin/product_category_manager">Product Department</a></li>
      <li class="icn_new_article"><a href="<?=$this->webroot?>admin/product_brand">Product Brand</a></li>
      <li class="icn_new_article"><a href="<?=$this->webroot?>admin/add_product_brand">Add Product Brand</a></li>
     <!-- <li class="icn_edit_article"><a href="<?=$this->webroot?>admin/Product_manager">All Product</a></li>-->
      <!--<li class="icn_categories"><a href="<?=$this->webroot?>admin/faq_manager">FAQ's Manager</a></li>-->
      <!--<li class="icn_tags"><a href="#">Social Buttons</a></li>-->
    </ul>
    <h3>Users</h3>
    <ul class="toggle">
      <li class="icn_view_users"><?php echo $this->Html->link('Admin user','/admin/adminUser'); ?></li>
      <!--<li class="icn_add_user"><a href="#">View Users</a></li>
      <li class="icn_profile"><a href="#">Your Profile</a></li>-->
    </ul>
   <h3>Site Settings</h3>
    <ul class="toggle">
      <li class="icn_folder"><a href="<?=$this->webroot?>admin/site_settings">General</a></li>
      <li class="icn_photo"><a href="<?=$this->webroot?>admin/system_settings">System</a></li>
     <!--  <li class="icn_audio"><a href="<?=$this->webroot?>admin/seo_settings">SEO</a></li> -->
      <li class="icn_video"><a href="<?=$this->webroot?>admin/language_settings">Language</a></li>
      <li class="icn_video"><a href="<?=$this->webroot?>admin/social_settings">Social</a></li>
    </ul>
    <h3>Merchant</h3>
    <ul class="toggle">
        <li class="icn_categories"><a href="<?=$this->webroot?>admin/merchants">All Merchants</a></li>
        <li class="icn_categories"><a href="<?=$this->webroot?>admin/ratingReviews">Ratings & Reviews</a></li>
    </ul>
    <h3>Reports</h3>
    <ul class="toggle">
        <li class="icn_categories"><a href="<?=$this->webroot?>admin/merchant/report">Merchants</a></li>
        <li class="icn_categories"><a href="<?=$this->webroot?>admin/products/report">Product</a></li>
        <li class="icn_categories"><a href="<?=$this->webroot?>admin/click_track">Click Track</a></li>
      <!-- <li class="icn_categories"><a href="<?=$this->webroot?>admin/visitors_report">Visitors</a></li>  -->
      <li class="icn_categories"><a href="<?=$this->webroot?>reports">Custom Reports</a></li> 
    </ul>

<h3>Crawlings</h3>
    <ul class="toggle">
        <li class="icn_categories"><a href="<?=$this->webroot?>crawls/souq">SOUQ.COM</a></li>
        <li class="icn_categories"><a href="<?=$this->webroot?>crawls/namshi">NAMSHI.COM</a></li>
         <li class="icn_categories"><a href="<?=$this->webroot?>crawls/markavip">MARKAVIP.COM</a></li>
		  <li class="icn_categories"><a href="<?=$this->webroot?>crawls/ikea">IKEA.COM</a></li>
		   <li class="icn_categories"><a href="<?=$this->webroot?>crawls/sukar">SUKAR.COM</a></li>
		    <li class="icn_categories"><a href="<?=$this->webroot?>crawls/extrastores">EXTRASTORES.COM</a></li>
 
    </ul>
   
     <h3>BACKUP & RESTORE</h3>
    <ul class="toggle">
        <li class="icn_categories"><a href="<?=$this->webroot?>admin/backuprestor/">Backup/Restore</a></li>
       
    </ul>
     <h3>Admin</h3>
    <ul class="toggle">
      <!--<li class="icn_settings"><a href="#">Options</a></li>
      <li class="icn_security"><a href="#">Security</a></li>-->
      <li class="icn_jump_back"><a href="<?=$this->webroot?>admin/logout">Logout</a></li>
    </ul>
    
    <footer>
      <hr />
      <p><strong>Copyright &copy; 2011 MENACOMPARE</strong></p>
      <p>Theme by <a href="http://www.maastrixsolutions.com.com">Maastrix solutions</a></p>
    </footer>
  </aside><!-- end of sidebar -->
<section id="main" class="column">
  <?php echo $this->Session->flash(); ?>
  <?php echo $this->fetch('content'); ?>
</section>

<!-- End: login-holder -->
  <?php echo $this->element('sql_dump'); ?>

<div>
  <?php //print_r($setting);?>
</body>
<style>
.delete_overly
{
  position: fixed;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  top: 0px;
  display: none;

}
  .delete_action_popup{
    width: 50%;
    margin: 100px auto;
    height: auto;
    background: #fff;
    border: 11px solid rgba(85, 82, 82, 0.56);
    border-radius: 5px;

  }
.del_cnf_heading{
  width: 100%;
  font-size: 17px;
  text-align: center;
  padding: 7px 0px;
  background: #4A6EFF;
  color: #fff;
  font-weight: bold;
}
.del_cnf_inner_content .del_cnf_inner_deltails img{
  max-width: 150px;
  max-height: 109px;
  text-align: center;
  display: block;
  margin: 15px auto 0px auto;
}
 .del_cnf_inner_content .del_cnf_inner_deltails  .item_title{
  display: block;
  text-align: center;
  font-weight: bold;
  color: #1C75E7;
  text-transform: capitalize;
  font-size: 15px;
  margin-top: 20px;
 }
 .del_cnf_inner_content .del_cnf_inner_deltails  .conf_msg{
  display: block;
  text-align: center;
  font-size: 15px;
  color: #D36C1B;
 }
 .del_cnf_inner_action{
  border: 2px solid rgba(122, 143, 209, 0.34);
  border-bottom: 0px;
  border-left: 0px;
  border-right: 0px;
  padding: 13px 5px;
  margin-top: 25px;
 }
 .del_cnf_inner_action a{
  padding: 7px 29px;
  background: #5883CF;
  color: #fff;
  margin-left: 16px;
  border-radius: 2px;
  font-weight: bold;
 }
</style>
<script>
function deleteAction(updateUrl,type,title,imgpath,text,js){
  if(js==undefined)
  {
    js=false;
  }
  var CreateDeleteJson={
    'updateUrl':updateUrl,
    'type':type,
    'title':title,
    'imgpath':imgpath,
    'text':text,
    'js':js
  }
    var template = $('#belete_cnf_inner').html();
    console.log(CreateDeleteJson);
    var html = Mustache.to_html(template, CreateDeleteJson);
    console.log(html);
    $('.delete_action_popup').html(html);
    $('.delete_overly').show();
}
function backupAction(updateUrl,type,title,imgpath,text){
  var CreateDeleteJson={
    'updateUrl':updateUrl,
    'type':type,
    'title':title,
    'imgpath':imgpath,
    'text':text
  }
    var template = $('#back_cnf_inner').html();
    console.log(CreateDeleteJson);
    var html = Mustache.to_html(template, CreateDeleteJson);
    console.log(html);
    $('.delete_action_popup').html(html);
    $('.delete_overly').show();
}
function SendMailAction(fromID,toID,msg){
  var CreateDeleteJson={
    'fromID':(fromID=="")?"<?=$setting['Setting']['site_email']?>":fromID,
    'toID':toID,
    'msg':msg,
    
  }
    var template = $('#mail_sending_box_section').html();
    console.log(CreateDeleteJson);
    var html = Mustache.to_html(template, CreateDeleteJson);
    console.log(html);
    $('.delete_action_popup').html(html);
    $('.delete_overly').show();
}

function closeDeleterCnf(){
  $('.delete_overly').hide();
}
function alertBox(text,time){  
  $('.alert_overly').fadeIn();
  $('.alert_notification').text(text);
  setTimeout(function(){
    $('.alert_overly').fadeOut();
  },time)
}
function addCatBox(cid){  
  $('.add_overly').fadeIn();
   var template = $('#add_cat_by_p').html();
    
    var html = Mustache.to_html(template, {'cid':cid});
     $('.alert_notification').html(html);
   // console.log(html);
 // $('.alert_notification').text(text);
  
}

$('#catname').bind("keydown", function (e) {
    if (e.keyCode === 13) {
        $('#but_add_cat').click();
    }
});
function deleteCat(cid)
{
   $.post('<?=$this->webroot?>admin/ajax_delete_cat',{'pid':cid},function(r){
    console.log(r);
        if(r==1)
        {
          $('.delete_overly').hide();
          var id=$('#cat_li_'+cid).parents('.cat_column').attr('id');
          var pid=$('#cat_li_'+cid).parents('.cat_column').data('pid');
          if(pid!=0)
          {
            id=id.split('_');
           getChildCats(pid,(parseInt(id[1])-1))
          }
          else
          {
            window.location.reload();
          }
          
          alertBox('This Category deleted  Successfully',1000);
        }
   })
}
function addCategory(cthis,pid){
   console.log();
  var catname=$(cthis).prev().val();
  if(catname!=""){
    $.post('<?=$this->webroot?>admin/ajax_add_cat_by_parent',{'pid':pid,catname:catname},function(r){
      console.log(r);
      if(r==1)
      {
        $(cthis).prev().val("");
        $('.add_overly').fadeOut();
        alertBox('A new Category added Successfully',1000);
        var id=$('#cat_li_'+pid).parents('.cat_column').attr('id');
        id=id.split('_');
       // console.log(id);
        getChildCats(pid,id[1])
      }
    })
  }
}
window.onload=function(){
 /* deleteAction('http://google.com','Banner Manger','banner9','http://localhost/mena/uploads/banners/032809Bigstock_55003565.jpg','Are you want to delete this banner?') */
// SendMailAction('info@hoppay.com','Panda.sanjay18@gmail.com','hii');
}

</script>
<script id="belete_cnf_inner" type="text/template">
 <div class="del_cnf_heading"> Delete confirmation for "{{type}}" </div>
 <div class="del_cnf_inner_content">
     <div class="del_cnf_inner_deltails">
     {{#imgpath}}
        <img src="{{imgpath}}" alt="">
     {{/imgpath}}
        <span class="item_title">{{title}}</span>
        <span class="conf_msg">{{text}}</span>
     </div>
     <div class="del_cnf_inner_action">
     {{#js}}
        <a href="javascript:void(0)" onclick="{{updateUrl}}">Delete</a>
      {{/js}}
      {{^js}}
        <a href="{{updateUrl}}">Delete</a>
      {{/js}}
        <a href="javascript:void(0)" onclick="closeDeleterCnf()">Cancel</a>
     </div>
 </div>
</script>
<script id="back_cnf_inner" type="text/template">
 <div class="del_cnf_heading"> {{type}} confirmation </div>
 <div class="del_cnf_inner_content">
     <div class="del_cnf_inner_deltails">
     {{#imgpath}}
        <img src="{{imgpath}}" alt="">
     {{/imgpath}}
        <span class="item_title">{{title}}</span>
        <span class="conf_msg">{{text}}</span>
     </div>
     <div class="del_cnf_inner_action">
        <a href="{{updateUrl}}">{{type}}</a>
        <a href="javascript:void(0)" onclick="closeDeleterCnf()">Cancel</a>
     </div>
 </div>
</script>
<style type="text/css">
  .del_cnf_inner_deltails
  {
    padding: 10px;
  }
  .del_cnf_inner_deltails label
  {
    font-family: 'Droid Sans', sans-serif;
    position: inherit;
    color: #252525;
    width: 100%;
    display: block;
    font-size: 12px;
    padding-bottom: 4px;
  }
  .del_cnf_inner_deltails input[type=text], .del_cnf_inner_deltails textarea
  {
    font-size: 12px;
    font-weight: bold;
    vertical-align: middle;
    outline: none;
    width: 99%;
    height: 30px;
    line-height: 30px;
    text-indent: 10px;
    margin-bottom: 7px;
    font-family: 'Droid Sans', sans-serif;
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #D1D1D1;
    border-radius: 3px 3px 3px 3px;
  }
  .del_cnf_inner_deltails textarea{height: 120px;}
  .del_cnf_inner_action input[type=submit]
  {
    padding: 7px 29px;
    background: #5883CF;
    color: #fff;
    margin-left: 16px;
    border-radius: 2px;
    font-weight: bold;
    border:none;
    cursor: pointer;
    height: auto;
  }
  .del_cnf_inner_action input:hover[type=submit], .del_cnf_inner_action a:hover
  {
    background: #FF8500;
  }
</style>

<script id="mail_sending_box_section" type="text/template">
 <div class="del_cnf_heading"> Send Message</div>
 <div class="del_cnf_inner_content">
 <form id="validates_email" action="javascript:void(0);" onSubmit="return sendMail();">
     <div class="del_cnf_inner_deltails">
        <label for="fromemail">From Email ID:</label>
        <input type="text" id="fromemail" multiple  required value="{{fromID}}" name="fromemail">
        <label for="toemail">To Email ID:</label>
        <input type="text"  multiple  required id="fromemail" value="{{toID}}" name="toemail">
        <label for="subject">Subject:</label>
        <input type="text" required id="subject" value="" name="subject">
        <label for="descriptons">Message:</label>
        <textarea name="description" id="descriptons" placeholder="Enter your Message here.">{{msg}}</textarea>

     </div>
     <div class="del_cnf_inner_action">
        <input type="submit" name="Send" value="Send">
        <a href="javascript:void(0)" onclick="closeDeleterCnf()">Cancel</a>
     </div>
     </form>
 </div>
</script>

<script id="add_cat_by_p" type="text/template">
<span>Category Name: </span><input type="text" id="catname" class="catname">
<input type="button" id="but_add_cat" class="but_add_cat" value="Add" onclick="addCategory(this,{{cid}})">

</script>
<!-- Delete Alert popup sections -->
<div class="delete_overly">
  <div class="delete_action_popup">

  </div>
</div>
<!-- Backup and restor section  popup sections -->
<div class="alert_overly">
<div class="alert_notification">

</div>
</div>
<div class="add_overly">
<div class="alert_notification">

</div>
</div>
<!-- Email sending section popup sections -->

</html>