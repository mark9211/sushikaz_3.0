<?
#BEGIN THEME GLOBAL STYLES
echo $this->Html->css('assets/global/css/components.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');

# Page Level Plugin
echo $this->Html->script('assets/global/plugins/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');
echo $this->Html->script('assets/global/plugins/clockface/js/clockface.js');
echo $this->Html->script('assets/pages/scripts/components-date-time-pickers.min.js');

?>
<?echo $this->Form->create(null, array(
    'url' => array('controller' => 'sales', 'action' => 'monthly_report')
));?>
    <div class="page-container">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>エクセル出力 <small>Monthly Reports</small></h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
        </div>
        <!-- END PAGE HEAD -->
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Modal title</h4>
                            </div>
                            <div class="modal-body">
                                Widget settings form goes here
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn blue">Save changes</button>
                                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div class="row">
                    <div class="col-md-4">
                        <div class="portlet light" style="height: 400px;">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe font-green-sharp"></i>
                                    <span class="caption-subject font-green-sharp bold uppercase">出力ファイル選択</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_tab_2_1">
                                        <div class="skin skin-minimal">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <div class="icheck-list">
                                                                <label>
                                                                    <input type="radio" name="data_type" checked class="icheck" value="1"> 売上表 </label>
                                                                <label>
                                                                    <input type="radio" name="data_type" class="icheck" value="2"> 店内経費支払表 </label>
                                                                <label>
                                                                    <input type="radio" name="data_type" class="icheck" value="3"> 給与明細書(バイト)</label>
                                                                <label>
                                                                    <input type="radio" name="data_type" class="icheck" value="4"> 売上高人件費率</label>
                                                                <label>
                                                                    <input type="radio" name="data_type" class="icheck" value="5"> 仕入れ管理表</label>
                                                                <label>
                                                                    <input type="radio" name="data_type" class="icheck" value="6"> 差益率管理表（フード＋ドリンク）</label>
                                                                <label>
                                                                    <input type="radio" name="data_type" class="icheck" value="7"> 営業日報</label>
                                                                <label>
                                                                    <input type="radio" name="data_type" class="icheck" value="8"> 棚卸表 </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <!-- BEGIN PORTLET-->
                        <div class="portlet light form-fit" style="height: 300px;">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-cogs font-green-sharp"></i>
                                    <span class="caption-subject font-green-sharp bold uppercase">パラメータ選択</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">月選択</label>
                                        <div class="col-md-9">
                                            <input id="datepicker" name="month" data-date-format="yyyy-mm" class="form-control input-small date-picker" size="16" type="text" value="<?echo date('Y-m');?>" readonly>
                                            <script>
                                                $('#datepicker').datepicker({
                                                    dateFormat: "yy-mm",
                                                    numberOfMonths: 2,
                                                    minDate: 0,
                                                    maxDate: '+1M'
                                                });
                                            </script>
                                            <!-- /input-group -->
											<span class="help-block" style="width: 140px;">
											月を選択してください </span>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top:100px;">
                                        <label class="control-label col-md-3">店舗選択</label>
                                        <div class="col-md-9">
                                            <select name="location">
                                                <option value="">店舗指定なし</option>
                                                <option value="1">池袋店</option>
                                                <option value="2">赤羽店</option>
                                                <option value="3">和光店</option>
                                                <option value="4">東池袋店</option>
												<option value="5">池袋東武店</option>
                                            </select>
                                            <!-- /input-group -->
											<span class="help-block" style="width: 140px;">
											店舗を選択してください </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET-->
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                    <div class="col-md-3">
                        <div class="portlet light">
                            <div class="form-actions">
                                <button type="submit" class="btn green-haze">Excelダウンロード</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?echo $this->Form->end;?>
