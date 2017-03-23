<?
#css
echo $this->Html->css('assets/pages/css/login.css');
#js
echo $this->Html->script('assets/pages/scripts/login.js');
echo $this->Html->script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js');
//debug($new_members);
?>
<body class="login">
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'login'));?>" method="post" novalidate="novalidate">
        <h3 class="form-title">従業員ログイン</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" placeholder="メールアドレス" name="MemberProfile[email]">
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="パスワード" name="MemberProfile[password]">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success uppercase">ログイン</button>
            <label class="rememberme check">
                <input type="checkbox" name="remember" value="1">Cookieで記憶する </label>
            <p>
                <a href="javascript:;" id="forget-password" class="forget-password">パスワードをお忘れですか？</a>
            </p>
        </div>
        <!--
        <div class="login-options">
            <h4>Or login with</h4>
            <ul class="social-icons">
                <li>
                    <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                </li>
            </ul>
        </div>
        -->
        <a href="javascript:;" id="register-btn" class="uppercase" style="font-size:20px;color: #fff;">
        <div class="create-account">
            <p>
                新規登録
            </p>
        </div>
            </a>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" action="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'add'));?>" method="post" novalidate="novalidate">
        <h3>従業員名選択</h3>
        <p class="hint">
            あなたのお名前を選択してください。
        </p>
        <div class="form-group">
            <select name="member_id" class="form-control">
                <option value="">選択してください</option>
                <?if($new_members!=null):?>
                    <?foreach($new_members as $new_member):?>
                        <option value="<?echo $new_member['Member']['id'];?>"><?echo $new_member['Member']['name'];?></option>
                    <?endforeach;?>
                <?endif;?>
            </select>
        </div>
        <div class="form-group margin-top-20 margin-bottom-20">
            <label class="check">
                <input type="checkbox" name="tnc"> <a href="javascript:;">利用規約</a>に同意する
            </label>
            <div id="register_tnc_error">
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="register-back-btn" class="btn btn-default">戻る</button>
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">送信</button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" novalidate="novalidate">
        <h3>パスワード再発行</h3>
        <p>
            登録したメールアドレスにパスワード再発行用のURLを送ります。
        </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" id="emailCheck">
            <span id="emailHelp" class="help-block help-block-error" style="color: red;"></span>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">戻る</button>
            <button type="button" class="btn btn-success uppercase pull-right" id="emailButton">送信</button>
        </div>
        <script>
            $("#emailButton").click(function() {
                var email = $("#emailCheck").val();
                $.post("<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'emailCheck'));?>",
                    { email: email },
                    function(data){
                        //リクエストが成功した際に実行する関数
                        //alert("Data Loaded: " + data);
                        if(data==0){
                            $("#emailHelp").text("このメールアドレスは登録されていません。");
                        }else if(data=1){
                            window.location.href = "<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'password'));?>?email="+email;
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
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->
<!--[if lt IE 9]>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function() {
        Layout.init(); // init current layout
        Demo.init();
        Login.init();
    });
</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
</body>