<?
#css
echo $this->Html->css('assets/pages/css/coming-soon.css');
#js
echo $this->Html->script('assets/global/plugins/countdown/jquery.countdown.min.js');
echo $this->Html->script('assets/global/plugins/backstretch/jquery.backstretch.min.js');
echo $this->Html->script('assets/pages/scripts/coming-soon.js');

?>
<div class="container">
    <div class="row">
        <div class="col-md-12 coming-soon-header">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 coming-soon-content" style="float: none;margin-left: auto;margin-right: auto;text-align: center;">
            <h1>メール送信完了！</h1>
            <p>
                パスワード再発行用のリンクをあなたのメールアドレスに送りました。
            </p>
            <br>
        </div>
        <!--
        <div class="col-md-6 coming-soon-countdown">
            <div id="defaultCountdown" class="hasCountdown">
                <span class="countdown_row countdown_show4">
                    <span class="countdown_section">
                        <span class="countdown_amount">111</span><br>Days
                    </span>
                    <span class="countdown_section">
                        <span class="countdown_amount">2</span><br>Hours
                    </span>
                    <span class="countdown_section">
                        <span class="countdown_amount">8</span><br>Minutes
                    </span>
                    <span class="countdown_section">
                        <span class="countdown_amount">22</span><br>Seconds
                    </span>
                </span>
            </div>
        </div>
        -->
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        Layout.init(); // init current layout
        Demo.init(); // init demo features
        ComingSoon.init();
        // init background slide images
        $.backstretch([
            "<?echo $this->webroot;?>img/sushikaz2.jpg",
            "<?echo $this->webroot;?>img/sushikaz1.jpg",
        ], {
            fade: 1000,
            duration: 10000
        });
    });
</script>
<div class="backstretch" style="opacity: 0.7;"></div>
