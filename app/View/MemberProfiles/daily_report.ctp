<?
# css
# BEGIN PAGE LEVEL PLUGINS
//echo $this->Html->css('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css');
//echo $this->Html->css('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
//echo $this->Html->css('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
//echo $this->Html->css('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
echo $this->Html->css('assets/global/plugins/clockface/css/clockface.css');
echo $this->Html->css('assets/global/plugins/morris/morris.css');
echo $this->Html->css('assets/global/plugins/fullcalendar/fullcalendar.min.css');
# END PAGE LEVEL PLUGINS
# BEGIN THEME GLOBAL STYLES
echo $this->Html->css('assets/global/css/components.min.css');
# END THEME GLOBAL STYLES
# js
# Page Level Plugin
echo $this->Html->script('assets/global/plugins/moment.min.js');
echo $this->Html->script('datepicker-ja.js');
//echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js');
//echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
//echo $this->Html->script('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js');
//echo $this->Html->script('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');
echo $this->Html->script('assets/global/plugins/clockface/js/clockface.js');
echo $this->Html->script('assets/global/plugins/morris/morris.min.js');
echo $this->Html->script('assets/global/plugins/morris/raphael-min.js');
echo $this->Html->script('assets/global/plugins/counterup/jquery.waypoints.min.js');
echo $this->Html->script('assets/global/plugins/counterup/jquery.counterup.min.js');
echo $this->Html->script('assets/global/plugins/amcharts/amcharts/amcharts.js');
echo $this->Html->script('assets/global/plugins/amcharts/amcharts/serial.js');
echo $this->Html->script('assets/global/plugins/amcharts/amcharts/pie.js');
echo $this->Html->script('assets/global/plugins/amcharts/amcharts/radar.js');
echo $this->Html->script('assets/global/plugins/amcharts/amcharts/themes/light.js');
echo $this->Html->script('assets/global/plugins/amcharts/amcharts/themes/patterns.js');
echo $this->Html->script('assets/global/plugins/amcharts/amcharts/themes/chalk.js');
echo $this->Html->script('assets/global/plugins/amcharts/ammap/ammap.js');
echo $this->Html->script('assets/global/plugins/amcharts/ammap/maps/js/worldLow.js');
echo $this->Html->script('assets/global/plugins/amcharts/amstockcharts/amstock.js');
echo $this->Html->script('assets/global/plugins/fullcalendar/fullcalendar.min.js');
echo $this->Html->script('assets/global/plugins/jquery.sparkline.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.resize.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.categories.min.js');
echo $this->Html->script('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js');
# Page Level Script
echo $this->Html->script('assets/pages/scripts/dashboard.js');

