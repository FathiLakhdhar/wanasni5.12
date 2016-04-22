
( function ($){

    $.fn.AddMsgToMenuMsg=function(data){

        var element=this;

        $.each( data, function( key, $thread ) {

            var $class="";
            if(!$thread.message.isRead){
                $class="bg-info";
            }

        $new=$('<li class="'+$class+'">' +
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

            element.append($new);
        });
    }


}(jQuery));


function isEqual(data,cache){

    var bool= true;

    if(cache.length==0 || data.length==0 || data.length>cache.length){
        bool=false;
        return false;
    }

    $.each( data, function( key, $thread ) {
        if($thread.id != cache[key].id){bool=false; return false;}
        if($thread.message.id != cache[key].message.id){bool=false;return false;}
    });
    return bool;
}


function UpdateMenuMsg(){
    var $cache=[];
    var menu_message=$('#menu_messages');

    $('#envelope_click').click(function(){
        var $url=menu_message.data("url-msg");

        $('#msg_load').show();
        menu_message.children().remove();
        menu_message.AddMsgToMenuMsg($cache);

        $.getJSON( $url, function( data ) {
            if(isEqual(data,$cache)){
                $('#msg_load').hide();
                return false;
            }
            else{
                $('#msg_load').hide();
                menu_message.children().remove();
                menu_message.AddMsgToMenuMsg(data);
                $cache=data;
            }



        });
    });
}

function NotifMessage(){
    var $cache=$('#nb_msg_unread').data('nb-unread');
    var menu_message=$('#menu_messages');
    var htmlelementUnreadMsg=$('li.message_nb_unread');
    var $url=htmlelementUnreadMsg.data("messages-nb-unread");
    setInterval(function(){
        $.getJSON($url, function( data ) {
            $('.nb_msg_unread').each(function(){
                if($cache != data['NbUnreadMessages']){
                    $(this).html(data['NbUnreadMessages']);
                    $('#chatAudio')[0].play();
                    $cache=data['NbUnreadMessages'];
                }
            });
        });
    }, 3000);
}

$( document ).ready(function(){
    UpdateMenuMsg();
    NotifMessage();
});
