<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/01/19
 * Time: 21:21
 */
class AdminController extends AppController{
    #フォームヘルパー
    public $helpers = array('Html', 'Form');
    #Cookieの使用
    var $components = array('Cookie');

    #共通スクリプト
    public function beforeFilter(){
        #ページタイトル設定
        parent::beforeFilter();
        $this->set('title_for_layout', '各種設定');
        #使用モデル
        $this->loadModel("Location");
        $this->loadModel("Association");
        $this->loadModel("StocktakingType");
        $this->loadModel("KaikakeStore");
        $this->loadModel("IntermediateOne");
        #ログイン処理
        if(!$this->Session->check('myData')){
            #loginページへ
            $this->redirect(array('controller'=>'member_profiles','action'=>'login'));
        }else{
            #Session値
            $myData = $this->Session->read('myData');
            $this->set('myData', $myData);
        }
    }

    public function index(){
    }

    public function kaikake_store(){
        # GET
        if($this->request->is('get')){
            # 買掛先種別
            $stocktaking_types = $this->StocktakingType->find('all');
            $this->set("stocktaking_types", $stocktaking_types);
            # 買掛先
            $kaikake_stores = $this->KaikakeStore->find('all', array(
                'conditions' => array('KaikakeStore.status' => 'active'),
                'order' => ['KaikakeStore.rank' => 'asc'],
            ));
            $this->set("kaikake_stores", $kaikake_stores);
        }
    }

    public function kaikake_store_add(){
        # POST
        if($this->request->is('post')){
            # パラメーター変数格納
            $rank = $this->request->data['rank'];
            $type_id = $this->request->data['type_id'];
            $name = $this->request->data['name'];
            # Validation
            if(empty($rank)||!is_numeric($rank)){
                $this->Session->setFlash("追加エラー：表示順を正しく設定してください");
                $this->redirect($this->referer());
            }
            if(empty($type_id)||!is_numeric($type_id)){
                $this->Session->setFlash("追加エラー：種類を正しく設定してください");
                $this->redirect($this->referer());
            }
            if(empty($name)){
                $this->Session->setFlash("追加エラー：買掛先名を正しく設定してください");
                $this->redirect($this->referer());
            }
            # INSERT
            $data = array('KaikakeStore' => array(
                'rank' => $rank,
                'type_id' => $type_id,
                'name' => $name,
            ));
            if($this->KaikakeStore->save($data)){
                $this->Session->setFlash("新しい買掛先の追加に成功しました");
            }
            else{
                $this->Session->setFlash("新しい買掛先の追加に失敗しました");
            }
            $this->redirect($this->referer());
        }
    }

    public function kaikake_store_edit(){
        # POST
        if($this->request->is('post')){
            # パラメーター変数格納
            $stores = $this->request->data;
            if($stores!=null){
                foreach($stores as $store_id => $store){
                    $data = array('KaikakeStore' => array(
                        'id' => $store_id,
                        'rank' => $store['rank'],
                        'type_id' => $store['type_id'],
                        'name' => $store['name'],
                    ));
                    # ループ実行文
                    $this->KaikakeStore->create(false);
                    $this->KaikakeStore->save($data);
                }
            }
            $this->Session->setFlash("買掛先の更新に成功しました");
            $this->redirect($this->referer());
        }
    }

    public function kaikake_store_delete(){
        # GET
        if($this->request->is('get')){
            # リファラチェック
            if($this->referer()=='/'){
                throw new NotFoundException('このページは見つかりませんでした');
            }
            if(isset($this->params['url']['id'])){
                $store_id = $this->params['url']['id'];
                # 店舗紐付けデータ削除
                $this->IntermediateOne->deleteAll(array('store_id' => $store_id));
                # Status変更
                $data = array('KaikakeStore' => array(
                    'id' => $store_id,
                    'status' => 'deleted',
                ));
                if($this->KaikakeStore->save($data)){
                    $this->Session->setFlash("買掛先の削除に成功しました");
                }
                else{
                    $this->Session->setFlash("買掛先の削除に失敗しました");
                }
                $this->redirect($this->referer());
            }
        }
    }