//debug($m_location1);
//debug($m_location2);
//debug($m_location3);
//debug($m_location4);
?>
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>日別売上 <small><?echo $working_day;?></small></h1>
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
                            $(function() {
                                //カレンダー
                                $('#formBd').datepicker({
                                    dateFormat: "yy-mm-dd",
                                    onSelect: function(dateText, inst){
                                        var date  = dateText;
                                        var url   = location.href;
                                        var parameters    = url.split("?");
                                        var dateJob = parameters[1].split("=");
                                        if (date != dateJob[1]) {
                                            window.location.href = '?date='+date;
                                        };
                                    }
                                });
                                $('#formBd').datepicker("setDate", "<?echo $working_day;?>");
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
<div class="page-container" style="background: #eff3f8;">
    <!-- BEGIN PAGE CONTENT -->
    <div class="container">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner" style="margin-top: 30px;">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green-sharp">
                                    <small class="font-green-sharp">¥</small>
                                    <span data-counter="counterup" data-value="<?if(isset($location1)){echo number_format($location1['sales']);}else{echo 0;}?>">0</span>
                                </h3>
                                <small>寿し和 池袋店</small>
                            </div>
                            <div class="icon">
                                <i class="<?if(isset($location1['sales'])&&isset($location1['target'])&&$location1['target']!=0){$r=floor($location1['sales']/$location1['target']*100);if($r>=100){echo "icon-like";}else{echo "icon-dislike";}}else{echo "icon-dislike";}?>"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: <?if(isset($location1['sales'])&&isset($location1['target'])){echo floor($location1['sales']/$location1['target']*100);}else{echo 0;}?>%;" class="progress-bar progress-bar-success green-sharp">
                                    <span class="sr-only"></span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> 目標達成率 </div>
                                <div class="status-number"> <?if(isset($location1['sales'])&&isset($location1['target'])&&$location1['target']!=0){echo floor($location1['sales']/$location1['target']*100);}else{echo 0;}?>% </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">
                                    <small class="font-green-sharp">¥</small>
                                    <span data-counter="counterup" data-value="<?if(isset($location2)){echo number_format($location2['sales']);}else{echo 0;}?>">0</span>
                                </h3>
                                <small>寿し和 赤羽店</small>
                            </div>
                            <div class="icon">
                                <i class="<?if(isset($location2['sales'])&&isset($location2['target'])&&$location2['target']!=0){$r=floor($location2['sales']/$location2['target']*100);if($r>=100){echo "icon-like";}else{echo "icon-dislike";}}else{echo "icon-dislike";}?>"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: <?if(isset($location2['sales'])&&isset($location2['target'])){echo floor($location2['sales']/$location2['target']*100);}else{echo 0;}?>%;" class="progress-bar progress-bar-success red-haze">
                                    <span class="sr-only"></span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> 目標達成率 </div>
                                <div class="status-number"> <?if(isset($location2['sales'])&&isset($location2['target'])&&$location2['target']!=0){echo floor($location2['sales']/$location2['target']*100);}else{echo 0;}?>% </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue-sharp">
                                    <small class="font-green-sharp">¥</small>
                                    <span data-counter="counterup" data-value="<?if(isset($location3)){echo number_format($location3['sales']);}else{echo 0;}?>">0</span>
                                </h3>
                                <small>寿し和 和光店</small>
                            </div>
                            <div class="icon">
                                <i class="<?if(isset($location3['sales'])&&isset($location3['target'])&&$location3['target']!=0){$r=floor($location3['sales']/$location3['target']*100);if($r>=100){echo "icon-like";}else{echo "icon-dislike";}}else{echo "icon-dislike";}?>"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: <?if(isset($location3['sales'])&&isset($location3['target'])){echo floor($location3['sales']/$location3['target']*100);}else{echo 0;}?>%;" class="progress-bar progress-bar-success blue-sharp">
                                    <span class="sr-only"></span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> 目標達成率 </div>
                                <div class="status-number"> <?if(isset($location3['sales'])&&isset($location3['target'])&&$location3['target']!=0){echo floor($location3['sales']/$location3['target']*100);}else{echo 0;}?>% </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-purple-soft">
                                    <small class="font-green-sharp">¥</small>
                                    <span data-counter="counterup" data-value="<?if(isset($location4)){echo number_format($location4['sales']);}else{echo 0;}?>">0</span>
                                </h3>
                                <small>和光苑</small>
                            </div>
                            <div class="icon">
                                <i class="<?if(isset($location4['sales'])&&isset($location4['target'])&&$location4['target']!=0){$r=floor($location4['sales']/$location4['target']*100);if($r>=100){echo "icon-like";}else{echo "icon-dislike";}}else{echo "icon-dislike";}?>"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: <?if(isset($location4['sales'])&&isset($location4['target'])){echo floor($location4['sales']/$location4['target']*100);}else{echo 0;}?>%;" class="progress-bar progress-bar-success purple-soft">
                                    <span class="sr-only"></span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> 目標達成率 </div>
                                <div class="status-number"> <?if(isset($location4['sales'])&&isset($location4['target'])&&$location4['target']!=0){echo floor($location4['sales']/$location4['target']*100);}else{echo 0;}?>% </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bar-chart font-red"></i>
                                <span class="caption-subject font-red bold uppercase">店舗別成績一覧</span>
                                <span class="caption-helper">weekly stats...</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Today
                                    </label>
                                    <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                        <input type="radio" name="options" class="toggle" id="option3">Month
                                    </label>
                                </div>
                                <script>
                                    $(function() {
                                        $('input[name="options"]:radio').change(function(){
                                            var result1 = $('#option1').is(':checked'); // tab1
                                            var result2 = $('#option3').is(':checked'); // tab3
                                            if(result1==true){
                                                $('#tab1').css('display', 'block');
                                                $('#tab3').css('display', 'none');
                                            }else if(result2==true){
                                                $('#tab1').css('display', 'none');
                                                $('#tab3').css('display', 'block');
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- START DAY -->
                            <div class="table-scrollable table-scrollable-borderless" id="tab1">
                                <table class="table table-hover table-light">
                                    <thead>
                                    <tr class="uppercase">
                                        <th colspan="2"> 店名 </th>
                                        <th> 客数 </th>
                                        <th> 売上 </th>
                                        <th> 目標額 </th>
                                    </tr>
                                    </thead>
                                    <tbody><tr>
                                        <td class="fit">
                                            <img class="user-pic rounded" src=""></td>
                                        <td>
                                            <a href="javascript:;" class="primary-link">寿し和 池袋店</a>
                                        </td>
                                        <td> <?if(isset($location1)){echo number_format($location1['customer']);}else{echo 0;}?>名 </td>
                                        <td> ¥<?if(isset($location1)){echo number_format($location1['sales']);}else{echo 0;}?> </td>
                                        <td> ¥<?if(isset($location1)){echo number_format($location1['target']);}else{echo 0;}?> </td>
                                    </tr>
                                    <tr>
                                        <td class="fit">
                                            <img class="user-pic rounded" src=""> </td>
                                        <td>
                                            <a href="javascript:;" class="primary-link">寿し和 赤羽店</a>
                                        </td>
                                        <td> <?if(isset($location2)){echo number_format($location2['customer']);}else{echo 0;}?>名 </td>
                                        <td> ¥<?if(isset($location2)){echo number_format($location2['sales']);}else{echo 0;}?> </td>
                                        <td> ¥<?if(isset($location2)){echo number_format($location2['target']);}else{echo 0;}?> </td>
                                    </tr>
                                    <tr>
                                        <td class="fit">
                                            <img class="user-pic rounded" src=""> </td>
                                        <td>
                                            <a href="javascript:;" class="primary-link">寿し和 和光店</a>
                                        </td>
                                        <td> <?if(isset($location3)){echo number_format($location3['customer']);}else{echo 0;}?>名 </td>
                                        <td> ¥<?if(isset($location3)){echo number_format($location3['sales']);}else{echo 0;}?> </td>
                                        <td> ¥<?if(isset($location3)){echo number_format($location3['target']);}else{echo 0;}?> </td>
                                    </tr>
                                    <tr>
                                        <td class="fit">
                                            <img class="user-pic rounded" src=""> </td>
                                        <td>
                                            <a href="javascript:;" class="primary-link">和光苑</a>
                                        </td>
                                        <td> <?if(isset($location4)){echo number_format($location4['customer']);}else{echo 0;}?>名 </td>
                                        <td> ¥<?if(isset($location4)){echo number_format($location4['sales']);}else{echo 0;}?> </td>
                                        <td> ¥<?if(isset($location4)){echo number_format($location4['target']);}else{echo 0;}?> </td>
                                    </tr>
                                    <tr>
                                        <td class="fit">
                                            <img class="user-pic rounded" src=""> </td>
                                        <td>
                                            <a href="javascript:;" class="primary-link">和光２店舗合計</a>
                                        </td>
                                        <td> <?if(isset($location3)&&isset($location4)){echo number_format($location3['customer']+$location4['customer']);}else{echo 0;}?>名 </td>
                                        <td> ¥<?if(isset($location3)&&isset($location4)){echo number_format($location3['sales']+$location4['sales']);}else{echo 0;}?> </td>
                                        <td> ¥<?if(isset($location3)&&isset($location4)){echo number_format($location3['target']+$location4['target']);}else{echo 0;}?> </td>
                                    </tr>
                                    <tr>
                                        <td class="fit">
                                            <img class="user-pic rounded" src=""> </td>
                                        <td>
                                            <a href="javascript:;" class="primary-link">全店舗合計</a>
                                        </td>
                                        <td> <?if(isset($location1)&&isset($location2)&&isset($location3)&&isset($location4)){echo number_format($location1['customer']+$location2['customer']+$location3['customer']+$location4['customer']);}else{echo 0;}?>名 </td>
                                        <td> ¥<?if(isset($location1)&&isset($location2)&&isset($location3)&&isset($location4)){echo number_format($location1['sales']+$location2['sales']+$location3['sales']+$location4['sales']);}else{echo 0;}?> </td>
                                        <td> ¥<?if(isset($location1)&&isset($location2)&&isset($location3)&&isset($location4)){echo number_format($location1['target']+$location2['target']+$location3['target']+$location4['target']);}else{echo 0;}?> </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- END DAY -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
    <!-- END PAGE CONTENT -->
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
            Layout.init(); // init current layout
            Demo.init(); // init demo features
        });
    </script>
</div>