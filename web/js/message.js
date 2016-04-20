/*
setInterval(function(){
    $.getJSON( "ajax/test.json", function( data ) {
        $.each( data, function( key, val ) {
            items.push( "<li id='" + key + "'>" + val + "</li>" );
        });

        $( "<ul/>", {
            "class": "my-new-list",
            html: items.join( "" )
        }).appendTo( "body" );
    });
}, 3000);
*/

( function ($){

    $.fn.AddMsgToMenuMsg=function($thread){
        $new=$('<li>' +
            '<a href="'+$thread.link+'#message_'+$thread.message.id+'">' +
            '<div class="pull-left">' +
            '<img src="'+$thread.message.icon+'" class="img-circle" alt="'+$thread.message.sender+'">' +
            '</div>' +
            '<h4>' +
            $thread.message.sender+
            '<small><i class="fa fa-clock-o"></i>'+$thread.message.createAt+'</small>' +
            '</h4>' +
            '<p>'+$thread.message.body+'</p>' +
            '</a>' +
            '</li>');

        this.append($new);

    }

}(jQuery));



$( document ).ready(function(){

    var $cache=[];

    $('#envelope_click').click(function(){
        $('#menu_messages').children().remove();
        var $url=$('#menu_messages').data("url-msg");
        $.getJSON( $url, function( data ) {
            $.each( data, function( key, val ) {
                console.log(val);
                if(val.id in $cache){}
                else{
                    $('#menu_messages').AddMsgToMenuMsg(val);
                }
            });
        });
    });
});
