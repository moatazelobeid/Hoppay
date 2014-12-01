var hintShown = false;
$(function(){

$('.anpHintable').focus(onHintableFocus);

	
})
var onHintableFocus = function() {
    var pos = $(this).offset();
    //console.log(pos);
    if (!hintShown) {
      $('#anpHint').css('top', pos.top-256).fadeIn();
      
      hintShown = true;
    } else {
      $('#anpHint').animate({
        top: (pos.top-256)
      });
     
    }
 $('.anpHintArrow').animate({
        marginLeft:'-28px',
       
      })
      $('.anpHintArrow').animate({
        marginLeft:'-20px',
       
      })
      $('.anpHintArrow').animate({
        marginLeft:'-28px',
       
      })
      $('.anpHintArrow').animate({
        marginLeft:'-20px',
       
      })
    var hintNum = parseInt($(this).attr('data-hint-num'));
    $('#anpHintHeader').text(tipNames[hintNum]);
    $('#anpHintContent').html(tips[hintNum]);
  }