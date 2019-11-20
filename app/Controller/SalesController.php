<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/09
 * Time: 12:47
 */
#Zaim用Oauth認証ライブラリ
App::import('Vendor', 'OAuth/OAuthClient');

class SalesController extends AppController{
	#フォームヘルパー
	public $helpers = array('Html', 'Form');
	#Cookieの使用
	var $components = array('Cookie');
	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		parent::beforeFilter();
		$this->set('title_for_layout', 'エクセル出力 | 寿し和');
		#共通使用モデル
		$this->loadModel("Location");
		$this->loadModel("Sales");
		$this->loadModel("SalesType");
		$this->loadModel("TotalSales");
		$this->loadModel("CreditSales");
		$this->loadModel("CreditType");
		$this->loadModel("CustomerCount");
		$this->loadModel("CustomerTimezone");
		$this->loadModel("CouponDiscount");
		$this->loadModel("CouponType");
		$this->loadModel("OtherDiscount");
		$this->loadModel("OtherType");
		$this->loadModel("Expense");
		$this->loadModel("ExpenseType");
		$this->loadModel("OtherInformation");
		$this->loadModel("SlipNumber");
		$this->loadModel("Attendance");
		$this->loadModel("AttendanceResult");
		$this->loadModel("Member");
		$this->loadModel("PartyInformation");
		$this->loadModel("Inventory");
		$this->loadModel("Payroll");
		$this->loadModel("Target");
		$this->loadModel("PayableAccount");
		$this->loadModel("Holiday");
		$this->loadModel("SalesLunch");
		$this->loadModel("SalesAttribute");
		$this->loadModel("AddCash");
		$this->loadModel("Stocktaking");
		$this->loadModel("ReceiptSummary");
	}

	#月末報告
	public function monthly_report(){
		if($this->request->is('post')){
			$data = $this->request->data;
			$month = $data['month'];$date = $month.'-01';
			# location
			if($data['location']!='null'){
				$location = $this->Location->findById($data['location']);
			}else{
				$location = null;
			}
			# month
			if($this->request->data['month']==null){
				debug("月が入力されていません");
				exit;
			}
			// // エクセル出力用ライブラリ
			App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
			App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
			// Excel2007形式(xlsx)テンプレートの読み込み
			$reader = PHPExcel_IOFactory::createReader('Excel2007');
			$template = realpath(WWW_ROOT);
			$template .= '/excel/';
			# 曜日配列
			$weekday = array( "日", "月", "火", "水", "木", "金", "土" );
			# 全店or各店
			if($this->request->data['data_type']==1){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-sales-ikebukuro';
				}elseif($location['Location']['name']=='赤羽店'){
					$data_name = 'monthly-report-sales-akabane';
				}elseif($location['Location']['name']=='和光店'){
					$data_name = 'monthly-report-sales-wako';
				}else{
					echo "Error : 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				######################################２店舗用###############################################
				if($location['Location']['name']=='和光店'){
					for ($i=1; $i <= 31; $i++) {
						$working_day = $this->request->data['month'] . '-' . $i;
						$day = $weekday[date('w', strtotime($working_day))];
						$row_number = date('j', strtotime($working_day)) + 4;
						#売上内訳
						$this->Sales->recursive = 2;
						$sales = $this->Sales->find('all', array(
							'conditions' => array('Sales.location_id' => $location['Location']['id'], 'Sales.working_day' => $working_day)
						));
						if($sales!=null){
							$attribute_sales = $this->Sales->diviseSushiYakinikuArray($sales);
							$divise_sales = $this->Sales->diviseSushiYakiniku($sales);
							#寿司
							$sushi_sales = array();
							$sushi_sales['itaba'] = 0;
							$sushi_sales['yakiba'] = 0;
							$sushi_sales['drink'] = 0;
							foreach($attribute_sales['寿司'] as $attribute_sales_one){
								#板場
								if($attribute_sales_one['Type']['name']=='板場売上'){
									$sushi_sales['itaba'] = $attribute_sales_one['Sales']['fee'];
								}
								#焼き場
								if($attribute_sales_one['Type']['name']=='焼場売上'){
									$sushi_sales['yakiba'] = $attribute_sales_one['Sales']['fee'];
								}
								#飲料
								if($attribute_sales_one['Type']['name']=='飲料売上'){
									$sushi_sales['drink'] = $attribute_sales_one['Sales']['fee'];
								}
								#共同（焼場に加算）
								if($attribute_sales_one['Type']['name']=='共同売上'){
									$sushi_sales['yakiba'] += $attribute_sales_one['Sales']['fee'];
								}
							}
							#焼肉
							$yakiniku_sales = array();
							$yakiniku_sales['chori'] = 0;
							$yakiniku_sales['drink'] = 0;
							foreach($attribute_sales['焼肉'] as $attribute_sales_one){
								#調理場
								if($attribute_sales_one['Type']['name']=='調理場売上'){
									$yakiniku_sales['chori'] = $attribute_sales_one['Sales']['fee'];
								}
								#飲料
								if($attribute_sales_one['Type']['name']=='飲料売上'){
									$yakiniku_sales['drink'] = $attribute_sales_one['Sales']['fee'];
								}
								#共同（調理場に加算）
								if($attribute_sales_one['Type']['name']=='共同売上'){
									$yakiniku_sales['chori'] += $attribute_sales_one['Sales']['fee'];
								}
							}
							#ランチ売上
							$sales_lunches = $this->SalesLunch->find('all', array(
								'conditions' => array('SalesLunch.location_id' => $location['Location']['id'], 'SalesLunch.working_day' => $working_day)
							));
							if($sales_lunches!=null){
								$lunch = array();
								$lunch['sushi'] = 0;
								$lunch['yakiniku'] = 0;
								foreach($sales_lunches as $sales_lunch){
									#寿司
									if($sales_lunch['Attribute']['name']=='寿司'){
										$lunch['sushi'] = $sales_lunch['SalesLunch']['fee'];
									}
									#焼肉
									if($sales_lunch['Attribute']['name']=='焼肉'){
										$lunch['yakiniku'] = $sales_lunch['SalesLunch']['fee'];
									}
								}
								#ディナー売上
								$dinner_sales = $this->Sales->calculateDinnerSales($sales_lunches, $divise_sales);
								#客数
								$this->CustomerCount->recursive = 2;
								$customer_counts = $this->CustomerCount->find('all', array(
									'conditions' => array('CustomerCount.location_id' => $location['Location']['id'], 'working_day' => $working_day)
								));
								$divise_customers = $this->CustomerCount->diviseLunchDinner($customer_counts);

								//page 1
								$obj->setActiveSheetIndex(0)
									->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
									->setCellValue('C'.$row_number, $day)
									->setCellValue('D'.$row_number, floor($lunch['sushi']*1.08))
									->setCellValue('E'.$row_number, $divise_customers['lunch']['寿司'])
									->setCellValue('F'.$row_number, floor($dinner_sales['寿司']*1.08))
									->setCellValue('G'.$row_number, $divise_customers['dinner']['寿司'])
									->setCellValue('J'.$row_number, floor($sushi_sales['itaba']*1.08))
									->setCellValue('K'.$row_number, floor($sushi_sales['yakiba']*1.08))
									->setCellValue('L'.$row_number, floor($sushi_sales['drink']*1.08));
								//page 2
								$obj->setActiveSheetIndex(1)
									->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
									->setCellValue('C'.$row_number, $day)
									->setCellValue('D'.$row_number, floor($lunch['yakiniku']*1.08))
									->setCellValue('E'.$row_number, $divise_customers['lunch']['焼肉'])
									->setCellValue('F'.$row_number, floor($dinner_sales['焼肉']*1.08))
									->setCellValue('G'.$row_number, $divise_customers['dinner']['焼肉'])
									->setCellValue('J'.$row_number, floor($yakiniku_sales['chori']*1.08))
									->setCellValue('K'.$row_number, floor($yakiniku_sales['drink']*1.08));
								//page 3
								$obj->setActiveSheetIndex(2)
									->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
									->setCellValue('C'.$row_number, $day);
							}
						}
					}
					#########################################################################################
				}else{
					# 年度と月
					$obj->setActiveSheetIndex(0)
						->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
					#総売上取得
					$total_sales = $this->TotalSales->find('all', array(
						'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%'.$this->request->data['month'].'%')
					));
					foreach ($total_sales as $total_sales_one) {
						#営業日
						$working_day = $total_sales_one['TotalSales']['working_day'];
						//曜日取得
						$day = $weekday[date('w', strtotime($working_day))];
						//開始番号設定
						$row_number = date('j', strtotime($working_day)) + 4;
						#伝票番号
						$maisu = 0;
						$slip_numbers = $this->SlipNumber->find('all', array(
							'conditions' => array('SlipNumber.location_id' => $location['Location']['id'], 'SlipNumber.working_day' => $working_day)
						));
						if($slip_numbers!=null){
							foreach($slip_numbers as $slip_number){
								if($slip_number['Type']['name']=='出前'){
									$maisu = $slip_number['SlipNumber']['end_number'] - $slip_number['SlipNumber']['start_number'] + 1;
								}
							}
						}
						#シート毎分岐
						if($location['Location']['name']=='池袋店'){
							$obj->setActiveSheetIndex(0)
								->setCellValue('C'.$row_number, $day)
								->setCellValue('E'.$row_number, $total_sales_one['TotalSales']['customer_counts'])
								->setCellValue('H'.$row_number, $total_sales_one['TotalSales']['demae_cnt']);
						}elseif($location['Location']['name']=='赤羽店'){
							$obj->setActiveSheetIndex(0)
								->setCellValue('C'.$row_number, $day)
								->setCellValue('E'.$row_number, $total_sales_one['TotalSales']['customer_counts'])
								->setCellValue('I'.$row_number, $maisu);
						}
						#内訳
						$tennai = 0;
						$demae = 0;
						$drink = 0;
						$itaba = 0;
						$cyubo = 0;
						$sales = $this->Sales->find('all', array(
							'conditions' => array('Sales.location_id' => $location['Location']['id'], 'Sales.working_day' => $working_day)
						));
						foreach($sales as $sales_one){
							if($sales_one['Type']['name']=='店内売上'){
								$tennai = $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='出前売上'){
								$demae = $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='飲料売上'){
								$drink = $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='板場売上'){
								$itaba = $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='厨房売上'){
								$cyubo = $sales_one['Sales']['fee'];
							}
						}
						#店舗毎分岐
						if($location['Location']['name']=='池袋店'){
							$obj->setActiveSheetIndex(0)
								->setCellValue('D'.$row_number, $tennai)
								->setCellValue('F'.$row_number, $drink)
								->setCellValue('G'.$row_number, $demae);
						}elseif($location['Location']['name']=='赤羽店'){
							$obj->setActiveSheetIndex(0)
								->setCellValue('D'.$row_number, $itaba)
								->setCellValue('F'.$row_number, $cyubo)
								->setCellValue('G'.$row_number, $drink)
								->setCellValue('H'.$row_number, $demae);
						}
					}
				}
			}
			elseif($this->request->data['data_type']==2){
				$data_name = 'monthly-report-expense';
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				# 年度と月
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
					->setCellValue('M2', $location['Location']['name']);
				# 支出カテゴリー
				$this->loadModel("ExpenseType");
				$expense_types = $this->ExpenseType->find('all', array(
					'conditions' => array('ExpenseType.location_id' => $location['Location']['id'])
				));
				$char = 'G';
				$expense_arr = array();
				foreach($expense_types as $expense_type){
					$obj->setActiveSheetIndex(0)
						->setCellValue($char.'4', $expense_type['ExpenseType']['name']);
					$expense_arr[$expense_type['ExpenseType']['id']] = $char;
					$char = ++$char;
				}
				# 営業日取得
				$working_days = $this->ReceiptSummary->getWorkingDay($location['Location']['id'], $this->request->data['month']);
				if($working_days!=null){
					foreach($working_days as $working_day){
						# 曜日取得
						$day = $weekday[date('w', strtotime($working_day))];
						# 開始番号設定
						$row_number = date('j', strtotime($working_day)) + 4;
						# レシートサマリ
						$receipt_summary = $this->ReceiptSummary->dailySummarize($location['Location']['id'], $working_day);
						# セルにInsert
						$obj->setActiveSheetIndex(0)
							->setCellValue('C'.$row_number, $day)
							->setCellValue('D'.$row_number, $receipt_summary['total'])
							->setCellValue('E'.$row_number, $receipt_summary['credit'])
							->setCellValue('U'.$row_number, $receipt_summary['voucher'])
							->setCellValue('V'.$row_number, $receipt_summary['other'])
							->setCellValue('Z'.$row_number, $receipt_summary['discount']);
						# 支出
						$expenses = $this->Expense->find('all', array(
							'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $working_day)
						));
						if($expenses!=null){
							# 種類別累計計算
							$expense_arr_two = array();
							foreach ($expenses as $expense){
								if(isset($expense_arr_two[$expense['Type']['id']])){
									$expense_arr_two[$expense['Type']['id']] += (int)$expense['Expense']['fee'];
								}else{
									$expense_arr_two[$expense['Type']['id']] = (int)$expense['Expense']['fee'];
								}
							}
							# 挿入
							foreach($expense_arr_two as $key => $e){
								$obj->setActiveSheetIndex(0)
									->setCellValue($expense_arr[$key].$row_number, $e);
							}
						}
					}
				}
			}
			elseif($this->request->data['data_type']==3){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'payroll-ikebukuro';
				}elseif($location['Location']['name']=='赤羽店'){
					$data_name = 'payroll-akabane';
				}elseif($location['Location']['name']=='和光店'){
					$data_name = 'monthly-payroll-wako';
				}
				else{
					echo "Error : 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				######################################２店舗用###############################################
				if($location['Location']['name']=='和光店'){
					$month = $this->request->data['month'];
					#全従業員
					$members = $this->Member->getMemberByLocationId($location['Location']['id']);
					#エクセルnum
					$num = 5;
					#大入り日
					$special_days = array();
					#祝日取得
					$datas = $this->Payroll->get_holidays();
					#売上取得
					$total_sales = $this->TotalSales->find('all', array(
						'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%'.$month.'%')
					));
					$sales_arr = array();
					foreach($total_sales as $total_sales_one){
						$w = $total_sales_one['TotalSales']['working_day'];
						$s = $total_sales_one['TotalSales']['sales'];
						$sales_lunches = $this->SalesLunch->find('all', array(
							'conditions' => array('SalesLunch.location_id' => $location['Location']['id'], 'SalesLunch.working_day' => $w)
						));
						$l=0;
						if($sales_lunches!=null){
							foreach($sales_lunches as $sales_lunch){
								$l += $sales_lunch['SalesLunch']['fee'];
							}
						}
						$sales_arr[$w]['lunch']=floor($l*1.08);$sales_arr[$w]['dinner']=floor(($s-$l)*1.08);
					}
					$w_arr = array( "日" => "bonus_four", "土" => "bonus_three", "金" => "bonus_two", "木" => "bonus_one", "水" => "bonus_one", "火" => "bonus_one", "月" => "bonus_one" );
					foreach($members as $member) {
						if($member['Type']['name'] == "アルバイト") {
							$attendance_results = $this->AttendanceResult->find('all', array(
								'conditions' => array('AttendanceResult.location_id' => $location['Location']['id'], 'AttendanceResult.working_day LIKE' => '%' . $month . '%', 'AttendanceResult.member_id' => $member['Member']['id'])
							));
							if($attendance_results!=null) {
								#時間数
								$hours_arr = array();
								$hours_arr['weekday']['normal'] = 0;$hours_arr['weekday']['late'] = 0;$hours_arr['weekend']['normal'] = 0;$hours_arr['weekend']['late'] = 0;
								#給与金額
								$salary_arr = array();
								$salary_arr['weekday']['normal'] = 0;$salary_arr['weekday']['late'] = 0;$salary_arr['weekend']['normal'] = 0;$salary_arr['weekend']['late'] = 0;
								#大入り手当
								$special_fee = 0;
								#交通費
								$compensation = 0;
								#まかない
								$makanai = 0;
								if(count($attendance_results) < 16){    //日ごと
									if($member['Member']['compensation_daily']!=0){
										$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
									}else{
										$compensation = $member['Member']['compensation_monthly'];
									}
								}elseif(count($attendance_results) >= 16){   //定期
									if($member['Member']['compensation_monthly']!=0){
										#定期の方が高かったら,日割り
										if($member['Member']['compensation_monthly'] > count($attendance_results)*$member['Member']['compensation_daily']&&$member['Member']['compensation_daily']!=0){
											$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
										}else{
											$compensation = $member['Member']['compensation_monthly'];
										}
									}else{
										$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
									}
								}
								#交通費補正
								if($compensation > 10000){
									$compensation = 10000;
								}
								#計算
								foreach($attendance_results as $attendance_result){
									#時給
									$hourly_wage = 0;
									#曜日取得
									$working_day = $attendance_result['AttendanceResult']['working_day'];
									$day = $weekday[date('w', strtotime($working_day))];
									#平日or休日判定（休日なら時給1.25倍）
									$flag = 0;
									$result = array_key_exists($working_day, $datas);
									#勤怠管理時時給
									if($attendance_result['AttendanceResult']['day_hourly_wage']!=0){
										$day_hourly_wage = $attendance_result['AttendanceResult']['day_hourly_wage'];
									}else{
										$day_hourly_wage = $member['Member']['hourly_wage'];
									}
									if ($result==true || $day=='日' || $day=='土') {
										$hourly_wage = $day_hourly_wage + 100;
										$flag = 1;//休日フラグ
									}else{
										$hourly_wage = $day_hourly_wage;
										$flag = 2;//平日フラグ
									}
									/*
                                    foreach ($datas as $data) {
                                        $data['date'] = date('Y-m-d', strtotime($data['date']));
                                        if ($working_day==$data['date'] || $day=='日' || $day=='土') {
                                            $hourly_wage = floor($member['Member']['hourly_wage']*1.25);
                                            $flag = 1;//休日フラグ
                                        }else{
                                            $hourly_wage = $member['Member']['hourly_wage'];
                                            $flag = 2;//平日フラグ
                                        }
                                    }
                                    */
									#休日
									if($flag==1){
										#時間数
										$hours_arr['weekend']['normal'] += $attendance_result['AttendanceResult']['hours'];
										$hours_arr['weekend']['late'] += $attendance_result['AttendanceResult']['late_hours'];
										#給与
										$salary_arr['weekend']['normal'] += $hourly_wage*$attendance_result['AttendanceResult']['hours'];
										$salary_arr['weekend']['late'] += $attendance_result['AttendanceResult']['late_hours']*floor($hourly_wage*1.25);
									}
									#平日
									elseif($flag==2){
										#時間数
										$hours_arr['weekday']['normal'] += $attendance_result['AttendanceResult']['hours'];
										$hours_arr['weekday']['late'] += $attendance_result['AttendanceResult']['late_hours'];
										#給与
										$salary_arr['weekday']['normal'] += $hourly_wage*$attendance_result['AttendanceResult']['hours'];
										$salary_arr['weekday']['late'] += $attendance_result['AttendanceResult']['late_hours']*floor($hourly_wage*1.25);
									}
									else{
										echo "ERROR:Holiday";
										exit;
									}
									#大入り判定
									$timezone = $this->AttendanceResult->judgeLunchDinner($attendance_result);	//勤務時間帯
									if($timezone=='lunch'||$timezone=='dinner'){
										$target = $this->Target->find('first', array(
											'conditions' => array('Target.location_id' => $location['Location']['id'], 'Target.working_month' => $month.'-01', 'Target.type' => $timezone)
										));
										if($target!=null){
											# 祝日判定
											if($result==true){
												if($sales_arr[$working_day][$timezone]>=$target['Target']['bonus_five']){
													$special_fee += 300;
													$special_days[$working_day][$timezone] = $sales_arr[$working_day][$timezone];
												}
											}else{
												if($sales_arr[$working_day][$timezone]>=$target['Target'][$w_arr[$day]]){
													$special_fee += 300;
													$special_days[$working_day][$timezone] = $sales_arr[$working_day][$timezone];
												}
											}
										}
									}
									elseif($timezone=='lunch/dinner'){
										$t_arr = array(0=>"lunch", 1=>"dinner");$f=0;
										foreach($t_arr as $type){
											$target = $this->Target->find('first', array(
												'conditions' => array('Target.location_id' => $location['Location']['id'], 'Target.working_month' => $month.'-01', 'Target.type' => $type)
											));
											if($target!=null){
												# 祝日判定
												if($result==true){
													if($sales_arr[$working_day][$type]>=$target['Target']['bonus_five']){
														if($f==0){
															$special_fee += 300;
															$f = 300;
														}
														$special_days[$working_day][$type] = $sales_arr[$working_day][$type];
													}
												}else{
													if($sales_arr[$working_day][$type]>=$target['Target'][$w_arr[$day]]){
														if($f==0){
															$special_fee += 300;
															$f = 300;
														}
														$special_days[$working_day][$type] = $sales_arr[$working_day][$type];
													}
												}
											}
										}
									}
									#賄い
									if($attendance_result['AttendanceResult']['makanai']==1){
										$makanai += 300;
									}
								}
								#page 1
								$obj->setActiveSheetIndex(0)
									->setCellValue('B2', date('Y年m月', strtotime($month)))
									->setCellValue('C'.$num, $member['Member']['name'])
									->setCellValue('D'.$num, count($attendance_results))
									->setCellValue('E'.$num, $hours_arr['weekday']['normal']+$hours_arr['weekday']['late']+$hours_arr['weekend']['normal']+$hours_arr['weekend']['late'])
									->setCellValue('F'.$num, $hours_arr['weekday']['normal'])
									->setCellValue('G'.$num, $hours_arr['weekend']['normal'])
									->setCellValue('H'.$num, $hours_arr['weekday']['late'])
									->setCellValue('I'.$num, $hours_arr['weekend']['late'])
									->setCellValue('J'.$num, floor($salary_arr['weekday']['normal']))
									->setCellValue('K'.$num, floor($salary_arr['weekend']['normal']))
									->setCellValue('L'.$num, floor($salary_arr['weekday']['late']))
									->setCellValue('M'.$num, floor($salary_arr['weekend']['late']))
									->setCellValue('N'.$num, $special_fee)
									->setCellValue('P'.$num, $compensation)
									->setCellValue('R'.$num, $makanai);
								$num += 1;
							}
						}
					}
					#page 2
					//$obj->setActiveSheetIndex(1)
						//->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
					#page 3
					#和光大入り日
					$obj->setActiveSheetIndex(1)
						->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
					#エクセルnum
					$num = 5;
					ksort($special_days);
					foreach($special_days as $key => $special_day){
						#ランチ
						if(isset($special_day['lunch'])){
							$obj->setActiveSheetIndex(1)
								->setCellValue('C'.$num, $key)
								->setCellValue('D'.$num, 'ランチ')
								->setCellValue('E'.$num, $special_day['lunch']);
							$num +=1;
						}
						#ディナー
						if(isset($special_day['dinner'])){
							$obj->setActiveSheetIndex(1)
								->setCellValue('C'.$num, $key)
								->setCellValue('D'.$num, 'ディナー')
								->setCellValue('E'.$num, $special_day['dinner']);
							$num +=1;
						}
					}
				}
				else{##################################１店舗用###################################################
					$obj->setActiveSheetIndex(0)
						->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
					#全従業員
					$members = $this->Member->getMemberByLocationId($location['Location']['id']);
					#エクセルnum
					$num = 5;
					foreach($members as $member){
						if($member['Type']['name']=="アルバイト"){
							$attendance_results = $this->AttendanceResult->find('all', array(
								'conditions' => array('AttendanceResult.location_id' => $location['Location']['id'], 'AttendanceResult.working_day LIKE' => '%'.$this->request->data['month'].'%', 'AttendanceResult.member_id' => $member['Member']['id'])
							));
							if($attendance_results!=null){
								#パラメータ初期化
								$hours = 0;
								$late_hours = 0;
								$special_fee = 0;
								#20150807追記
								$salaries = 0;
								$late_salaries = 0;
								#まかない
								$makanai = 0;
								#交通費
								if(count($attendance_results) < 16){    //日ごと
									if($member['Member']['compensation_daily']!=0){
										$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
									}else{
										$compensation = $member['Member']['compensation_monthly'];
									}
								}elseif(count($attendance_results) >= 16){   //定期
									if($member['Member']['compensation_monthly']!=0){
										#定期の方が高かったら,日割り
										if($member['Member']['compensation_monthly'] > count($attendance_results)*$member['Member']['compensation_daily']&&$member['Member']['compensation_daily']!=0){
											$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
										}else{
											$compensation = $member['Member']['compensation_monthly'];
										}
									}else{
										$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
									}
								}else{
									echo "Fatal Error : Attendance Results are not availables";
									exit;
								}
								#交通費補正
								if($compensation > 10000){
									#特定の従業員除外
									if($member['Member']['id']!=23){
										$compensation = 10000;
									}
								}
								#加算
								foreach($attendance_results as $attendance_result){
									$hours += $attendance_result['AttendanceResult']['hours'];
									$salaries += floor($attendance_result['AttendanceResult']['hours']*$member['Member']['hourly_wage']);
									$late_hours += $attendance_result['AttendanceResult']['late_hours'];
									$late_salaries += floor($attendance_result['AttendanceResult']['late_hours']*floor($member['Member']['hourly_wage']*1.25));
									#大入り判定
									$total_sales = $this->TotalSales->find('first', array(
										'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day' => $attendance_result['AttendanceResult']['working_day'], 'sales >' => '400000')
									));
									if($total_sales!=null){
										$special_fee += 500;
									}
									#賄い
									if($attendance_result['AttendanceResult']['makanai']==1){
										$makanai += 300;
									}
								}
								#書き込み（店舗毎きりかえ）
								#店舗毎分岐
								if($location['Location']['name']=='池袋店'){
									$obj->setActiveSheetIndex(0)
										->setCellValue('C'.$num, $member['Member']['name'])
										->setCellValue('D'.$num, count($attendance_results))
										->setCellValue('E'.$num, $hours+$late_hours)
										->setCellValue('F'.$num, $hours)
										->setCellValue('G'.$num, $late_hours)
										->setCellValue('H'.$num, $salaries)
										->setCellValue('I'.$num, $late_salaries)
										->setCellValue('J'.$num, $special_fee)
										->setCellValue('L'.$num, $compensation)
										->setCellValue('N'.$num, $makanai);
								}elseif($location['Location']['name']=='赤羽店'){  //大入りなし
									$obj->setActiveSheetIndex(0)
										->setCellValue('C'.$num, $member['Member']['name'])
										->setCellValue('D'.$num, count($attendance_results))
										->setCellValue('E'.$num, $hours+$late_hours)
										->setCellValue('F'.$num, $hours)
										->setCellValue('G'.$num, $late_hours)
										->setCellValue('H'.$num, $salaries)
										->setCellValue('I'.$num, $late_salaries)
										->setCellValue('L'.$num, $compensation);
								}
								$num += 1;
							}
						}
					}
					#池袋大入り
					if($location['Location']['name']=='池袋店') {
						// sheet 2
						$obj->setActiveSheetIndex(1)
							->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
						//大入り日
						#大入り判定
						$special_days = $this->TotalSales->find('all', array(
							'fields' => array('TotalSales.working_day'),
							'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%' . $this->request->data['month'] . '%', 'sales >' => '400000')
						));
						if ($special_days != null) {
							//エクセルnum
							$num = 5;
							foreach ($special_days as $special_day) {
								$obj->setActiveSheetIndex(1)
									->setCellValue('C' . $num, $special_day['TotalSales']['working_day']);
								$num += 1;
							}
						}
					}
				}
			}
			elseif($this->request->data['data_type']==4){
				$data_name = 'monthly-report-laborcostratio';
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
					->setCellValue('J2', $location['Location']['name']);
				#人件費率取得
				$payrolls = $this->Payroll->find('all', array(
					'conditions' => array('Payroll.location_id' => $location['Location']['id'], 'Payroll.working_day LIKE' => '%'.$this->request->data['month'].'%')
				));
				if($payrolls!=null){
					foreach($payrolls as $payroll){
						#営業日
						$working_day = $payroll['Payroll']['working_day'];
						//曜日取得
						$day = $weekday[date('w', strtotime($working_day))];
						//開始番号設定
						$row_number = date('j', strtotime($working_day)) + 4;

						$obj->setActiveSheetIndex(0)
							->setCellValue('C'.$row_number, $day)
							->setCellValue('D'.$row_number, $payroll['TotalSales']['sales'])
							->setCellValue('E'.$row_number, $payroll['Payroll']['hall'])
							->setCellValue('F'.$row_number, $payroll['Payroll']['kitchen']);
					}
				}
			}
			elseif($this->request->data['data_type']==5){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-purchase-ikebukuro';
				}else{
					echo "Error: 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
				for ($i=1; $i <= 31; $i++) {
					$working_day = $this->request->data['month'].'-'.$i;
					//曜日取得
					$day = $weekday[date('w', strtotime($working_day))];
					#小計考慮
					$day_num = date('j', strtotime($working_day));
					if($day_num<=7){
						//開始番号設定
						$row_number = $day_num + 4;
					}elseif($day_num<=14){
						//開始番号設定
						$row_number = $day_num + 5;
					}elseif($day_num<=21){
						//開始番号設定
						$row_number = $day_num + 6;
					}elseif($day_num<=28){
						//開始番号設定
						$row_number = $day_num + 7;
					}elseif($day_num<=31){
						//開始番号設定
						$row_number = $day_num + 8;
					}else{
						echo "ERROR :Day Number is not exist.";
						exit;
					}
					#初期化
					$yasai = 0; //現金のみ
					$chomiryo = 0;  //現金のみ
					$shomohin = 0;
					$kome = 0;
					$sonota = 0;
					$neta = 0;
					$sake = 0;
					#支出（現金分）
					$expenses = $this->Expense->find('all', array(
						'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $working_day)
					));
					if($expenses!=null){
						foreach($expenses as $expense){
							if($expense['Type']['name']=='野菜'){
								$yasai += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='調味料'){
								$chomiryo += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='消耗品'){
								$shomohin += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='米（賄い）'){
								$kome += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='その他'){
								$sonota += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='ネタ'){
								$neta += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='飲料'){
								$sake += $expense['Expense']['fee'];
							}
						}
					}
					#買掛合計
					$payable_accounts = $this->PayableAccount->find('all', array(
						'conditions' => array('PayableAccount.location_id' => $location['Location']['id'], 'PayableAccount.working_day' => $working_day)
					));
					if($payable_accounts!=null){
						foreach($payable_accounts as $payable_account){
							if($payable_account['Type']['name']=='消耗品'){
								$shomohin += $payable_account['PayableAccount']['fee'];
							}elseif($payable_account['Type']['name']=='米（賄い）'){
								$kome += $payable_account['PayableAccount']['fee'];
							}elseif($payable_account['Type']['name']=='その他'){
								$sonota += $payable_account['PayableAccount']['fee'];
							}elseif($payable_account['Type']['name']=='ネタ（仲買）'){
								$neta += $payable_account['PayableAccount']['fee'];
							}elseif($payable_account['Type']['name']=='酒（飲料）'){
								$sake += $payable_account['PayableAccount']['fee'];
							}
						}
					}
					#Excel挿入
					$obj->setActiveSheetIndex(0)
						->setCellValue('C'.$row_number, $day)
						->setCellValue('D'.$row_number, $yasai)
						->setCellValue('E'.$row_number, $chomiryo)
						->setCellValue('F'.$row_number, $shomohin)
						->setCellValue('G'.$row_number, $kome)
						->setCellValue('H'.$row_number, $sonota)
						->setCellValue('I'.$row_number, $neta)
						->setCellValue('K'.$row_number, $sake);
				}
			}
			elseif($this->request->data['data_type']==6){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-saekirate-ikebukuro';
				}else{
					echo "Error: 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
				// sheet 2
				$obj->setActiveSheetIndex(1)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
				for ($i=1; $i <= 31; $i++) {
					$working_day = $this->request->data['month'].'-'.$i;
					//曜日取得
					$day = $weekday[date('w', strtotime($working_day))];
					#小計考慮
					$day_num = date('j', strtotime($working_day));
					if($day_num<=7){
						//開始番号設定
						$row_number = $day_num + 4;
					}elseif($day_num<=14){
						//開始番号設定
						$row_number = $day_num + 5;
					}elseif($day_num<=21){
						//開始番号設定
						$row_number = $day_num + 6;
					}elseif($day_num<=28){
						//開始番号設定
						$row_number = $day_num + 7;
					}elseif($day_num<=31){
						//開始番号設定
						$row_number = $day_num + 8;
					}else{
						echo "ERROR :Day Number is not exist.";
						exit;
					}
					#初期化
					$sushi_sales = 0;
					$drink_sales = 0;
					#売上（飲料売上のみドリンク売上）
					$sales = $this->Sales->find('all', array(
						'conditions' => array('Sales.location_id' => $location['Location']['id'], 'working_day' => $working_day)
					));
					if($sales!=null){
						foreach($sales as $sales_one){
							if($sales_one['Type']['name']=='店内売上'){
								$sushi_sales += $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='出前売上'){
								$sushi_sales += $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='飲料売上'){
								$drink_sales += $sales_one['Sales']['fee'];
							}
						}
					}
					#初期化
					$sushi_purchases = 0;
					$drink_purchases = 0;
					#支出（飲料のみドリンク仕入）
					$expenses = $this->Expense->find('all', array(
						'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $working_day)
					));
					if($expenses!=null){
						foreach($expenses as $expense){
							if($expense['Type']['name']=='飲料'){
								$drink_purchases += $expense['Expense']['fee'];
							}else{
								$sushi_purchases += $expense['Expense']['fee'];
							}
						}
					}
					#買掛合計（飲料のみドリンク仕入）
					$payable_accounts = $this->PayableAccount->find('all', array(
						'conditions' => array('PayableAccount.location_id' => $location['Location']['id'], 'PayableAccount.working_day' => $working_day)
					));
					if($payable_accounts!=null){
						foreach($payable_accounts as $payable_account){
							if($payable_account['Type']['name']=='酒（飲料）'){
								$drink_purchases += $payable_account['PayableAccount']['fee'];
							}else{
								$sushi_purchases += $payable_account['PayableAccount']['fee'];
							}
						}
					}
					#Excel挿入
					// sheet 1
					$obj->setActiveSheetIndex(0)
						->setCellValue('C'.$row_number, $day)
						->setCellValue('D'.$row_number, $sushi_sales)
						->setCellValue('E'.$row_number, $sushi_purchases);
					// sheet 2
					$obj->setActiveSheetIndex(1)
						->setCellValue('C'.$row_number, $day)
						->setCellValue('D'.$row_number, $drink_sales)
						->setCellValue('E'.$row_number, $drink_purchases);
				}
			}
			elseif($this->request->data['data_type']==7){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-mix-ikebukuro';
				}elseif($location['Location']['name']=='赤羽店'){
					$data_name = 'monthly-report-mix-akabane';
				}else{
					echo "Error: 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));

				#客単価平均算出
				$d = 0;
				$total_averages = 0;
				for ($i=1; $i <= 31; $i++) {
					$working_day = $this->request->data['month'].'-'.$i;
					//曜日取得
					$day = $weekday[date('w', strtotime($working_day))];
					#小計考慮
					$day_num = date('j', strtotime($working_day));
					if($day_num<=7){
						//開始番号設定
						$row_number = $day_num + 4;
					}elseif($day_num<=14){
						//開始番号設定
						$row_number = $day_num + 5;
					}elseif($day_num<=21){
						//開始番号設定
						$row_number = $day_num + 6;
					}elseif($day_num<=28){
						//開始番号設定
						$row_number = $day_num + 7;
					}elseif($day_num<=31){
						//開始番号設定
						$row_number = $day_num + 8;
					}else{
						echo "ERROR :Day Number is not exist.";
						exit;
					}
					#20150923 akabane
					$target = $this->Target->getTargetByDay($location['Location']['id'], $working_day);
					#総売上取得
					$total_sales = $this->TotalSales->find('first', array(
						'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day' => $working_day)
					));
					#出前売上取得
					$demae_sales = 0;
					$sales = $this->Sales->find('all', array(
						'conditions' => array('Sales.location_id' => $location['Location']['id'], 'working_day' => $working_day)
					));
					if($sales!=null){
						foreach($sales as $sales_one){
							if($sales_one['Type']['name']=='出前売上'){
								$demae_sales = $sales_one['Sales']['fee'];
							}
						}
					}
					#伝票番号取得
					$num_demae = 0;
					$slip_numbers = $this->SlipNumber->find('all', array(
						'conditions' => array('SlipNumber.location_id' => $location['Location']['id'], 'working_day' => $working_day)
					));
					if($slip_numbers!=null){
						#出前数算出
						foreach($slip_numbers as $slip_number){
							if($slip_number['Type']['name'] == "出前"){
								$num_demae = $slip_number['SlipNumber']['end_number'] - $slip_number['SlipNumber']['start_number'] + 1;
							}
						}
					}
					#支出
					$total_expenses = 0;
					$expenses = $this->Expense->find('all', array(
						'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $working_day)
					));
					foreach($expenses as $expense){
						$total_expenses += $expense['Expense']['fee'];
					}
					#買掛
					$total_accounts = 0;
					$payable_accounts = $this->PayableAccount->find('all', array(
						'conditions' => array('PayableAccount.location_id' => $location['Location']['id'], 'PayableAccount.working_day' => $working_day)
					));
					foreach($payable_accounts as $payable_account){
						$total_accounts += $payable_account['PayableAccount']['fee'];
					}
					#Excel挿入
					if($total_sales!=null){
						#客単価計算
						$average = 0;
						if($total_sales['TotalSales']['customer_counts']!=0){
							$average = ($total_sales['TotalSales']['sales'] - $demae_sales) / $total_sales['TotalSales']['customer_counts'];
						}
						#for akabane
						if($location['Location']['name']=='池袋店'){
							// sheet 1
							$obj->setActiveSheetIndex(0)
								->setCellValue('C'.$row_number, $day)
								->setCellValue('D'.$row_number, $total_sales['TotalSales']['sales'])
								->setCellValue('E'.$row_number, $total_expenses + $total_accounts)
								->setCellValue('L'.$row_number, $total_sales['TotalSales']['customer_counts'])
								->setCellValue('N'.$row_number, $num_demae)
								->setCellValue('P'.$row_number, $average);
						}elseif($location['Location']['name']=='赤羽店'){
							// sheet 1
							$obj->setActiveSheetIndex(0)
								->setCellValue('C'.$row_number, $day)
								->setCellValue('D'.$row_number, $target)
								->setCellValue('F'.$row_number, $total_sales['TotalSales']['sales'])
								->setCellValue('H'.$row_number, $total_expenses + $total_accounts)
								->setCellValue('P'.$row_number, $total_sales['TotalSales']['customer_counts'])
								->setCellValue('R'.$row_number, $num_demae)
								->setCellValue('T'.$row_number, $average);
						}
						#客単価平均
						$d += 1;
						$total_averages += $average;
					}
				}
				/*
                if($d!=0){
                    if($location['Location']['name']=='池袋店'){
                        // sheet 1
                        $obj->setActiveSheetIndex(0)
                            ->setCellValue('P42', $total_averages / $d);
                    }
                }
                */
			}
			elseif($this->request->data['data_type']==8){
				$data_name = 'stocktaking';$jp_name = "棚卸表";
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				# sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($date)));
				$sheet = $obj->getActiveSheet();
				$sheet->setTitle(date('Y年m月', strtotime($date)));

				# 棚卸
				$stocktakings = $this->Stocktaking->find('all', array(
					'conditions' => array('Stocktaking.working_month LIKE' => '%'.$date.'%'),
					'order' => array('Stocktaking.association_id', 'Stocktaking.type_id')
				));
				$arr = array();
				foreach($stocktakings as $stocktaking){
					$arr[$stocktaking['Type']['id']]['last'][$stocktaking['Stocktaking']['association_id']] = $stocktaking['Stocktaking']['last_month'];
					$arr[$stocktaking['Type']['id']]['this'][$stocktaking['Stocktaking']['association_id']] = $stocktaking['Stocktaking']['this_month'];
				}
				$r=5;
				unset($arr[6]);     //その他！
				foreach($arr as $key => $a){
					# last
					$obj->setActiveSheetIndex(0)
						->setCellValue('D'.$r, $a['last'][1])
						->setCellValue('E'.$r, $a['last'][2])
						->setCellValue('F'.$r, $a['last'][3])
						->setCellValue('G'.$r, $a['last'][4])
						->setCellValue('H'.$r, $a['last'][5]);
					$r++;
					# this
					$obj->setActiveSheetIndex(0)
						->setCellValue('D'.$r, $a['this'][1])
						->setCellValue('E'.$r, $a['this'][2])
						->setCellValue('F'.$r, $a['this'][3])
						->setCellValue('G'.$r, $a['this'][4])
						->setCellValue('H'.$r, $a['this'][5]);
					$r++;
				}

			}
			elseif($this->request->data['data_type']==9){
				$data_name = 'uriage_nikkeihyo';$jp_name = "売上日計表";
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				# sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B3', date('Y年m月', strtotime($date)))
					->setCellValue('D3', $location['Location']['name']);
				$location_id = $location['Location']['id'];
				# 売上累計
				$sales_ruikei_result = $this->sales_ruikei($this->request->data['month'], $location_id);
				$obj->setActiveSheetIndex(0)
					->setCellValue('G7', floor($sales_ruikei_result*1.08));
				# 客数累計
				$customer_counts_ruikei_result = $this->customer_counts_ruikei($this->request->data['month'], $location_id);
				$obj->setActiveSheetIndex(0)
					->setCellValue('I7', $customer_counts_ruikei_result);
				for ($i=1; $i <= 31; $i++) {
					if($i<10){$working_day = $this->request->data['month'].'-0'.$i;} else{$working_day = $this->request->data['month'].'-'.$i;}
					$day = $weekday[date('w', strtotime($working_day))];
					$row_number = date('j', strtotime($working_day)) + 6;
					# 売上
					$sales_result = $this->sales($working_day, $location_id);
					if($sales_result!=null){
						$obj->setActiveSheetIndex(0)
							->setCellValue('B'.$row_number, $working_day)
							->setCellValue('C'.$row_number, $day)
							->setCellValue('D'.$row_number, floor($sales_result[$working_day]['lunch']*1.08))
							->setCellValue('F'.$row_number, floor($sales_result[$working_day]['total']*1.08));
					}
					# 客数
					$customer_counts_result = $this->customer_counts($working_day, $location_id);
					if($customer_counts_result!=null){
						$obj->setActiveSheetIndex(0)
							->setCellValue('J'.$row_number, $customer_counts_result[$working_day]['11:00:00'])
							->setCellValue('K'.$row_number, $customer_counts_result[$working_day]['12:00:00'])
							->setCellValue('L'.$row_number, $customer_counts_result[$working_day]['13:00:00'])
							->setCellValue('M'.$row_number, $customer_counts_result[$working_day]['14:00:00'])
							->setCellValue('N'.$row_number, $customer_counts_result[$working_day]['15:00:00'])
							->setCellValue('O'.$row_number, $customer_counts_result[$working_day]['16:00:00'])
							->setCellValue('Q'.$row_number, $customer_counts_result[$working_day]['17:00:00'])
							->setCellValue('R'.$row_number, $customer_counts_result[$working_day]['18:00:00'])
							->setCellValue('S'.$row_number, $customer_counts_result[$working_day]['19:00:00'])
							->setCellValue('T'.$row_number, $customer_counts_result[$working_day]['20:00:00'])
							->setCellValue('U'.$row_number, $customer_counts_result[$working_day]['21:00:00'])
							->setCellValue('V'.$row_number, $customer_counts_result[$working_day]['22:00:00'])
							->setCellValue('W'.$row_number, $customer_counts_result[$working_day]['23:00:00']);
					}

				}
				# sheet 2 and 3
				/*
				$obj->setActiveSheetIndex(1)
					->setCellValue('A2', date('Y年m月', strtotime($date)))
					->setCellValue('C2', $location['Location']['name']);
				$obj->setActiveSheetIndex(2)
					->setCellValue('A2', date('Y年m月', strtotime($date)))
					->setCellValue('C2', $location['Location']['name']);
				$result_arr=array();
				for ($i=1; $i <= 31; $i++) {
					if ($i < 10) {$working_day = $this->request->data['month'] . '-0' . $i;} else {$working_day = $this->request->data['month'] . '-' . $i;}
					$day = $weekday[date('w', strtotime($working_day))];
					$row_number = date('j', strtotime($working_day))+5;
					$labor_result = $this->labor($working_day, $location_id);
					if($labor_result!=null){
						foreach($labor_result[$working_day] as $youbi => $labor) {
							if(!isset($result_arr[$youbi][date('j', strtotime($working_day))])){$result_arr[$youbi][date('j', strtotime($working_day))] = $labor['hall']+$labor['kitchen'];} else{$result_arr[$youbi][date('j', strtotime($working_day))] += $labor['hall']+$labor['kitchen'];}
						}
						$obj->setActiveSheetIndex(1)
							->setCellValue('A'.$row_number, $working_day)
							->setCellValue('B'.$row_number, $day)
							->setCellValue('C'.$row_number, $labor_result[$working_day]['11:00:00']['hall'])
							->setCellValue('D'.$row_number, $labor_result[$working_day]['11:00:00']['kitchen'])
							->setCellValue('F'.$row_number, $labor_result[$working_day]['12:00:00']['hall'])
							->setCellValue('G'.$row_number, $labor_result[$working_day]['12:00:00']['kitchen'])
							->setCellValue('I'.$row_number, $labor_result[$working_day]['13:00:00']['hall'])
							->setCellValue('J'.$row_number, $labor_result[$working_day]['13:00:00']['kitchen'])
							->setCellValue('L'.$row_number, $labor_result[$working_day]['14:00:00']['hall'])
							->setCellValue('M'.$row_number, $labor_result[$working_day]['14:00:00']['kitchen'])
							->setCellValue('O'.$row_number, $labor_result[$working_day]['15:00:00']['hall'])
							->setCellValue('P'.$row_number, $labor_result[$working_day]['15:00:00']['kitchen'])
							->setCellValue('R'.$row_number, $labor_result[$working_day]['16:00:00']['hall'])
							->setCellValue('S'.$row_number, $labor_result[$working_day]['16:00:00']['kitchen'])
							->setCellValue('X'.$row_number, $labor_result[$working_day]['17:00:00']['hall'])
							->setCellValue('Y'.$row_number, $labor_result[$working_day]['17:00:00']['kitchen'])
							->setCellValue('AA'.$row_number, $labor_result[$working_day]['18:00:00']['hall'])
							->setCellValue('AB'.$row_number, $labor_result[$working_day]['18:00:00']['kitchen'])
							->setCellValue('AD'.$row_number, $labor_result[$working_day]['19:00:00']['hall'])
							->setCellValue('AE'.$row_number, $labor_result[$working_day]['19:00:00']['kitchen'])
							->setCellValue('AG'.$row_number, $labor_result[$working_day]['20:00:00']['hall'])
							->setCellValue('AH'.$row_number, $labor_result[$working_day]['20:00:00']['kitchen'])
							->setCellValue('AJ'.$row_number, $labor_result[$working_day]['21:00:00']['hall'])
							->setCellValue('AK'.$row_number, $labor_result[$working_day]['21:00:00']['kitchen'])
							->setCellValue('AM'.$row_number, $labor_result[$working_day]['22:00:00']['hall'])
							->setCellValue('AN'.$row_number, $labor_result[$working_day]['22:00:00']['kitchen'])
							->setCellValue('AP'.$row_number, $labor_result[$working_day]['23:00:00']['hall'])
							->setCellValue('AQ'.$row_number, $labor_result[$working_day]['23:00:00']['kitchen']);
						$obj->setActiveSheetIndex(2)
							->setCellValue('A'.$row_number, $working_day)
							->setCellValue('B'.$row_number, $day)
							->setCellValue('C'.$row_number, $labor_result[$working_day]['11:00:00']['hall_fee'])
							->setCellValue('D'.$row_number, $labor_result[$working_day]['11:00:00']['kitchen_fee'])
							->setCellValue('F'.$row_number, $labor_result[$working_day]['12:00:00']['hall_fee'])
							->setCellValue('G'.$row_number, $labor_result[$working_day]['12:00:00']['kitchen_fee'])
							->setCellValue('I'.$row_number, $labor_result[$working_day]['13:00:00']['hall_fee'])
							->setCellValue('J'.$row_number, $labor_result[$working_day]['13:00:00']['kitchen_fee'])
							->setCellValue('L'.$row_number, $labor_result[$working_day]['14:00:00']['hall_fee'])
							->setCellValue('M'.$row_number, $labor_result[$working_day]['14:00:00']['kitchen_fee'])
							->setCellValue('O'.$row_number, $labor_result[$working_day]['15:00:00']['hall_fee'])
							->setCellValue('P'.$row_number, $labor_result[$working_day]['15:00:00']['kitchen_fee'])
							->setCellValue('R'.$row_number, $labor_result[$working_day]['16:00:00']['hall_fee'])
							->setCellValue('S'.$row_number, $labor_result[$working_day]['16:00:00']['kitchen_fee'])
							->setCellValue('X'.$row_number, $labor_result[$working_day]['17:00:00']['hall_fee'])
							->setCellValue('Y'.$row_number, $labor_result[$working_day]['17:00:00']['kitchen_fee'])
							->setCellValue('AA'.$row_number, $labor_result[$working_day]['18:00:00']['hall_fee'])
							->setCellValue('AB'.$row_number, $labor_result[$working_day]['18:00:00']['kitchen_fee'])
							->setCellValue('AD'.$row_number, $labor_result[$working_day]['19:00:00']['hall_fee'])
							->setCellValue('AE'.$row_number, $labor_result[$working_day]['19:00:00']['kitchen_fee'])
							->setCellValue('AG'.$row_number, $labor_result[$working_day]['20:00:00']['hall_fee'])
							->setCellValue('AH'.$row_number, $labor_result[$working_day]['20:00:00']['kitchen_fee'])
							->setCellValue('AJ'.$row_number, $labor_result[$working_day]['21:00:00']['hall_fee'])
							->setCellValue('AK'.$row_number, $labor_result[$working_day]['21:00:00']['kitchen_fee'])
							->setCellValue('AM'.$row_number, $labor_result[$working_day]['22:00:00']['hall_fee'])
							->setCellValue('AN'.$row_number, $labor_result[$working_day]['22:00:00']['kitchen_fee'])
							->setCellValue('AP'.$row_number, $labor_result[$working_day]['23:00:00']['hall_fee'])
							->setCellValue('AQ'.$row_number, $labor_result[$working_day]['23:00:00']['kitchen_fee']);
					}
				}
				*/
			}
			elseif($this->request->data['data_type']==10){
				$data_name = 'labor_cost';$jp_name = "";
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				# 取得日付配列
				$working_day_arr = $this->date_array("2016-09-01", "2016-09-31");
				$result_arr = array();
				foreach($working_day_arr as $working_day){
					$day = $weekday[date('w', strtotime($working_day))];
					$location_id = $location['Location']['id'];
					$result = $this->labor($working_day, $location_id);
					foreach($result as $k => $r){
						if(!isset($result_arr[$k][$day]['num'])){$result_arr[$k][$day]['num']=$r['num'];}else{$result_arr[$k][$day]['num']+=$r['num'];}
						if(!isset($result_arr[$k][$day]['fee'])){$result_arr[$k][$day]['fee']=$r['fee'];}else{$result_arr[$k][$day]['fee']+=$r['fee'];}
						if(!isset($result_arr[$k][$day]['count'])){$result_arr[$k][$day]['count']=1;}else{$result_arr[$k][$day]['count']+=1;}
					}
				}
				$row_number = 3;
				foreach($result_arr as $key_day => $re){
					$obj->setActiveSheetIndex(0)
						->setCellValue('B'.$row_number, $key_day)
						->setCellValue('C'.$row_number, $re['日']['num']/$re['日']['count'])
						->setCellValue('D'.$row_number, $re['月']['num']/$re['月']['count'])
						->setCellValue('E'.$row_number, $re['火']['num']/$re['火']['count'])
						->setCellValue('F'.$row_number, $re['水']['num']/$re['水']['count'])
						->setCellValue('G'.$row_number, $re['木']['num']/$re['木']['count'])
						->setCellValue('H'.$row_number, $re['金']['num']/$re['金']['count'])
						->setCellValue('I'.$row_number, $re['土']['num']/$re['土']['count']);
					$obj->setActiveSheetIndex(1)
						->setCellValue('B'.$row_number, $key_day)
						->setCellValue('C'.$row_number, $re['日']['fee']/$re['日']['count'])
						->setCellValue('D'.$row_number, $re['月']['fee']/$re['月']['count'])
						->setCellValue('E'.$row_number, $re['火']['fee']/$re['火']['count'])
						->setCellValue('F'.$row_number, $re['水']['fee']/$re['水']['count'])
						->setCellValue('G'.$row_number, $re['木']['fee']/$re['木']['count'])
						->setCellValue('H'.$row_number, $re['金']['fee']/$re['金']['count'])
						->setCellValue('I'.$row_number, $re['土']['fee']/$re['土']['count']);
					$row_number++;
				}
			}
			else{
				echo "Fatal Error: Your Request is not avaibale";
				exit;
			}
			// Excel2007
			$filename = $location['Location']['name'].'-'.$data_name.'-'.$this->request->data['month'].'.xlsx';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=$filename");
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
			$writer->save('php://output');
			exit;
		}
	}

	public function sales($working_day, $location_id){
		$result = array();
		$sales_lunches = $this->SalesLunch->find('all', array(
			'fields' => array('sum(SalesLunch.fee) as sum'),
			'conditions' => array('SalesLunch.location_id' => $location_id, 'SalesLunch.working_day' => $working_day),
		));
		$total_sales = $this->TotalSales->find('first', array(
			'fields' => array('TotalSales.sales'),
			'conditions' => array('TotalSales.location_id' => $location_id, 'TotalSales.working_day' => $working_day),
		));
		if($sales_lunches!=null&&$total_sales!=null){
			$result[$working_day]['lunch'] = $sales_lunches[0][0]['sum'];
			$result[$working_day]['total'] = $total_sales['TotalSales']['sales'];
		}
		return $result;
	}

	public function sales_ruikei($month, $location_id){
		$working_day = $month.'-01';
		$year = date('Y', strtotime($working_day));
		$total_sales = $this->TotalSales->find('all', array(
			'fields' => array('sum(TotalSales.sales) as sum'),
			'conditions' => array('TotalSales.location_id' => $location_id, 'TotalSales.working_day LIKE' => '%'.$year.'%', 'TotalSales.working_day <=' => $working_day)
		));
		if($total_sales!=null){
			return $total_sales[0][0]['sum'];
		}
	}

	public function customer_counts($working_day, $location_id){
		$result = array();
		$customer_counts = $this->CustomerCount->find('all', array(
			'joins' => array(array("type" => "INNER", "table" => "customer_timezones", 'alias' => 'CustomerTimezone', "conditions" => array("CustomerCount.timezone_id = CustomerTimezone.id"))),
			'fields' => array('sum(CustomerCount.count) as sum', 'CustomerCount.working_day', 'CustomerCount.working_day', 'CustomerTimezone.name'),
			'conditions' => array('CustomerCount.location_id' => $location_id, 'CustomerCount.working_day' => $working_day),
			'group' => array('CustomerCount.working_day', 'CustomerTimezone.name')
		));
		if($customer_counts!=null){
			foreach($customer_counts as $customer_count){
				$result[$working_day][$customer_count['CustomerTimezone']['name']] = $customer_count[0]['sum'];
			}
		}
		return $result;
	}

	public function customer_counts_ruikei($month, $location_id){
		$working_day = $month.'-01';
		$year = date('Y', strtotime($working_day));
		$customer_counts = $this->CustomerCount->find('all', array(
			'fields' => array('sum(CustomerCount.count) as sum'),
			'conditions' => array('CustomerCount.location_id' => $location_id, 'CustomerCount.working_day LIKE' => '%'.$year.'%', 'CustomerCount.working_day <=' => $working_day)
		));
		if($customer_counts!=null){
			return $customer_counts[0][0]['sum'];
		}
	}

	public function labor($working_day, $location_id){
		$hours = array('10:00:00','11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00', '23:00:00', '24:00:00');
		$result = array();
		foreach($hours as $hour){
			$time = $working_day.' '.$hour;
			$attendances = $this->Attendance->find('all', array(
				'conditions' => array('Attendance.location_id' => $location_id, 'Attendance.working_day' => $working_day, 'Attendance.type_id' => 1, 'Attendance.time <='=> $time),
				'recursive'=> 1
			));
			if($attendances!=null){
				foreach($attendances as $attendance){
					# アルバイトのみ
					if($attendance['Member']['type_id']!=1&&$attendance['Member']['type_id']!=3&&$attendance['Member']['type_id']!=5){
						# ホールのみ
						if($attendance['Member']['position_id']==1||$attendance['Member']['position_id']==3||$attendance['Member']['position_id']==5){
							$member_id=$attendance['Attendance']['member_id'];
							$end = $this->Attendance->find('first', array(
								'conditions' => array('Attendance.location_id' => $location_id, 'Attendance.member_id' => $member_id, 'Attendance.working_day' => $working_day, 'Attendance.type_id' => 2, 'Attendance.time >'=> $time)
							));
							if($end!=null){
								$pose = $this->Attendance->find('all', array(
									'conditions' => array('Attendance.location_id' => $location_id, 'Attendance.member_id' => $member_id, 'Attendance.working_day' => $working_day, 'OR' => array(array('Attendance.type_id' => 3),array('Attendance.type_id' => 4))),
									'order' => array('Attendance.time' => 'asc')
								));
								$m = 0;
								if($pose!=null){
									if(count($pose)%2==0){
										$array = array();
										for($s=0;$s<count($pose);$s+=2){
											if(isset($pose[$s])){
												$t = $s+1;
												$i = strtotime($pose[$s]['Attendance']['time']);
												while($i <= strtotime($pose[$t]['Attendance']['time'])){
													$array[] = date('Y-m-d H:i:s', $i);
													$i+=900;
												}
											}
										}
										if(in_array($time, $array)){
											$u = strtotime($time);$j=$u+3600;
											while($u <= $j){
												$datetime= date('Y-m-d H:i:s', $u);
												if(!in_array($datetime, $array)){
													$m+=0.25;
												}
												$u+=900;
											}
										}
										else{
											$m = 1;
										}
									}
								}else{
									$m = 1;
								}
								#時給
								$attendance_result = $this->AttendanceResult->find('first', array(
									'conditions' => array('AttendanceResult.location_id' => $location_id, 'AttendanceResult.member_id' => $member_id, 'AttendanceResult.working_day' => $working_day),
									'recursive'=> 2
								));
								if($attendance_result!=null){
									if($attendance_result['AttendanceResult']['day_hourly_wage']!=0){
										$hourly_wage = $attendance_result['AttendanceResult']['day_hourly_wage'];
									}
									else{
										$hourly_wage = $attendance_result['Member']['hourly_wage'];
									}
									#深夜給
									if($hour=='22:00:00'||$hour=='23:00:00'||$hour=='24:00:00'){
										$hourly_wage = $hourly_wage*1.25;
									}
									#初期値
									if(!isset($result[$hour]['fee'])){$result[$hour]['fee']=0;}
									if(!isset($result[$hour]['num'])){$result[$hour]['num']=0;}
									if($m>0){
										$result[$hour]['fee'] += $hourly_wage*$m;
										$result[$hour]['num'] += $m;
									}
								}
							}
						}
					}
				}
			}
		}
		return $result;
	}

	public function date_array($startDate, $endDate){
		$period = array();
		$diff = (strtotime($endDate) - strtotime($startDate)) / ( 60 * 60 * 24);
		for($i = 0; $i <= $diff; $i++) {
			$period[] = date('Y-m-d', strtotime($startDate . '+' . $i . 'days'));
		}
		return $period;
	}


}
