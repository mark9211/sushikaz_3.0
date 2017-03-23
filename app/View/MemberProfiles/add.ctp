<?
#css
echo $this->Html->css('assets/global/plugins/select2/css/select2.css');
#js
echo $this->Html->script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js');
echo $this->Html->script('assets/global/plugins/jquery-validation/js/additional-methods.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js');
echo $this->Html->script('assets/global/plugins/select2/js/select2.min.js');
echo $this->Html->script('assets/pages/scripts/form-wizard.js');
#郵便番号js
echo $this->Html->script('jquery.jpostal.js');
#写真アップロードcss js
echo $this->Html->css('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
echo $this->Html->script('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js');

//debug($member);
?>
<div class="page-container">
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
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light" id="form_wizard_1">
                        <div class="portlet-title">
                            <div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">
								<i class="fa fa-gift"></i> 従業員登録 - <span class="step-title">Step 1 of 4 </span>
								</span>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                </a>
                                <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
                                </a>
                                <a href="javascript:;" class="reload" data-original-title="" title="">
                                </a>
                                <a href="javascript:;" class="remove" data-original-title="" title="">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'login'));?>" class="form-horizontal" id="submit_form" method="POST">
                                <input type="hidden" name="member_id" value="<?if(isset($member)){echo $member['Member']['id'];}else{echo 'ERROR:500';}?>">
                                <div class="form-wizard">
                                    <div class="form-body">
                                        <ul class="nav nav-pills nav-justified steps">
                                            <li class="active">
                                                <a href="#tab1" data-toggle="tab" class="step" aria-expanded="true">
												<span class="number">
												1 </span>
												<span class="desc">
												<i class="fa fa-check"></i> ログイン設定 </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab2" data-toggle="tab" class="step">
												<span class="number">
												2 </span>
												<span class="desc">
												<i class="fa fa-check"></i> アカウント設定 </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab3" data-toggle="tab" class="step active">
												<span class="number">
												3 </span>
												<span class="desc">
												<i class="fa fa-check"></i> ピクチャー設定 </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab4" data-toggle="tab" class="step">
												<span class="number">
												4 </span>
												<span class="desc">
												<i class="fa fa-check"></i> 確認 </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="bar" class="progress progress-striped" role="progressbar">
                                            <div class="progress-bar progress-bar-success" style="width: 25%;">
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="alert alert-danger display-none">
                                                <button class="close" data-dismiss="alert"></button>
                                                You have some form errors. Please check below.
                                            </div>
                                            <div class="alert alert-success display-none">
                                                <button class="close" data-dismiss="alert"></button>
                                                Your form validation is successful!
                                            </div>
                                            <div class="tab-pane active" id="tab1">
                                                <h3 class="block">ログイン用のメールアドレス&パスワードを設定してください。</h3>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">メールアドレス <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="email" id="emailCheck">
														<span class="help-block">
														メールアドレスを入力してください。 </span>
                                                        <span id="emailHelp" class="help-block help-block-error" style="color: red;"></span>
                                                        <script>
                                                            $("#emailCheck").focusout(function() {
                                                                var email = $(this).val();
                                                                $.post("<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'emailCheck'));?>",
                                                                    { email: email },
                                                                    function(data){
                                                                        //リクエストが成功した際に実行する関数
                                                                        //alert("Data Loaded: " + data);
                                                                        if(data==1){
                                                                            $("#emailHelp").text("このメールアドレスは既に登録されています。");
                                                                            $("#emailCheck").val('');
                                                                        }
                                                                    }
                                                                );
                                                            });
                                                            $("#emailCheck").focusin(function() {
                                                                if($("#emailHelp").text()!=''){
                                                                    //エラーメッセージを削除
                                                                    $("#emailHelp").text('');
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">パスワード <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="password" class="form-control" name="password" id="submit_form_password">
														<span class="help-block">
														パスワードを入力してください。 </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">パスワード確認用 <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="password" class="form-control" name="rpassword">
														<span class="help-block">
														パスワードを入力してください。（確認用） </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab2">
                                                <h3 class="block">アカウント情報を設定してください。</h3>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">性別 <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <div class="radio-list">
                                                            <label>
                                                                <div class="radio"><input type="radio" name="gender" value="M" data-title="Male"></div>
                                                                男性
                                                            </label>
                                                            <label>
                                                                <div class="radio"><input type="radio" name="gender" value="F" data-title="Female"></div>
                                                                女性
                                                            </label>
                                                        </div>
                                                        <div id="form_gender_error">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">生年月日 <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input id="datepicker" data-date-format="yyyy-mm-dd" class="form-control input-large date-picker" name="birthday" readonly>
														<span class="help-block">
														例）1992-11-11 </span>
                                                        <script>
                                                            $('#datepicker').datepicker({
                                                                dateFormat: "yy-mm-dd",
                                                                numberOfMonths: 2,
                                                                minDate: 0,
                                                                maxDate: '+1M'
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">電話番号 <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="phone">
														<span class="help-block">
														例）08012345678 </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">郵便番号 <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="postcode" id="postcode1">
                                                        <span class="help-block">
														例）3510112（ハイフンなし） </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">都道府県 <span class="required" aria-required="true">
													* </span></label>
                                                    <div class="col-md-4">
                                                        <select name="address1" class="form-control" id="address1">
                                                            <option value="" selected="selected">選択してください</option>
                                                            <option value="北海道">北海道</option>
                                                            <option value="青森県">青森県</option>
                                                            <option value="岩手県">岩手県</option>
                                                            <option value="宮城県">宮城県</option>
                                                            <option value="秋田県">秋田県</option>
                                                            <option value="山形県">山形県</option>
                                                            <option value="福島県">福島県</option>
                                                            <option value="茨城県">茨城県</option>
                                                            <option value="栃木県">栃木県</option>
                                                            <option value="群馬県">群馬県</option>
                                                            <option value="埼玉県">埼玉県</option>
                                                            <option value="千葉県">千葉県</option>
                                                            <option value="東京都">東京都</option>
                                                            <option value="神奈川県">神奈川県</option>
                                                            <option value="新潟県">新潟県</option>
                                                            <option value="富山県">富山県</option>
                                                            <option value="石川県">石川県</option>
                                                            <option value="福井県">福井県</option>
                                                            <option value="山梨県">山梨県</option>
                                                            <option value="長野県">長野県</option>
                                                            <option value="岐阜県">岐阜県</option>
                                                            <option value="静岡県">静岡県</option>
                                                            <option value="愛知県">愛知県</option>
                                                            <option value="三重県">三重県</option>
                                                            <option value="滋賀県">滋賀県</option>
                                                            <option value="京都府">京都府</option>
                                                            <option value="大阪府">大阪府</option>
                                                            <option value="兵庫県">兵庫県</option>
                                                            <option value="奈良県">奈良県</option>
                                                            <option value="和歌山県">和歌山県</option>
                                                            <option value="鳥取県">鳥取県</option>
                                                            <option value="島根県">島根県</option>
                                                            <option value="岡山県">岡山県</option>
                                                            <option value="広島県">広島県</option>
                                                            <option value="山口県">山口県</option>
                                                            <option value="徳島県">徳島県</option>
                                                            <option value="香川県">香川県</option>
                                                            <option value="愛媛県">愛媛県</option>
                                                            <option value="高知県">高知県</option>
                                                            <option value="福岡県">福岡県</option>
                                                            <option value="佐賀県">佐賀県</option>
                                                            <option value="長崎県">長崎県</option>
                                                            <option value="熊本県">熊本県</option>
                                                            <option value="大分県">大分県</option>
                                                            <option value="宮崎県">宮崎県</option>
                                                            <option value="鹿児島県">鹿児島県</option>
                                                            <option value="沖縄県">沖縄県 </option>
                                                        </select>
                                                        <span class="help-block">
														    例）埼玉県 </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">市区町村 <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="address2" id="address2">
														<span class="help-block">
														和光市 </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">番地など <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="address3" id="address3">
														<span class="help-block">
														丸山台1-10-4 </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">マンション名など</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="address4">
                                                            <span class="help-block">
														    例）F'sBox 2F </span>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(window).ready( function() {
                                                        $('#postcode1').jpostal({
                                                            postcode : [
                                                                '#postcode1'
                                                            ],
                                                            address : {
                                                                '#address1'  : '%3',
                                                                '#address2'  : '%4',
                                                                '#address3'  : '%5'
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </div>
                                            <div class="tab-pane" id="tab3">
                                                <h3 class="block">プロフィール写真を設定してください。</h3>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">あなたの写真 <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;"></div>
                                                        <div>
                                                            <span class="btn default btn-file">
                                                                <span class="fileinput-new">写真を選ぶ </span>
                                                                <span class="fileinput-exists">変更 </span>
                                                                <input type="file" name="">
                                                            </span>
                                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                                Remove </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Card Holder Name <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="card_name">
														<span class="help-block">
														</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Card Number <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="card_number">
														<span class="help-block">
														</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">CVC <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" placeholder="" class="form-control" name="card_cvc">
														<span class="help-block">
														</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Expiration(MM/YYYY) <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" placeholder="MM/YYYY" maxlength="7" class="form-control" name="card_expiry_date">
														<span class="help-block">
														e.g 11/2020 </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Payment Options <span class="required" aria-required="true">
													* </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <div class="checkbox-list">
                                                            <label>
                                                                <div class="checker"><span><input type="checkbox" name="payment[]" value="1" data-title="Auto-Pay with this Credit Card."></span></div> Auto-Pay with this Credit Card </label>
                                                            <label>
                                                                <div class="checker"><span><input type="checkbox" name="payment[]" value="2" data-title="Email me monthly billing."></span></div> Email me monthly billing </label>
                                                        </div>
                                                        <div id="form_payment_error">
                                                        </div>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                            <div class="tab-pane" id="tab4">
                                                <h3 class="block">この設定でよろしいですか？</h3>
                                                <h4 class="form-section">従業員情報</h4>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">氏名:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static">
                                                            <?if(isset($member)){echo $member['Member']['name'];}else{echo "ERROR:500";}?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <h4 class="form-section">ログイン設定</h4>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">メールアドレス:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="email">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">パスワード:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="password">
                                                        </p>
                                                    </div>
                                                </div>
                                                <h4 class="form-section">アカウント設定</h4>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">性別:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="gender">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">生年月日:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="birthday">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">電話番号:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="phone">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">郵便番号:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="postcode">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">住所１:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="address1">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">住所２:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="address2">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">住所３:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="address3">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">住所４:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="address4">
                                                        </p>
                                                    </div>
                                                </div>
                                                <h4 class="form-section">ピクチャー設定</h4>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">プロフィール写真:</label>
                                                    <div class="col-md-4">
                                                        <img class="form-control-static" data-display="photo" style="width: 150px; height: 150px; line-height: 150px;">
                                                    </div>
                                                </div>
                                                <!--
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Card Holder Name:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="card_name">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Card Number:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="card_number">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">CVC:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="card_cvc">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Expiration:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="card_expiry_date">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Payment Options:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" data-display="payment">
                                                        </p>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <a href="javascript:;" class="btn default button-previous disabled" style="display: none;">
                                                    <i class="m-icon-swapleft"></i> 戻る </a>
                                                <a href="javascript:;" class="btn blue button-next">
                                                    次へ <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
                                                <button type="submit" class="btn green button-submit" style="display: none;">
                                                    送信 <i class="m-icon-swapright m-icon-white"></button>
                                                <input type="hidden" id="url1" value="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'add'));?>">
                                                <input type="hidden" id="url2" value="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'index'));?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END PAGE CONTENT -->
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
            Layout.init(); // init current layout
            Demo.init(); // init demo features
            FormWizard.init();
        });
    </script>
</div>


