<?
# CSS files
echo $this->Html->css('assets/global/plugins/datatables/datatables.min.css');
echo $this->Html->css('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');
echo $this->Html->css('assets/global/css/components.min.css');
# JS files
echo $this->Html->script('assets/global/scripts/datatable.js');
echo $this->Html->script('assets/global/plugins/datatables/datatables.min.js');
echo $this->Html->script('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');
?>
<!-- BEGIN CONTAINER -->
<style>
    .clickable{
        cursor: cell;
    }
    .unclickable{
        cursor: not-allowed;
    }
    .split_cell{
        border-bottom: 1px solid #000 !important;
    }
</style>
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>売上成績 <small>windows 8 style tiles examples</small></h1>
                </div>
                <div class="page-toolbar">
                    <!-- BEGIN THEME PANEL -->
                    <div class="btn-group btn-theme-panel">
                        <a href="#form_modal2" class="btn dropdown-toggle" data-toggle="modal">
                            <span class="badge badge-default" style="background: red;">日付変更</span>
                            <i class="icon-calendar"></i>
                        </a>
                    </div>
                    <!-- END THEME PANEL -->
                </div>
                <div id="form_modal2" class="modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">日付選択</h4>
                            </div>
                            <div class="modal-body">
                                <div id="formBd"></div>
                                <style type="text/css">
                                    .ui-state-active{background: #4DB2B6;}
                                    .ui-datepicker{width: 100%; font-family: 'Monda', sans-serif; text-align: center; background: #48C2C2; margin: 0 0 10px 0}
                                    .ui-datepicker a{color: #fff;}
                                    .ui-datepicker-calendar{width: 100%;}
                                    .ui-datepicker-group{margin: 0 0 10px 0;background: #48C2C2;}
                                    .ui-datepicker-header {color: #fff;padding: 15px;text-transform: uppercase;letter-spacing: 3px;}
                                    .ui-datepicker-calendar thead th{color: #fff; padding:10px;}
                                    .ui-datepicker-calendar th,.ui-datepicker-calendar td{font-size: 14px; color: #378F8F; text-align: center;}
                                    .ui-datepicker-calendar td span{display: block; padding:10px;}
                                    .ui-datepicker-calendar td a{color: #fff; display: block; padding:10px;}
                                    .ui-datepicker-title{clear: both;}
                                    .ui-datepicker-prev{float: left;}
                                    .ui-datepicker-next{float: right;}
                                </style>
                                <script>
                                    $(function(){
                                        //パラメータ取得
                                        var url = location.href;
                                        var parameters = url.split("?");
                                        var params = parameters[1].split("&");
                                        var paramsArray = [];
                                        for ( i = 0; i < params.length; i++ ) {
                                            neet = params[i].split("=");
                                            paramsArray.push(neet[0]);
                                            paramsArray[neet[0]] = neet[1];
                                        }
                                        var queryDate = paramsArray["date"];

                                        // DATE PICKER
                                        $('#formBd').datepicker({
                                            dateFormat: "yy-mm-dd",
                                            onSelect: function(dateText, inst){
                                                var date  = dateText;
                                                var str = date.split('-');
                                                var month = str[0]+'-'+str[1]+'-01';
                                                var url   = location.href;
                                                var parameters    = url.split("?");
                                                var dateJob = parameters[1].split("=");
                                                if (date != dateJob[1]) {
                                                    window.location.href = '?date='+month;
                                                };
                                            }
                                        });
                                        $('#formBd').datepicker("setDate", queryDate);

                                    });
                                </script>
                            </div>
                            <div class="modal-footer">
                                <h5 class="modal-title">日付をタップしてください</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PAGE TITLE -->
            </div>
        </div>
        <div class="page-container">
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="container">
                    <!-- BEGIN PAGE BREADCRUMBS -->
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?= $this->Html->url(array('controller'=>'member_profiles', 'action'=>'index'));?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="#">More</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="#">Tables</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span>Datatables</span>
                        </li>
                    </ul>
                    <!-- END PAGE BREADCRUMBS -->
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase">支出入力（<?echo date('Y年m月', strtotime($date));?>分）</span>
                                        </div>
                                        <div class="tools"></div>
                                    </div>
                                    <div class="portlet-body">
                                        <form id="tableForm" role="form" action="" method="post">
                                            <input type="hidden" class="date" value="<?echo $date;?>">
                                            <table class="table table-striped table-hover table-bordered" id="sample_1" style="border-bottom-color: #e7ecf1">
                                                <thead>
                                                <tr>
                                                    <th> Num </th>
                                                    <th> 分類 </th>
                                                    <?foreach($associations as $association):?>
                                                        <th><?echo $association['Location']['name'];?>（<?echo $association['Attribute']['name'];?>）</th>
                                                    <?endforeach;?>
                                                    <th> 合計 </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="background-color: #FFE4C4;">
                                                        <td>
                                                            <?$num=5;echo $num;?>
                                                        </td>
                                                        <td class="split_cell">
                                                            <strong>総売上（税込）</strong>
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable split_cell">
                                                                <?= $summaries[$id]['total'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['total'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable split_cell">
                                                            <?= $total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="10%">
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td width="20%">
                                                            フード売上
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="numeric unclickable" width="15%">
                                                                <?= $summaries[$id]['food'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['food'];?>
                                                        <?endforeach;?>
                                                        <td class="numeric unclickable" width="10%">
                                                            <?= $total;?>
                                                        </td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid #000;">
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td class="split_cell">
                                                            ドリンク売上
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable split_cell">
                                                                <?= $summaries[$id]['drink'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['drink'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable split_cell">
                                                            <?= $total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            ランチ売上
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable">
                                                                <?= $summaries[$id]['lunch'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['lunch'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?= $total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            アラカルト売上
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable">
                                                                <?= $summaries[$id]['dinner'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['dinner'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?= $total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            コース売上
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable">
                                                                <?= $summaries[$id]['course'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['course'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?= $total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td class="split_cell">
                                                            テイクアウト売上
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable split_cell">
                                                                <?= $summaries[$id]['takeout'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['takeout'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable split_cell">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            ランチ客数
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable">
                                                                <?= $summaries[$id]['lunch_visitors'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['lunch_visitors'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            アラカルト客数
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable">
                                                                <?= $summaries[$id]['dinner_visitors'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['dinner_visitors'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            コース客数
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable">
                                                                <?= $summaries[$id]['course_visitors'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['course_visitors'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td class="split_cell">
                                                            テイクアウト客数
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable split_cell">
                                                                <?= $summaries[$id]['takeout_visitors'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['takeout_visitors'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable split_cell">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #fa8072;">
                                                        <td>
                                                            <?$num+=7;echo $num;?>
                                                        </td>
                                                        <td class="split_cell">
                                                            <strong>純売上（税抜）</strong>
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable split_cell">
                                                                <?= $summaries[$id]['total']-$summaries[$id]['tax']-$summaries[$id]['discount'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['total']-$summaries[$id]['tax']-$summaries[$id]['discount'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable split_cell">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <!-- BEGIN 買掛 -->
                                                    <?foreach($kaikake as $key => $kaikake_category):?>
                                                        <?if($key!="消耗品"&&$key!="その他"):?>
                                                        <tr>
                                                            <td>
                                                                <?$num++;echo $num;?>
                                                            </td>
                                                            <td>
                                                                <?echo $key;?>
                                                            </td>
                                                            <?$total=0;?>
                                                            <?foreach($associations as $association):?>
                                                                <?$id=$association['Association']['id'];?>
                                                                <td class="unclickable">
                                                                    <?if(isset($kaikake_category[$id])){echo $kaikake_category[$id];$total+=$kaikake_category[$id];}else{echo 0;}?>
                                                                </td>
                                                            <?endforeach;?>
                                                            <td class="unclickable">
                                                                <?echo $total;?>
                                                            </td>
                                                        </tr>
                                                        <?endif;?>
                                                    <?endforeach;?>
                                                    <!-- END 買掛 -->
                                                    <!-- BEGIN 給与（社員） -->
                                                    <?$num=28;?>
                                                    <tr>
                                                        <td style="background-color:#7FFF00 !important">
                                                            <?=$num;?>
                                                        </td>
                                                        <td>
                                                            給与（社員）
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="clickable">
                                                                <span><?if(isset($full_salary[$id])){echo $full_salary[$id];$total+=$full_salary[$id];}?></span>
                                                                <input class="form-control inputNumber visible" type="text" value="<?= $full_salary[$id];?>" placeholder="金額を入力してください" style="display: none;">
                                                                <input type="hidden" class="association" value="<?= $id;?>">
                                                                <input type="hidden" class="type" value="full">
                                                                <input type="hidden" class="model" value="MonthlySalary">
                                                            </td>
                                                        <?endforeach;?>
                                                        <td class="totalSum">
                                                            <?= $total;?>
                                                        </td>
                                                    </tr>
                                                    <!-- END 給与 -->
                                                    <!-- BEGIN 給与（アルバイト） -->
                                                    <tr>
                                                        <td style="background-color: #7FFF00!important">
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            給与（アルバイト）
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="clickable">
                                                                <span><?if(isset($part_salary[$id])){echo $part_salary[$id];$total+=$part_salary[$id];}?></span>
                                                                <input class="form-control inputNumber visible" type="text" value="<?= $part_salary[$id];?>" placeholder="金額を入力してください" style="display: none;">
                                                                <input type="hidden" class="association" value="<?= $id;?>">
                                                                <input type="hidden" class="type" value="part">
                                                                <input type="hidden" class="model" value="MonthlySalary">
                                                            </td>
                                                        <?endforeach;?>
                                                        <td class="totalSum">
                                                            <?echo $total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #7FFF00!important">
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            福利厚生費
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="clickable">
                                                                <span><?if(isset($fukuri[$id])){echo $fukuri[$id];$total+=$fukuri[$id];}?></span>
                                                                <input class="form-control inputNumber visible" type="text" value="<?= $fukuri[$id];?>" placeholder="金額を入力してください" style="display: none;">
                                                                <input type="hidden" class="association" value="<?= $id;?>">
                                                                <input type="hidden" class="type" value="fukuri">
                                                                <input type="hidden" class="model" value="MonthlySalary">
                                                            </td>
                                                        <?endforeach;?>
                                                        <td class="totalSum">
                                                            <?echo $total;?>
                                                        </td>
                                                    </tr>
                                                    <!-- END 給与 -->
                                                    <!-- BEGIN 定額支出 -->
                                                    <?$num+=2;?>
                                                    <?foreach($expense as $category):?>
                                                        <tr>
                                                            <td style="background-color: #7FFF00!important">
                                                                <?$num++;echo $num;?>
                                                            </td>
                                                            <td>
                                                                <?echo $category['ExpenseDfType']['name'];?>
                                                            </td>
                                                            <?$total=0;?>
                                                            <?if($category['Intermediate']!=null):?>
                                                                <?foreach($category['Intermediate'] as $intermediate_three):?>
                                                                    <?if(isset($intermediate_three['ThisMonth'])):?>
                                                                        <td class="clickable">
                                                                            <span><?echo $intermediate_three['ThisMonth']['ExpenseDfFee']['fee'];?></span>
                                                                            <input name="ExpenseDfFee[<?echo $category['ExpenseDfType']['id'];?>][<?echo $intermediate_three['association_id'];?>]" class="form-control inputNumber invisible" type="text" value="<?echo $intermediate_three['ThisMonth']['ExpenseDfFee']['fee'];$total+=$intermediate_three['ThisMonth']['ExpenseDfFee']['fee'];?>" placeholder="金額を入力してください" style="display: none;">
                                                                            <input type="hidden" class="association" value="<?echo $intermediate_three['association_id'];?>">
                                                                            <input type="hidden" class="type" value="<?echo $category['ExpenseDfType']['id'];?>">
                                                                            <input type="hidden" class="model" value="ExpenseDfFee">
                                                                        </td>
                                                                    <?else:?>
                                                                        <td class="clickable">
                                                                            <input name="ExpenseDfFee[<?echo $category['ExpenseDfType']['id'];?>][<?echo $intermediate_three['association_id'];?>]" class="form-control inputNumber visible" type="text" value="<?echo $intermediate_three['cost'];$total+=$intermediate_three['cost'];?>" placeholder="金額を入力してください" style="display: block;">
                                                                            <input type="hidden" class="association" value="<?echo $intermediate_three['association_id'];?>">
                                                                            <input type="hidden" class="type" value="<?echo $category['ExpenseDfType']['id'];?>">
                                                                            <input type="hidden" class="model" value="ExpenseDfFee">
                                                                        </td>
                                                                    <?endif;?>
                                                                <?endforeach;?>
                                                            <?else:?>
                                                                <?foreach($associations as $association):?>
                                                                    <td class="clickable">
                                                                        <input name="ExpenseDfFee[<?echo $category['ExpenseDfType']['id'];?>][<?echo $association['Association']['id'];?>]" class="form-control inputNumber visible" type="text" value="" placeholder="金額を入力してください" style="display: block;">
                                                                        <input type="hidden" class="association" value="<?echo $association['Association']['id'];?>">
                                                                        <input type="hidden" class="type" value="<?echo $category['ExpenseDfType']['id'];?>">
                                                                        <input type="hidden" class="model" value="ExpenseDfFee">
                                                                    </td>
                                                                <?endforeach;?>
                                                            <?endif;?>
                                                            <td class="totalSum">
                                                                <?echo $total;?>
                                                            </td>
                                                        </tr>
                                                    <?endforeach;?>
                                                    <!-- END 定額支出 -->
                                                    <!-- BEGIN その他 -->
                                                    <?foreach($other as $key => $o):?>
                                                        <tr>
                                                            <td>
                                                                <?$num++;echo $num;?>
                                                            </td>
                                                            <td>
                                                                <?=$key;?>
                                                            </td>
                                                            <?$total=0;?>
                                                            <?foreach($associations as $association):?>
                                                                <?$id=$association['Association']['id'];?>
                                                                <td class="unclickable">
                                                                    <?if(isset($o[$id])){echo $o[$id];$total+=$o[$id];}else{echo 0;}?>
                                                                </td>
                                                            <?endforeach;?>
                                                            <td class="unclickable">
                                                                <?=$total;?>
                                                            </td>
                                                        </tr>
                                                    <?endforeach;?>
                                                    <!-- END その他 -->
                                                    <!-- BEGIN 店内経費 -->
                                                    <?$num=58;?>
                                                    <tr>
                                                        <td>
                                                            <?=$num;?>
                                                        </td>
                                                        <td>
                                                            割引・割増
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable">
                                                                <?= $summaries[$id]['discount']*-1;?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['discount']*-1;?>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            ポイント・金券
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <?$id=$association['Association']['id'];?>
                                                            <td class="unclickable">
                                                                <?= $summaries[$id]['voucher'];?>
                                                            </td>
                                                            <?$total+=$summaries[$id]['voucher'];?>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <!-- BEGIN 消耗品 -->
                                                    <tr>
                                                        <td>
                                                            <?$num++;echo $num;?>
                                                        </td>
                                                        <td>
                                                            消耗品
                                                        </td>
                                                        <?$total=0;?>
                                                        <?foreach($associations as $association):?>
                                                            <td class="unclickable">
                                                                <?
                                                                if($kaikake!=null){
                                                                    foreach($kaikake as $key => $kaikake_category){
                                                                        if($key=="消耗品"){
                                                                            $id=$association['Association']['id'];
                                                                            if(isset($kaikake_category[$id])){echo $kaikake_category[$id];$total+=$kaikake_category[$id];}else{echo 0;}
                                                                        }
                                                                    }
                                                                }
                                                                else{echo 0;}
                                                                ?>
                                                            </td>
                                                        <?endforeach;?>
                                                        <td class="unclickable">
                                                            <?=$total;?>
                                                        </td>
                                                    </tr>
                                                    <!-- END 消耗品 -->
                                                    <?if(isset($tennai2)&&$tennai2!=null):?>
                                                        <?foreach($tennai2 as $key => $t):?>
                                                            <tr>
                                                                <td style="background-color: #7FFF00!important">
                                                                    <?$num++;echo $num;?>
                                                                </td>
                                                                <td>
                                                                    <?=$key;?>
                                                                </td>
                                                                <?$total=0;?>
                                                                <?foreach($associations as $association):?>
                                                                    <?$id=$association['Association']['id'];?>
                                                                    <td class="clickable">
                                                                        <span><?if(isset($t[$id])){echo $t[$id]['MonthlyExpense']['fee'];$total+=$t[$id]['MonthlyExpense']['fee'];}else{echo 0;}?></span>
                                                                        <input class="form-control inputNumber visible" type="text" value="<?echo $t[$id]['MonthlyExpense']['fee'];?>" placeholder="金額を入力してください" style="display: none;">
                                                                        <input type="hidden" class="association" value="<?echo $id;?>">
                                                                        <input type="hidden" class="type" value="<?echo $t[$id]['Type']['id'];?>">
                                                                        <input type="hidden" class="model" value="MonthlyExpense">
                                                                    </td>
                                                                <?endforeach;?>
                                                                <td class="totalSum">
                                                                    <?=$total;?>
                                                                </td>
                                                            </tr>
                                                        <?endforeach?>
                                                    <?endif;?>
                                                </tbody>
                                            </table>
                                            <div class="form-actions noborder">
                                                <button type="submit" class="btn blue">更新</button>
                                                <button type="button" class="btn default">キャンセル</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<script>
    // Total Calculate
    // AJAX
    $(function(){

        // 入力済みのinputをtextへ
        $(".inputNumber").blur(function(){
            var value = $(this).val();
            if(value!=''){
                $(this).parent().append('<span>'+value+'</span>');
                $(this).css('display', 'none');
                $(this).removeClass("visible");
                $(this).addClass("invisible");

                // AJAX
                var association_id = $(this).parent().find(".association").val();
                var type = $(this).parent().find(".type").val();
                var date = $('.date').val();
                var model = $(this).parent().find(".model").val();
                var array = {0:association_id, 1:type, 2:date, 3:value, 4:model};
                // Function 切り替え
                if($.isNumeric(type)){
                    ajaxSend(array);
                }else{
                    ajaxSend2(array);
                }

                // Total Calculate
                var total = 0;
                var spans = $(this).parent().parent().find("span");
                if(spans.length!=0){
                    spans.each(function(){
                        //console.log(parseInt($(this).text()));
                        total += parseInt($(this).text());
                    });
                }
                $(this).parent().parent().find(".totalSum").text(total);
            }
        });

        // 再クリック時にinput復活
        $(".clickable").click(function(){
            if($(this).find("input").css('display')=='none'){
                var value = $(this).find("span").text();
                //console.log(value);
                $(this).find("span").remove();
                $(this).find(".inputNumber").val(value);
                $(this).find(".inputNumber").attr("value", value);

                $(this).find(".inputNumber").css('display', 'block');
                $(this).find(".inputNumber").removeClass("invisible");
                $(this).find(".inputNumber").addClass("visible");
                // Focus
                $(this).find(".inputNumber").focus();
            }
        });

        function ajaxSend(array){
            $.ajax({
                url: "<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'ajax4'));?>",
                type:'POST',
                data: array
            }).done(function(data, textStatus, jqXHR){
                //var obj = jQuery.parseJSON(data);
                //console.log(obj);
            }).fail(function(data, textStatus, errorThrown){
                alert(textStatus); //エラー情報を表示
                console.log(errorThrown.message); //例外情報を表示
            }).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
                // alert(textStatus);
            });
        }

        function ajaxSend2(array){
            $.ajax({
                url: "<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'ajax5'));?>",
                type:'POST',
                data: array
            }).done(function(data, textStatus, jqXHR){
                //var obj = jQuery.parseJSON(data);
                //console.log(obj);
            }).fail(function(data, textStatus, errorThrown){
                alert(textStatus); //エラー情報を表示
                console.log(errorThrown.message); //例外情報を表示
            }).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
                // alert(textStatus);
            });
        }

        // Table情報取得

    });

    // TABLE
    var TableDatatablesButtons = function () {

        var initTable1 = function () {
            var table = $('#sample_1');

            var oTable = table.dataTable({

                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "_START_ ~ _END_ 件表示 (_TOTAL_ 件中)",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered1 from _MAX_ total entries)",
                    "lengthMenu": "_MENU_ 件",
                    "search": "検索:",
                    "zeroRecords": "No matching records found"
                },

                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},


                buttons: [
                    { extend: 'print', className: 'btn dark btn-outline' },
                    { extend: 'copy', className: 'btn red btn-outline' },
                    //{ extend: 'pdf', className: 'btn green btn-outline' },
                    //{ extend: 'excel', className: 'btn yellow btn-outline ' },
                    { extend: 'csv', className: 'btn purple btn-outline '},
                    { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'},
                    {
                        text: 'Excel',
                        className: 'btn yellow btn-outline',
                        action: function ( e, dt, node, config ) {
                            // body or header

                            var array = dt.buttons.exportData().body;
                            var postForm = function(url, data) {
                                var $form = $('<form/>', {'action': url, 'method': 'post'});
                                // 日付
                                $form.append($('<input/>', {'type': 'hidden', 'name': 'date', 'value': $('.date').val()}));
                                for(var key in data) {
                                    $form.append($('<input/>', {'type': 'hidden', 'name': key, 'value': data[key]}));
                                }
                                $form.appendTo(document.body);
                                $form.submit();
                            };
                            postForm("<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'excel'));?>", array);

                        }
                    }
                ],

                // setup responsive extension: http://datatables.net/extensions/responsive/
                responsive: true,

                //"ordering": false,
                //"paging": false, disable pagination

                "order": [
                    [0, 'asc']
                ],

                "lengthMenu": [
                    [10, 20, 40, 50, -1],
                    [10, 20, 40, 50, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": -1,

                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });

        }

        var initTable2 = function () {
            var table = $('#sample_2');

            var oTable = table.dataTable({

                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "_START_ ~ _END_ 件表示 (_TOTAL_ 件中)",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered1 from _MAX_ total entries)",
                    "lengthMenu": "_MENU_ 件",
                    "search": "検索:",
                    "zeroRecords": "No matching records found"
                },

                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},

                buttons: [
                    { extend: 'print', className: 'btn default' },
                    { extend: 'copy', className: 'btn default' },
                    { extend: 'pdf', className: 'btn default' },
                    { extend: 'excel', className: 'btn default' },
                    { extend: 'csv', className: 'btn default' },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            //dt.ajax.reload();
                            alert('Custom Button');
                        }
                    }
                ],

                responsive: true,

                "order": [
                    [0, 'asc']
                ],

                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 20,

                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });
        }

        return {
            //main function to initiate the module
            init: function () {
                if (!jQuery().dataTable) {
                    return;
                }
                initTable1();
                initTable2();
            }
        };

    }();
    jQuery(document).ready(function() {
        TableDatatablesButtons.init();

    });
</script>