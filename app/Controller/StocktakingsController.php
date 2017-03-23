<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/23
 * Time: 12:24
 */
class StocktakingsController extends AppController{
    #フォームヘルパー
    public $helpers = array('Html', 'Form');
    #Cookieの使用
    var $components = array('Cookie');

    #共通スクリプト
    public function beforeFilter(){
        #ページタイトル設定
        parent::beforeFilter();
        $this->set('title_for_layout', '月別棚卸入力');
        #使用モデル
        $this->loadModel("Location");
        #ログイン処理
        if(!$this->Cookie->check('myData')){
            #loginページへ
            $this->redirect(array('controller'=>'locations','action'=>'login'));
        }else{
            #クッキー値
            $location = $this->Location->findById($this->Cookie->read('myData'));
            $this->set('location', $location);
        }
    }

    #カレンダー
    public function index(){
        #クッキー値
        $location = $this->Location->findById($this->Cookie->read('myData'));
        $this->set('location', $location);
        #月
        $month = $this->params['url']['month'];
        if($month!=null){
            $this->set('month', $month);
            #棚卸カテゴリー
            $this->loadModel("StocktakingType");
            $stocking_types = $this->StocktakingType->find('all');
            if($stocking_types!=null){
                $data_set = array();
                foreach($stocking_types as $stocking_type){
                    $stocktaking = $this->Stocktaking->find('first', array(
                        'conditions' => array('Stocktaking.location_id' => $location['Location']['id'], 'Stocktaking.type_id' => $stocking_type['StocktakingType']['id'], 'Stocktaking.working_month LIKE' => '%'.$month.'%')
                    ));
                    if($stocktaking!=null){
                        $stocking_type['ThisMonth'] = $stocktaking;
                    }
                    $data_set[] = $stocking_type;
                }
                $this->set("stocking_types", $data_set);
            }else{
                echo "Category Error!!";
                exit;
            }
        }else{
            echo "Month Error!!";
            exit;
        }

    }

    #編集
    public function edit(){
        #クッキー値
        $location = $this->Location->findById($this->Cookie->read('myData'));
        $this->set('location', $location);
        $month = $this->request->data['month'];
        $stocktakings = $this->request->data['Stocktaking'];
        if($stocktakings!=null){
            foreach($stocktakings as $key => $stocktaking){
                $history_stocktaking = $this->Stocktaking->find('first', array(
                    'conditions' => array('Stocktaking.location_id' => $location['Location']['id'], 'Stocktaking.type_id' => $key, 'Stocktaking.working_month LIKE' => '%'.$month.'%')
                ));
                if($history_stocktaking!=null){ //既存
                    $data = array('Stocktaking' => array(
                        'id' => $history_stocktaking['Stocktaking']['id'],
                        'last_month' => $stocktaking['last_month'],
                        'this_month' => $stocktaking['this_month']
                    ));
                }else{  //新規
                    $data = array('Stocktaking' => array(
                        'location_id' => $location['Location']['id'],
                        'type_id' => $key,
                        'working_month' => $month.'-01',
                        'last_month' => $stocktaking['last_month'],
                        'this_month' => $stocktaking['this_month']
                    ));
                }
                #ループ実行文
                $this->Stocktaking->create(false);
                $this->Stocktaking->save($data);
            }
        }
        $this->Session->setFlash("棚卸入力を受け付けました。");
        $this->redirect($this->referer());
    }

}
