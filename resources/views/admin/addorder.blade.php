@extends("admin.common")

@section("title","领队列表")

@section("content")

    <div class="content" >
        <div style="padding-left:80px;position: relative;padding-top:5px;padding-right:10px;background-color:#fff;" >
            <div style="height:70px;width:70px;background-image:url(/admin/data/images/{{$data->pictures}});background-size:cover;background-position:center;position: absolute;left:5px;top:5px;" ></div>
            <div>
                {{$data->title}}
            </div>
            <span style="color:#FF9531;font-size:20px;">￥{{$data->price}}</span>
        </div>
        <div style="clear:both" ></div>
        <div style="height:60px;line-height:60px;background: #f5f5f5;padding:0 10px;margin-top:40px;" >
            <span style="float:left" >游客信息</span>
        </div>
        <div style="background:#fff;" class="youkelist">
            {{--<div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;">--}}
            {{--<p>张三 TEL：18328402803</p>--}}
            {{--<p>身份证：511002199109187631</p>--}}
            {{--<div  onclick="removeyouke(this)"  style="position: absolute;right:20px;color:#FF9531;top:25px;font-size:20px;" ><span class="glyphicon glyphicon-minus-sign" ></span></div>--}}
            {{--</div>--}}
        </div>
        <div onclick="$('#myModal2').modal('show')" style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;color:#FF9531;font-size:16px;background: #fff;cursor:pointer;" ><span style="margin:10px;" class="glyphicon glyphicon-plus-sign" ></span>添加游客</div>
        <div style="height:40px;line-height:40px;background: #f5f5f5;padding:0 10px;margin-top:10px;" >
            <span style="float:left" >联系人/预订人信息</span>
        </div>
        <div style="background-color: #fff;">
            <div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;font-size:16px;" >姓名：
                <input name="c-name" type="text" value="" style="border:none;background:none;" placeholder="联系人姓名"  >
            </div>
            <div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;font-size:16px;" >电话：
                <input name="c-mobile" type="text" value="" style="border:none;background:none;" placeholder="联系人电话"  >
            </div>
        </div>

        <div style="height:40px;line-height:40px;background: #f5f5f5;padding:0 10px;margin-top:10px;" >
            <span style="float:left" >出发日期(不同集合地点请分次下单)</span>
        </div>
        <div style="background-color: #fff;">
            <div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;font-size:16px;" >出发日期：{{$data->startday}}</div>
            <div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;font-size:16px;" >集合地点：
                <select name="jihe" class="form-control" style="width:240px;display: inline-block">
                    @for( $res = explode("#",$data->jihedidian),$i=0;$i<count($res);$i++  )
                        <option value="{{$res[$i]}}">{{$res[$i]}}</option>
                    @endfor
                </select>
            </div>
            <div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;font-size:16px;" >信息备注：
                <input name="mark" type="text" class="form-control" style="width:240px;display: inline-block"></div>
        </div>

    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加游客</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label >真实姓名 <span style="color:red">*</span></label>
                        <input class="form-control" type="text" value="" placeholder="真实姓名" name="bm-realname" >
                    </div>
                    <div class="form-group">
                        <label >联系手机 <span style="color:red">*</span></label>
                        <input class="form-control" type="text" value="" placeholder="联系号码" name="bm-mobile" >
                    </div>
                    <div class="form-group">
                        <label >身份证号 <span style="color:red">*</span></label>
                        <input class="form-control" type="text" value="" placeholder="身份证号" name="bm-idcard" >
                    </div>
                    <button onclick="addyouke()" type="button" class="btn btn-primary">添加</button>
                </div>

            </div>
        </div>
    </div>

    <div style="height:70px;" ></div>
    <div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;font-size:16px;" ><span  style="color:red">会员的登录手机号：</span>
        <input id="userphoneInput"  type="text" value="" style="border:none;background:none;border-radius:0;border-bottom:1px solid red !important;" placeholder=""  >
    </div>
    <div onclick="tijiaobaoming()" style="float:left;width:30%;height:50px;background:#FF9531;text-align:center;line-height:50px;font-size:18px;color:#fff;cursor:pointer" >提交订单</div>
@stop


@section("htmlend")
    <script>
        function addyouke() {
            var realname = $("input[name='bm-realname']").val();
            var mobile = $("input[name='bm-mobile']").val();
            var idcard = $("input[name='bm-idcard']").val();
            if( $.trim(realname) == '' || mobile.length != 11 || idcard.length != 18  ) {
                toast("信息格式填写有误");return ;
            }
            var item = `<div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;">
                <p>${realname} TEL: ${mobile}</p>
                <p>身份证: ${idcard}</p>
                <div onclick="removeyouke(this)" style="position: absolute;right:20px;color:#FF9531;top:25px;font-size:20px;" ><a href="javascript:void(0)">删除</a></div>
            </div>`;
            $(".youkelist").append(item);
            $("#myModal2").modal("hide");
            $(".currentmoney").text("{{$data->price}}"*$(".youkelist").children("div").length);
            $(".num").text($(".youkelist").children("div").length);
        }
        function removeyouke(that) {
            $(that).parent("div").remove();
            $(".currentmoney").text("{{$data->price}}"*$(".youkelist").children("div").length);
            $(".num").text($(".youkelist").children("div").length);
        }

        function tijiaobaoming() {
            var c_name = $("input[name='c-name']").val();
            var c_mobile = $("input[name='c-mobile']").val();
            var jihe = $("select[name='jihe']").val();
            var mark = $("input[name='mark']").val();
            var youkes = new Array();
            var tmp = $(".youkelist").children("div");
            if( tmp.length == 0 ) {
                toast("请至少添加一个游客"); return ;
            }
            for( var i=0;i<tmp.length;i++ ) {
                var pos = {
                    "name":$($(tmp[i]).children("p")[0]).text().split("TEL")[0],
                    "mobile":$($(tmp[i]).children("p")[0]).text().substr(-11),
                    "idcard":$($(tmp[i]).children("p")[1]).text().substr(5),
                };
                youkes.push(pos);
            }
            youkes = JSON.stringify(youkes);
            $.post("/admin/addorder",{
                "tid":"{{$data->id}}",
                "realname":c_name,
                "mobile":c_mobile,
//                "idcard":$("input[name=tb-idcard]").val(),
                "num":tmp.length,
                "jihe":jihe,
                "youkes":youkes,
                "mark":mark,
                "userphone":$("#userphoneInput").val()
            },function(d){
                if( res = ajaxdata(d) ) {
                    toast(res);
                    setTimeout(function(){
                        history.go(-1);
                    },1000)
                }
            })
        }
    </script>

@stop