    public function intermediate_one(){
        # Post
        if($this->request->is('post')){
            if($this->request->data['tab']!=null){
                foreach($this->request->data['tab'] as $key => $a){
                    # 一度リセット
                    $this->IntermediateOne->deleteAll(array('store_id' => $key));
                    # Insert
                    foreach($a as $b){
                        if($b!=null){
                            $data = array('IntermediateOne' => array(
                                'association_id' => $b,
                                'store_id' => $key,
                            ));
                            #ループ実行文
                            $this->IntermediateOne->create(false);
                            $this->IntermediateOne->save($data);
                        }
                    }
                }
                $this->Session->setFlash('データを保存しました','flash_success');
                $this->redirect(array('action' => 'intermediate_one'));
            }

        }else{
            $stocktaking_types = $this->StocktakingType->find('all');
            $associations = $this->Association->find('all');
            $this->set("associations", $associations);
            $data_set = array();
            foreach($stocktaking_types as $stocktaking_type){
                $kaikake_stores = $this->KaikakeStore->find('all', array(
                    'conditions' => array('KaikakeStore.type_id' => $stocktaking_type['StocktakingType']['id'], 'KaikakeStore.status' => 'active'),
                    'order' => ['KaikakeStore.rank' => 'asc'],
                ));
                $data_set2 = array();
                foreach($kaikake_stores as $kaikake_store){
                    $arr = array();
                    $intermediate_ones = $this->IntermediateOne->find('all', array(
                        'conditions' => array('IntermediateOne.store_id' => $kaikake_store['KaikakeStore']['id']),
                        'fields' => array('IntermediateOne.association_id')
                    ));
                    foreach($intermediate_ones as $intermediate_one){
                        $arr[] = $intermediate_one['IntermediateOne']['association_id'];
                    }
                    $kaikake_store['Association'] = $arr;
                    $data_set2[] = $kaikake_store;
                }
                $stocktaking_type['Store'] = $data_set2;
                $data_set[] = $stocktaking_type;
            }
            //debug($data_set[0]);
            $this->set("tab_1", $data_set[0]);
            $this->set("tab_2", $data_set[1]);
            $this->set("tab_3", $data_set[2]);
            $this->set("tab_4", $data_set[3]);
            $this->set("tab_5", $data_set[4]);
            $this->set("tab_6", $data_set[5]);
        }
    }

    public function intermediate_three(){
        # 使用モデル
        $this->loadModel("IntermediateThree");
        $this->loadModel("ExpenseDfType");
        # Association
        $associations = $this->Association->find('all');
        $this->set("associations", $associations);
        # ExpenseDfType
        $expense_df_types = $this->ExpenseDfType->find('all');
        //debug($expense_df_types);
        $this->set("expense_df_types", $expense_df_types);
        # Post
        if($this->request->is('post')){
            if(isset($this->request->data['IntermediateThree'])){
                foreach($this->request->data['IntermediateThree'] as $type_id => $intermediate_threes){
                    foreach($intermediate_threes as $association_id => $cost){
                        # 既存チェック
                        $history = $this->IntermediateThree->find('first', array(
                            'conditions' => array('IntermediateThree.association_id' => $association_id, 'IntermediateThree.type_id' => $type_id)
                        ));
                        if($history==null){
                            $data = array('IntermediateThree' => array(
                                'association_id' => $association_id,
                                'type_id' => $type_id,
                                'cost' => $cost
                            ));
                        }
                        else{
                            $data = array('IntermediateThree' => array(
                                'id' => $history['IntermediateThree']['id'],
                                'cost' => $cost
                            ));
                        }
                        #ループ実行文
                        $this->IntermediateThree->create(false);
                        $this->IntermediateThree->save($data);
                    }
                }
                $this->Session->setFlash('データを保存しました','flash_success');
                $this->redirect(array('action' => 'intermediate_three'));
            }
        }

    }

}
