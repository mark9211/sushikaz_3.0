<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/11
 * Time: 20:20
 */
class MembersController extends AppController{
	var $scaffold;
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
		$this->loadModel("MemberPost");
		$this->loadModel("MemberPosition");
		$this->loadModel("MemberType");
		if(!$this->Cookie->check('myData')){
			#loginページへ
			$this->redirect(array('controller'=>'locations','action'=>'login'));
		}else{
			$location = $this->Location->findById($this->Cookie->read('myData'));
			$this->set('location', $location);
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
		}
	}

	#index上書き
	public function index(){
		#従業員取得byLocationId
		$members = $this->Member->find('all', array(
			'conditions' => array('Member.location_id'=>$this->Cookie->read('myData'))
		));
		$this->set('members', $members);
	}

	#edit上書き
	public function edit($id){
		if($this->request->is('post')){
			#従業員情報
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
		}
	}

	#add上書き
	public function add(){
		if($this->request->is('post')){
			if($this->Member->save($this->request->data)){
				$this->Session->setFlash("新規登録しました");
				$this->redirect(array("controller"=>"members", 'action'=>'index'));
			}
		}else{
			#店舗
			$locations = $this->Location->find('all');
			$this->set('locations', $locations);
			#役職
			$posts = $this->MemberPost->find('all', array(
				'conditions' => array('location_id' => $this->Cookie->read('myData'))
			));
			$this->set('posts', $posts);
			#持ち場
			$positions = $this->MemberPosition->find('all', array(
				'conditions' => array('location_id' => $this->Cookie->read('myData'))
			));
			$this->set('positions', $positions);
			#就業形態
			$types = $this->MemberType->find('all', array(
				'conditions' => array('location_id' => $this->Cookie->read('myData'))
			));
			$this->set('types', $types);
		}
	}

}
