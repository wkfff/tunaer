@extends('admin.common')

@section("content")
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="index.html">快捷面板</a>
            </li>
        </ul>

        <?php
        if( empty(Session::get("mianban")) ) {
            $sql = " select * from options where title='mianban' ";
            $mianban = DB::select($sql);
            Session::put("mianban",$mianban[0]->content);
        }
        $mianban = Session::get("mianban");

        ?>
        {!! $mianban !!}


@stop
