<?

?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <?php echo $this->Html->charset('utf-8'); ?>
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>

    <?php
    echo $this->Html->meta('icon');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    #BEGIN GLOBAL MANDATORY STYLES
    echo $this->Html->css('assets/global/plugins/font-awesome/css/font-awesome.min.css');
    echo $this->Html->css('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
    echo $this->Html->css('assets/global/plugins/bootstrap/css/bootstrap.min.css');
    echo $this->Html->css('assets/global/plugins/uniform/css/uniform.default.css');
    echo $this->Html->css('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
    #BEGIN THEME STYLES
    echo $this->Html->css('assets/global/css/components-rounded.css');
    echo $this->Html->css('assets/global/css/plugins.min.css');
    #BEGIN THEME LAYOUT STYLES
    echo $this->Html->css('assets/layouts/layout3/css/layout.min.css');
    echo $this->Html->css('assets/layouts/layout3/css/themes/default.min.css');
    echo $this->Html->css('assets/layouts/layout3/css/custom.min.css');

    #base js
    echo $this->Html->script('js/modernizr-2.6.2.min.js');

    #plugin js
    echo $this->Html->script('assets/global/plugins/jquery.min.js');
    echo $this->Html->script('assets/global/plugins/jquery-migrate.min.js');
    echo $this->Html->script('assets/global/plugins/jquery-ui/jquery-ui.min.js');
    echo $this->Html->script('assets/global/plugins/bootstrap/js/bootstrap.min.js');
    echo $this->Html->script('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');
    echo $this->Html->script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');
    echo $this->Html->script('assets/global/plugins/jquery.blockui.min.js');
    echo $this->Html->script('assets/global/plugins/jquery.cokie.min.js');
    echo $this->Html->script('assets/global/plugins/uniform/jquery.uniform.min.js');
    echo $this->Html->script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');
    echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');

    echo $this->Html->script('assets/global/scripts/app.min.js');
    echo $this->Html->script('assets/layouts/layout3/scripts/layout.js');
    echo $this->Html->script('assets/layouts/layout3/scripts/demo.js');

    ?>

</head>
<body>
<div id="container">

    <div id="content">

        <?php echo $this->Session->flash(); ?>

        <?php echo $this->fetch('content'); ?>
    </div>

</div>
</body>
</html>
