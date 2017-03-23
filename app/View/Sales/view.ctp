<?
#cssファイル
echo $this->Html->css('assets/global/plugins/select2/select2.css');
echo $this->Html->css('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datepicker/css/datepicker.css');

#jsファイル
echo $this->Html->script('jquery-ui-1.10.4.custom.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.resize.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.categories.js');

echo $this->Html->script('assets/admin/pages/scripts/ecommerce-index.js');

echo $this->Html->script('assets/admin/pages/scripts/charts-flotcharts.js');
echo $this->Html->script('assets/admin/pages/scripts/table-advanced.js');

echo $this->Html->script('assets/global/plugins/flot/jquery.flot.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.resize.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.pie.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.stack.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.crosshair.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.categories.min.js');

echo $this->Html->script('assets/global/plugins/select2/select2.min.js');
echo $this->Html->script('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');
echo $this->Html->script('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js');

echo $this->Html->script('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');

echo $this->Html->script('assets/admin/pages/scripts/ui-datepaginator.js');

echo $this->Html->script('assets/global/plugins/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js');


?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>日報一覧 <small>Daily Reports</small></h1>
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
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">日付選択</span>
					</div>
					<div class="tools">
						<a href="javascript:;" class="collapse">
						</a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-6">
							<input id="datepicker" data-date-format="yyyy-mm-dd" class="form-control input-small date-picker" type="text" value="<?echo $working_day; ?>" readonly>
							<script>
								$('#datepicker').datepicker({
									dateFormat: "yy-mm-dd",
									numberOfMonths: 2,
									minDate: 0,
									maxDate: '+1M'
								});
							</script>
						</div>

						<div class="col-md-6">
							<button type="button" class="btn red" onClick="goNextDay();"><i class="fa fa-check"></i>日付を選択する</button>
							<script>
								function goNextDay(){
									var date  = $("#datepicker").val();
									var url   = location.href;
									var parameters    = url.split("?");
									var dateJob = parameters[1].split("=");
									if (date != dateJob[1]) {
										window.location.href = '?date='+date;
									};
								}
							</script>
						</div>
					</div>
				</div>
			</div>
			<!-- BEGIN PAGE CONTENT INNER -->

			<div class="row">

				<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
					<a class="dashboard-stat dashboard-stat-light red-intense" href="javascript:;">
						<div class="visual">
							<i class="fa fa-trophy fa-icon-medium"></i>
						</div>
						<div class="details">
							<div class="number">
								¥<?if(isset($total_sales)){echo number_format($total_sales['TotalSales']['sales']);}?>
							</div>
							<div class="desc">
								総売上
							</div>
							<div class="desc">
								<?if(isset($sales)){
									foreach($sales as $sales_one){
										echo $sales_one['Type']['name'].":¥".number_format($sales_one['Sales']['fee'])." ";
									}
								}?>
							</div>
						</div>
					</a>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<a class="dashboard-stat dashboard-stat-light blue-hoki" href="javascript:;">
						<div class="visual">
							<i class="fa fa-moon-o"></i>
						</div>
						<div class="details">
							<div class="number">
								¥<?if(isset($total_sales)){if($total_sales['TotalSales']['customer_counts']!=0){echo number_format(floor(($total_sales['TotalSales']['sales'] - $sales_demae) / $total_sales['TotalSales']['customer_counts']));}}?>
							</div>
							<div class="desc">
								客単価
							</div>
							<div class="desc">
								客数:<?if(isset($total_sales)){echo number_format($total_sales['TotalSales']['customer_counts']);}?>, 出前数:<?if(isset($num_demae)){echo $num_demae;}?>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<!-- Begin stat blocks -->
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="dashboard-stat grey">
								<div class="visual">
									<i class="fa fa-spinner"></i>
								</div>
								<div class="details">
									<div class="number">
										<?if(isset($other_informations)){echo $other_informations['OtherInformation']['weather'];}?>
									</div>
									<div class="desc">
										天気
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="fa fa-flash"></i>
								</div>
								<div class="details">
									<div class="number">
										¥<?if(isset($payroll)){echo number_format($payroll['Payroll']['hall']+$payroll['Payroll']['kitchen']);}?>
									</div>
									<div class="desc">
										人件費合計
									</div>
								</div>

							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="fa fa-users"></i>
								</div>
								<div class="details">
									<div class="number">
										<?if(isset($payroll)){echo $payroll['Payroll']['ratio'];}?>%
									</div>
									<div class="desc">
										人件費比率（対売上）
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="fa fa-bar-chart-o"></i>
								</div>
								<div class="details">
									<div class="number">
										<?if(isset($total_sales)&&isset($target)){echo floor($total_sales['TotalSales']['sales']/$target*100);}?>%
									</div>
									<div class="desc">
										目標達成率(<?if(isset($total_sales)&&isset($target)){$diff =$total_sales['TotalSales']['sales']-$target;if($diff>0){echo '+'.number_format($diff);}else{echo number_format($diff);}}?>)
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End stat blocks -->
					<!-- Begin: life time stats -->

					<!-- End: life time stats -->
				</div>
				<div class="col-md-6">
					<!-- Begin: life time stats -->
					<div class="portlet light">
						<div class="portlet-title tabbable-line">
							<div class="caption">
								<i class="icon-share font-red-sunglo"></i>
								<span class="caption-subject font-red-sunglo bold uppercase">時間別客数</span>
								<span class="caption-helper"># of customers</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
							<ul class="nav nav-tabs">
								<li>
									<!--
									<a href="#portlet_tab2" data-toggle="tab" id="statistics_amounts_tab">
										寿し和 </a>
									-->
								</li>
							</ul>
						</div>
						<div class="portlet-body">
							<div class="tab-content">
								<div class="tab-pane active" id="portlet_tab1">
									<div id="statistics_1" class="chart">
									</div>
								</div>
								<div class="tab-pane" id="portlet_tab2">
									<div id="statistics_2" class="chart">
									</div>
								</div>
							</div>
							<div class="margin-top-20 no-margin no-border">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-warning uppercase">
										Total</span>
										<h3><?if(isset($total_sales)){echo $total_sales['TotalSales']['customer_counts'];}?></h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End: life time stats -->
				<!-- BEGIN PIE CHART PORTLET-->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-hand-o-down font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">売上内訳</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div id="pie_chart_3" class="chart">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
			<!-- BEGIN ACCORDION PORTLET-->
			<div class="row">
				<div class="col-md-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">その他取引アイテム</span>
								<span class="caption-helper">other items</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="panel-group accordion scrollable" id="accordion2">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
												カード売上</a>
										</h4>
									</div>
									<div id="collapse_2_1" class="panel-collapse collapse">
										<!-- BEGIN CONDENSED TABLE PORTLET-->
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																種類
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>
														<tbody>
														<?if(isset($credit_sales)):?>
															<?$n=0;?>
															<?php foreach ($credit_sales as $credit_sales_one): ?>
																<tr>
																	<td>
																		<?php $n += 1; ?>
																		<?php echo h($n); ?>
																	</td>
																	<td>
																		<?echo $credit_sales_one['CreditType']['name']; ?>
																	</td>
																	<td>
																		¥<?echo number_format($credit_sales_one['CreditSales']['fee']); ?>
																	</td>
																</tr>
															<?php endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">

													<h3>¥<?if(isset($total_sales)){echo number_format($total_sales['TotalSales']['credit_sales']);} ?></h3>
												</div>
											</div>
										</div>
										<!-- END CONDENSED TABLE PORTLET-->
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_3">
												クーポン使用</a>
										</h4>
									</div>
									<div id="collapse_2_3" class="panel-collapse collapse">
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																種類
															</th>
															<th>
																名前
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>
														<tbody>
														<?php $n = 0; ?>
														<?if(isset($coupon_discounts)):?>
														<?php foreach ($coupon_discounts as $coupon_discount): ?>
															<tr>
																<th>
																	<?php $n += 1; ?>
																	<?php echo $n; ?>
																</th>
																<th>
																	<?echo $coupon_discount['CouponType']['name'];?>
																</th>
																<th>
																	<?echo $coupon_discount['CouponDiscount']['customer_name'];?>
																</th>
																<th>
																	¥<?php echo number_format($coupon_discount['CouponDiscount']['fee']); ?>
																</th>
															</tr>
														<?php endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">
													<h2>¥<?if(isset($total_sales)){ echo h(number_format($total_sales['TotalSales']['coupon_discounts']));} ?></h2>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_4">
												支払いオプション</a>
										</h4>
									</div>
									<div id="collapse_2_4" class="panel-collapse collapse">
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																種類
															</th>
															<th>
																名前
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>
														<tbody>
														<?php $n = 0; ?>
														<?if(isset($other_discounts)):?>
														<?php foreach ($other_discounts as $other_discount): ?>
															<tr>
																<th>
																	<?php $n += 1; ?>
																	<?php echo $n; ?>
																</th>
																<th>
																	<?php echo $other_discount['OtherType']['name']; ?>
																</th>
																<th>
																	<?php echo $other_discount['OtherDiscount']['customer_name']; ?>
																</th>
																<th>
																	¥<?php echo number_format($other_discount['OtherDiscount']['fee']); ?>
																</th>
															</tr>
														<?php endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">
													<h2>¥<?if(isset($total_sales)){echo number_format($total_sales['TotalSales']['other_discounts']);} ?></h2>
												</div>
											</div>

										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_2">
												支出</a>
										</h4>
									</div>
									<div id="collapse_2_2" class="panel-collapse collapse">
										<!-- BEGIN SAMPLE TABLE PORTLET-->
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																カテゴリ
															</th>
															<th>
																支出先
															</th>
															<th>
																購入品
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>

														<tbody>
														<?php $n = 0; ?>
														<?if(isset($expenses)):?>
														<?php foreach ($expenses as $expense): ?>
															<tr>
																<th>
																	<?php $n += 1; ?>
																	<?php echo $n; ?>
																</th>
																<th>
																	<?php echo $expense['Type']['name']; ?>
																</th>
																<th>
																	<?php echo $expense['Expense']['store_name']; ?>
																</th>
																<th>
																	<?php echo $expense['Expense']['product_name']; ?>
																</th>
																<th>
																	¥<?php echo h(number_format($expense['Expense']['fee'])); ?>
																</th>
															</tr>
														<?php endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">
													<h2>¥<?if(isset($total_sales)){ echo h(number_format($total_sales['TotalSales']['expenses']));} ?></h2>
												</div>
											</div>
										</div>
										<!-- END SAMPLE TABLE PORTLET-->
									</div>
								</div>

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_6">
												現金計</a>
										</h4>
									</div>
									<div id="collapse_2_6" class="panel-collapse collapse">
										<div class="panel-body">
											<h2>¥<?if(isset($total_sales)){ echo h(number_format($total_sales['TotalSales']['cash']));} ?></h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


				<!-- BEGIN PAGE CONTENT INNER -->

				<div class="col-md-3">
					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-green-sharp">
								<i class="icon-speech font-green-sharp"></i>
								<span class="caption-subject bold uppercase">その他</span>
								<span class="caption-helper">other info</span>
							</div>
							<div class="actions">
								<a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen"></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
								<h5>【日報報告者】</h5>
								<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?if(isset($other_informations)){echo $other_informations['Member']['name'];}?></p>
								<h5>【社員公休】</h5>
								<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?if(isset($absences['one']['Member']['name'])){echo $absences['one']['Member']['name'];}?>, <?if(isset($absences['two']['Member']['name'])){echo $absences['two']['Member']['name'];}?>, <?if(isset($absences['three']['Member']['name'])){echo $absences['three']['Member']['name'];}?></p>
								<h5>【伝票番号】</h5>
								<?if(isset($slip_numbers)):?>
									<?foreach($slip_numbers as $slip_number):?>
										<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?echo $slip_number['Type']['name'];?>:<?echo $slip_number['SlipNumber']['start_number']; ?> ~ <?echo $slip_number['SlipNumber']['end_number']; ?></p>
									<?endforeach;?>
								<?endif;?>
							</div>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
				<div class="col-md-3">
					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-green-sharp">
								<i class="icon-speech font-green-sharp"></i>
								<span class="caption-subject bold uppercase"> 備考欄</span>
								<span class="caption-helper">message</span>
							</div>
							<div class="actions">
								<a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen"></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
								<h5>【宴会情報】</h5>
								<?if(isset($party_informations)):?>
								<?foreach($party_informations as $party_information):?>
									<p>コース名:<?echo $party_information['Type']['name']; ?>, 開始時刻:<?echo $party_information['PartyInformation']['starting_time']; ?>, 人数:<?echo $party_information['PartyInformation']['customer_count']; ?>, お名前:<?echo $party_information['PartyInformation']['customer_name']; ?></p>
								<?endforeach;?>
								<?endif;?>
								<p></p>
								<h5>【その他】</h5>
								<p>
									<?if(isset($other_informations)){echo nl2br($other_informations['OtherInformation']['notes']);} ?>
								</p>
							</div>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-rocket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">スタッフ出勤一覧</span>
								<span class="caption-helper">attendance list</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_3">
								<thead>
								<tr>
									<th>
										氏名
									</th>
									　　　　　　　　　　　　　　　　　　　　　<th>
										担当業務
									</th>
									<th>
										開始時間
									</th>
									<th>
										終了時間
									</th>
									<th>
										通常実働
									</th>
									<th>
										深夜実働
									</th>
									<th>
										合計実働
									</th>
								</tr>
								</thead>
								<tbody>

								<?if(isset($attendance_results)):?>
								<?php foreach ($attendance_results as $attendance_result): ?>
									<tr>
										<td>
											<?php echo $attendance_result['Member']['name']; ?>
										</td>
										<td>
											<?php echo $attendance_result['Member']['Position']['name']; ?>
										</td>
										<th>
											<?php echo date("H:i", strtotime($attendance_result['AttendanceResult']['attendance_start'])); ?>
										</th>
										<th>
											<?php echo date("H:i", strtotime($attendance_result['AttendanceResult']['attendance_end'])); ?>
										</th>
										<td>
											<?php echo $attendance_result['AttendanceResult']['hours']; ?>
										</td>
										<td>
											<?php echo $attendance_result['AttendanceResult']['late_hours']; ?>
										</td>
										<td>
											<?php echo $attendance_result['AttendanceResult']['hours']+$attendance_result['AttendanceResult']['late_hours']; ?>
										</td>
									</tr>
								<?php endforeach; ?>
								<?endif;?>

								</tbody>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END ACCORDION PORTLET-->

		</div>

	</div>
</div>
</div>
</div>
<!-- END PAGE CONTENT -->


</div>
<script>
	jQuery(document).ready(function() {
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init(); // init demo features
		EcommerceIndex.init(<?if(isset($graph_one)){echo $graph_one;}?>);
		UIDatepaginator.init();
		ChartsFlotcharts.init();
		ChartsFlotcharts.initCharts();
		ChartsFlotcharts.initPieCharts(<?if(isset($graph_two)){echo $graph_two;}?>);
		ChartsFlotcharts.initBarCharts();
		TableAdvanced.init();
	});
</script>
