<?
#BEGIN THEME GLOBAL STYLES
echo $this->Html->css('assets/global/css/components.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
# icheck
echo $this->Html->css('assets/global/plugins/clockface/css/clockface.css');
echo $this->Html->css('assets/global/plugins/icheck/skins/all.css');
# Page Level Plugin
echo $this->Html->script('assets/global/plugins/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');
echo $this->Html->script('assets/global/plugins/clockface/js/clockface.js');
echo $this->Html->script('assets/pages/scripts/components-date-time-pickers.min.js');
# icheck
echo $this->Html->script('assets/global/plugins/icheck/icheck.min.js');
echo $this->Html->script('assets/pages/scripts/form-icheck.min.js');
# amChart
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
//echo $this->Html->script('assets/pages/scripts/charts-amcharts.js');

?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>メニュー比較
                        <small>date, datetime and daterange pickers</small>
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMBS -->
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="index.html">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">Components</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Date & Time Pickers</span>
                    </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light form-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-pin font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">検索条件</span>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="<?if(isset($post_radio1)){echo 'expand';}else{echo 'collapse';}?>" data-original-title="" title="">
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body form" style="display: <?if(isset($post_radio1)){echo 'none';}else{echo 'block';}?>;">
                                        <!-- BEGIN FORM-->
                                        <form class="form-horizontal form-bordered" role="form" method="post" action="">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">店舗</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <div class="icheck-inline" id="locationBox">
                                                                <?foreach($locations as $location):?>
                                                                    <label>
                                                                        <input type="radio" name="radio1" value="<?echo $location['Location']['id'];?>" class="icheck" data-radio="iradio_square-blue" <?if(isset($post_radio1)&&$post_radio1==$location['Location']['id']){echo "checked";}?>> <?echo $location['Location']['name'];?>
                                                                    </label>
                                                                <?endforeach;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">期間</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <div class="icheck-inline">
                                                                <label>
                                                                    <input type="radio" name="radio2" value="1" class="icheck" data-radio="iradio_square-blue" <?if(isset($post_radio2)&&$post_radio2==1){echo "checked";}elseif(!isset($post_radio2)){echo "checked";}?>> 日間 </label>
                                                                <label>
                                                                    <input type="radio" name="radio2" value="2" class="icheck" data-radio="iradio_square-blue" <?if(isset($post_radio2)&&$post_radio2==2){echo "checked";}?>> 月間 </label>
                                                                <label>
                                                                    <input type="radio" name="radio2" value="3" class="icheck" data-radio="iradio_square-blue" <?if(isset($post_radio2)&&$post_radio2==3){echo "checked";}?>> 年間 </label>
                                                                <label>
                                                                    <input type="radio" name="radio2" value="4" class="icheck" data-radio="iradio_square-blue" <?if(isset($post_radio2)&&$post_radio2==4){echo "checked";}?>> 四半期 </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">日付</label>
                                                    <div class="col-md-3">
                                                        <div id="dateBox" class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-viewmode="years" data-date-minviewmode="months">
                                                            <input name="date" value="<?if(isset($post_date)){echo $post_date;}else{echo date("Y-m-d");}?>" type="text" class="form-control" readonly>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                        </div>
                                                        <!-- /input-group -->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">グループ</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <div id="groupBox">
                                                                <?if(isset($post_groups)):?>
                                                                    <?foreach($post_groups as $post_group):?>
                                                                    <label>
                                                                        <input type="checkbox" name="group[]" value="<?echo $post_group['id'];?>" <?if($post_group['checked']==1){echo "checked";}?>> <?echo $post_group['name'];?>
                                                                    </label>
                                                                    <?endforeach;?>
                                                                <?endif;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">部門</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <div class="icheck-inline" id="sectionBox">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions noborder">
                                                <button type="submit" class="btn blue">送信</button>
                                                <button type="button" class="btn default">キャンセル</button>
                                            </div>
                                        </form>
                                        <!-- END FORM-->
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN CHART PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart font-green-haze"></i>
                                        <span class="caption-subject bold uppercase font-green-haze"> ABC分析</span>
                                        <span class="caption-helper">duration on value axis</span>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="<?if(isset($menusales_arr)){echo 'collapse';}else{echo 'expand';}?>"> </a>
                                        <a href="javascript:;" class="reload"> </a>
                                        <a href="javascript:;" class="fullscreen"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body" style="display: <?if(isset($menusales_arr)){echo 'block';}else{echo 'none';}?>;">
                                    <div id="chart_2" class="chart" style="height: 500px;"> </div>
                                </div>
                            </div>
                            <!-- END CHART PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-comments"></i>
                                        <span class="caption-subject bold uppercase"> 詳細一覧</span>
                                        <span class="caption-helper">duration on value axis</span>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="<?if(isset($menusales_decode_arr)){echo 'collapse';}else{echo 'expand';}?>"> </a>
                                        <a href="javascript:;" class="reload"> </a>
                                        <a href="javascript:;" class="fullscreen"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body" style="display: <?if(isset($menusales_decode_arr)){echo 'block';}else{echo 'none';}?>;">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th> 順位 </th>
                                                    <th> メニュー名 </th>
                                                    <th> 売上 </th>
                                                    <th> 数量 </th>
                                                    <th> 構成比 </th>
                                                    <th> 累積売上 </th>
                                                    <th> 累積構成比 </th>
                                                    <th> 区分 </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?if(isset($menusales_decode_arr)):?>
                                                    <?$num = 1;$sales = 0;?>
                                                    <?foreach($menusales_decode_arr as $menusales):?>
                                                        <tr class="<?if($menusales['class']=='A'){echo 'success';}elseif($menusales['class']=='B'){echo 'warning';}elseif($menusales['class']=='C'){echo 'danger';}?>">
                                                            <td> <?echo $num;$num++;?> </td>
                                                            <td> <?echo $menusales['name'];?></td>
                                                            <td> <?echo $menusales['income'];?> 円</td>
                                                            <td> <?echo $menusales['num'];?> </td>
                                                            <td> <?echo $menusales['percent'];?> %</td>
                                                            <td> <?$sales+=$menusales['income'];echo $sales;?> 円</td>
                                                            <td> <?echo $menusales['count'];?> %</td>
                                                            <td> <?echo $menusales['class'];?></td>
                                                        </tr>
                                                    <?endforeach;?>
                                                <?endif;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <?if(isset($menusales_zero_arr)):?>
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-comments"></i>
                                        <span class="caption-subject bold uppercase"> 売上0メニュー</span>
                                        <span class="caption-helper">duration on value axis</span>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="<?if(isset($menusales_zero_arr)){echo 'collapse';}else{echo 'expand';}?>"> </a>
                                        <a href="javascript:;" class="reload"> </a>
                                        <a href="javascript:;" class="fullscreen"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body" style="display: <?if(isset($menusales_zero_arr)){echo 'block';}else{echo 'none';}?>;">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th> 順位 </th>
                                                <th> メニュー名 </th>
                                                <th> 区分 </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?if(isset($menusales_zero_arr)):?>
                                                <?$num = 1;$sales = 0;?>
                                                <?foreach($menusales_zero_arr as $menusales_zero):?>
                                                    <tr class="<?echo 'danger'?>">
                                                        <td> <?echo $num;$num++;?> </td>
                                                        <td> <?echo $menusales_zero['name'];?></td>
                                                        <td> D </td>
                                                    </tr>
                                                <?endforeach;?>
                                            <?endif;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <?endif;?>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END PAGE CONTENT BODY -->
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<script>
    // checkBox AJAX
    $(function(){
        // init
        groupBoxSend();

        function groupBoxSend(){
            var id = $('#locationBox').find("input:checked").val();var locationId = {0:id};
            var array = {};var num = 1;
            $("#groupBox").find("input").each(function(){
                if($(this).prop("checked")){
                    array[num] = $(this).val();
                    num++;
                }
            });
            array[0] = locationId[0];
            console.log(array);
            ajaxSend(array);
        }


        $('#locationBox').find('.iCheck-helper').click(function(){
            $('body').css('opacity', 0.5);
            $("#sectionBox").empty();
            var locationId = $(this).parent().find("input").val();
            var array = {0:locationId};
            ajaxSend3(array);
        });

        $('#groupBox').find("input").click(function(){
            $('body').css('opacity', 0.5);
            groupBoxSend();
        });

        function ajaxSend3(locationId){
            $.ajax({
                url: "<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'ajax3'));?>",
                type:'POST',
                data: locationId
            }).done(function(data, textStatus, jqXHR){
                var obj = jQuery.parseJSON(data);
                $("#groupBox").empty(); // 中身削除
                $.each(obj, function(index, value) {
                    var content = $("<label class='checkbox-inline'>").append('<input type="checkbox" name="group[]" value='+value.id+'>').append(value.name);
                    $("#groupBox").append(content);
                    // checkFunc
                    $('#groupBox').find("input").click(function(){
                        $('body').css('opacity', 0.5);
                        // チェックがついているboxを取得（チェックボックス変更処理済み）
                        var array = {};
                        var num = 1;
                        $("#groupBox").find("input").each(function(){
                            if($(this).prop("checked")){
                                array[num] = $(this).val();
                                num++;
                            }
                        });
                        array[0] = locationId[0];
                        ajaxSend(array);
                    });
                });

            }).fail(function(data, textStatus, errorThrown){
                alert(textStatus); //エラー情報を表示
                console.log(errorThrown.message); //例外情報を表示
            }).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
                $('body').css('opacity', 1);
            });
        }

        function ajaxSend(array){
            $.ajax({
                url: "<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'ajax'));?>",
                type:'POST',
                data: array
            }).done(function(data, textStatus, jqXHR){
                var obj = jQuery.parseJSON(data);
                $("#sectionBox").empty(); // 中身削除
                $.each(obj, function(index, value) {
                    var content = $("<label class='checkbox-inline'>").append('<input type="checkbox" name="section[]" value='+value.id+' checked>').append(value.name);
                    $("#sectionBox").append(content);
                });

            }).fail(function(data, textStatus, errorThrown){
                alert(textStatus); //エラー情報を表示
                console.log(errorThrown.message); //例外情報を表示
            }).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
                $('body').css('opacity', 1);
            });
        }

    });

    // graph
    var ChartsAmcharts = function() {
        var up = false;
        var initChartSample2 = function() {
            var chart = AmCharts.makeChart("chart_2", {
                "type": "serial",
                "theme": "light",
                "fontFamily": 'Open Sans',
                "color":    '#888888',

                "legend": {
                    "equalWidths": false,
                    "useGraphSettings": true,
                    "valueAlign": "left",
                    "valueWidth": 120
                },
                "dataProvider": <?if(isset($menusales_arr)){echo $menusales_arr;}else{echo $demo;};?>
                ,
                "valueAxes": [{
                    "id": "incomeAxis",
                    "axisAlpha": 0,
                    "gridAlpha": 0,
                    "position": "left",
                    "title": "売上"
                }, {
                    "id": "countAxis",
                    "axisAlpha": 0,
                    "gridAlpha": 0,
                    "position": "right",
                    "title": "累積構成比"
                }],
                "graphs": [{
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:13px;'>[[title]] <br> [[category]]:<b>[[value]]円</b> [[additional]]</span>",
                    "dashLengthField": "dashLength",
                    "fillAlphas": 0.7,
                    "fillColorsField": "lineColor",
                    "legendPeriodValueText": "総額: [[value.sum]] 円",
                    "legendValueText": "[[value]] 円",
                    "title": "売上",
                    "type": "column",
                    "valueField": "income",
                    "valueAxis": "incomeAxis"
                }, {
                    "balloonText": "<span style='font-size:13px;'>[[title]] <br> [[category]]:<b>[[value]]%</b> [[additional]]</span>",
                    "bullet": "round",
                    "bulletBorderColor": "#a94442",
                    "bulletColor": "#a94442",
                    "lineColor": "#a94442",
                    "bulletBorderAlpha": 1,
                    "bulletBorderThickness": 1,
                    "dashLengthField": "dashLength",
                    "legendValueText": "[[value]]%",
                    "title": "累積構成比",
                    "fillAlphas": 0,
                    "valueField": "count",
                    "valueAxis": "countAxis"
                }],
                "chartCursor": {
                    "cursorAlpha": 0.1,
                    "cursorColor": "#000000",
                    "fullWidth": true,
                    "valueBalloonsEnabled": false,
                    "zoomable": false
                },
                "categoryField": "name",
                "categoryAxis": {
                    "labelRotation": -90,
                    "axisAlpha": 0,
                    "tickLength": 0,
                    "gridAlpha": 0.1,
                    "gridPosition":"start",
                    "gridColor": "#000000",
                    "autoGridCount":false,
                    "gridCount":50
                },
                "exportConfig": {
                    "menuBottom": "20px",
                    "menuRight": "22px",
                    "menuItems": [{
                        "icon": App.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                        "format": 'png'
                    }]
                }
            });

            $('#chart_2').closest('.portlet').find('.fullscreen').click(function() {
                chart.invalidateSize();
            });
        };

        return {
            //main function to initiate the module
            init: function() {
                initChartSample2();
            }

        };

    }();

    jQuery(document).ready(function() {
        <?if(isset($post_radio1)):?>
            ChartsAmcharts.init();
        <?endif;?>
    });
</script>