<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 16:01
 */
class AttendancesController extends AppController{
	#フォームヘルパー
	public $helpers = array('Html', 'Form');
	#Cookieの使用
	var $components = array('Cookie');

	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		$this->set('title_for_layout', 'タイムカード | 寿し和');
		#共通使用モデル
		$this->loadModel("Member");
		$this->loadModel("Location");
		#ログイン処理
		if(!$this->Cookie->check('myData')){
			#loginページへ
			$this->redirect(array('controller'=>'locations','action'=>'login'));
		}else{
			$location = $this->Location->findById($this->Cookie->read('myData'));
			$this->set('location', $location);
		}
	}

	#インデックス
	public function index(){
		#クッキー値
		$location_id=$this->Cookie->read('myData');
		#使用モデル
		$this->loadModel("Attendance");
		#営業日取得
		$working_day = $this->Attendance->judge24Hour(time());
		$this->set('working_day', $working_day);
		#従業員取得
		$members=$this->Member->getMemberByLocationId($location_id);
		#従業員雇用形態
		$member_types = array();
		#勤務状態取得
		$member_flags = array();
		foreach($members as $member){
			$member_types[$member['Type']['id']] = $member['Type']['name'];
			$member_flags[$member['Member']['id']] = $this->Attendance->judgeJobState($working_day, $member['Member']['id'], $location_id);
		}
		$this->set('members', $members);
		$this->set('member_flags', $member_flags);
		$this->set('member_types', $member_types);
		#従業員雇用形態（数）
		$this->set('member_type_num', count($member_types));
	}

	#勤怠画面
	public function view(){
		if($this->request->is('get')){
			#従業員情報
			$member = $this->Member->findById($this->params['url']['id']);
			$this->set('member', $member);
			#勤務状態
			$this->set('flag', $this->params['url']['flag']);
		}elseif($this->request->is('post')){
			#使用モデル
			$this->loadModel("AttendanceType");
			#クッキー値
			$location_id=$this->Cookie->read('myData');
			#営業日取得
			$working_day = $this->Attendance->judge24Hour(time());
			#勤怠状態取得
			$attendance_type = $this->AttendanceType->find('first', array(
				'conditions' => array('name' => $this->request->data['state'])
			));
			if($attendance_type==null){
				throw new NotFoundException('不正なエラーが発生しました。担当者にお知らせください。');
			}
			#時間調整（15分毎）
			$time = $this->Attendance->timeOrganizer($this->request->data['state'], time());
			$data = array('Attendance' => array(
				'location_id' => $location_id,
				'member_id' => $this->request->data['member_id'],
				'working_day' => $working_day,
				'type_id' => $attendance_type['AttendanceType']['id'],
				'time' => $time
			));
			$this->Attendance->save($data);
			$this->Session->setFlash("完了しました！");
			$this->redirect(array('controller'=>'locations', 'action'=>'index'));
		}
	}

	#勤怠管理
	public function edit(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			#クッキー値
			$location_id=$this->Cookie->read('myData');
			#営業日
			$working_day = $this->params['url']['date'];
			$this->set('working_day', $working_day);
			#勤怠記録
			$attendances = $this->Attendance->find('all', array(
				'conditions' => array('working_day' => $working_day, 'Attendance.location_id' => $location_id)
			));
			#配列フォーマット変更
			$arr = array();
			foreach($attendances as $attendance){
				$arr[$attendance['Member']['id']][$attendance['Type']['name']] = $attendance;
			}
			$this->set('attendances', $arr);
			#全従業員
			$members=$this->Member->getMemberByLocationId($location_id);
			$this->set('members', $members);
		}
	}

	#削除
	public function delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->Attendance->delete($this->params['url']['id'], false);
				if(isset($this->params['url']['id_two'])){
					$this->Attendance->delete($this->params['url']['id_two'], false);
					if(isset($this->params['url']['id_three'])&&isset($this->params['url']['id_four'])){
						$this->Attendance->delete($this->params['url']['id_three'], false);
						$this->Attendance->delete($this->params['url']['id_four'], false);
					}
				}
				$this->Session->setFlash("出退勤の削除が完了しました");
				$this->redirect($this->referer());
			}else{
				throw new NotFoundException('このページは見つかりませんでした');
			}
		}
	}

	#追加andResult
	public function add(){
		if($this->request->is('post')){
			#debug($this->request->data);
			#使用モデル
			$this->loadModel("AttendanceResult");
			#クッキー値
			$location_id=$this->Cookie->read('myData');
			$working_day = $this->request->data['working_day'];
			#既存
			if(isset($this->request->data['AttendanceResult'])){
				foreach($this->request->data['AttendanceResult'] as $key => $attendance_result){
					#Attendanceのupdate
					#出勤
					$data = array('Attendance' => array(
						'id' => key($attendance_result['attendance_start']),
						'time' => $attendance_result['attendance_start'][key($attendance_result['attendance_start'])]
					));
					$this->Attendance->save($data);
					#退勤
					$data = array('Attendance' => array(
						'id' => key($attendance_result['attendance_end']),
						'time' => $attendance_result['attendance_end'][key($attendance_result['attendance_end'])]
					));
					$this->Attendance->save($data);

					if($attendance_result['attendance_start_break'][0]==null||$attendance_result['attendance_end_break'][0]==null){
						#休憩なし
						$hours = $this->Attendance->twoDiffCalculator($working_day,$attendance_result['attendance_start'][key($attendance_result['attendance_start'])], $attendance_result['attendance_end'][key($attendance_result['attendance_end'])]);
					}else{
						#休憩あり
						#Attendanceのupdate
						#休憩開始
						$data = array('Attendance' => array(
							'id' => key($attendance_result['attendance_start_break']),
							'time' => $attendance_result['attendance_start_break'][key($attendance_result['attendance_start_break'])]
						));
						$this->Attendance->save($data);
						#休憩終了
						$data = array('Attendance' => array(
							'id' => key($attendance_result['attendance_end_break']),
							'time' => $attendance_result['attendance_end_break'][key($attendance_result['attendance_end_break'])]
						));
						$this->Attendance->save($data);
						$hours = $this->Attendance->fourDiffCalculator($working_day,$attendance_result['attendance_start'][key($attendance_result['attendance_start'])],$attendance_result['attendance_start_break'][key($attendance_result['attendance_start_break'])],$attendance_result['attendance_end_break'][key($attendance_result['attendance_end_break'])],$attendance_result['attendance_end'][key($attendance_result['attendance_end'])]);
					}
					#AttendanceResult
					#既存かどうか
					$already_result = $this->AttendanceResult->find('first', array(
						'conditions' => array('AttendanceResult.location_id'=>$location_id, 'member_id'=>$key, 'working_day'=>$working_day)
					));
					if($already_result==null){
						$data = array('AttendanceResult' => array(
							'location_id' => $location_id,
							'member_id' => $key,
							'working_day' => $working_day,
							'attendance_start' => $attendance_result['attendance_start'][key($attendance_result['attendance_start'])],
							'attendance_end' => $attendance_result['attendance_end'][key($attendance_result['attendance_end'])],
							'hours' => $hours['normal_hours'],
							'late_hours' => $hours['late_hours']
						));
						$this->AttendanceResult->create(false);
						$this->AttendanceResult->save($data);
					}else{
						$data = array('AttendanceResult' => array(
							'id' => $already_result['AttendanceResult']['id'],
							'attendance_start' => $attendance_result['attendance_start'][key($attendance_result['attendance_start'])],
							'attendance_end' => $attendance_result['attendance_end'][key($attendance_result['attendance_end'])],
							'hours' => $hours['normal_hours'],
							'late_hours' => $hours['late_hours']
						));
						$this->AttendanceResult->save($data);
					}
				}
			}
			#新規
			foreach($this->request->data['NewAttendanceResult'] as $new_attendance_result){
				#空判定
				if($new_attendance_result['member_id']!=null&&$new_attendance_result['attendance_start']!=null&&$new_attendance_result['attendance_end']!=null){
					#AttendanceResult
					#既存かどうか
					$already_result = $this->AttendanceResult->find('first', array(
						'conditions' => array('AttendanceResult.location_id'=>$location_id, 'member_id'=>$new_attendance_result['member_id'], 'working_day'=>$working_day)
					));
					#休憩ありなし＝＞時間差分計算
					if($new_attendance_result['attendance_start_break']==null||$new_attendance_result['attendance_end_break']==null){
						$hours = $this->Attendance->twoDiffCalculator($working_day, $new_attendance_result['attendance_start'], $new_attendance_result['attendance_end']);
					}else{
						$hours = $this->Attendance->fourDiffCalculator($working_day,$new_attendance_result['attendance_start'],$new_attendance_result['attendance_start_break'],$new_attendance_result['attendance_end_break'],$new_attendance_result['attendance_end']);
					}
					if($already_result==null){
						$data = array('AttendanceResult' => array(
							'location_id' => $location_id,
							'member_id' => $new_attendance_result['member_id'],
							'working_day' => $working_day,
							'attendance_start' => $new_attendance_result['attendance_start'],
							'attendance_end' => $new_attendance_result['attendance_end'],
							'hours' => $hours['normal_hours'],
							'late_hours' => $hours['late_hours']
						));
						$this->AttendanceResult->create(false);
						$this->AttendanceResult->save($data);
					}else{
						$data = array('AttendanceResult' => array(
							'id' => $already_result['AttendanceResult']['id'],
							'attendance_start' => $new_attendance_result['attendance_start'],
							'attendance_end' => $new_attendance_result['attendance_end'],
							'hours' => $hours['normal_hours'],
							'late_hours' => $hours['late_hours']
						));
						$this->AttendanceResult->save($data);
					}
				}
			}
			$this->Session->setFlash("勤怠管理を受け付けました。");
			$this->redirect(array('controller'=>'locations','action'=>'index'));
		}
	}

}
