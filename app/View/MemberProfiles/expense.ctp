<script>
    $(function(){
        //パラメータ取得
        var url = location.href;
        var parameters    = url.split("?");
        var params   = parameters[1].split("&");
        var paramsArray = [];
        for ( i = 0; i < params.length; i++ ) {
            neet = params[i].split("=");
            paramsArray.push(neet[0]);
            paramsArray[neet[0]] = neet[1];
        }
        var locationId = paramsArray["location"];
        var queryDate = paramsArray["date"];
        if(locationId==1){
            $('#selectable1').addClass('active');
        }else if(locationId==2){
            $('#selectable2').addClass('active');
        }else if(locationId==3){
            $('#selectable3').addClass('active');
        }else if(locationId==4){
            $('#selectable4').addClass('active');
        }
        //カレンダー
        $('#formBd').datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function(dateText, inst){
                //パラメータ取得
                var url = location.href;
                var parameters    = url.split("?");
                var params   = parameters[1].split("&");
                var paramsArray = [];
                for ( i = 0; i < params.length; i++ ) {
                    neet = params[i].split("=");
                    paramsArray.push(neet[0]);
                    paramsArray[neet[0]] = neet[1];
                }
                var locationId = paramsArray["location"];
                //date
                var date  = dateText;
                var str = date.split('-');
                var month = str[0]+'-'+str[1]+'-01';
                var url   = location.href;
                var parameters    = url.split("?");
                var dateJob = parameters[1].split("=");
                if (date != dateJob[1]) {
                    window.location.href = '?location='+locationId+'&date='+month;
                };
            }
        });
        $('#formBd').datepicker("setDate", queryDate);

    });
</script>
<?
#BEGIN THEME GLOBAL STYLES
echo $this->Html->css('assets/global/css/components.min.css');
echo $this->Html->css('assets/global/plugins/fullcalendar/fullcalendar.min.css');
# Page Level Plugin
echo $this->Html->script('assets/global/plugins/moment.min.js');
echo $this->Html->script('datepicker-ja.js');
echo $this->Html->script('assets/global/plugins/fullcalendar/fullcalendar.min.js');

?>
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>支出入力
                        <small></small>
                    </h1>
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
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title" style="padding:0;padding-bottom: 5px;">
                                    <div class="mt-element-step">
                                        <div class="row step-thin">
                                            <a class="selectable" href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'expense', '?' => array('location' => 1, 'date' => $date)));?>">
                                                <div class="col-md-6 bg-grey mt-step-col" id="selectable1">
                                                    <div class="mt-step-number bg-white font-grey">1</div>
                                                    <div class="mt-step-title uppercase font-grey-cascade">寿し和 池袋店</div>
                                                    <div class="mt-step-content font-grey-cascade">Sushikaz Ikebukuro</div>
                                                </div>
                                            </a>
                                            <a class="selectable" href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'expense', '?' => array('location' => 2, 'date' => $date)));?>">
                                                <div class="col-md-6 bg-grey mt-step-col" id="selectable2">
                                                    <div class="mt-step-number bg-white font-grey">2</div>
                                                    <div class="mt-step-title uppercase font-grey-cascade">寿し和 赤羽店</div>
                                                    <div class="mt-step-content font-grey-cascade">Sushikaz Akabane</div>
                                                </div>
                                            </a>
                                            <a class="selectable" href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'expense', '?' => array('location' => 3, 'date' => $date)));?>">
                                                <div class="col-md-6 bg-grey mt-step-col" id="selectable3">
                                                    <div class="mt-step-number bg-white font-grey">3</div>
                                                    <div class="mt-step-title uppercase font-grey-cascade">寿し和 和光店</div>
                                                    <div class="mt-step-content font-grey-cascade">Sushikaz Wakô</div>
                                                </div>
                                            </a>
                                            <a class="selectable" href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'expense', '?' => array('location' => 4, 'date' => $date)));?>">
                                                <div class="col-md-6 bg-grey mt-step-col" id="selectable4">
                                                    <div class="mt-step-number bg-white font-grey">4</div>
                                                    <div class="mt-step-title uppercase font-grey-cascade">和光苑</div>
                                                    <div class="mt-step-content font-grey-cascade">Wakôen</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <form role="form" action="" method="post">
                                        <input type="hidden" name="association_id" value="<?echo $association_id;?>">
                                        <input type="hidden" name="working_month" value="<?echo $date;?>">
                                        <div class="mt-element-list">
                                            <div class="mt-list-head list-default ext-1 yellow-saffron">
                                                <div class="row">
                                                    <div class="col-xs-8">
                                                        <div class="list-head-title-container">
                                                            <h3 class="list-title uppercase sbold">買掛現金支払表</h3>
                                                            <div class="list-date"><?echo date('Y年m月', strtotime($date));?>分</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <div class="list-head-summary-container">
                                                            <div class="list-pending">
                                                                <div class="list-count badge badge-default "><?echo $num_yet;?></div>
                                                                <div class="list-label">未入力</div>
                                                            </div>
                                                            <div class="list-done">
                                                                <div class="list-count badge badge-default last"><?echo $num_exist;?></div>
                                                                <div class="list-label">入力済み</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <?foreach($stocktaking_types as $stocktaking_type):?>
                                                <div class="col-md-6">
                                                    <div class="mt-list-container list-default ext-1">
                                                        <div class="mt-list-title uppercase"><?echo $stocktaking_type['StocktakingType']['name'];?>
                                                            <span class="badge badge-default pull-right bg-hover-green-jungle">
                                                              <a class="font-white" href="javascript:;">
                                                                 <i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                        <ul>
                                                            <?foreach($stocktaking_type['Store'] as $stores):?>
                                                                <li class="mt-list-item <?if(isset($stores['month'])){echo "done";}?>">
                                                                    <div class="list-icon-container">
                                                                        <i class="icon-<?if(isset($stores['month'])){echo "check";}else{echo "close";}?>"></i>
                                                                    </div>
                                                                    <div class="list-datetime"> 11am
                                                                        <br> 8 Nov </div>
                                                                    <div class="list-item-content">
                                                                        <div class="form-body">
                                                                            <div class="form-group form-md-line-input <?if(isset($stores['month'])){echo "has-success";}?>" style="padding-top: 0;">
                                                                                <div class="input-icon right">
                                                                                    <label for="form_control_1"><?echo $stores['KaikakeStore']['name'];?></label>
                                                                                    <input type="text" name="fee[<?echo $stores['KaikakeStore']['id'];?>]" class="form-control" id="form_control_1" placeholder="金額を入力してください" value="<?if(isset($stores['month'])){echo $stores['month']['KaikakeFee']['fee'];}?>">
                                                                                    <i class="icon-user"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            <?endforeach;?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?endforeach;?>
                                            </div>
                                        </div>
                                        <div class="form-actions noborder" style="margin-top: 30px;">
                                            <button type="submit" class="btn blue">送信</button>
                                            <button type="button" class="btn default">キャンセル</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form-group.form-md-line-input.has-success .form-control {
        border-bottom: 1px solid #26C281;
    }
    .form-group.form-md-line-input.has-success label {
        color: #26C281;
    }
</style>