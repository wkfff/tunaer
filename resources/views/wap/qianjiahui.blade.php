<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>千佳汇网约车司机办证信息收集表</title>
    <link rel="stylesheet" href="/web/css/bootstrap.min.css">
    <link rel="stylesheet" href="/web/css/common.css">
</head>
<body style="background:#FCFCFC;color: #222; ">
<div style="height:44px;background:#6A6A6A;" ></div>
<form action="/doqianjiahui" method="GET">
<h2 class="form-title col-md-12 font-family-inherit" style="font-size: 1.667em; font-weight: normal; text-align: left;">
    千佳汇网约车司机办证信息收集表
</h2>
<div class="form-description col-md-12" style="margin-top:20px;">
    <p>* 信息请填写完整信息，不要写简称。</p>
    <p>
        大成都包含：锦江区、青羊区、金牛区、武侯区、成华区、龙泉驿区、青白江区、新都区、温江区、双流区、都江堰市、彭州市、邛崃市、崇州市、简阳市、金堂县、郫都区、大邑县、蒲江县、新津县</p>
</div>
<div class="form-group col-md-12">
    <label for="exampleInputEmail1">司机姓名 <span style="color:red" >*</span></label>
    <input type="text" name="name" required class="form-control" placeholder="姓名" >
</div>
<div class="form-group col-md-12">
    <label for="exampleInputEmail1">注册车牌 <span style="color:red" >*</span></label>
    <div>车牌一律大写</div>
    <input type="text" name="chepai" required class="form-control" value="" placeholder="川A 68430">
</div>
<div class="form-group col-md-12">
    <label for="exampleInputEmail1">注册手机号 <span style="color:red" >*</span></label>
    <input type="number" oninput="if(value.length>11)value=value.slice(0,11)"  required name="phone" placeholder="手机号" class="form-control" value="" >
</div>
<div class="form-group col-md-12">
    <label for="exampleInputEmail1">户口所在地 <span style="color:red" >*</span></label>
    <br>
    <select name="pri" class="form-control" required id="pro" onchange="loadC(this)" style="width:49%;display: inline-block;">
        <option value="">地区 - 省</option>
    </select>
    <select name="city" class="form-control" required id="city" style="width:49%;display: inline-block;">
        <option value="">地区 - 市</option>
    </select>
</div>

<div class="form-group col-md-12">
    <label >是否拥有大成都居住证 <span style="color:red" >*</span></label>
    <div class="radio">
        <label>
            <input type="radio" name="hasjuzhuzheng"  value="1" checked>
            有
        </label>
        <label>
            <input type="radio" name="hasjuzhuzheng"  value="0">
            无
        </label>
    </div>

</div>
<div class="form-group col-md-12">
    <label >是否需要代办居住证 <span style="color:red" >*</span></label>
    <div class="radio">
        <label>
            <input type="radio" name="needjuzhuzheng"  value="1" checked>
            需要
        </label>
        <label>
            <input type="radio" name="needjuzhuzheng"  value="0">
            不需要
        </label>
    </div>
</div>
<div class="form-group col-md-12">
    <label >是否愿意转入运营性质 <span style="color:red" >*</span></label>
    <div class="radio">
        <label>
            <input type="radio" name="yunying"  value="1" checked>
            愿意
        </label>
        <label>
            <input type="radio" name="yunying" value="0">
            不愿意
        </label>
    </div>
</div>
<div class="form-description col-md-12" style="margin-top:20px;">
    <p>欢迎有意向的师傅提交资料，具体考试详情我们会以短信的方式通知您</p>
</div>
<div class="form-group col-md-12">
    <input type="submit" class="form-control btn btn-primary " style="height:40px;" value="提交报名" >
</div>
</form>
</body>
</html>

<script src="/web/js/jquery.min.js" ></script>
<script src="/web/js/bootstrap.min.js" ></script>
<script src="/web/js/addr.js" ></script>

<script>
    function loadP() {
        for( var i=0;i<pro.length;i++ ) {
            var node = "<option value='"+pro[i]+"'>"+pro[i]+"</option>";
            $("#pro").append(node);
        }
    }
    function loadC(that) {
        $("#city").children().remove();
        $("#city").append("<option value=''>地区 - 市</option>");
        var val = $(that).val();
        if( $.trim(val) != '' ) {
            var tmps = city[val];
            for( var i=0;i<tmps.length;i++ ) {
                var node = "<option value='"+tmps[i]+"'>"+tmps[i]+"</option>";
                $("#city").append(node);
            }
        }

    }
    $(document).ready(function(){
        loadP();
    })
</script>