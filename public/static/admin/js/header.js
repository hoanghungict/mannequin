
var x =10;
var ready = true;
$('.menu').scroll(function() {
    if(ready && $(this).scrollTop() + $(this).innerHeight() > this.scrollHeight) {
        ready = false;
        $( "#loadding" ).removeClass( "hidden" );
        $.ajax({

            type:"GET",
            url:"/admin/load-notification/"+x,
            success:function(data){
                $.each(data, function(key,val) {
                    $(".menu").append(""+
                        "<li style='background-color: #edf2fa'>"+
                        "<li>"+
                        "<a href=''>"+
                        "<div class='pull-left'>"+
                        "<img src='' class='img-circle' alt='User Image'>"+
                        "</div>"+
                        "<h4>"+val.category_type+"<small><i class='fa fa-clock-o'></i>"+
                        "</small>"+
                        "</h4>"+
                        "<p>"+val.content+"</p>"+
                        "</a>"+
                        "</li>"+
                        "</ul>"+
                        "</li>"
                    );
                });
            }

        })
            .always(function()
            {
                ready = true;
                $( "#loadding" ).addClass('hidden');
            });
        x += 10;
    }

});