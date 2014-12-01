
    $(document).ready(function() {
 $('.ratings .ratings_stars').hover(

            // Handles the mouseover

            function() {

                $(this).prevAll().andSelf().addClass('ratings_over');
               

            },

            // Handles the mouseout

            function() {

                $(this).prevAll().andSelf().removeClass('ratings_over');
                var id=$(this).parent().attr('id');
                console.log(id);
                $('#'+id+' div').each(function(k,v){

                   var select=$(this).parent().next().val();
                   console.log(select);
                   if(select!=undefined)
                    if(k<select)
                    {
                          $(this).prevAll().andSelf().addClass('ratings_over');
                    }
                })

            }

        );
//send ajax request to rate.php
        $('.ratings .ratings_stars').bind('click', function() {
			
			var id=$(this).parent().attr("id");
		    var num=$(this).attr("class");

            $(this).addClass('select');
			//var poststr="id="+id+"&stars="+num;
          var cla= num.split(' ');
          var fnum= cla[0].split('_');
          console.log(fnum[1]);
            $(this).parent().next().val(fnum[1]);
             var id=$(this).parent().attr('id');
                console.log(id);
        		/*$.ajax({url:"rate.php",cache:0,data:poststr,success:function(result){
                        document.getElementById(id).innerHTML=result;}
                });	*/
            $('#'+id+' div').removeClass('ratings_over');
               $('#'+id+' div').each(function(k,v){
               // console.log($(this).parent().next().next());
                   var select= $(this).parent().next().val();

                   //console.log(select);
                   //console.log(k);
                   if(select!=undefined)
                    if(k<select)
                    {
                          //console.log( $(this).prevAll().andSelf());
                          $(this).prevAll().andSelf().addClass('ratings_over');
                    }
                })


		});

 
        });
function removeRatings(slecter){
  slecter.find('div').removeClass('ratings_over');
  slecter.find('div').removeClass('select');
  slecter.next().val('')

}

        
