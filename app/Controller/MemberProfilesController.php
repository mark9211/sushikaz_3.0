<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/10/04
 * Time: 13:30
 */
App::uses('Security', 'Utility');

class MemberProfilesController extends AppController{
    var $scaffold;
    #フォームヘルパー
    public $helpers = array('Html', 'Form');
    #Cookieの使用
    var $components = array('Cookie');
    #共通スクリプト
    public function beforeFilter(){
        #ページタイトル設定
        $this->set('title_for_layout', '従業員専用 | 寿し和');
        $this->loadModel("Member");
        $this->loadModel("AttendanceResult");
        $this->loadModel("Attendance");
        $this->loadModel("TotalSales");
        $this->loadModel("CustomerCount");
        $this->loadModel("CustomerTimezone");
        $this->loadModel("SalesLunch");
        $this->loadModel("TotalSales");
        $this->loadModel("ReceiptSummary");
    }

    #index上書き
    public function index(){
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }else{
            #Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
            if(isset($myData['CustomerProfile'])){
                $this->Session->setFlash('顧客アカウントをログアウトしてください','flash_error');
                $this->redirect(array('controller'=>'customer_profiles','action'=>'index'));
            }
        }
    }

    public function login(){
        $this->layout = 'sample';
        //debug(Security::hash('mark9211', 'sha1', true));exit;
        #ログイン処理
        if(!$this->Session->check('myData')){
            if($this->request->is('post')){
                if(isset($this->request->data['member_id'])){   #新規登録から
                    $data = array('MemberProfile' => array(
                        'member_id' => $this->request->data['member_id'],
                        'email' => $this->request->data['email'],
                        'password' => $this->request->data['password'],
                        'gender' => $this->request->data['gender'],
                        'birthday' => $this->request->data['birthday'],
                        'phone' => $this->request->data['phone'],
                        'postcode' => $this->request->data['postcode'],
                        'address1' => $this->request->data['address1'],
                        'address2' => $this->request->data['address2'],
                        'address3' => $this->request->data['address3'],
                        'address4' => $this->request->data['address4'],
                        'photo' => $this->request->data['photo']
                    ));
                    if($this->MemberProfile->save($data)){
                        #再取得
                        $member = $this->Member->findById($data['MemberProfile']['member_id']);
                        //メール送信
                        App::uses( 'CakeEmail', 'Network/Email');
                        // テンプレートに送る変数
                        $ary_body = array (
                            'name' => $member['Member']['name'],
                            'email' => $member['MemberProfile']['email'],
                            'password' => $this->request->data['password'],
                            'url' => Router::url('/member_profiles/login/', true),
                        );
                        $email = new CakeEmail('gmail');
                        $email->config(array('log' => 'emails'))
                            ->template('default', 'default')
                            ->viewVars($ary_body)
                            ->from( array( 'kazuki.k@sushikaz.com' => 'kazuki.k@sushikaz.com'))
                            ->to($member['MemberProfile']['email'])
                            ->subject('【登録完了】')
                            ->send();
                        #セッション書き込み
                        $this->Session->write('myData', $member);
                        $this->Session->setFlash('アカウントを作成しました。','flash_success');
                        $this->redirect(array('action'=>'index'));
                    }
                }elseif(isset($this->request->data['MemberProfile'])){  #ログインフォームから
                    $email = $this->request->data['MemberProfile']['email'];
                    //password ハッシュ化
                    $password = Security::hash($this->request->data['MemberProfile']['password'], 'sha1', true);
                    $member_profile = $this->MemberProfile->find('first', array(
                        'conditions' => array(
                            'MemberProfile.email' => $email,
                            'MemberProfile.password' => $password
                        )
                    ));
                    if($member_profile!=null){
                        $member = $this->Member->findById($member_profile['MemberProfile']['member_id']);
                        $this->Session->write('myData', $member);
                        $this->redirect(array('action'=>'index'));
                    }else{
                        $this->Session->setFlash('メールアドレスまたはパスワードが正しくありません。','flash_error');
                    }
                }
            }else{
                $members = $this->Member->find('all');
                $new_members = array();
                foreach($members as $member){
                    if($member['MemberProfile']['member_id']==null){
                        $new_members[] = $member;
                    }
                }
                $this->set('new_members', $new_members);
            }
        }else{
            #indexページへ
            $this->redirect(array('action'=>'index'));
        }
    }

    #edit上書き
    public function edit($id){
        if($this->request->is('post')){
            #従業員情報
            /*
            $member = $this->Member->findById($id);
            if ($member != null) {
                $this->set('member', $member);
                #店舗
                $locations = $this->Location->find('all');
                $this->set('locations', $locations);
                #役職
                $posts = $this->MemberPost->find('all', array(
                    'conditions' => array('location_id' => $member['Location']['id'])
                ));
                $this->set('posts', $posts);
                #持ち場
                $positions = $this->MemberPosition->find('all', array(
                    'conditions' => array('location_id' => $member['Location']['id'])
                ));
                $this->set('positions', $positions);
                #就業形態
                $types = $this->MemberType->find('all', array(
                    'conditions' => array('location_id' => $member['Location']['id'])
                ));
                $this->set('types', $types);
            } else {
                debug("えらー！");
                exit;
            }
        }elseif($this->request->is('get')){
            if($this->Member->save($this->request->query)){
                $this->Session->setFlash("編集完了しました");
                $this->redirect(array("controller"=>"members", 'action'=>'index'));
            }
            */
        }
    }

    public function add(){
        if($this->request->is('post')){ #新規登録へ
            $member_id = $this->request->data['member_id'];
            $member = $this->Member->findById($member_id);
            if($member!=null){
                $this->set('member', $member);
            }else{
                echo "ERROR:500";
            }
        }
    }

    #20151006EmailCheck
    public function emailCheck(){
        $this->autoRender = FALSE;
        if($this->request->is('ajax')){
            //return $this->data['email'];
            #table検索
            $member_profile = $this->MemberProfile->find('first', array(
                'conditions' => array(
                    'MemberProfile.email' => $this->data['email']
                )
            ));
            #既存判定
            if($member_profile==null){
                return 0;
            }else{
                return 1;
            }
        }
    }

    #20151006PasswordForgot
    public function password(){
        if($this->request->is('get')){
            #リファラチェック
            if($this->referer()=='/'){
                throw new NotFoundException('このページは見つかりませんでした');
            }
            if(isset($this->params['url']['email'])) {
                $member_profile = $this->MemberProfile->find('first', array(
                    'conditions' => array('MemberProfile.email' => $this->params['url']['email']),
                    'limit' => 1
                ));
                if($member_profile != null) {
                    //sessionにemail情報書き込み
                    $this->Cookie->write('forPasswordChange', $member_profile['MemberProfile']['email'], true, '1 day');
                    //メール送信
                    App::uses('CakeEmail', 'Network/Email');
                    // テンプレートに送る変数
                    $url = Router::url('/member_profiles/password_reset?hash=', true);
                    $ary_body = array(
                        'url' => $url . $member_profile['MemberProfile']['password'],
                    );
                    $email = new CakeEmail('gmail');
                    $email->config(array('log' => 'emails'))
                        ->template('password', 'default')
                        ->viewVars($ary_body)
                        ->from(array('kazuki.k@sushikaz.com' => 'kazuki.k@sushikaz.com'))
                        ->to($member_profile['MemberProfile']['email'])
                        ->subject('【パスワード変更】')
                        ->send();
                    $this->redirect(array('action' => 'password'));
                }else{
                    echo "Error 500";
                    exit;
                }
            }else{
                $this->layout = 'sample';
            }
        }
    }

    #20151006
    public function password_reset(){
        $this->layout = 'sample';
        if($this->request->is('get')){
            //有効期限切れ処理
            $email = $this->Cookie->read('forPasswordChange');
            if($email==null){
                throw new NotFoundException('このページは見つかりませんでした');
            }
            $password = $this->params['url']['hash'];
            #確認
            $member_profile = $this->MemberProfile->find('first', array(
                'conditions' => array('MemberProfile.email' => $email, 'MemberProfile.password' => $password),
                'limit' => 1
            ));
            if($member_profile!=null){
                $this->set('member_profile', $member_profile);
            }else{
                echo "ERROR:500";
                exit;
            }
        }
        if($this->request->is('post')){
            //パスワード更新
            $data = array('MemberProfile' => array(
                'id' => $this->request->data['id'],
                'password' => $this->request->data['password']
            ));
            if($this->MemberProfile->save($data)){
                $this->Session->setFlash('パスワードを変更しました。','flash_success');
                $this->redirect(array('action' => 'login'));
            }else{
                echo "Error:500";
                exit;
            }
        }
    }

    public function logout(){
        $this->Session->delete('myData');
        $this->Session->setFlash('ログアウトしました','flash_success');
        $this->redirect(array('action' => 'login'));
    }

    public function view(){
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }else{
            #Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
            #month
            $month = $this->params['url']['month'];
            $this->set('month', $month);
            #calcul
            if($myData['Type']['name']=="アルバイト"){
                #パラメータ初期化
                $days = 0;
                $hours = 0;
                $late_hours = 0;
                $special_fee = 0;
                #20150807追記
                $salaries = 0;
                $late_salaries = 0;
                $compensation = 0;
                #勤務記録参照
                $attendance_results = $this->AttendanceResult->find('all', array(
                    'conditions' => array('AttendanceResult.location_id' => $myData['Location']['id'], 'AttendanceResult.working_day LIKE' => '%'.$month.'%', 'AttendanceResult.member_id' => $myData['Member']['id'])
                ));
                if($attendance_results!=null){
                    #交通費
                    if(count($attendance_results) < 16){    //日ごと
                        if($myData['Member']['compensation_daily']!=0){
                            $compensation = count($attendance_results)*$myData['Member']['compensation_daily'];
                        }else{
                            $compensation = $myData['Member']['compensation_monthly'];
                        }
                    }elseif(count($attendance_results) >= 16){   //定期
                        if($myData['Member']['compensation_monthly']!=0){
                            #定期の方が高かったら,日割り
                            if($myData['Member']['compensation_monthly'] > count($attendance_results)*$myData['Member']['compensation_daily']&&$myData['Member']['compensation_daily']!=0){
                                $compensation = count($attendance_results)*$myData['Member']['compensation_daily'];
                            }else{
                                $compensation = $myData['Member']['compensation_monthly'];
                            }
                        }else{
                            $compensation = count($attendance_results)*$myData['Member']['compensation_daily'];
                        }
                    }else{
                        echo "Fatal Error : Attendance Results are not availables";
                        exit;
                    }
                    #交通費補正
                    if($compensation > 10000){
                        $compensation = 10000;
                    }
                    #加算
                    foreach($attendance_results as $attendance_result){
                        $hours += $attendance_result['AttendanceResult']['hours'];
                        $salaries += floor($attendance_result['AttendanceResult']['hours']*$myData['Member']['hourly_wage']);
                        $late_hours += $attendance_result['AttendanceResult']['late_hours'];
                        $late_salaries += floor($attendance_result['AttendanceResult']['late_hours']*floor($myData['Member']['hourly_wage']*1.25));
                        #大入り判定
                        $total_sales = $this->TotalSales->find('first', array(
                            'conditions' => array('TotalSales.location_id' => $myData['Location']['id'], 'TotalSales.working_day' => $attendance_result['AttendanceResult']['working_day'], 'sales >' => '400000')
                        ));
                        if($total_sales!=null){
                            $special_fee += 500;
                        }
                    }
                    $days = count($attendance_results);
                }
                #set
                $this->set('days', $days); //勤務日数
                $this->set('hours', $hours); //平日時間
                $this->set('late_hours', $late_hours); //平日時間
                $this->set('salaries', $salaries); //平日給与
                $this->set('late_salaries', $late_salaries); //平日給与
                $this->set('special_fee', $special_fee); //大入り
                $this->set('compensation', $compensation); //交通費
            }
        }
    }

    #日別売上20151209
    public function daily_report(){
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }else{
            # Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
            # working_day
            $working_day = $this->params['url']['date'];
            $this->set('working_day', $working_day);
            #日別売上and売上目標and客数取得
            $this->loadModel("TotalSales");
            $this->loadModel("Sales");
            $this->loadModel('CustomerCount');
            $this->loadModel("Target");
            $this->loadModel("Payroll");
            #祝日配列
            $datas = $this->Payroll->get_holidays();
            $target_col = $this->Target->returnNumDay($working_day, $datas);
            #month
            $month = date('Y-m', strtotime($working_day));$month = $month.'-01';
            ########################## BEGIN DAY ############################################
            #池袋店
            $location = array();
            $total_sales1 = $this->TotalSales->find('first', array(
                'conditions' => array('TotalSales.location_id' => 1, 'TotalSales.working_day' => $working_day)
            ));
            $target_sum = $this->Target->getTargetByMonth(1, $month, $target_col);
            if($total_sales1!=null){
                $location['sales'] = $total_sales1['TotalSales']['sales'];$location['target'] = $target_sum;$location['customer'] = $total_sales1['TotalSales']['customer_counts'];
                $this->set('location1', $location);
            }

            #赤羽店
            $location = array();
            $total_sales2 = $this->TotalSales->find('first', array(
                'conditions' => array('TotalSales.location_id' => 2, 'TotalSales.working_day' => $working_day)
            ));
            $target_sum = $this->Target->getTargetByMonth(2, $month, $target_col);
            if($total_sales2!=null){
                $location['sales'] = $total_sales2['TotalSales']['sales'];$location['target'] = $target_sum;$location['customer'] = $total_sales2['TotalSales']['customer_counts'];
                $this->set('location2', $location);
            }
            #和光店
            $location = array();
            $this->Sales->recursive = 2;
            $sales = $this->Sales->find('all', array(
                'conditions' => array('Sales.location_id' => 3, 'Sales.working_day' => $working_day)
            ));
            $result = $this->Sales->diviseSushiYakiniku($sales);
            $target_sum = $this->Target->getTargetByMonth(3, $month, $target_col);
            if($result!=null){
                $this->CustomerCount->recursive = 2;
                $customer_counts = $this->CustomerCount->find('all', array(
                    'conditions' => array('CustomerCount.location_id' => 3, 'CustomerCount.working_day' => $working_day)
                ));
                $c_result = $this->CustomerCount->diviseSushiYakiniku($customer_counts);

                if($result['寿司']!=null){
                    $location['sales'] = floor($result['寿司']*1.08);$location['target'] = floor($target_sum/2);$location['customer'] = $c_result['寿司'];
                    $this->set('location3', $location);
                }
                $location = array();
                if($result['焼肉']!=null){
                    $location['sales'] = floor($result['焼肉']*1.08);$location['target'] = floor($target_sum/2);$location['customer'] = $c_result['焼肉'];
                    $this->set('location4', $location);
                }
            }
            ############################# END DAY ##########################################

            ########################## BEGIN MONTH ###########################################
            /*
            $this->loadModel("SalesHistory");
            $this->loadModel("SalesType");
            $this->loadModel("CustomerTimezone");
            #月
            $month = date('Y-m', strtotime($working_day));
            $last_month = date('Y-m', strtotime("$working_day -1 year"));
            #池袋店
            $m_location = array();
            $sales_types = $this->SalesType->find('all', array(
                'conditions' => array('SalesType.location_id' => 1, 'SalesType.attribute_id' => 1)
            ));
            $m_location['sales'] = $this->Sales->monthlySalesAddition(1, $month, $sales_types);
            $customer_timezones = $this->CustomerTimezone->find('all', array(
                'conditions' => array('CustomerTimezone.location_id' => 1, 'CustomerTimezone.attribute_id' => 1)
            ));
            $m_location['customer'] = $this->CustomerCount->monthlyCustomerAddition(1, $month, $customer_timezones);
            $sales_history = $this->SalesHistory->find('first', array(
                'conditions' => array('SalesHistory.location_id' => 1,'SalesHistory.working_day LIKE' => '%'.$last_month.'%','SalesHistory.attribute_id' => 1)
            ));
            if($sales_history!=null){
                $m_location['target'] = ceil($sales_history['SalesHistory']['fee']*1.05);
            }
            $this->set('m_location1', $m_location);
            #赤羽店
            $m_location = array();
            $sales_types = $this->SalesType->find('all', array(
                'conditions' => array('SalesType.location_id' => 2, 'SalesType.attribute_id' => 1)
            ));
            $m_location['sales'] = $this->Sales->monthlySalesAddition(2, $month, $sales_types);
            $customer_timezones = $this->CustomerTimezone->find('all', array(
                'conditions' => array('CustomerTimezone.location_id' => 2, 'CustomerTimezone.attribute_id' => 1)
            ));
            $m_location['customer'] = $this->CustomerCount->monthlyCustomerAddition(2, $month, $customer_timezones);
            $sales_history = $this->SalesHistory->find('first', array(
                'conditions' => array('SalesHistory.location_id' => 2,'SalesHistory.working_day LIKE' => '%'.$last_month.'%','SalesHistory.attribute_id' => 1)
            ));
            if($sales_history!=null){
                $m_location['target'] = ceil($sales_history['SalesHistory']['fee']*1.05);
            }
            $this->set('m_location2', $m_location);
            #和光店（寿司）
            $m_location = array();
            $sales_types = $this->SalesType->find('all', array(
                'conditions' => array('SalesType.location_id' => 3, 'SalesType.attribute_id' => 1)
            ));
            $m_location['sales'] = floor($this->Sales->monthlySalesAddition(3, $month, $sales_types)*1.08);
            $customer_timezones = $this->CustomerTimezone->find('all', array(
                'conditions' => array('CustomerTimezone.location_id' => 3, 'CustomerTimezone.attribute_id' => 1)
            ));
            $m_location['customer'] = $this->CustomerCount->monthlyCustomerAddition(3, $month, $customer_timezones);
            $sales_history = $this->SalesHistory->find('first', array(
                'conditions' => array('SalesHistory.location_id' => 3,'SalesHistory.working_day LIKE' => '%'.$last_month.'%','SalesHistory.attribute_id' => 1)
            ));
            if($sales_history!=null){
                $m_location['target'] = ceil($sales_history['SalesHistory']['fee']*1.05);
            }
            $this->set('m_location3', $m_location);
            #和光店（焼肉）
            $m_location = array();
            $sales_types = $this->SalesType->find('all', array(
                'conditions' => array('SalesType.location_id' => 3, 'SalesType.attribute_id' => 2)
            ));
            $m_location['sales'] = floor($this->Sales->monthlySalesAddition(3, $month, $sales_types)*1.08);
            $customer_timezones = $this->CustomerTimezone->find('all', array(
                'conditions' => array('CustomerTimezone.location_id' => 3, 'CustomerTimezone.attribute_id' => 2)
            ));
            $m_location['customer'] = $this->CustomerCount->monthlyCustomerAddition(3, $month, $customer_timezones);
            $sales_history = $this->SalesHistory->find('first', array(
                'conditions' => array('SalesHistory.location_id' => 3,'SalesHistory.working_day LIKE' => '%'.$last_month.'%','SalesHistory.attribute_id' => 2)
            ));
            if($sales_history!=null){
                $m_location['target'] = ceil($sales_history['SalesHistory']['fee']*1.05);
            }
            $this->set('m_location4', $m_location);
            */
            ############################# END MONTH ##########################################
        }
    }

    #20160106
    public function graph(){
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }else {
            # Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
            $location_id = $this->params['url']['location'];
            if($location_id!=null){
                # SalesHistories
                $this->loadModel('SalesHistory');
                $dataSet = array();
                $dataJson = array();
                $years = array('2013', '2014', '2015');
                $this->set('years', json_encode($years));
                if($location_id==1||$location_id==2){
                    foreach($years as $year){
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => $location_id, 'SalesHistory.attribute_id' => 1, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] = $sales_history['SalesHistory']['fee'];
                        }
                    }
                }elseif($location_id==3){
                    foreach($years as $year){
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => $location_id, 'SalesHistory.attribute_id' => 1, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] = $sales_history['SalesHistory']['fee'];
                        }
                    }
                }elseif($location_id==4){
                    foreach($years as $year){
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => 3, 'SalesHistory.attribute_id' => 2, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] = $sales_history['SalesHistory']['fee'];
                        }
                    }
                }elseif($location_id==5){
                    foreach($years as $year){
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => 3, 'SalesHistory.attribute_id' => 1, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] = $sales_history['SalesHistory']['fee'];
                        }
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => 3, 'SalesHistory.attribute_id' => 2, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] += $sales_history['SalesHistory']['fee'];
                        }
                    }
                }elseif($location_id==6){
                    foreach($years as $year){
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => 1, 'SalesHistory.attribute_id' => 1, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] = $sales_history['SalesHistory']['fee'];
                        }
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => 2, 'SalesHistory.attribute_id' => 1, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] += $sales_history['SalesHistory']['fee'];
                        }
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => 3, 'SalesHistory.attribute_id' => 1, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] += $sales_history['SalesHistory']['fee'];
                        }
                        $sales_histories = $this->SalesHistory->find('all', array(
                            'conditions' => array('SalesHistory.location_id' => 3, 'SalesHistory.attribute_id' => 2, 'SalesHistory.working_day LIKE' => '%'.$year.'%')
                        ));
                        foreach($sales_histories as $sales_history){
                            $dataSet[$year][$sales_history['SalesHistory']['working_day']] += $sales_history['SalesHistory']['fee'];
                        }
                    }
                }else{
                    echo "Param Error!!";
                    exit;
                }
                # Json Data Set
                foreach($years as $year){
                    $dataJson[$year] = json_encode(array_values($dataSet[$year]));
                }
                $this->set('dataJson', $dataJson);
            }else{
                echo "Param Error!!";
                exit;
            }
            # loccatoion and attribute
            //$this->loadModel('Association');
            //$associations = $this->Association->find('all');
            //debug($associations);
        }
    }

    public function expense(){
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }else {
            # Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
            # 使用モデル
            $this->loadModel("StocktakingType");
            $this->loadModel("KaikakeStore");
            $this->loadModel("KaikakeFee");
            $this->loadModel("IntermediateOne");
            if($this->request->is('post')){
                $association_id = $this->request->data['association_id'];
                $working_month = $this->request->data['working_month'];
                foreach($this->request->data['fee'] as $key => $fee){
                    if($fee!=null){
                        # 既存チェック
                        $kaikake_fee = $this->KaikakeFee->find('first', array(
                            'conditions' => array('KaikakeFee.association_id' => $association_id, 'KaikakeFee.store_id' => $key, 'KaikakeFee.working_month LIKE' => '%'.$working_month.'%')
                        ));
                        if($kaikake_fee!=null){
                            $data = array('KaikakeFee' => array(
                                'id' => $kaikake_fee['KaikakeFee']['id'],
                                'fee' => $fee
                            ));
                        }else{
                            $data = array('KaikakeFee' => array(
                                'association_id' => $association_id,
                                'store_id' => $key,
                                'working_month' => $working_month,
                                'fee' => $fee
                            ));
                        }
                        #ループ実行文
                        $this->KaikakeFee->create(false);
                        $this->KaikakeFee->save($data);
                    }
                }
                $this->Session->setFlash('データを保存しました','flash_success');
                $this->redirect($this->referer());
            }else{
                # パラメータ
                $association_id = $this->params['url']['location'];
                $date = $this->params['url']['date'];
                if($association_id!=null&&$date!=null){
                    $this->set("association_id", $association_id);
                    $this->set("date", $date);
                    $stocktaking_types = $this->StocktakingType->find('all');
                    $data_set = array();
                    $num_total = 0;$num_exist = 0;
                    foreach($stocktaking_types as $stocktaking_type){
                        # 支出先
                        $kaikake_stores = $this->KaikakeStore->find('all', array(
                            'conditions' => array('KaikakeStore.type_id' => $stocktaking_type['StocktakingType']['id'])
                        ));
                        $n = array();
                        foreach($kaikake_stores as $kaikake_store){
                            $intermediate_one = $this->IntermediateOne->find('first', array(
                                'conditions' => array('IntermediateOne.association_id' => $association_id, 'IntermediateOne.store_id' => $kaikake_store['KaikakeStore']['id'])
                            ));
                            if($intermediate_one!=null){
                                $num_total++;
                                $kaikake_fee = $this->KaikakeFee->find('first', array(
                                    'conditions' => array('KaikakeFee.association_id' => $association_id, 'KaikakeFee.store_id' => $kaikake_store['KaikakeStore']['id'], 'KaikakeFee.working_month LIKE' => '%'.$date.'%')
                                ));
                                if($kaikake_fee!=null){
                                    $num_exist++;
                                    $kaikake_store['month'] = $kaikake_fee;
                                }
                                $n[] = $kaikake_store;
                            }
                        }
                        $stocktaking_type['Store'] = $n;
                        $data_set[] = $stocktaking_type;
                        # 棚卸額

                    }
                    $this->set("stocktaking_types", $data_set);
                    # 入力済or未入力
                    $this->set("num_exist", $num_exist);
                    $this->set("num_yet", $num_total-$num_exist);

                }else{
                    echo "Error:Param Query Error!!";
                    exit;
                }
            }
        }
    }

    public function menu(){
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }
        else {
            # Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
            # 使用モデル
            $this->loadModel("Location");
            $this->loadModel("Tgroupmaster");
            $this->loadModel("Tsectionmaster");
            $this->loadModel("IntermediateTwo");

            # 店舗
            $locations = $this->Location->find('all');
            $this->set("locations", $locations);

            # 検索タグ
            $intermediate_twos = $this->IntermediateTwo->find('all');
            $group_id_arr = array();
            foreach($intermediate_twos as $intermediate_two){
                $group_id_arr[$intermediate_two['IntermediateTwo']['group_id']] = $intermediate_two['IntermediateTwo']['group_id'];
            }
            $group_arr = array();
            foreach($group_id_arr as $group_id){
                $group_master = $this->Tgroupmaster->find('first', array(
                    'conditions' => array('Tgroupmaster.グループコード' => $group_id)
                ));
                $group_arr[] = $group_master;
            }
            $this->set("group_masters", $group_arr);
            //$section_masters = $this->Tsectionmaster->find('all');
            //$this->set("section_masters", $section_masters);

            # GET
            if($this->request->is('get')){
                # graph
                $demo = array();
                $demo[] = array('name'=>'demo', 'income' => 0, 'count' => 0);
                $this->set('demo', json_encode($demo));
            }
            # POST
            if($this->request->is('post')){
                # 使用モデル
                $this->loadModel("Tmenumaster");
                $this->loadModel("Tmenusales");
                $this->loadModel("Tgroupmaster");
                $this->loadModel("Association");
                $this->loadModel("Menu");
                $this->loadModel("MenuSales");
                $this->loadModel("MenuGroup");

                # Error 構文
                if($this->request->data['radio1']==null||$this->request->data['radio2']==null||$this->request->data['date']==null||$this->request->data['group']==null||$this->request->data['section']==null){
                    echo "Error: Please complete the form";
                    exit;
                }

                # 日付
                if($this->request->data['radio2']==1){
                    $date = $this->request->data['date'];
                }elseif($this->request->data['radio2']==2){
                    $date = date('Y-m', strtotime($this->request->data['date']));
                }elseif($this->request->data['radio2']==3){
                    $date = date('Y', strtotime($this->request->data['date']));
                }elseif($this->request->data['radio2']==4){
                    $date = $this->request->data['date'];
                    $pre_date = date("Y-m-d",strtotime($date . "-3 month"));
                }else{
                    echo "ERROR: Date is not correct.";
                    exit;
                }
                # post情報set
                $this->set("post_radio1", $this->request->data['radio1']);
                $this->set("post_radio2", $this->request->data['radio2']);
                $this->set("post_date", $this->request->data['date']);

                $menusales_arr = array();
                $menusales_zero_arr = array();
                $post_group_arr = array();
                if($this->request->data['radio1']==3){ # 和光
                    # 検索タグ
                    $intermediate_twos = $this->IntermediateTwo->find('all');
                    $group_id_arr = array();
                    foreach($intermediate_twos as $intermediate_two){
                        $group_id_arr[$intermediate_two['IntermediateTwo']['group_id']] = $intermediate_two['IntermediateTwo']['group_id'];
                    }
                    foreach($group_id_arr as $group_id){
                        $group_master = $this->Tgroupmaster->find('first', array(
                            'conditions' => array('Tgroupmaster.グループコード' => $group_id)
                        ));
                        $group_master['id'] = (int)$group_master['Tgroupmaster']['グループコード'];
                        $group_master['name'] = $group_master['Tgroupmaster']['グループ名'];
                        if(in_array((int)$group_master['Tgroupmaster']['グループコード'], $this->request->data['group'])){
                            $group_master['checked'] = 1;
                        }else{
                            $group_master['checked'] = 0;
                        }
                        unset($group_master['Tgroupmaster']);
                        $post_group_arr[] = $group_master;
                    }
                    foreach($this->request->data['group'] as $group_id){
                        foreach($this->request->data['section'] as $section_id){
                            $menu_masters = $this->Tmenumaster->find('all', array(
                                'conditions' => array('Tmenumaster.グループコード' => $group_id, 'Tmenumaster.部門コード' => $section_id, 'Tmenumaster.グランド通常単価 >' => 0)
                            ));
                            foreach($menu_masters as $menu_master){
                                if($this->request->data['radio2']==4){
                                    $menu_sales = $this->Tmenusales->find('all', array(
                                        'conditions' => array('Tmenusales.メニュー№' => $menu_master['Tmenumaster']['メニュー№'], 'Tmenusales.営業日 between ? and ?' => array($pre_date, $date))
                                    ));
                                }
                                else{
                                    $menu_sales = $this->Tmenusales->find('all', array(
                                        'conditions' => array('Tmenusales.メニュー№' => $menu_master['Tmenumaster']['メニュー№'], 'Tmenusales.営業日 LIKE' => '%'.$date.'%')
                                    ));
                                }
                                # 合計計算
                                $somme = array();$somme['name'] = '';$somme['income'] = 0;$somme['num'] = 0;
                                if($menu_sales!=null){
                                    foreach($menu_sales as $menu_sales_one){
                                        $somme['name'] = $menu_sales_one['Tmenusales']['メニュー名'];
                                        $somme['income'] += $menu_sales_one['Tmenusales']['金額'];
                                        $somme['num'] += $menu_sales_one['Tmenusales']['グランド数量'];
                                    }
                                    $menusales_arr[] = $somme;
                                }else{
                                    $somme['name'] = $menu_master['Tmenumaster']['メニュー名'];
                                    $menusales_zero_arr[] = $somme;
                                }
                            }
                        }
                    }
                }
                elseif($this->request->data['radio1']==1||$this->request->data['radio1']==2){ # 池袋or赤羽
                    # location_id=>association_id
                    $association = $this->Association->find('all', array(
                        'conditions' => array('Association.location_id' => $this->request->data['radio1'])
                    ));
                    if($association==null||count($association)>=2){
                        echo "Association Error!!";exit;
                    }
                    # post group array
                    $menu_groups = $this->MenuGroup->find('all', array(
                        'conditions' => array('MenuGroup.association_id' => $association[0]['Association']['id'])
                    ));
                    foreach($menu_groups as $menu_group){
                        if(in_array($menu_group['MenuGroup']['id'], $this->request->data['group'])){
                            $post_group_arr[] = array('id'=> $menu_group['MenuGroup']['id'],'name'=>$menu_group['MenuGroup']['name'], 'checked'=>1);
                        }else{
                            $post_group_arr[] = array('id'=> $menu_group['MenuGroup']['id'],'name'=>$menu_group['MenuGroup']['name'], 'checked'=>0);
                        }
                    }
                    foreach($this->request->data['section'] as $section_id){
                        $menus = $this->Menu->find('all', array(
                            'conditions' => array('Menu.type_id' => $section_id)
                        ));
                        if($menus!=null){
                            foreach($menus as $menu){
                                $menu_sales = $this->MenuSales->find('all', array(
                                    'conditions' => array('MenuSales.menu_id' => $menu['Menu']['id'], 'MenuSales.association_id' => $association[0]['Association']['id'], 'MenuSales.working_day LIKE' => '%'.$date.'%')
                                ));
                                if($menu_sales!=null){
                                    # 合計計算
                                    $somme = array();$somme['name'] = '';$somme['income'] = 0;$somme['num'] = 0;
                                    foreach($menu_sales as $menu_sales_one){
                                        $somme['name'] = $menu['Menu']['name'];
                                        $somme['income'] += $menu_sales_one['MenuSales']['fee'];
                                        $somme['num'] += $menu_sales_one['MenuSales']['num'];
                                    }
                                    $menusales_arr[] = $somme;
                                }
                            }
                        }
                    }
                }
                else{
                    echo "Sorry, this store is not yet supported.";
                    exit;
                }
                $this->set("post_groups", $post_group_arr);

                # sort
                $incomes = array();$sum = 0;$stock = 0;$new_arr = array();
                if($menusales_arr!=null){
                    foreach($menusales_arr as $menusales_arr_one){
                        $incomes[] = $menusales_arr_one['income'];
                        $sum += $menusales_arr_one['income'];
                    }
                    array_multisort($incomes, SORT_DESC, SORT_NUMERIC, $menusales_arr);
                    # 累積構成比
                    foreach($menusales_arr as $menusales_arr_one){
                        if($stock<70){
                            $menusales_arr_one['lineColor'] = "#dff0d8";
                            $menusales_arr_one['class'] = "A";
                        }elseif($stock<90){
                            $menusales_arr_one['lineColor'] = "#f9e491";
                            $menusales_arr_one['class'] = "B";
                        }else{
                            $menusales_arr_one['lineColor'] = "#fbe1e3";
                            $menusales_arr_one['class'] = "C";
                        }
                        $stock += $menusales_arr_one['income']/$sum*1000/10;
                        $menusales_arr_one['percent'] = floor($menusales_arr_one['income']/$sum*1000)/10;
                        $menusales_arr_one['count'] = floor($stock*10)/10;
                        $new_arr[] = $menusales_arr_one;
                    }
                }
                //debug($new_arr);
                $this->set("menusales_arr", json_encode($new_arr));
                $this->set("menusales_decode_arr", $new_arr);
                if($menusales_zero_arr!=null){
                    $this->set("menusales_zero_arr", $menusales_zero_arr);
                }

            }
        }
    }

    public function ajax(){
        $this->autoRender = FALSE;
        if($this->request->is('ajax')){
            # 使用モデル
            $this->loadModel("Tgroupmaster");
            $this->loadModel("Tsectionmaster");
            $this->loadModel("IntermediateTwo");
            $this->loadModel("Association");
            $this->loadModel("MenuType");
            # locationId
            $location_id = (int)$this->request->data[0];
            unset($this->request->data[0]);
            $section_arr = array();
            if($location_id==3){ //和光
                foreach($this->request->data as $key => $group_id){
                    $intermediate_twos = $this->IntermediateTwo->find('all', array(
                        'conditions' => array('IntermediateTwo.group_id' => $group_id)
                    ));
                    if($intermediate_twos!=null){
                        foreach($intermediate_twos as $intermediate_two){
                            $section = $this->Tsectionmaster->find('first', array(
                                'conditions' => array('Tsectionmaster.部門コード' => $intermediate_two['IntermediateTwo']['section_id'])
                            ));
                            if($section!=null){
                                $section['id'] = $section['Tsectionmaster']['部門コード'];
                                $section['name'] = $section['Tsectionmaster']['部門名'];
                                unset($section['Tsectionmaster']);
                                $section_arr[] = $section;
                            }
                        }
                    }
                }
            }
            else{
                # location_id=>association_id
                $association = $this->Association->find('all', array(
                    'conditions' => array('Association.location_id' => $location_id)
                ));
                if($association==null||count($association)>=2){
                    echo "Association Error!!";
                    exit;
                }
                foreach($this->request->data as $key => $group_id){
                    $menu_types = $this->MenuType->find('all', array(
                        'conditions' => array('MenuType.group_id' => (int)$group_id)
                    ));
                    if($menu_types!=null){
                        foreach($menu_types as $menu_type){
                            $menu_type['id'] = $menu_type['MenuType']['id'];
                            $menu_type['name'] = $menu_type['MenuType']['name'];
                            unset($menu_type['MenuType']);
                            $section_arr[] = $menu_type;
                        }
                    }
                }
            }
            # json送信
            echo json_encode($section_arr);
        }
    }

    public function ajax2(){
        $this->autoRender = FALSE;
        if($this->request->is('ajax')){
            # 使用モデル
            $this->loadModel("KaikakeFee");
            # data
            $association_id = $this->request->data[0];
            $store_id = $this->request->data[1];
            $date = $this->request->data[2];
            $fee = $this->request->data[3];
            if($association_id!=null&&$store_id!=null&&$date!=null&&$fee!=null){
                # 既存チェック
                $kaikake_fee = $this->KaikakeFee->find('first', array(
                    'conditions' => array('KaikakeFee.association_id' => $association_id, 'KaikakeFee.store_id' => $store_id, 'KaikakeFee.working_month LIKE' => '%'.$date.'%')
                ));
                if($kaikake_fee!=null){
                    $data = array('KaikakeFee' => array(
                        'id' => $kaikake_fee['KaikakeFee']['id'],
                        'fee' => $fee
                    ));
                }else{
                    $data = array('KaikakeFee' => array(
                        'association_id' => $association_id,
                        'store_id' => $store_id,
                        'working_month' => $date,
                        'fee' => $fee
                    ));
                }
                #ループ実行文
                $this->KaikakeFee->create(false);
                if($this->KaikakeFee->save($data)){
                    echo 0;
                }else{
                    echo 1;
                }
            }
        }
    }

    public function ajax3(){
        $this->autoRender = FALSE;
        # 使用モデル
        $this->loadModel("Tgroupmaster");
        $this->loadModel("IntermediateTwo");
        $this->loadModel("Association");
        $this->loadModel("MenuGroup");

        if($this->request->is('ajax')){
            # WAKO
            if((int)$this->request->data[0]==3){
                # 検索タグ
                $intermediate_twos = $this->IntermediateTwo->find('all');
                $group_id_arr = array();
                foreach($intermediate_twos as $intermediate_two){
                    $group_id_arr[$intermediate_two['IntermediateTwo']['group_id']] = $intermediate_two['IntermediateTwo']['group_id'];
                }
                $group_arr = array();
                foreach($group_id_arr as $group_id){
                    $group_master = $this->Tgroupmaster->find('first', array(
                        'conditions' => array('Tgroupmaster.グループコード' => $group_id)
                    ));
                    $group_master['id'] = (int)$group_master['Tgroupmaster']['グループコード'];
                    $group_master['name'] = $group_master['Tgroupmaster']['グループ名'];
                    unset($group_master['Tgroupmaster']);
                    $group_arr[] = $group_master;
                }
                # json送信
                echo json_encode($group_arr);
            }
            else {
                # location_id=>association_id
                $association = $this->Association->find('all', array(
                    'conditions' => array('Association.location_id' => (int)$this->request->data[0])
                ));
                if($association==null||count($association)>=2){
                    echo "Association Error!!";
                    exit;
                }
                $menu_groups = $this->MenuGroup->find('all', array(
                    'conditions' => array('MenuGroup.association_id' => (int)$association[0]['Association']['id'])
                ));
                $group_arr = array();
                foreach($menu_groups as $menu_group){
                    $menu_group['id'] = (int)$menu_group['MenuGroup']['id'];
                    $menu_group['name'] = $menu_group['MenuGroup']['name'];
                    unset($menu_group['MenuGroup']);
                    $group_arr[] = $menu_group;
                }
                # json送信
                echo json_encode($group_arr);
            }
        }
    }

    public function ajax4(){
        $this->autoRender = FALSE;
        if($this->request->is('ajax')){
            # 使用モデル
            $this->loadModel("ExpenseDfFee");
            $this->loadModel("MonthlyExpense");
            # data
            $association_id = $this->request->data[0];
            $type_id = $this->request->data[1];
            $date = $this->request->data[2];
            $fee = $this->request->data[3];
            $model = $this->request->data[4];
            if($association_id!=null&&$type_id!=null&&$date!=null&&$fee!=null){
                if($model=="ExpenseDfFee"){
                    # 既存チェック
                    $history = $this->ExpenseDfFee->find('first', array(
                        'conditions' => array('ExpenseDfFee.association_id' => $association_id, 'ExpenseDfFee.type_id' => $type_id, 'ExpenseDfFee.working_month LIKE' => '%'.$date.'%')
                    ));
                    if($history!=null){
                        $data = array('ExpenseDfFee' => array(
                            'id' => $history['ExpenseDfFee']['id'],
                            'fee' => $fee
                        ));
                    }else{
                        $data = array('ExpenseDfFee' => array(
                            'association_id' => $association_id,
                            'type_id' => $type_id,
                            'working_month' => $date,
                            'fee' => $fee
                        ));
                    }
                    #ループ実行文
                    $this->ExpenseDfFee->create(false);
                    if($this->ExpenseDfFee->save($data)){
                        echo 0;
                    }else{
                        echo 1;
                    }
                }
                elseif($model=="MonthlyExpense"){
                    # 既存チェック
                    $history = $this->MonthlyExpense->find('first', array(
                        'conditions' => array('MonthlyExpense.association_id' => $association_id, 'MonthlyExpense.type_id' => $type_id, 'MonthlyExpense.working_month LIKE' => '%'.$date.'%')
                    ));
                    if($history!=null){
                        $data = array('MonthlyExpense' => array(
                            'id' => $history['MonthlyExpense']['id'],
                            'fee' => $fee
                        ));
                    }else{
                        $data = array('MonthlyExpense' => array(
                            'association_id' => $association_id,
                            'type_id' => $type_id,
                            'working_month' => $date,
                            'fee' => $fee
                        ));
                    }
                    #ループ実行文
                    $this->MonthlyExpense->create(false);
                    if($this->MonthlyExpense->save($data)){
                        echo 0;
                    }else{
                        echo 1;
                    }
                }
            }

        }
    }

    public function ajax5(){
        $this->autoRender = FALSE;
        if($this->request->is('ajax')){
            # 使用モデル
            $this->loadModel("MonthlySalary");
            # data
            $association_id=$this->request->data[0];$style=$this->request->data[1];$date=$this->request->data[2];$fee=$this->request->data[3];
            if($association_id!=null&&$style!=null&&$date!=null&&$fee!=null){
                # 既存チェック
                $history = $this->MonthlySalary->find('first', array(
                    'conditions' => array('MonthlySalary.association_id' => $association_id, 'MonthlySalary.style' => $style, 'MonthlySalary.working_month LIKE' => '%'.$date.'%')
                ));
                if($history!=null){
                    $data = array('MonthlySalary' => array(
                        'id' => $history['MonthlySalary']['id'],
                        'fee' => $fee
                    ));
                }else{
                    $data = array('MonthlySalary' => array(
                        'association_id' => $association_id,
                        'style' => $style,
                        'working_month' => $date,
                        'fee' => $fee
                    ));
                }
                #ループ実行文
                $this->MonthlySalary->create(false);
                if($this->MonthlySalary->save($data)){
                    echo 0;
                }else{
                    echo 1;
                }
            }
        }
    }

    public function excel(){
        $this->autoRender = FALSE;
        if($this->request->is('post')){
            // エクセル出力用ライブラリ
            App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
            App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
            // Excel2007形式(xlsx)テンプレートの読み込み
            $reader = PHPExcel_IOFactory::createReader('Excel2007');
            $template = realpath(WWW_ROOT);
            $template .= '/excel/';
            $data_name = 'profit-and-loss';
            $templatePath = $template.$data_name.'.xlsx';
            $obj = $reader->load($templatePath);
            # パラメータ
            $data = $this->request->data;
            $date = $data['date'];
            unset($data['date']);
            //page 1
            $obj->setActiveSheetIndex(0)
                ->setCellValue('B2', date('Y年m月', strtotime($date)));
            $sheet = $obj->getActiveSheet();
            $sheet->setTitle(date('Y年m月', strtotime($date)));
            # 税抜に金額修正する行
            $num_arr = [23,24,25,26,33,34,35,36,37,38,39,40,41,42,43,44,45,46,53,54,55,56,57,58,59,60,61,64,65,66];
            foreach($data as $d){
                $arr = explode(',',$d);
                $num = $arr[0];
                # 項目名
                $obj->setActiveSheetIndex(0)
                    ->setCellValue('C'.$num, $arr[1]);
                if(in_array($num, $num_arr)){
                    $obj->setActiveSheetIndex(0)
                        ->setCellValue('E'.$num, floor($arr[2]/1.08))
                        ->setCellValue('G'.$num, floor($arr[3]/1.08))
                        ->setCellValue('I'.$num, floor($arr[4]/1.08))
                        ->setCellValue('K'.$num, floor($arr[5]/1.08));
                }
                else{
                    $obj->setActiveSheetIndex(0)
                        ->setCellValue('E'.$num, floor($arr[2]))
                        ->setCellValue('G'.$num, floor($arr[3]))
                        ->setCellValue('I'.$num, floor($arr[4]))
                        ->setCellValue('K'.$num, floor($arr[5]));
                }
            }
            // Excel2007
            $filename = '全店売上成績表-'.date('Y年m月', strtotime($date)).'.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=$filename");
            header('Cache-Control: max-age=0');
            $writer = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
            $writer->save('php://output');
            exit;
        }
    }

    public function excel2(){
        $this->autoRender = FALSE;
        if($this->request->is('post')){
            // エクセル出力用ライブラリ
            App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
            App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
            // Excel2007形式(xlsx)テンプレートの読み込み
            $reader = PHPExcel_IOFactory::createReader('Excel2007');
            $template = realpath(WWW_ROOT);
            $template .= '/excel/';
            $data_name = 'kaikake';
            $templatePath = $template.$data_name.'.xlsx';
            $obj = $reader->load($templatePath);
            # パラメータ
            $data = $this->request->data;
            $date = $data['date'];
            unset($data['date']);
            //page 1
            $this_month = date('m月', strtotime($date));
            $next_month = date('m月', strtotime("$date +1 month"));
            $obj->setActiveSheetIndex(0)
                ->setCellValue('B2', date('Y年m月', strtotime($date)))
                ->setCellValue('I2', $this_month."分:".$next_month."支払");
            $sheet = $obj->getActiveSheet();
            $sheet->setTitle(date('Y年m月', strtotime($date)));
            foreach($data as $d){
                $arr = explode(',',$d);
                # Data矯正
                foreach($arr as $key => $a){
                    if($key!=1&&$key!=2&&!is_numeric($a)){
                        $arr[$key] = 0;
                    }
                }
                $num = $arr[0];
                $obj->setActiveSheetIndex(0)
                    ->setCellValue('C'.$num, $arr[2])
                    ->setCellValue('E'.$num, $arr[3])
                    ->setCellValue('F'.$num, $arr[4])
                    ->setCellValue('G'.$num, $arr[5])
                    ->setCellValue('H'.$num, $arr[6]);
            }
            # 棚卸
            $this->loadModel("Stocktaking");
            $stocktakings = $this->Stocktaking->find('all', array(
                'conditions' => array('Stocktaking.working_month LIKE' => '%'.$date.'%'),
                'order' => array('Stocktaking.association_id', 'Stocktaking.type_id')
            ));
            $arr = array();
            foreach($stocktakings as $stocktaking){
                $arr[$stocktaking['Type']['id']]['last'][$stocktaking['Stocktaking']['association_id']] = $stocktaking['Stocktaking']['last_month'];
                $arr[$stocktaking['Type']['id']]['this'][$stocktaking['Stocktaking']['association_id']] = $stocktaking['Stocktaking']['this_month'];
            }
            $cell_arr=array(1=>47,2=>61,3=>70,4=>75,5=>81,6=>null);
            foreach($arr as $key => $a){
                $r = $cell_arr[$key];
                if($r!=null){
                    # last
                    if(isset($a['last'][1])){ $last1=$a['last'][1]; }else{ $last1=0; }
                    if(isset($a['last'][2])){ $last2=$a['last'][2]; }else{ $last2=0; }
                    if(isset($a['last'][3])){ $last3=$a['last'][3]; }else{ $last3=0; }
                    if(isset($a['last'][4])){ $last4=$a['last'][4]; }else{ $last4=0; }
                    $obj->setActiveSheetIndex(0)
                        ->setCellValue('E'.$r, $last1)
                        ->setCellValue('F'.$r, $last2)
                        ->setCellValue('G'.$r, $last3)
                        ->setCellValue('H'.$r, $last4);
                    $r++;
                    # this
                    if(isset($a['this'][1])){ $this1=$a['this'][1]; }else{ $this1=0; }
                    if(isset($a['this'][2])){ $this2=$a['this'][2]; }else{ $this2=0; }
                    if(isset($a['this'][3])){ $this3=$a['this'][3]; }else{ $this3=0; }
                    if(isset($a['this'][4])){ $this4=$a['this'][4]; }else{ $this4=0; }
                    $obj->setActiveSheetIndex(0)
                        ->setCellValue('E'.$r, $this1)
                        ->setCellValue('F'.$r, $this2)
                        ->setCellValue('G'.$r, $this3)
                        ->setCellValue('H'.$r, $this4);
                }
            }
            // Excel2007
            $filename = '買掛現金支払表-'.date('Y年m月', strtotime($date)).'.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=$filename");
            header('Cache-Control: max-age=0');
            $writer = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
            $writer->save('php://output');
            exit;
        }
    }

    public function cash(){
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }else {
            # Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
            # 使用モデル
            $this->loadModel("StocktakingType");
            $this->loadModel("Stocktaking");
            $this->loadModel("Association");
            $this->loadModel("KaikakeStore");
            $this->loadModel("KaikakeFee");
            $this->loadModel("IntermediateOne");
            $this->loadModel("ExpenseType");
            $this->loadModel("Expense");
            # POST
            if($this->request->is('post')){
                if(isset($this->request->data['Stocktaking'])){
                    $stocktakings = $this->request->data['Stocktaking'];
                    $date = $this->request->data['date'];
                    foreach($stocktakings as $association_id => $stocktaking_arr){
                        foreach($stocktaking_arr as $type_id => $stocktaking){
                            $history_stocktaking = $this->Stocktaking->find('first', array(
                                'conditions' => array('Stocktaking.association_id' => $association_id, 'Stocktaking.type_id' => $type_id, 'Stocktaking.working_month LIKE' => '%'.$date.'%')
                            ));
                            if($history_stocktaking!=null){ //既存
                                $data = array('Stocktaking' => array(
                                    'id' => $history_stocktaking['Stocktaking']['id'],
                                    'last_month' => $stocktaking['last_month'],
                                    'this_month' => $stocktaking['this_month']
                                ));
                            }else{  //新規
                                $data = array('Stocktaking' => array(
                                    'association_id' => $association_id,
                                    'type_id' => $type_id,
                                    'working_month' => $date.'-01',
                                    'last_month' => $stocktaking['last_month'],
                                    'this_month' => $stocktaking['this_month']
                                ));
                            }
                            #ループ実行文
                            $this->Stocktaking->create(false);
                            $this->Stocktaking->save($data);
                        }
                    }
                }
                $this->Session->setFlash('登録完了しました','flash_success');
                $this->redirect($this->referer());
            }else{
                # パラメータ
                $date = $this->params['url']['date'];
                $associations = $this->Association->find('all');
                if($date!=null){
                    $this->set("date", $date);
                    $month = date('Y-m', strtotime($date));
                    # 店内経費
                    $var = array(0=>array("name"=>"野菜", "store_id"=>25), 1=>array("name"=>"ネタ", "store_id"=>26), 2=>array("name"=>"飲料", "store_id"=>33), 3=>array("name"=>"調味料", "store_id"=>36), 4=>array("name"=>"消耗品", "store_id"=>39));
                    foreach($var as $v){
                        $expenses_types = $this->ExpenseType->find('all', array(
                            'conditions' => array('ExpenseType.name' => $v['name']),
                        ));
                        if($expenses_types!=null){
                            foreach($expenses_types as $expenses_type){
                                # location_id=>association_id
                                $location_id = $expenses_type['ExpenseType']['location_id'];
                                $associations = $this->Association->find('all', array('conditions' => array('Association.location_id' => $location_id)));
                                $association_id_arr = array();
                                foreach($associations as $association){
                                    $association_id_arr[] = $association['Association']['id'];
                                }
                                $cnt = count($association_id_arr);
                                $type_id = $expenses_type['ExpenseType']['id'];
                                $expenses = $this->Expense->find('all', array(
                                    'conditions' => array('Expense.type_id' => $type_id, 'Expense.working_day LIKE' => '%'.$month.'%')
                                ));
                                if($expenses!=null){
                                    $total_fee = 0;
                                    foreach($expenses as $expense){
                                        $fee = $expense['Expense']['fee'];
                                        $total_fee += $fee;
                                    }
                                    foreach($association_id_arr as $association_id){
                                        # 既存チェック
                                        $kaikake_fee = $this->KaikakeFee->find('first', array(
                                            'conditions' => array('KaikakeFee.association_id' => $association_id, 'KaikakeFee.store_id' => $v["store_id"], 'KaikakeFee.working_month LIKE' => '%'.$date.'%')
                                        ));
                                        if($kaikake_fee!=null){
                                            $data = array('KaikakeFee' => array(
                                                'id' => $kaikake_fee['KaikakeFee']['id'],
                                                'fee' => $total_fee/$cnt
                                            ));
                                        }else{
                                            $data = array('KaikakeFee' => array(
                                                'association_id' => $association_id,
                                                'store_id' => $v["store_id"],
                                                'working_month' => $date,
                                                'fee' => $total_fee/$cnt
                                            ));
                                        }
                                        #ループ実行文
                                        $this->KaikakeFee->create(false);
                                        $this->KaikakeFee->save($data);
                                    }
                                }
                            }
                        }
                    }
                    # 支出先
                    $kaikake_arr = array();
                    $kaikake_stores = $this->KaikakeStore->find('all', array(
                        'order' => ['KaikakeStore.rank']
                    ));
                    $associations = $this->Association->find('all');
                    $this->set("association_arr", $associations);
                    foreach($kaikake_stores as $kaikake_store){
                        $kaikake_fees = $this->KaikakeFee->find('all', array(
                            'conditions' => array('KaikakeFee.store_id' => $kaikake_store['KaikakeStore']['id'], 'KaikakeFee.working_month LIKE' => '%'.$date.'%'),
                            'order' => array('KaikakeFee.association_id' => 'asc')
                        ));
                        if($kaikake_fees!=null){
                            $total = 0;
                            foreach($kaikake_fees as $kaikake_fee){
                                $kaikake_store['Today'][$kaikake_fee['KaikakeFee']['association_id']] = $kaikake_fee;
                                $total += $kaikake_fee['KaikakeFee']['fee'];
                            }
                            $kaikake_store['Total'] = $total;
                        }
                        # デフォ設定
                        foreach($associations as $association){
                            $id = $association['Association']['id'];
                            $intermediate_one = $this->IntermediateOne->find('first', array(
                                'conditions' => array('IntermediateOne.store_id' => $kaikake_store['KaikakeStore']['id'], 'IntermediateOne.association_id' => $id)
                            ));
                            if($intermediate_one!=null){
                                $kaikake_store['IntermediateOne'][$id] = true;
                            }else{
                                $kaikake_store['IntermediateOne'][$id] = false;
                            }
                        }
                        $kaikake_arr[] = $kaikake_store;
                    }
                    //debug($kaikake_arr);
                    $this->set("kaikake_stores", $kaikake_arr);
                    # 棚卸額
                    $association_arr = array();
                    foreach($associations as $association){
                        $association_arr[$association['Association']['id']] = $association;
                    }
                    $this->set("associations", $association_arr);
                    $stocking_types = $this->StocktakingType->find('all');
                    if($stocking_types!=null){
                        $data_set = array();
                        foreach($stocking_types as $stocking_type){
                            # 既存レコード
                            foreach($association_arr as $association){
                                # 初期化
                                $stocking_type['ThisMonth'] = null;
                                $stocktaking = $this->Stocktaking->find('first', array(
                                    'conditions' => array('Stocktaking.association_id' => $association['Association']['id'], 'Stocktaking.type_id' => $stocking_type['StocktakingType']['id'], 'Stocktaking.working_month LIKE' => '%'.$date.'%')
                                ));
                                if($stocktaking!=null){
                                    $stocking_type['ThisMonth'] = $stocktaking;
                                }
                                $data_set[$association['Association']['id']][] = $stocking_type;
                            }
                        }
                        $this->set("stocking_types", $data_set);
                    }else{
                        echo "Category Error!!";
                        exit;
                    }
                }else{
                    echo "Error:Param Query Error!!";
                    exit;
                }
            }
        }
    }

    public function report_card(){
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }
        else {
            # Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
            # 使用Model
            $this->loadModel("StocktakingType");
            $this->loadModel("Stocktaking");
            $this->loadModel("Association");
            $this->loadModel("KaikakeStore");
            $this->loadModel("KaikakeFee");
            $this->loadModel("IntermediateOne");
            $this->loadModel("IntermediateThree");
            $this->loadModel("TotalSales");
            $this->loadModel("Location");
            $this->loadModel("Sales");
            $this->loadModel("ExpenseDfFee");
            $this->loadModel("ExpenseDfType");
            $this->loadModel("MonthlySalary");
            $this->loadModel("MonthlyExpense");
            $this->loadModel("MonthlyExpenseType");
            # アソシ二段階
            $this->KaikakeFee->recursive = 2;
            $this->Sales->recursive = 2;
            # POST
            if($this->request->is('post')){
                $this->Session->setFlash('登録完了しました','flash_success');
                $this->redirect($this->referer());
            }else{
                # パラメータ
                $date = $this->params['url']['date'];
                # Associations
                $locations = $this->Location->find('all');
                $associations = $this->Association->find('all');
                $this->set("associations", $associations);
                $stocktaking_types = $this->StocktakingType->find('all');
                # 各種データ取得
                if($date!=null){
                    $this->set("date", $date);
                    $month = date('Y-m', strtotime($date));
                    # 売上（池袋・赤羽・和光２店舗）
                    $sales_arr = array();
                    # レシートサマリ
                    foreach($associations as $association){
                        $receipt_summary = $this->ReceiptSummary->monthlySummarize($association['Location']['id'], $month, $association['Attribute']['brand']);
                        $sales_arr[$association['Association']['id']] = $receipt_summary;
                    }
                    $this->set("summaries", $sales_arr);
                    # 給料手当
                    $part_arr = [];$full_arr = [];$fukuri_arr = [];
                    $style_arr = array(0=>"full", 1=>"part", 2=>"fukuri");
                    foreach($associations as $association){
                        $id = $association['Association']['id'];
                        foreach($style_arr as $style){
                            $monthly_salary = $this->MonthlySalary->find('first', array(
                                'conditions' => array('MonthlySalary.association_id' => $id, 'MonthlySalary.style' => $style, 'MonthlySalary.working_month LIKE' => '%'.$month.'%')
                            ));
                            # Empty処理
                            if($monthly_salary==null){
                                $location['Location'] = $association['Location'];
                                $value = 0;
                                # Insert
                                $data = array('MonthlySalary' => array(
                                    'association_id' => $id,
                                    'style' => $style,
                                    'working_month' => $date,
                                    'fee' => floor($value)
                                ));
                                $this->MonthlySalary->create(false);
                                $this->MonthlySalary->save($data);
                                # 再取得
                                $monthly_salary = $this->MonthlySalary->find('first', array(
                                    'conditions' => array('MonthlySalary.association_id' => $id, 'MonthlySalary.style' => $style, 'MonthlySalary.working_month' => $date)
                                ));
                            }
                            # 配列きりかえ
                            if($style=="part"){
                                if(isset($monthly_salary['MonthlySalary']['fee'])){
                                    $part_arr[$id] = $monthly_salary['MonthlySalary']['fee'];
                                }
                                else{
                                    $part_arr[$id] = 0;
                                }
                            }
                            elseif($style=="full"){
                                if(isset($monthly_salary['MonthlySalary']['fee'])){
                                    $full_arr[$id] = $monthly_salary['MonthlySalary']['fee'];
                                }
                                else{
                                    $full_arr[$id] = 0;
                                }
                            }
                            elseif($style=="fukuri"){
                                if(isset($monthly_salary['MonthlySalary']['fee'])){
                                    $fukuri_arr[$id] = $monthly_salary['MonthlySalary']['fee'];
                                }
                                else{
                                    $fukuri_arr[$id] = 0;
                                }
                            }
                        }
                    }
                    $this->set("full_salary", $full_arr);
                    $this->set("part_salary", $part_arr);
                    $this->set("fukuri", $fukuri_arr);
                    # 買掛支払
                    $kaikake_arr = array();
                    foreach($stocktaking_types as $stocktaking_type){
                        foreach($associations as $association){
                            $kaikake_fees = $this->KaikakeFee->find('all', array(
                                'conditions' => array('KaikakeFee.association_id' => $association['Association']['id'], 'KaikakeFee.working_month LIKE' => '%'.$month.'%')
                            ));
                            foreach($kaikake_fees as $kaikake_fee){
                                if($stocktaking_type['StocktakingType']['id']==$kaikake_fee['Store']['Type']['id']){
                                    if(!isset($kaikake_arr[$stocktaking_type['StocktakingType']['name']][$association['Association']['id']])){
                                        $kaikake_arr[$stocktaking_type['StocktakingType']['name']][$association['Association']['id']] = 0;
                                    }
                                    $kaikake_arr[$stocktaking_type['StocktakingType']['name']][$association['Association']['id']] += $kaikake_fee['KaikakeFee']['fee'];
                                }
                            }
                            $stocktaking = $this->Stocktaking->find('first', array(
                                'conditions' => array('Stocktaking.association_id' => $association['Association']['id'], 'Stocktaking.type_id' => $stocktaking_type['StocktakingType']['id'], 'Stocktaking.working_month LIKE' => '%'.$month.'%')
                            ));
                            if($stocktaking!=null){
                                $diff = $stocktaking['Stocktaking']['last_month']-$stocktaking['Stocktaking']['this_month'];
                                //debug($kaikake_arr[$stocktaking_type['StocktakingType']['name']][$association['Association']['id']]);
                                if(isset($kaikake_arr[$stocktaking_type['StocktakingType']['name']][$association['Association']['id']])){
                                    $kaikake_arr[$stocktaking_type['StocktakingType']['name']][$association['Association']['id']] += $diff;
                                }
                            }
                        }
                    }
                    $kaikake_total = array();$kaikake_total2 = array();
                    foreach($kaikake_arr as $key => $kaikake){
                        if($key!="消耗品"&&$key!="その他"){
                            foreach($kaikake as $id => $k){
                                if(isset($kaikake_total[$id])){
                                    $kaikake_total[$id] += $k;
                                }else{
                                    $kaikake_total[$id] = $k;
                                }
                            }
                        }else{
                            foreach($kaikake as $id => $k){
                                if(!isset($kaikake_total2[$id])){
                                    $kaikake_total2[$id] = 0;
                                }
                                $kaikake_total2[$id] += $k;
                            }
                        }
                    }
                    $this->set("kaikake_total", $kaikake_total);
                    $this->set("kaikake_total2", $kaikake_total2);
                    $this->set("kaikake", $kaikake_arr);
                    # その他
                    $other_arr = array();
                    $associations = $this->Association->find('all');
                    $kaikake_stores = $this->KaikakeStore->find('all', array(
                        'conditions' => array('KaikakeStore.type_id' => 6)
                    ));
                    if($kaikake_stores!=null){
                        foreach($kaikake_stores as $kaikake_store){
                            foreach($associations as $association){
                                $kaikake_fee = $this->KaikakeFee->find('first', array(
                                    'conditions' => array('KaikakeFee.store_id' => $kaikake_store['KaikakeStore']['id'], 'KaikakeFee.association_id' => $association['Association']['id'], 'KaikakeFee.working_month LIKE' => '%'.$month.'%')
                                ));
                                if($kaikake_fee!=null){
                                    $name = $kaikake_store['KaikakeStore']['name'];
                                    if($name=="ゴキブリ(ダスキン早稲田)"||$name=="ゴキブリ(ダスキン城北)"){
                                        $name = "害虫駆除";
                                    }
                                    if(!isset($other_arr[$name][$association['Association']['id']])){
                                        $other_arr[$name][$association['Association']['id']] = 0;
                                    }
                                    $other_arr[$name][$association['Association']['id']] += $kaikake_fee['KaikakeFee']['fee'];
                                }else{
                                    $name = $kaikake_store['KaikakeStore']['name'];
                                    if($name!="ゴキブリ(ダスキン早稲田)"&&$name!="ゴキブリ(ダスキン城北)"){
                                        $other_arr[$kaikake_store['KaikakeStore']['name']][$association['Association']['id']] = 0;
                                    }
                                }
                            }
                        }
                    }
                    $this->set("other", $other_arr);
                    # 定額支出
                    $expense_df_types = $this->ExpenseDfType->find('all', array(
                        'order' => array('ExpenseDfType.rank')
                    ));
                    $data_set = array();
                    $total_arr = array();
                    if($expense_df_types!=null){
                        foreach($expense_df_types as $expense_df_type){
                            $data_set2 = array();
                            foreach($expense_df_type['Intermediate'] as $intermediate_three){
                                $association_id = $intermediate_three['association_id'];
                                $history = $this->ExpenseDfFee->find('first', array(
                                    'conditions' => array('ExpenseDfFee.association_id' => $association_id, 'ExpenseDfFee.type_id' => $expense_df_type['ExpenseDfType']['id'], 'ExpenseDfFee.working_month LIKE' => '%'.$month.'%'),
                                    'order' =>  array('ExpenseDfFee.association_id' => 'asc')
                                ));
                                if($history!=null){
                                    $intermediate_three['ThisMonth'] = $history;
                                    # Total
                                    if(isset($total_arr[$association_id])){
                                        $total_arr[$association_id] += $history['ExpenseDfFee']['fee'];
                                    }else{
                                        $total_arr[$association_id] = $history['ExpenseDfFee']['fee'];
                                    }
                                }
                                $data_set2[] = $intermediate_three;
                            }
                            $expense_df_type['Intermediate'] = $data_set2;
                            $data_set[] = $expense_df_type;
                        }
                    }
                    $this->set("expense", $data_set);
                    $this->set("total_expense", $total_arr);
                    #################################################################################################################################
                    # 店内経費
                    $result_arr = array();$expense_arr = array();$total_expense_arr = array();
                    $monthly_expense_types = $this->MonthlyExpenseType->find('all');
                    foreach($locations as $location){
                        $result = $this->expenseCalculator($location, $month);
                        # ゴミ（exception）
                        if($location['Location']['name']=='和光店'){
                            $result['expense']['ゴミ'] = 43200;
                        }
                        $associations = $this->Association->convertLocationToAssociation($location);$cnt=count($associations);
                        foreach($associations as $association){
                            $id = $association['Association']['id'];
                            # 既存チェック
                            foreach($monthly_expense_types as $monthly_expense_type){
                                $type_id = $monthly_expense_type['MonthlyExpenseType']['id'];
                                $type_name = $monthly_expense_type['MonthlyExpenseType']['name'];
                                $history = $this->MonthlyExpense->find('first', array(
                                    'conditions' => array('MonthlyExpense.association_id' => $id, 'MonthlyExpense.type_id' => $type_id, 'MonthlyExpense.working_month LIKE' => '%'.$month.'%'),
                                    'order' =>  array('MonthlyExpense.association_id')
                                ));
                                if($history!=null){
                                    $expense_arr[$type_name][$id] = $history;
                                    if(isset($result['expense'][$type_name])){
                                        $fee=$result['expense'][$type_name]/$cnt;
                                        # コピー（exception）
                                        if($type_name=="コピー"){$fee+=2000/$cnt;}
                                        $data = array('MonthlyExpense' => array(
                                            'id' => $history['MonthlyExpense']['id'],
                                            'fee' => $fee
                                        ));
                                        $this->MonthlyExpense->create(false);
                                        $this->MonthlyExpense->save($data);
                                        # 再取得
                                        $monthly_expense = $this->MonthlyExpense->find('first', array(
                                            'conditions' => array('MonthlyExpense.association_id' => $id, 'MonthlyExpense.type_id' => $type_id, 'MonthlyExpense.working_month' => $date)
                                        ));
                                    }
                                    $expense_arr[$type_name][$id] = $monthly_expense;
                                }else{
                                    $monthly_expense=0;
                                    if(isset($result['expense'][$type_name])){
                                        $fee=$result['expense'][$type_name]/$cnt;
                                        # コピー（exception）
                                        if($type_name=="コピー"){ $fee+=2000; }
                                        # Insert
                                        $data = array('MonthlyExpense' => array(
                                            'association_id' => $id,
                                            'type_id' => $type_id,
                                            'working_month' => $date,
                                            'fee' => $fee
                                        ));
                                        $this->MonthlyExpense->create(false);
                                        $this->MonthlyExpense->save($data);
                                        # 再取得
                                        $monthly_expense = $this->MonthlyExpense->find('first', array(
                                            'conditions' => array('MonthlyExpense.association_id' => $id, 'MonthlyExpense.type_id' => $type_id, 'MonthlyExpense.working_month' => $date)
                                        ));
                                    }
                                    $expense_arr[$type_name][$id] = $monthly_expense;
                                }
                                # Total
                                if(!isset($total_expense_arr[$id])){ $total_expense_arr[$id] = 0; }
                                $total_expense_arr[$id] += $expense_arr[$type_name][$id]['MonthlyExpense']['fee'];
                            }
                        }
                    }
                    //debug($expense_arr);
                    $this->set("tennai", $result_arr);
                    $this->set("tennai2", $expense_arr);
                    $this->set("total_tennai2", $total_expense_arr);
                    #################################################################################################################################
                }

            }
        }
    }

    #給料計算Func
    public function salesCalculator($location, $month){
        # 使用モデル
        $this->loadModel('Member');
        $this->loadModel('Payroll');
        $this->loadModel('AttendanceResult');
        $this->loadModel('CustomerCount');
        $this->loadModel('OtherInformation');
        $this->loadModel('Target');
        $this->loadModel('SalesLunch');

        # 曜日配列
        $weekday = array("日", "月", "火", "水", "木", "金", "土");
        ######################################２店舗用###############################################
        if($location['Location']['name']=='和光店'){
            $part = 0;$full = array();$exception = 0;
            #全従業員
            $members = $this->Member->getMemberByLocationId($location['Location']['id']);
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
            foreach($members as $member) {
                if($member['Type']['name']=="アルバイト") {
                    $attendance_results = $this->AttendanceResult->find('all', array(
                        'conditions' => array('AttendanceResult.location_id' => $location['Location']['id'], 'AttendanceResult.working_day LIKE' => '%'.$month.'%', 'AttendanceResult.member_id' => $member['Member']['id'])
                    ));
                    if($attendance_results!=null) {
                        # 給与金額
                        $salary_arr = array();
                        $salary_arr['weekday']['normal'] = 0;$salary_arr['weekday']['late'] = 0;$salary_arr['weekend']['normal'] = 0;$salary_arr['weekend']['late'] = 0;
                        $special_fee = 0;$compensation = 0;$makanai = 0;
                        if(count($attendance_results) < 16){    //日ごと
                            if($member['Member']['compensation_daily']!=0){
                                $compensation = count($attendance_results)*$member['Member']['compensation_daily'];
                            }else{
                                $compensation = (int)$member['Member']['compensation_monthly'];
                            }
                        }elseif(count($attendance_results) >= 16){   //定期
                            if($member['Member']['compensation_monthly']!=0){
                                #定期の方が高かったら,日割り
                                if($member['Member']['compensation_monthly'] > count($attendance_results)*$member['Member']['compensation_daily']&&$member['Member']['compensation_daily']!=0){
                                    $compensation = count($attendance_results)*$member['Member']['compensation_daily'];
                                }else{
                                    $compensation = (int)$member['Member']['compensation_monthly'];
                                }
                            }else{
                                $compensation = count($attendance_results)*$member['Member']['compensation_daily'];
                            }
                        }
                        # 交通費補正
                        if($compensation > 10000){
                            #特定の従業員除外
                            if($member['Member']['id']!=30){
                                $compensation = 10000;
                            }
                        }
                        foreach($attendance_results as $attendance_result){
                            #曜日取得
                            $working_day = $attendance_result['AttendanceResult']['working_day'];
                            $day = $weekday[date('w', strtotime($working_day))];
                            #平日or休日判定（休日なら時給1.25倍）
                            $result = array_key_exists($working_day, $datas);
                            #勤怠管理時時給
                            if($attendance_result['AttendanceResult']['day_hourly_wage']!=0){
                                $day_hourly_wage = $attendance_result['AttendanceResult']['day_hourly_wage'];
                            }else{
                                $day_hourly_wage = $member['Member']['hourly_wage'];
                            }
                            if ($result==true || $day=='日' || $day=='土') {
                                $hourly_wage = $day_hourly_wage+50;
                                $flag = 1;//休日フラグ
                            }else{
                                $hourly_wage = $day_hourly_wage;
                                $flag = 2;//平日フラグ
                            }
                            #休日
                            if($flag==1){
                                #給与
                                $salary_arr['weekend']['normal'] += $hourly_wage*$attendance_result['AttendanceResult']['hours'];
                                $salary_arr['weekend']['late'] += $attendance_result['AttendanceResult']['late_hours']*floor($hourly_wage*1.25);
                            }
                            #平日
                            elseif($flag==2){
                                #給与
                                $salary_arr['weekday']['normal'] += $hourly_wage*$attendance_result['AttendanceResult']['hours'];
                                $salary_arr['weekday']['late'] += $attendance_result['AttendanceResult']['late_hours']*floor($hourly_wage*1.25);
                            }
                            else{
                                echo "ERROR:Holiday";
                                exit;
                            }
                            #大入り判定
                            $w_arr = array( "日" => "bonus_four", "土" => "bonus_three", "金" => "bonus_two", "木" => "bonus_one", "水" => "bonus_one", "火" => "bonus_one", "月" => "bonus_one" );
                            $timezone = $this->AttendanceResult->judgeLunchDinner($attendance_result);	//勤務時間帯
                            if($timezone=='lunch'||$timezone=='dinner'){
                                $target = $this->Target->find('first', array(
                                    'conditions' => array('Target.location_id' => $location['Location']['id'], 'Target.working_month' => $month.'-01', 'Target.type' => $timezone)
                                ));
                                if($target!=null){
                                    # 祝日判定
                                    if($result==true){
                                        if($sales_arr[$working_day][$timezone]>=(int)$target['Target']['bonus_five']){
                                            $special_fee += 300;
                                            $special_days[$working_day][$timezone] = $sales_arr[$working_day][$timezone];
                                        }
                                    }else{
                                        if($sales_arr[$working_day][$timezone]>=(int)$target['Target'][$w_arr[$day]]){
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
                                            if($sales_arr[$working_day][$type]>=(int)$target['Target']['bonus_five']){
                                                if($f==0){
                                                    $special_fee += 300;
                                                    $f = 300;
                                                }
                                                $special_days[$working_day][$type] = $sales_arr[$working_day][$type];
                                            }
                                        }else{
                                            if($sales_arr[$working_day][$type]>=(int)$target['Target'][$w_arr[$day]]){
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
                        if($member['Member']['id']==30){
                            $exception = floor($salary_arr['weekday']['normal'])+floor($salary_arr['weekend']['normal'])+floor($salary_arr['weekday']['late'])+floor($salary_arr['weekend']['late'])+floor($compensation)+floor($special_fee);
                        }
                        $part += floor($salary_arr['weekday']['normal']);
                        $part += floor($salary_arr['weekend']['normal']);
                        $part += floor($salary_arr['weekday']['late']);
                        $part += floor($salary_arr['weekend']['late']);
                        $part += floor($compensation);
                        $part += floor($special_fee);
                    }
                }
                elseif($member['Type']['name']=="社員"){
                    $member_id = $member['Member']['id'];
                    if(isset($full[$member['Member']['attribute_id']])){
                        $full[$member['Member']['attribute_id']] += $member['Member']['compensation_monthly'];
                        $full[$member['Member']['attribute_id']] += $member['Member']['hourly_wage'];
                    }else{
                        $full[$member['Member']['attribute_id']] = (int)$member['Member']['compensation_monthly'];
                        $full[$member['Member']['attribute_id']] = (int)$member['Member']['hourly_wage'];
                    }
                }
            }

            return array('part'=>$part, 'full'=>$full, 'exception'=>$exception);
        }
        else {##################################１店舗用###################################################
            $part =0;$full = 0;
            #全従業員
            $members = $this->Member->getMemberByLocationId($location['Location']['id']);
            #エクセルnum
            $num = 5;
            foreach($members as $member){
                if($member['Type']['name']=="アルバイト"){
                    $attendance_results = $this->AttendanceResult->find('all', array(
                        'conditions' => array('AttendanceResult.location_id' => $location['Location']['id'], 'AttendanceResult.working_day LIKE' => '%'.$month.'%', 'AttendanceResult.member_id' => $member['Member']['id'])
                    ));
                    if($attendance_results!=null){
                        #パラメータ初期化
                        $hours = 0;
                        $late_hours = 0;
                        $special_fee = 0;
                        #20150807追記
                        $salaries = 0;
                        $late_salaries = 0;
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
                            $compensation = 10000;
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
                        }
                        $part += $salaries;$part += $late_salaries;$part += $compensation;
                        if($location['Location']['id']!=2){$part+=$special_fee;}
                    }
                }elseif($member['Type']['name']=="社員"){
                    $member_id = $member['Member']['id'];
                    $full += $member['Member']['compensation_monthly'];
                    $full += $member['Member']['hourly_wage'];

                    # 大入り（池袋のみ）
                    if($location['Location']['name']=="池袋店"){
                        $total_sales = $this->TotalSales->find('all', array(
                            'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%'.$month.'%', 'sales >' => '400000')
                        ));
                        # 公休チェック
                        if($total_sales!=null){
                            foreach($total_sales as $total_sales_one){
                                $working_day = $total_sales_one['TotalSales']['working_day'];
                                $other = $this->OtherInformation->find('first', array(
                                    'conditions' => array('OtherInformation.location_id' => $location['Location']['id'], 'OtherInformation.working_day' => $working_day)
                                ));
                                if($other['OtherInformation']['absence_one_id']!=$member_id&&$other['OtherInformation']['absence_two_id']!=$member_id&&$other['OtherInformation']['absence_three_id']!=$member_id){
                                    $full+=500;
                                }
                            }
                        }
                    }

                }
            }
            return array('part'=>(int)$part, 'full'=>(int)$full, 'total'=>(int)$part+$full);
        }
    }

    # 店内経費計算Func
    public function expenseCalculator($location, $month){
        # 使用モデル
        $this->loadModel("TotalSales");
        $this->loadModel("Expense");
        $this->loadModel("ExpenseType");
        $this->loadModel("OtherDiscount");
        # 10%割引andポイント
        $total_sales = $this->TotalSales->find('all', array(
            'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%'.$month.'%')
        ));
        $coupon=0;$discount=0;$points=0;$discounts=0;
        foreach ($total_sales as $total_sales_one) {
            # 営業日
            $working_day = $total_sales_one['TotalSales']['working_day'];
            $coupon+=$total_sales_one['TotalSales']['coupon_discounts'];
            $discount+=$total_sales_one['TotalSales']['other_discounts'];
            # その他割引
            $other_discounts = $this->OtherDiscount->find('all', array(
                'conditions' => array('OtherDiscount.location_id' => $location['Location']['id'], 'OtherDiscount.working_day' => $working_day)
            ));
            # ポイントor端数累計計算
            foreach ($other_discounts as $other_discount){
                if($other_discount['OtherType']['name']=="ポイント"){
                    $points+=(int)$other_discount['OtherDiscount']['fee'];
                }
                elseif($other_discount['OtherType']['name']=="サービス（端数割引）"){
                    $discounts+=(int)$other_discount['OtherDiscount']['fee'];
                }
            }
        }
        //debug($coupon);debug($discount);
        # 支出
        $expense_types = $this->ExpenseType->find('all', array(
            'conditions' => array('ExpenseType.location_id' => $location['Location']['id'])
        ));
        $expense_arr = array();
        foreach($expense_types as $expense_type){
            $name = $expense_type['ExpenseType']['name'];
            if($name!="野菜"&&$name!="ネタ"&&$name!="消耗品"&&$name!="調味料"&&$name!="飲料"&&$name!="ゴキブリ"&&$name!="ネット"&&$name!="工事費"){
                $expenses = $this->Expense->find('all', array(
                    'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.type_id' => $expense_type['ExpenseType']['id'], 'Expense.working_day LIKE' => '%'.$month.'%')
                ));
                $expense_arr[$name] = 0;
                if($expenses!=null){
                    foreach($expenses as $expense){
                        $expense_arr[$expense['Type']['name']] += $expense['Expense']['fee'];
                    }
                }
            }
        }
        return array('coupon'=>$coupon, 'point'=>$points, 'discount'=>$discounts, 'expense'=>$expense_arr);

    }

    public function export(){
        # POST
        if($this->request->is('post')) {
            # パラメータ
            $data = $this->request->data;
            $month = $data['month'];$date = $month.'-01';
            // エクセル出力用ライブラリ
            App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
            App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
            // Excel2007形式(xlsx)テンプレートの読み込み
            $reader = PHPExcel_IOFactory::createReader('Excel2007');
            $template = realpath(TMP);
            $template .= '/excel/';
            # ファイル切り替え
            if($this->request->data['data_type']==1){
                $data_name = 'stocktaking';$jp_name = "棚卸表";
                $templatePath = $template.$data_name.'.xlsx';
                $obj = $reader->load($templatePath);
                # sheet 1
                $obj->setActiveSheetIndex(0)
                    ->setCellValue('B2', date('Y年m月', strtotime($date)));
                $sheet = $obj->getActiveSheet();
                $sheet->setTitle(date('Y年m月', strtotime($date)));

                # 棚卸
                $this->loadModel("Stocktaking");
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
                        ->setCellValue('G'.$r, $a['last'][4]);
                    $r++;
                    # this
                    $obj->setActiveSheetIndex(0)
                        ->setCellValue('D'.$r, $a['this'][1])
                        ->setCellValue('E'.$r, $a['this'][2])
                        ->setCellValue('F'.$r, $a['this'][3])
                        ->setCellValue('G'.$r, $a['this'][4]);
                    $r++;
                }

            }
            else{
                echo "ERROR:EXCEL FILE ERROR";
                exit;
            }
            // Excel2007
            $filename = $jp_name.'-'.date('Y年m月', strtotime($date)).'.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=$filename");
            header('Cache-Control: max-age=0');
            $writer = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
            $writer->save('php://output');
            exit;
        }

    }

    public function line(){

    }

    public function jikantaibetsu(){
        $working_day = '2016-10-01';
        $location_id = 3;
        $this->sales($working_day, $location_id);
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
        $result[$working_day]['lunch'] = $sales_lunches[0][0]['sum'];
        $result[$working_day]['dinner'] = $total_sales['TotalSales']['sales'];
        return $result;
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

    public function labor($working_day, $location_id){
        $hours = array('11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00', '23:00:00', '24:00:00');
        $result = array();
        foreach($hours as $hour){
            $time = $working_day.' '.$hour;
            $attendances = $this->Attendance->find('all', array(
                'conditions' => array('Attendance.location_id' => $location_id, 'Attendance.working_day' => $working_day, 'Attendance.type_id' => 1, 'Attendance.time <'=> $time),
                'recursive'=> 1
            ));
            if($attendances!=null){
                foreach($attendances as $attendance){
                    # アルバイトのみ
                    if($attendance['Member']['type_id']!=1&&$attendance['Member']['type_id']!=3&&$attendance['Member']['type_id']!=5){
                        $member_id=$attendance['Attendance']['member_id'];
                        $end = $this->Attendance->find('first', array(
                            'conditions' => array('Attendance.location_id' => $location_id, 'Attendance.member_id' => $member_id, 'Attendance.working_day' => $working_day, 'Attendance.type_id' => 2, 'Attendance.time >'=> $time)
                        ));
                        if($end!=null){
                            $pose = $this->Attendance->find('all', array(
                                'conditions' => array('Attendance.location_id' => $location_id, 'Attendance.member_id' => $member_id, 'Attendance.working_day' => $working_day, 'OR' => array(array('Attendance.type_id' => 3),array('Attendance.type_id' => 4))),
                                'order' => array('Attendance.time' => 'asc')
                            ));
                            $m = 0;$hall=0;$kitchen=0;
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
                                        //debug($time);debug($array);debug($m);
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
                            #計算
                            if(!isset($result[$working_day][$hour]['fee'])){
                                $result[$working_day][$hour]['fee'] = $hourly_wage*$m;
                            }
                            else{
                                $result[$working_day][$hour]['fee'] += $hourly_wage*$m;
                            }
                            #ポジション
                            if($m>0){
                                if($attendance_result['Member']['Position']['name']=='ホール'){
                                    $hall++;
                                }
                                elseif($attendance_result['Member']['Position']['name']=='キッチン'){
                                    $kitchen++;
                                }
                            }
                            if(!isset($result[$working_day][$hour]['hall'])){$result[$working_day][$hour]['hall'] = $hall;} else{$result[$working_day][$hour]['hall'] += $hall;}
                            if(!isset($result[$working_day][$hour]['kitchen'])){$result[$working_day][$hour]['kitchen'] = $kitchen;} else{$result[$working_day][$hour]['kitchen'] += $kitchen;}
                        }
                    }
                }
            }
        }
        return $result;
    }

}
