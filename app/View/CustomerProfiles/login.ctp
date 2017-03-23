<?
#css
echo $this->Html->css('assets/pages/css/login.css');
echo $this->Html->css('jquery-ui.css');
#js
echo $this->Html->script('assets/pages/scripts/login.js');
echo $this->Html->script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js');
# datepicker
echo $this->Html->script('jquery-ui-1.10.4.custom.js');
echo $this->Html->script('datepicker-ja.js');

?>
<body class="login">
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="<?echo $this->Html->url(array('controller'=>'customer_profiles', 'action'=>'login'));?>" method="post" novalidate="novalidate">
        <h3 class="form-title">顧客検索</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
        </div>
        <div class="form-group">
            <label class="control-label">ポイントカード番号</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="number" placeholder="ポイントカード番号" name="CustomerProfile[card_id]">
        </div>
        <div class="form-group">
            <label class="control-label">電話番号</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="tel" placeholder="電話番号" name="CustomerProfile[phone]" id="inputTel">
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label">氏名（カナ）</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" placeholder="氏名（カナ）" name="CustomerProfile[kana]" id="inputName">
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label">Email</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="email" placeholder="メールアドレス" name="CustomerProfile[email]" id="inputEmail">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success uppercase">検索</button>
        </div>
        <a href="<?echo $this->Html->url(array('controller'=>'customer_profiles', 'action'=>'add'));?>" style="font-size:20px;color: #fff;">
            <div class="create-account">
                <p>
                    新規登録
                </p>
            </div>
        </a>
    </form>
    <!-- END LOGIN FORM -->
</div>
<!-- END LOGIN -->
<!--[if lt IE 9]>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    $(window).ready(function() {
        var data1 = <?echo $phone;?>;
        $('#inputTel').autocomplete({
            source: data1,
            minLength: 3,
            messages: {
                noResults: '',
                results: function() {}
            }
        });
        var data2 = <?echo $kana;?>;
        $('#inputName').autocomplete({
            source: data2,
            messages: {
                noResults: '',
                results: function() {}
            }
        });
        var data3 = <?echo $email;?>;
        $('#inputEmail').autocomplete({
            source: data3,
            messages: {
                noResults: '',
                results: function() {}
            }
        });
    });
</script>
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