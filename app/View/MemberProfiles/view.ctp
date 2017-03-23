<?
#css
echo $this->Html->css('assets/pages/css/tasks.css');
echo $this->Html->css('assets/pages/css/profile.css');
echo $this->Html->css('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');

#js
echo $this->Html->script('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js');
echo $this->Html->script('assets/global/plugins/jquery.sparkline.min.js');

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

echo $this->Html->script('assets/pages/scripts/profile.js');
echo $this->Html->script('assets/pages/scripts/charts-amcharts.js');

//debug($myData);
?>
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <div class="col-md-6">
                <input id="datepicker" data-date-format="yyyy-mm" class="form-control input-large date-picker" type="text" value="<?if($month!=null){echo $month;}else{echo "ERROR:500";}?>" readonly>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn red" onClick="goNextDay();"><i class="fa fa-check"></i>月を選択する</button>
            </div>
            <script>
                function goNextDay(){
                    var date  = $("#datepicker").val();
                    var url   = location.href;
                    var parameters    = url.split("?");
                    var dateJob = parameters[1].split("=");
                    if (date != dateJob[1]) {
                        window.location.href = '?month='+date;
                    };
                }
                $('#datepicker').datepicker({
                    dateFormat: "yy-mm-dd",
                    numberOfMonths: 2,
                    minDate: 0,
                    maxDate: '+1M'
                });
            </script>
        </div>
        <!-- END PAGE TITLE -->
    </div>
</div>
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row margin-top-10">
            <div class="col-md-12">
                <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar" style="width: 250px;">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            <img src="<?if($myData!=null){echo $myData['MemberProfile']['photo'];}?>" class="img-responsive" alt="">
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <?if($myData!=null){echo $myData['Member']['name'];}?>
                            </div>
                            <div class="profile-usertitle-job">
                                <?if($myData!=null){echo $myData['Post']['name'];}?>
                            </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->
                        <div class="profile-userbuttons">
                            <button type="button" class="btn btn-circle green-haze btn-sm"><?if($myData!=null){echo $myData['Position']['name'];}?></button>
                            <button type="button" class="btn btn-circle btn-danger btn-sm"><?if($myData!=null){echo $myData['Location']['name'];}?></button>
                        </div>
                        <!-- END SIDEBAR BUTTONS -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="active">
                                    <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'view'));?>">
                                        <i class="icon-home"></i>
                                        概要 </a>
                                </li>
                                <li>
                                    <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'edit'));?>">
                                        <i class="icon-settings"></i>
                                        アカウント設定 </a>
                                </li>
                                <!--
                                <li>
                                    <a href="page_todo.html" target="_blank">
                                        <i class="icon-check"></i>
                                        Tasks </a>
                                </li>
                                <li>
                                    <a href="extra_profile_help.html">
                                        <i class="icon-info"></i>
                                        Help </a>
                                </li>
                                -->
                            </ul>
                        </div>
                        <!-- END MENU -->
                    </div>
                    <!-- END PORTLET MAIN -->
                    <!-- PORTLET MAIN -->
                    <div class="portlet light">
                        <!-- STAT -->
                        <div class="row list-separated profile-stat">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title">
                                    <?echo $days;?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    日数合計
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title">
                                    <?echo $hours+$late_hours;?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    時間数合計
                                </div>
                            </div>
                        </div>
                        <!-- END STAT -->
                        <!-- STAT -->
                        <div class="row list-separated profile-stat">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title">
                                    <?echo $hours;?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    平日時間
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title">
                                    <?echo $late_hours;?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    深夜時間
                                </div>
                            </div>
                        </div>
                        <!-- END STAT -->
                        <div>
                            <h4 class="profile-desc-title">給与合計</h4>
                            <span class="profile-desc-text" style="font-size: 24px;"> ¥ 14,562</span>
                            <div class="margin-top-20 profile-desc-link">
                                通常給：
                                ¥ <?echo number_format($salaries);?>
                            </div>
                            <div class="margin-top-20 profile-desc-link">
                                深夜給：
                                ¥ <?echo number_format($late_salaries);?>
                            </div>
                            <div class="margin-top-20 profile-desc-link">
                                大入り手当：
                                ¥ <?echo number_format($special_fee);?>
                            </div>
                            <div class="margin-top-20 profile-desc-link">
                                通勤手当：
                                ¥ <?echo number_format($compensation);?>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET MAIN -->
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PORTLET -->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">相互採点評価</span>
                                        <span class="caption-helper hide">weekly stats...</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                            <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                            <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Month</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="chart_9" class="chart"></div>
                                </div>
                            </div>
                            <!-- END PORTLET -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PORTLET -->
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">勤務記録</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">
                                                System </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-toggle="tab">
                                                Activities </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <!--BEGIN TABS-->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_1">
                                            <div class="slimScrollDiv" style="overflow: auto;height: 300px;">
                                                <ul class="feeds">
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-success">
                                                                        <i class="fa fa-bell-o"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        You have 4 pending tasks. <span class="label label-sm label-info">
																			Take action <i class="fa fa-share"></i>
																			</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                Just now
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New version v1.4 just lunched!
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    20 mins
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-danger">
                                                                        <i class="fa fa-bolt"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Database server #12 overloaded. Please fix the issue.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                24 mins
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        New order received and pending for process.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                30 mins
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-success">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        New payment refund and pending approval.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                40 mins
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-warning">
                                                                        <i class="fa fa-plus"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        New member registered. Pending approval.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                1.5 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-success">
                                                                        <i class="fa fa-bell-o"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
																			Overdue </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                2 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-default">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Prod01 database server is overloaded 90%.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                3 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-warning">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        New group created. Pending manager review.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                5 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Order payment failed.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                18 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-default">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        New application received.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                21 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Dev90 web server restarted. Pending overall system check.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                22 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-default">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        New member registered. Pending approval
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                21 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        L45 Network failure. Schedule maintenance.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                22 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-default">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Order canceled with failed payment.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                21 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Web-A2 clound instance created. Schedule full scan.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                22 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-default">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Member canceled. Schedule account review.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                21 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        New order received. Please take care of it.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                22 hours
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_1_2">
                                            <div class="slimScrollDiv" style="overflow: auto;height: 300px;">
                                                <ul class="feeds">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New user registered
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    Just now
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New order received
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    10 mins
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-danger">
                                                                        <i class="fa fa-bolt"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Order #24DOP4 has been rejected. <span class="label label-sm label-danger ">
																			Take action <i class="fa fa-share"></i>
																			</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date">
                                                                24 mins
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New user registered
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    Just now
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New user registered
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    Just now
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New user registered
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    Just now
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New user registered
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    Just now
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New user registered
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    Just now
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New user registered
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    Just now
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc">
                                                                            New user registered
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">
                                                                    Just now
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END TABS-->
                                </div>
                            </div>
                            <!-- END PORTLET -->
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
            Layout.init(); // init current layout
            Demo.init(); // init demo features\
            Profile.init(); // init page demo
            ChartsAmcharts.init();
        });
    </script>
</div>
