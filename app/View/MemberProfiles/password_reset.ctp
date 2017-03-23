<?
#css
echo $this->Html->css('assets/pages/css/lock.css');
#js
echo $this->Html->script('assets/global/plugins/backstretch/jquery.backstretch.min.js');
echo $this->Html->script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js');
//debug($new_members);
?>
<div class="page-lock">
    <div class="page-logo">
        <!--
        <a class="brand" href="index.html">
            <img src="../../assets/admin/layout3/img/logo-big.png" alt="logo">
        </a>
        -->
    </div>
    <div class="page-body">
        <div class="lock-head">
            パスワード再設定
        </div>
        <div class="lock-body">
            <div class="pull-left lock-avatar-block">
                <img src="<?echo $member_profile['MemberProfile']['photo'];?>" class="lock-avatar">
            </div>
            <form class="lock-form pull-left" action="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'password_reset'));?>" method="post">
                <h4><?echo $member_profile['Member']['name'];?></h4>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?echo $member_profile['MemberProfile']['id'];?>">
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success uppercase">再設定</button>
                </div>
            </form>
        </div>
        <div class="lock-bottom">
            <!--
            <a href="">Not Amanda Smith?</a>
            -->
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Demo.init();
    });
</script>
