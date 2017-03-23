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
#郵便番号js
echo $this->Html->script('jquery.jpostal.js');
# datepicker
echo $this->Html->css('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css');
echo $this->Html->script('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js');
echo $this->Html->script('datepicker-ja.js');

?>
<style>
    .profile-userpic img {
        width: 30% !important;
        height: 30% !important;
    }
</style>
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
                            <?if($myData['CustomerProfile']['photo']!=null):?>
                                <img src="<?echo $myData['CustomerProfile']['photo'];?>" class="img-responsive" alt="">
                                <?else:?>
                                <?if($myData['CustomerProfile']['gender']=='M'){$image='male.jpg';}elseif($myData['CustomerProfile']['gender']=='F'){$image='female.jpg';}?>
                                <?echo $this->Html->image($image, array('class' => 'img-responsive'));?>
                            <?endif;?>
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <?if($myData!=null){echo $myData['CustomerProfile']['name'];}?>
                            </div>
                            <div class="profile-usertitle-job">
                                <?if($myData!=null){echo $myData['CustomerProfile']['kana'];}?>
                            </div>
                            <h5>
                                <i class="fa fa-credit-card"></i> : <a href="javascript:;"><?echo $myData['CustomerProfile']['card_id']?></a>
                            </h5>
                            <h5>
                                <i class="fa fa-phone"></i> : <a href="tel:<?echo $myData['CustomerProfile']['phone']?>"><?echo $myData['CustomerProfile']['phone']?></a>
                            </h5>
                            <h5>
                                <i class="fa fa-envelope-o"></i> : <a href="mailto:<?echo $myData['CustomerProfile']['email']?>"><?echo $myData['CustomerProfile']['email']?></a>
                            </h5>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->
                        <div class="profile-userbuttons" style="margin-top: 15px;">
                            <?if($myData['CustomerProfile']['gender']=='M'):?>
                            <button type="button" class="btn btn-circle green-haze btn-sm">男性</button>
                            <?elseif($myData['CustomerProfile']['gender']=='F'):?>
                            <button type="button" class="btn btn-circle red-mint btn-sm">女性</button>
                            <?endif;?>
                            <?$now=date("Ymd");$birth=date('Ymd', strtotime($myData['CustomerProfile']['birthday']));$age=floor(($now-$birth)/10000);?>
                            <button type="button" class="btn btn-circle blue-hoki btn-sm"><?echo $age;?> 歳</button>
                        </div>
                        <!-- END SIDEBAR BUTTONS -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu" style="padding-bottom: 0;margin-top: 10px;">
                            <ul class="nav">
                                <li class="active">
                                    <a href="#tab_3_1" data-toggle="tab">
                                        <i class="icon-home"></i>
                                        概要 </a>
                                </li>
                                <li>
                                    <a href="#tab_3_2" data-toggle="tab">
                                        <i class="icon-settings"></i>
                                        編集 </a>
                                </li>
                                <li>
                                    <a href="#tab_3_3" data-toggle="tab">
                                        <i class="fa fa-pencil"></i>
                                        来店登録 </a>
                                </li>
                                <li>
                                    <a href="<?echo $this->Html->url(array('controller'=>'customer_profiles', 'action'=>'logout'));?>">
                                        <i class="fa fa-unlock"></i> ログアウト </a>
                                </li>
                            </ul>
                        </div>
                        <!-- END MENU -->
                    </div>
                    <!-- END PORTLET MAIN -->
                    <!-- PORTLET MAIN -->
                    <div class="portlet light" style="padding-bottom: 0;">
                        <!-- STAT -->
                        <div class="row list-separated profile-stat">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="uppercase profile-stat-title">
                                    <?echo $total;?> <span style="font-size: medium;">回</span>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    総来店回数
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title" style="font-size: 20px;">
                                    <?echo $lunch;?> <span style="font-size: medium;">回</span>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    ランチ合計
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title" style="font-size: 20px;">
                                    <?echo $dinner;?> <span style="font-size: medium;">回</span>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    ディナー合計
                                </div>
                            </div>
                        </div>
                        <!-- END STAT -->
                        <div class="row list-separated profile-stat">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="uppercase profile-stat-title">
                                    ¥ <?echo number_format($total_pay);?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    総支払金額
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title" style="font-size: 18px;">
                                    ¥ <?echo number_format($lunch_pay);?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    ランチ合計
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title" style="font-size: 18px;">
                                    ¥ <?echo number_format($dinner_pay);?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    ディナー合計
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title" style="font-size: 18px;">
                                    ¥ <?if($lunch!=0){echo number_format(floor($lunch_pay/$lunch));}else{echo 0;}?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    ランチ平均
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="uppercase profile-stat-title" style="font-size: 18px;">
                                    ¥ <?if($dinner!=0){echo number_format(floor($dinner_pay/$dinner));}else{echo 0;}?>
                                </div>
                                <div class="uppercase profile-stat-text">
                                    ディナー平均
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET MAIN -->
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="tab-content">
                    <div class="profile-content tab-pane active" id="tab_3_1">
                        <!--
                    <div class="row">
                        <div class="col-md-12">
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
                        </div>
                    </div>
                    -->
                        <!-- BEGIN 来店履歴 -->
                        <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PORTLET -->
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">来店履歴</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">
                                                全て </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <!--BEGIN TABS-->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_1">
                                            <div class="slimScrollDiv" style="overflow: auto;max-height: 300px;">
                                                <table class="table table-striped table-bordered table-advance table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <i class="fa fa-home"></i> 店舗 </th>
                                                        <th>
                                                            <i class="fa fa-calendar"></i> 営業日 </th>
                                                        <th>
                                                            <i class="fa fa-users"></i> 来店人数 </th>
                                                        <th>
                                                            <i class="fa fa-credit-card"></i> レシート </th>
                                                        <th> </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?if($customer_records!=null):?>
                                                        <?foreach($customer_records as $customer_record):?>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:;"> <?echo $customer_record['Location']['name'];?> </a>
                                                            </td>
                                                            <td> <?echo $customer_record['CustomerRecord']['working_day'];?> </td>
                                                            <td> <?echo $customer_record['CustomerRecord']['visit_persons'];?> 人 </td>
                                                            <td> No. <?echo $customer_record['CustomerRecord']['receipt_number'];?>
                                                                <span class="label label-success label-sm"> Paid </span>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> 編集 </a>
                                                            </td>
                                                        </tr>
                                                        <?endforeach;?>
                                                    <?endif;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END TABS-->
                                </div>
                            </div>
                            <!-- END PORTLET -->
                        </div>
                        </div>
                        <!-- END 来店履歴-->
                        <!-- BEGIN 注文履歴 -->
                        <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PORTLET -->
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">注文履歴</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_2_1" data-toggle="tab">
                                                全て </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <!--BEGIN TABS-->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_2_1">
                                            <div class="slimScrollDiv" style="overflow: auto;max-height: 300px;">
                                                <table class="table table-striped table-bordered table-advance table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <i class="fa fa-home"></i> 店舗 </th>
                                                        <th>
                                                            <i class="fa fa-calendar"></i> 営業日 </th>
                                                        <th>
                                                            <i class="fa fa-tasks"></i> 品名 </th>
                                                        <th>
                                                            <i class="fa fa-sort-numeric-asc"></i> 数量 </th>
                                                        <th>
                                                            <i class="fa fa-credit-card"></i> レシート </th>
                                                        <th> </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?if($menu!=null):?>
                                                        <?foreach($menu as $m):?>
                                                            <tr>
                                                                <td>
                                                                    <a href="javascript:;"> <?echo $m['location'];?> </a>
                                                                </td>
                                                                <td> <?echo $m['working_day'];?> </td>
                                                                <td> <?echo trim($m['name']);?> </td>
                                                                <td> <?echo $m['num'];?>  </td>
                                                                <td> No. <?echo $m['receipt'];?>
                                                                    <span class="label label-success label-sm"> Paid </span>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> 編集 </a>
                                                                </td>
                                                            </tr>
                                                        <?endforeach;?>
                                                    <?endif;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END TABS-->
                                </div>
                            </div>
                            <!-- END PORTLET -->
                        </div>
                        </div>
                        <!-- END 注文履歴 -->
                    </div>
                    <div class="profile-content tab-pane" id="tab_3_2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">プロフィール編集</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_4_1" data-toggle="tab" aria-expanded="true">基本情報</a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_4_2" data-toggle="tab" aria-expanded="false">アバター写真</a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_4_3" data-toggle="tab" aria-expanded="false">パスワード</a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_4_4" data-toggle="tab" aria-expanded="false">プライバシー設定</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_4_1">
                                                <form role="form" method="post" action="<?echo $this->Html->url(array('controller'=>'customer_profiles', 'action'=>'edit'));?>">
                                                    <input type="hidden" value="<?if($myData!=null){echo $myData['CustomerProfile']['id'];}?>" name="CustomerProfile[id]">
                                                    <div class="form-group">
                                                        <label class="control-label">ポイントカードNo.</label>
                                                        <input type="text" placeholder="ポイントカードNo." value="<?if($myData!=null){echo $myData['CustomerProfile']['card_id'];}?>" class="form-control" name="CustomerProfile[card_id]"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">氏名（漢字）</label>
                                                        <input type="text" placeholder="氏名（漢字）" value="<?if($myData!=null){echo $myData['CustomerProfile']['name'];}?>" class="form-control" name="CustomerProfile[name]"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">氏名（カナ）</label>
                                                        <input type="text" placeholder="氏名（カナ）" value="<?if($myData!=null){echo $myData['CustomerProfile']['kana'];}?>" class="form-control" name="CustomerProfile[kana]"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">電話番号</label>
                                                        <input type="text" placeholder="09012345678" value="<?if($myData!=null){echo $myData['CustomerProfile']['phone'];}?>" class="form-control" name="CustomerProfile[phone]"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Email</label>
                                                        <input type="text" placeholder="sushikaz@xxx.com" value="<?if($myData!=null){echo $myData['CustomerProfile']['email'];}?>" class="form-control" name="CustomerProfile[email]"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">性別</label>
                                                        <div class="radio-list">
                                                            <label>
                                                                <div class="radio"><input type="radio" name="CustomerProfile[gender]" value="M" data-title="Male" <?if($myData!=null&&$myData['CustomerProfile']['gender']=='M'){echo "checked";}?>></div>
                                                                男性
                                                            </label>
                                                            <label>
                                                                <div class="radio"><input type="radio" name="CustomerProfile[gender]" value="F" data-title="Female" <?if($myData!=null&&$myData['CustomerProfile']['gender']=='F'){echo "checked";}?>></div>
                                                                女性
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">生年月日</label>
                                                        <input id="datepicker1" placeholder="1992-11-11" data-date-format="yyyy-mm-dd" value="<?if($myData!=null){echo $myData['CustomerProfile']['birthday'];}?>" class="form-control" name="CustomerProfile[birthday]" readonly>
                                                        <script>
                                                            $('#datepicker1').datepicker({
                                                                dateFormat: "yy-mm-dd",
                                                                numberOfMonths: 2,
                                                                minDate: 0,
                                                                maxDate: '+1M'
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">郵便番号</label>
                                                        <input type="text" placeholder="1234567" value="<?if($myData!=null){echo $myData['CustomerProfile']['postcode'];}?>" class="form-control" name="CustomerProfile[postcode]" id="postcode1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">都道府県</label>
                                                        <select name="CustomerProfile[address1]" class="form-control" id="address1">
                                                            <option value="" selected="selected">選択してください</option>
                                                            <option value="北海道" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='北海道'){echo "selected";}?>>北海道</option>
                                                            <option value="青森県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='青森県'){echo "selected";}?>>青森県</option>
                                                            <option value="岩手県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='岩手県'){echo "selected";}?>>岩手県</option>
                                                            <option value="宮城県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='宮城県'){echo "selected";}?>>宮城県</option>
                                                            <option value="秋田県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='秋田県'){echo "selected";}?>>秋田県</option>
                                                            <option value="山形県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='山形県'){echo "selected";}?>>山形県</option>
                                                            <option value="福島県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='福島県'){echo "selected";}?>>福島県</option>
                                                            <option value="茨城県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='茨城県'){echo "selected";}?>>茨城県</option>
                                                            <option value="栃木県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='栃木県'){echo "selected";}?>>栃木県</option>
                                                            <option value="群馬県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='群馬県'){echo "selected";}?>>群馬県</option>
                                                            <option value="埼玉県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='埼玉県'){echo "selected";}?>>埼玉県</option>
                                                            <option value="千葉県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='千葉県'){echo "selected";}?>>千葉県</option>
                                                            <option value="東京都" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='東京都'){echo "selected";}?>>東京都</option>
                                                            <option value="神奈川県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='神奈川県'){echo "selected";}?>>神奈川県</option>
                                                            <option value="新潟県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='新潟県'){echo "selected";}?>>新潟県</option>
                                                            <option value="富山県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='富山県'){echo "selected";}?>>富山県</option>
                                                            <option value="石川県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='石川県'){echo "selected";}?>>石川県</option>
                                                            <option value="福井県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='福井県'){echo "selected";}?>>福井県</option>
                                                            <option value="山梨県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='山梨県'){echo "selected";}?>>山梨県</option>
                                                            <option value="長野県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='長野県'){echo "selected";}?>>長野県</option>
                                                            <option value="岐阜県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='岐阜県'){echo "selected";}?>>岐阜県</option>
                                                            <option value="静岡県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='静岡県'){echo "selected";}?>>静岡県</option>
                                                            <option value="愛知県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='愛知県'){echo "selected";}?>>愛知県</option>
                                                            <option value="三重県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='三重県'){echo "selected";}?>>三重県</option>
                                                            <option value="滋賀県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='滋賀県'){echo "selected";}?>>滋賀県</option>
                                                            <option value="京都府" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='京都府'){echo "selected";}?>>京都府</option>
                                                            <option value="大阪府" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='大阪府'){echo "selected";}?>>大阪府</option>
                                                            <option value="兵庫県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='兵庫県'){echo "selected";}?>>兵庫県</option>
                                                            <option value="奈良県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='奈良県'){echo "selected";}?>>奈良県</option>
                                                            <option value="和歌山県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='和歌山県'){echo "selected";}?>>和歌山県</option>
                                                            <option value="鳥取県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='鳥取県'){echo "selected";}?>>鳥取県</option>
                                                            <option value="島根県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='島根県'){echo "selected";}?>>島根県</option>
                                                            <option value="岡山県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='岡山県'){echo "selected";}?>>岡山県</option>
                                                            <option value="広島県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='広島県'){echo "selected";}?>>広島県</option>
                                                            <option value="山口県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='山口県'){echo "selected";}?>>山口県</option>
                                                            <option value="徳島県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='徳島県'){echo "selected";}?>>徳島県</option>
                                                            <option value="香川県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='香川県'){echo "selected";}?>>香川県</option>
                                                            <option value="愛媛県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='愛媛県'){echo "selected";}?>>愛媛県</option>
                                                            <option value="高知県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='高知県'){echo "selected";}?>>高知県</option>
                                                            <option value="福岡県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='福岡県'){echo "selected";}?>>福岡県</option>
                                                            <option value="佐賀県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='佐賀県'){echo "selected";}?>>佐賀県</option>
                                                            <option value="長崎県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='長崎県'){echo "selected";}?>>長崎県</option>
                                                            <option value="熊本県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='熊本県'){echo "selected";}?>>熊本県</option>
                                                            <option value="大分県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='大分県'){echo "selected";}?>>大分県</option>
                                                            <option value="宮崎県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='宮崎県'){echo "selected";}?>>宮崎県</option>
                                                            <option value="鹿児島県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='鹿児島県'){echo "selected";}?>>鹿児島県</option>
                                                            <option value="沖縄県" <?if($myData!=null&&$myData['CustomerProfile']['address1']=='沖縄県'){echo "selected";}?>>沖縄県 </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">市区町村</label>
                                                        <input type="text" placeholder="◯◯市" value="<?if($myData!=null){echo $myData['CustomerProfile']['address2'];}?>" class="form-control" name="CustomerProfile[address2]" id="address2">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">番地など</label>
                                                        <input type="text" placeholder="××町" value="<?if($myData!=null){echo $myData['CustomerProfile']['address3'];}?>" class="form-control" name="CustomerProfile[address3]" id="address3">
                                                    </div>
                                                    <script>
                                                        $(window).ready( function() {
                                                            $('#postcode1').jpostal({
                                                                postcode : [
                                                                    '#postcode1'
                                                                ],
                                                                address : {
                                                                    '#address1'  : '%3',
                                                                    '#address2'  : '%4',
                                                                    '#address3'  : '%5'
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                    <div class="margiv-top-10">
                                                        <button type="submit" class="btn green button-submit">保存する</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- CHANGE AVATAR TAB -->
                                            <div class="tab-pane" id="tab_4_2">
                                                <form method="post" action="<?echo $this->Html->url(array('controller'=>'customer_profiles', 'action'=>'edit_photo'));?>" role="form">
                                                    <input type="hidden" value="<?if($myData!=null){echo $myData['CustomerProfile']['id'];}?>" name="id">
                                                    <div class="form-group">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <p>200px × 200px の写真を選択してください </p>
                                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                            <div>
                                                                <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> 写真を選択 </span>
                                                                    <span class="fileinput-exists"> 変更 </span>
                                                                    <input type="file" name="...">
                                                                </span>
                                                                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> 取り消す </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix margin-top-10">
                                                            <span class="label label-danger">NOTE! </span>
                                                            <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                                        </div>
                                                    </div>
                                                    <div class="margin-top-10">
                                                        <button type="submit" class="btn green button-submit">保存する</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE AVATAR TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane" id="tab_4_3">
                                                <form method="post" action="<?echo $this->Html->url(array('controller'=>'customer_profiles', 'action'=>'edit_password'));?>" role="form">
                                                    <input type="hidden" value="<?if($myData!=null){echo $myData['CustomerProfile']['id'];}?>" name="id">
                                                    <div class="form-group">
                                                        <label class="control-label">現在のパスワード</label>
                                                        <input type="password" class="form-control" name="password"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">新しいパスワード</label>
                                                        <input type="password" class="form-control" name="new_password"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">新しいパスワードの確認</label>
                                                        <input type="password" class="form-control" name="re_new_password"> </div>
                                                    <div class="margin-top-10">
                                                        <button type="submit" class="btn green button-submit">保存する</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->
                                            <!-- PRIVACY SETTINGS TAB -->
                                            <div class="tab-pane" id="tab_4_4">
                                                <form action="#">
                                                    <table class="table table-light table-hover">
                                                        <tbody><tr>
                                                            <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                                            <td>
                                                                <div class="mt-radio-inline">
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="optionsRadios1" value="option1"> Yes
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="optionsRadios1" value="option2" checked=""> No
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                            <td>
                                                                <div class="mt-radio-inline">
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="optionsRadios11" value="option1"> Yes
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="optionsRadios11" value="option2" checked=""> No
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                            <td>
                                                                <div class="mt-radio-inline">
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="optionsRadios21" value="option1"> Yes
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="optionsRadios21" value="option2" checked=""> No
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                            <td>
                                                                <div class="mt-radio-inline">
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="optionsRadios31" value="option1"> Yes
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="optionsRadios31" value="option2" checked=""> No
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                    <!--end profile-settings-->
                                                    <div class="margin-top-10">
                                                        <a href="javascript:;" class="btn red"> Save Changes </a>
                                                        <a href="javascript:;" class="btn default"> Cancel </a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PRIVACY SETTINGS TAB -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-content tab-pane" id="tab_3_3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">来店登録</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_5_1" data-toggle="tab" aria-expanded="true">レシート登録</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_5_1">
                                                <form role="form" method="post" action="<?echo $this->Html->url(array('controller'=>'customer_profiles', 'action'=>'record_add'));?>">
                                                    <input type="hidden" value="<?if($myData!=null){echo $myData['CustomerProfile']['id'];}?>" name="CustomerRecord[customer_id]">
                                                    <div class="form-group">
                                                        <label class="control-label">店舗</label>
                                                        <select name="CustomerRecord[location_id]" class="form-control">
                                                            <option value="">選択してください</option>
                                                            <option value="1">池袋店</option>
                                                            <option value="2">赤羽店</option>
                                                            <option value="3" selected="selected">和光店</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">営業日</label>
                                                        <input id="datepicker2" data-date-format="yyyy-mm-dd" value="<?echo date('Y-m-d');?>" class="form-control" name="CustomerRecord[visit_time]" readonly>
                                                        <script>
                                                            $('#datepicker2').datepicker({
                                                                language: 'ja',
                                                                dateFormat: "yy-mm-dd",
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">来店人数</label>
                                                        <select name="CustomerRecord[visit_persons]" class="form-control">
                                                            <option value="">選択してください</option>
                                                            <option value="1" selected>1名</option>
                                                            <?for($i=2;$i<50;$i++):?>
                                                            <option value="<?echo $i;?>"><?echo $i;?>名</option>
                                                            <?endfor;?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">レシートNo.</label>
                                                        <input type="text" value="" class="form-control" name="CustomerRecord[receipt_number]">
                                                    </div>
                                                    <div class="margiv-top-10">
                                                        <button type="submit" class="btn green button-submit">保存する</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                        </div>
                                    </div>
                                </div>
                            </div>
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
