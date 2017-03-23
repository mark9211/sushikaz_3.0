<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/09/10
 * Time: 0:09
 */
App::uses('Security', 'Utility');

class CustomerProfilesController extends AppController{
    var $scaffold;
    #フォームヘルパー
    public $helpers = array('Html', 'Form');
    #Cookieの使用
    var $components = array('Cookie');
    #共通スクリプト
    public function beforeFilter(){
        #ページタイトル設定
        $this->set('title_for_layout', '顧客専用 | 寿し和');
        #使用モデル
        $this->loadModel("CustomerProfile");
        $this->loadModel("CustomerRecord");
        $this->loadModel("Ttransaction");
        $this->loadModel("Tdepartment");
        $this->loadModel("Attendance");
    }

    #index上書き
    public function index(){
        $this->layout = 'sample';
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('action'=>'login'));
        }else{
            #Session値
            $myData = $this->Session->read('myData');
            if(isset($myData['MemberProfile'])){
                $this->Session->setFlash('従業員アカウントをログアウトしてください','flash_error');
                $this->redirect(array('controller'=>'member_profiles','action'=>'index'));
            }
            $customer_profile=$this->CustomerProfile->findById($myData['CustomerProfile']['id']);$this->set('myData', $customer_profile);
            #顧客ID
            $customer_id = $myData['CustomerProfile']['id'];
            #来店記録
            $customer_records = $this->CustomerRecord->find('all', array(
                'conditions' => array('CustomerRecord.customer_id' => $customer_id),
                'order' => array('CustomerRecord.working_day DESC'),
                'recursive'=>1
            ));
            $lunch=0;$dinner=0;$lunch_pay=0;$dinner_pay=0;$menu=array();
            if($customer_records!=null){
                foreach($customer_records as $customer_record){
                    $working_day =  $customer_record['CustomerRecord']['working_day'];
                    $receipt_number = $customer_record['CustomerRecord']['receipt_number'];
                    $ttransations = $this->Ttransaction->find('all', array(
                        'conditions' => array('Ttransaction.レシート№' => $receipt_number, 'Ttransaction.営業日' => $working_day)
                    ));
                    #ランチーorディナー判定
                    $time = $ttransations[0]['Ttransaction']['会計日時'];$lunch_time = $working_day.' 17:00:00';
                    if(strtotime($time) > strtotime($lunch_time)){ $result='dinner'; } else{ $result='lunch'; }
                    $some=0;
                    foreach($ttransations as $ttransation){
                        #部門コード
                        $department = $this->Tdepartment->find('first', array('conditions' => array('Tdepartment.部門コード' => $ttransation['Ttransaction']['部門コード'])));
                        if($department!=null){
                            $some+=$ttransation['Ttransaction']['金額'];
                            $menu[] = array("location" => $customer_record['Location']['name'],"name" =>$ttransation['Ttransaction']['品名'], "working_day" =>$working_day, "department" => $department['Tdepartment']['部門名'], "num" => $ttransation['Ttransaction']['数量'], "receipt" => $ttransation['Ttransaction']['レシート№']);
                        }
                    }
                    if($result=='lunch'){
                        $lunch++;
                        $lunch_pay+=$some;
                    }
                    elseif($result=='dinner'){
                        $dinner++;
                        $dinner_pay+=$some;
                    }
                }
            }
            $this->set('lunch', $lunch);$this->set('dinner', $dinner);$this->set('total', $lunch+$dinner);
            $this->set('lunch_pay', $lunch_pay);$this->set('dinner_pay', $dinner_pay);$this->set('total_pay', $lunch_pay+$dinner_pay);
            $this->set('customer_records', $customer_records);$this->set('menu', $menu);
        }
    }

    public function login(){
        $this->layout = 'sample';
        #Autocomplete
        $sources = $this->CustomerProfile->find('all', array(
            'fields' => array('CustomerProfile.phone', 'CustomerProfile.kana', 'CustomerProfile.email')
        ));
        $phone=array();$kana=array();$email=array();
        foreach($sources as $source){
            if($source['CustomerProfile']['phone']!=null){
                $phone[] = $source['CustomerProfile']['phone'];
            }
            if($source['CustomerProfile']['kana']!=null){
                $kana[] = $source['CustomerProfile']['kana'];
            }
            if($source['CustomerProfile']['email']!=null){
                $email[] = $source['CustomerProfile']['email'];
            }
        }
        $this->set('phone', json_encode($phone));$this->set('kana', json_encode($kana));$this->set('email', json_encode($email));
        #ログイン処理
        if(!$this->Session->check('myData')){
            if(isset($this->request->data['CustomerProfile'])){  #ログインフォームから
                $customer_profile = "";
                # ポイントカードNo.
                if($this->request->data['CustomerProfile']['card_id']!=null){
                    $card_id = $this->request->data['CustomerProfile']['card_id'];
                    $customer_profile = $this->CustomerProfile->find('first', array(
                        'conditions' => array(
                            'CustomerProfile.card_id' => $card_id
                        )
                    ));
                }
                # 電話番号
                if($this->request->data['CustomerProfile']['phone']!=null){
                    $phone = $this->request->data['CustomerProfile']['phone'];
                    $customer_profile = $this->CustomerProfile->find('first', array(
                        'conditions' => array(
                            'CustomerProfile.phone' => $phone
                        )
                    ));
                }
                # 氏名（カナ）
                elseif($this->request->data['CustomerProfile']['kana']!=null){
                    $kana = $this->request->data['CustomerProfile']['kana'];
                    $customer_profile = $this->CustomerProfile->find('first', array(
                        'conditions' => array(
                            'CustomerProfile.kana' => $kana
                        )
                    ));
                }
                # email
                elseif($this->request->data['CustomerProfile']['email']!=null){
                    $email = $this->request->data['CustomerProfile']['email'];
                    $customer_profile = $this->CustomerProfile->find('first', array(
                        'conditions' => array(
                            'CustomerProfile.email' => $email
                        )
                    ));
                }

                if($customer_profile!=null){
                    $this->Session->write('myData', $customer_profile);
                    $this->redirect(array('action'=>'index'));
                }
                else{
                    $this->Session->setFlash('検索結果が0件です。','flash_error');
                }
            }
        }
        else{
            #indexページへ
            $this->redirect(array('action'=>'index'));
        }
    }

    #edit上書き
    public function edit(){
        if($this->request->is('post')){
            $data = $this->request->data;
            if($this->CustomerProfile->save($data)){
                $this->Session->setFlash('基本情報の編集を完了しました！','flash_success');
            }
            else{
                $this->Session->setFlash('編集中にエラーが発生しました！','flash_error');
            }
            $this->redirect(array('action'=>'index'));
        }
    }

    public function edit_photo(){
        if($this->request->is('post')){
            $data = array('CustomerProfile' => array(
                'id' => $this->request->data['id'],
                'photo' => $this->request->data['photo']
            ));
            if($this->CustomerProfile->save($data)){
                $this->Session->setFlash('アバター写真の編集を完了しました！','flash_success');
            }
            else{
                $this->Session->setFlash('編集中にエラーが発生しました！','flash_error');
            }
            $this->redirect(array('action'=>'index'));
        }
    }

    public function edit_password(){
        if($this->request->is('post')){
            //debug($this->request->data['password']);exit;
            $password = $this->CustomerProfile->findById($this->request->data['id'])['CustomerProfile']['password'];
            //password ハッシュ化
            if($password==Security::hash($this->request->data['password'], 'sha1', true)){
                if($this->request->data['new_password']==$this->request->data['re_new_password']){
                    $data = array('CustomerProfile' => array(
                        'id' => $this->request->data['id'],
                        'password' => $this->request->data['new_password']
                    ));
                    if($this->CustomerProfile->save($data)){
                        $this->Session->setFlash('アバター写真の編集を完了しました！','flash_success');
                    }
                    else{
                        $this->Session->setFlash('編集中にエラーが発生しました！','flash_error');
                    }
                    $this->redirect(array('action'=>'index'));
                }
                else{
                    $this->Session->setFlash('新しいパスワードが正しくありません','flash_error');
                    $this->redirect(array('action'=>'index'));
                }
            }
            else{
                $this->Session->setFlash('現在のパスワードが正しくありません','flash_error');
                $this->redirect(array('action'=>'index'));
            }
        }
    }

    public function add(){
        $this->layout = 'sample';
        if($this->request->is('post')){
            # Profile写真
            $photo = "";
            if(isset($this->request->data['photo'])){
                $photo = $this->request->data['photo'];
            }
            # 生年月日
            $nengo=$this->request->data['nengo'];$year=$this->request->data['year'];$month=$this->request->data['month'];$day=$this->request->data['day'];
            $birthday = $this->warekiSeireki($nengo, $year, $month, $day);
            $data = array('CustomerProfile' => array(
                'card_id' => $this->request->data['card_id'],
                'name' => $this->request->data['name'],
                'kana' => $this->request->data['kana'],
                'email' => $this->request->data['Email'],
                'password' => $this->request->data['password'],
                'gender' => $this->request->data['Gender'],
                'job' => $this->request->data['job'],
                'birthday' => $birthday,
                'phone' => $this->request->data['Phone'],
                'postcode' => $this->request->data['postcode'],
                'address1' => $this->request->data['address1'],
                'address2' => $this->request->data['address2'],
                'address3' => $this->request->data['address3'],
                'address4' => $this->request->data['address4'],
                'time' => $this->request->data['time'],
                'photo' => $photo
            ));
            if($this->CustomerProfile->save($data)){
                $this->Session->setFlash('アカウントを作成しました。','flash_success');
                $this->redirect(array('action'=>'add'));
            }
        }
    }

    #20151006EmailCheck
    public function emailCheck(){
        $this->autoRender = FALSE;
        if($this->request->is('ajax')){
            #table検索
            $customer_profile = $this->CustomerProfile->find('first', array(
                'conditions' => array(
                    'CustomerProfile.email' => $this->data['email']
                )
            ));
            #既存判定
            if($customer_profile==null){
                return 0;
            }else{
                return 1;
            }
        }
    }

    #20161103
    public function warekiSeireki($nengo, $year, $month, $day){
        if($nengo!=null&&$year!=null&&$month!=null&&$day!=null){
            if($month<10){$month = '0'.$month;}
            if($day<10){$day = '0'.$day;}
            $nengo_year = array('H'=>1988, 'S'=>1925);
            $Year = $nengo_year[$nengo] + $year;
            return $Year.'-'.$month.'-'.$day;
        }
        else{
            return null;
        }
    }

    public function logout(){
        $this->Session->delete('myData');
        $this->Session->setFlash('ログアウトしました','flash_success');
        $this->redirect(array('action' => 'login'));
    }

    public function record_add(){
        if($this->request->is('post')){
            $data = $this->request->data;
            #営業日
            //$data['CustomerRecord']['working_day'] = $this->Attendance->judge24Hour(strtotime($data['CustomerRecord']['visit_time']));
            $data['CustomerRecord']['working_day'] = date("Y-m-d", strtotime($data['CustomerRecord']['visit_time']));
            if($this->CustomerRecord->save($data)){
                $this->Session->setFlash('登録を完了しました！','flash_success');
            }
            else{
                $this->Session->setFlash('登録中にエラーが発生しました！','flash_error');
            }
            $this->redirect(array('action'=>'index'));
        }
    }

    public function pointCostCalculator(){
        $this->autoRender = false;
        # 変数
        $location_id = 3;
        $month = date("Y-m",strtotime("-1 month"));
        $customer_records = $this->CustomerRecord->find('all', array(
            'conditions' => array('CustomerRecord.location_id' => $location_id, 'CustomerRecord.working_day LIKE' => '%'.$month.'%')
        ));
        if($customer_records!=null){
            $total=0;
            foreach($customer_records as $customer_record){
                $working_day = $customer_record['CustomerRecord']['working_day'];
                $receipt_number = $customer_record['CustomerRecord']['receipt_number'];
                $options = array(
                    'fields' => array(
                        'sum(Ttransaction.金額) as price'
                    ),
                    'conditions' => array(
                        'Ttransaction.レシート№' => $receipt_number, 'Ttransaction.営業日' => $working_day
                    )
                );
                $ttransation = $this->Ttransaction->find('first', $options);
                $total+=floor($ttransation[0]['price']);
            }
            debug($total);
        }
        else{
            debug('利用履歴が0件です');exit;
        }
    }

    public function couponCostCalculator(){
        $this->autoRender = false;
        # 変数
        $hinban = 2140;
        $month = date("Y-m",strtotime("-1 month"));
        $options = array(
            'fields' => array(
                'Ttransaction.営業日',
                'Ttransaction.レシート№'
            ),
            'conditions' => array(
                'Ttransaction.品番' => $hinban, 'Ttransaction.営業日 LIKE' => '%'.$month.'%'
            ),
            'group' => array('Ttransaction.レシート№')
        );
        $receipt_numbers = $this->Ttransaction->find('all', $options);
        debug($receipt_numbers);
        if($receipt_numbers!=null){
            $total=0;
            foreach($receipt_numbers as $receipt_number){
                $options = array(
                    'fields' => array(
                        'sum(Ttransaction.金額) as price'
                    ),
                    'conditions' => array(
                        'Ttransaction.レシート№' => $receipt_number['Ttransaction']['レシート№'],
                        'Ttransaction.営業日' => $receipt_number['Ttransaction']['営業日'],
                        'NOT' => array('Ttransaction.品名')
                    )
                );
                $sales = $this->Ttransaction->find('first', $options);
                $total+=floor($sales[0]['price']);
            }
            debug($total);
        }
        else{
            debug('利用履歴が0件です');exit;
        }

    }

}
