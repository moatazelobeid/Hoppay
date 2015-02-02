<script>

function CheckValidate()
{
  var count=$('li.activate .lag_lists li').length;
  if(count>0)
  {
    $('li.activate .error').hide();
    return true;
  }
  else
  {
    $('li.activate  .error').css('display','block');
    return false;
  }
}
$(function(){

  $("#title").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $("#slug").val(Text);        
});

  $('.Tag_title li').click(function(){
      var index=$(this).index();
      $('.Tag_title li').removeClass('active');
      $('.Tag_title li').eq(index).addClass('active');
      $('.Tag_title_containt>li').hide().removeClass('activate');     
      $('.Tag_title_containt>li').eq(index).addClass('activate').fadeIn();
  })
  
 $('li.activate .lag_lists a').bind('click',function(e){
        e.preventDefault();   
        $(this).parent('li').index() 
        $(this).parent('li').eq(0).next('input').remove();
        $(this).parent('li').eq(0).remove();
      })
  $('li.activate .add_tages_here').keypress(function( event ) {

    if ( event.which == 13 ) {
        event.preventDefault();
        var data=$(this).val();
        console.log(data);
       if(data!="")
       {
     
        $('li.activate .lag_lists').prepend('<li>'+data+'<a>&times;</a></li><input type="hidden" name="all_tages[]" value="'+data+'">');    
        $(this).val('');
       $('li.activate .lag_lists a').bind('click',function(e){
        e.preventDefault();   
        $(this).parent('li').index() 
        $(this).parent('li').eq(0).next('input').remove();
        $(this).parent('li').eq(0).remove();
      })

     }
    }
  })
})
</script>

<article class="module width_full" style="background: #fafafa;">
  <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
  <div class="module_content listing_containt">
    <div class="left_addtag">
      <ul class="Tag_title">
        <li class="active">Add New</li>
        <?php foreach ($tages as $key => $value) { ?>
          <li><?=$value['Tag']['title']?></li>
        <?php } ?>
        
      </ul>
    </div>
    <div class="right_view_tags">
      <ul class="Tag_title_containt" style="position: relative;
top: -20px;">
        <li class="activate">
          <div class="tag_content">
              
                <form class="form_style" action="" method="post" onsubmit="return CheckValidate()">
                <div class="left_content">
                  <div>
                    <label>Enter tag name:</label>
                    <input type="text"  required id="title" placeholder="Enter your tag name" name="title">
                  </div>
                  <div>
                    <label>Enter slug name:</label>
                    <input type="text" required id="slug" placeholder="Enter your slug name" name="slug">
                  </div>
                  <div style="margin-top:24px">
                    <input type="submit" name="add_tags_submit" value="Add Tags">
                    <!--<input type="reset" name="reset" value="Reset">-->
                  </div>
                </div>
                 <div class="right_content">
                  <div>
                     <label>Enter Tages (Press enter):</label>                    
                    <input type="text" class="add_tages_here" placeholder="Enter your Tags" name="tages">
                    <label class="error" style="display:none;color:#f00" >Please add Tages Here (Press Enter)</label>
                  </div>

                  <ul class="lag_lists">
                 

                  </ul>
                </div>
                </form>
          
          </div>
        </li>
       <?php foreach ($tages as $key => $value) { ?>
          <li>
            <script>
            $(function(){
              $('.lag_list_s<?=$value["Tag"]["id"]?> a').bind('click',function(e){
                e.preventDefault();   
                $(this).parent('li').index() 
                $(this).parent('li').eq(0).next('input').remove();
                $(this).parent('li').eq(0).remove();
              })
               $('.add_tages_here<?=$value["Tag"]["id"]?>').keypress(function( event ) {

              if ( event.which == 13 ) {
                  event.preventDefault();
                  var data=$(this).val();
                  console.log(data);
                 if(data!="")
                 {
               
                  $('li.activate .lag_lists').prepend('<li>'+data+'<a>&times;</a></li><input type="hidden" name="all_tages[]" value="'+data+'">');    
                  $(this).val('');
                 $('li.activate .lag_lists a').bind('click',function(e){
                  e.preventDefault();   
                  $(this).parent('li').index() 
                  $(this).parent('li').eq(0).next('input').remove();
                  $(this).parent('li').eq(0).remove();
                })

               }
              }
            })
             });
            </script>
          <div class="tag_content">
            <form class="form_style" action="" method="post" onsubmit="return CheckValidate()">
               <div class="left_content">
                  <h2><?=$value['Tag']['title']?></h2>
                  <h4>Key: <?=$value['Tag']['slug']?></h4>
                  <h5><b>Use the below code to fetch the tags.</b></h5>
                  
<code style="width:200px;word-wrap: break-word;">
  <pre>
&lt;?php 
echo $this->Template->GetTagesByKey('<?=$value['Tag']['slug']?>');
?&gt;
  </pre>
</code>
                  </pre>
                  <?php $tags=json_decode($value['Tag_lang']['tags'])?>
                  <?php //print_r($tags)?>
                  <input type="hidden" name="tag_id" value="<?=$value["Tag"]["id"]?>">.
                  <input type="hidden" name="tag_id_lang" value="<?=$value["Tag_lang"]["id"]?>">
                  <div style="margin-top:24px">
                    <input type="submit" name="add_tags_update" style="width: 100px;" value="Update Tags">
                    <input type="submit" name="delete" value="Delete">
                  </div>
               </div>
               <div class="right_content">
                 <div>
                     <label>Enter Tages (Press enter):</label>                    
                    <input type="text" class="add_tages_here<?=$value["Tag"]["id"]?>" placeholder="Enter your Tags" name="tages">
                    <label class="error" style="display:none;color:#f00" >Please add Tages Here (Press Enter)</label>
                  </div>
                  
                  <ul class="lag_lists lag_list_s<?=$value["Tag"]["id"]?>">
                  <?php foreach ($tags as $k => $val) { ?>
                    <li><?=$val?><a>&times;</a></li>
                    <input type="hidden" name="all_tages[]" value="<?=$val?>">
                  <?php } ?>

                  </ul>
               </div>
             </form>
          </div>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</article>