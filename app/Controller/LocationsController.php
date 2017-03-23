<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 3:44
 */
class LocationsController extends AppController{
	#フォームヘルパー
	public $helpers = array('Html', 'Form');
	#Cookieの使用
	var $components = array('Cookie');

	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		$this->set('title_for_layout', '寿し和 | 管理システム');
	}

	#インデックス
	public function index(){
		#ログイン処理
		if(!$this->Cookie->check('myData')){
			#loginページへ
			$this->redirect(array('action'=>'login'));
		}else{
			#クッキー値
			$location = $this->Location->findById($this->Cookie->read('myData'));
			$this->set('location', $location);
		}
	}

	#ログイン画面
	public function login(){
		if($this->request->is('post')){
			#クッキー書き込み
			$cookie = $this->request->data['Location']['id'];
			$this->Cookie->write('myData', $cookie, true, '+6 weeks');
			$this->redirect(array('action'=>'index'));
		}else{
			#location
			$location = null;
			$this->set('location', $location);
			#店舗取得
			$locations=$this->Location->find('all');
			$this->set('locations', $locations);
		}
	}

}