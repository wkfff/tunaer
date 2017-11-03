@extends("wap.common")

@section("meta")
    <meta name="theme-color" content="#e83888">
@stop
@section("title","正在聊天...")
@section("css")
    <style>
        .leftchat,.rightchat{
            margin:20px 0;vertical-align: middle;
        }
        .chathead{
            display: inline-block;height:40px;width:40px;background-size:cover;background-position:center;border-radius:20px;vertical-align: middle;cursor:pointer;margin:0 5px;
        }
        .leftchat>.chathead{
            float:left;
        }
        .rightchat>.chathead{
            float:right;
        }
        .chatcontent{
            font-size:16px;float:right;max-width:400px;
        }
        .leftchat>.chatcontent{
            float:left;color:#444;margin-left:20px;
        }
        .rightchat>.chatcontent{
            float:right;color:forestgreen;margin-right:20px;
        }
        .chattime{
            clear:both;color:#999;font-size:13px;margin-top:10px;text-align:left;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:55px;background:#efefef;color:#333;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:45px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        <span style="max-width:180px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;line-height:55px;">{{$userinfo->uname}}</span>
        <span onclick="delchat({{$userinfo->uid}})"  style="float:left;position: absolute;right:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-trash" ></span>
    </div>
    <div class="content" style="margin-top:60px;" >
        <a href="javascript:void(0)" onclick="getchathistory({{$userinfo->uid}})" style="font-size:14px;display: block;text-align:center;">加载更多

        </a>
        <div class="chatbox">

        </div>

        <div style="height:50px;position:fixed;bottom:0px;left:0px;width:100%;" >
            <input id="chatinput" placeholder="请输入内容..." type="text" style="height:50px;width:80%;border:none;background:none;background:#efefef;float:left;font-size:16px;padding-left:10px;" >
            <div onclick="sendchat({{$userinfo->uid}})" style="float:left;width:20%;height:50px;background:#e83888;text-align:center;line-height:50px;font-size:16px;color:#fff;" >发送</div>
        </div>

    </div>

    {{--@include("wap.footer")--}}


@stop

@section("htmlend")
    <script>
        window.chatpage = 1;
        getchathistory({{$userinfo->uid}});
        function getchathistory(userid) {
            $.post("/getchathistory",{"userid":userid,"page":window.chatpage},function(d){
                if( res = ajaxdata(d) ) {
                    if( res.length == 0 && window.chatpage!=1) {
                        toast("没有更多了"); return ;
                    }
                    var tmpcls = "tmp"+(new Date()).getTime();
                    $(".chatbox").append("<div class='"+tmpcls+"' ></div>");
                    for( var i=res.length-1;i>=0;i-- ) {
                        // 我方是接受方
                        if( res[i].fid == userid ) {

                            var item = `<div class="leftchat">
                                    <div onclick="location.href='/user/${userid}'" class="chathead" style="background-image:url(/head/${res[i].fid});" ></div>
                                    <div class="chatcontent">
                                    ${chatmessage(res[i].content,res[i].fid,res[i].type,userid)}
                                        <div class="chattime" >
                                            ${res[i].stime.substr(5,11)}
                                        </div>
                                    </div>
                                    <div style="clear:both" ></div>
                                </div>`;
                        }else{
                            var item = `<div class="rightchat">
                                    <div class="chathead" style="background-image:url(/head/${res[i].fid});" ></div>
                                    <div class="chatcontent">
                                    ${chatmessage(res[i].content,res[i].fid,res[i].type,userid)}
                                        <div class="chattime" style="text-align:right;" >
                                            ${res[i].stime.substr(5,11)}
                                        </div>
                                    </div>
                                    <div style="clear:both" ></div>
                                </div>`;
                        }
                        $("."+tmpcls).append(item);
                    }
                    if( window.chatpage > 1 ) {
                        $(".chatbox").prepend($("."+tmpcls));
                    }else{
                        $(".chatbox").append($("."+tmpcls));
                    }

                    window.chatpage++;
                    $('#myModal3').modal('show');
                }
            })
        }
        function chatmessage(message,fid,type,userid) {
            if( type == "2" ) {
                if( fid == userid ) {
                    return "我给Ta打了个招呼";
                }else{
                    return "Ta给我打了个招呼";
                }
            }else{
                return message;
            }

        }
        function sendchat(userid) {
            var content = $("#chatinput").val();

            if( $.trim(content) == '' ) {
                toast("请输入聊天内容"); return;
            }
            $.post("/sendchat",{"userid":userid,"content":content},function(d){
                if( ajaxdata(d) ) {
                    var tmpcls = "tmp"+(new Date()).getTime();
                    $(".chatbox").append("<div class='"+tmpcls+"' ></div>");
                    var item = `<div class="rightchat">
                                    <div class="chathead" style="background-image:url(/head/{{Session::get('uid')}});" ></div>
                                    <div class="chatcontent">
                                    ${content}
                                        <div class="chattime" style="text-align:right;" >
                                            ${(new Date()).getHours()+":"+(new Date()).getMinutes()}
                                        </div>
                                    </div>
                                    <div style="clear:both" ></div>
                                </div>`;
                                $("."+tmpcls).append(item);
                }
            })
        }

        function delchat(userid){
            if( confirm("确定删除聊天记录并解除好友？") ) {
                $.post("/delchat/"+userid,{},function(d){
                    if(ajaxdata(d)) {
                        location.href="/chatlist";
                    }
                })
            }
        }
    </script>

@stop