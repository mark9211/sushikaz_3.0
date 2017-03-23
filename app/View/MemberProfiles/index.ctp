<?
?>
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Home <small>windows 8 style tiles examples</small></h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
</div>
<div class="page-container">
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="tiles">
                <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'view', '?' => array('month' => date(('Y-m')))));?>">
                    <div class="tile bg-yellow-saffron">
                        <div class="corner">
                        </div>
                        <div class="tile-body">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="tile-object">
                            <div class="name">
                                給与確認
                            </div>
                            <div class="number">
                                Ⅰ
                            </div>
                        </div>
                    </div>
                </a>
                <?$date = date('Y-m-d', strtotime('-1 day'));?>
                <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'daily_report', '?' => array('date' => $date)));?>">
                    <div class="tile bg-red-sunglo">
                        <div class="tile-body">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div class="tile-object">
                            <div class="name">
                                日別売上
                            </div>
                            <div class="number">
                                Ⅱ
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'graph', '?' => array('location' => 1)));?>">
                    <div class="tile bg-green">
                        <div class="tile-body">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="tile-object">
                            <div class="name">
                                売上比較
                            </div>
                            <div class="number">
                                Ⅲ
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'menu'));?>">
                    <div class="tile bg-blue-steel">
                        <div class="tile-body">
                            <i class="fa fa-coffee"></i>
                        </div>
                        <div class="tile-object">
                            <div class="name">
                                メニュー比較
                            </div>
                            <div class="number">
                                Ⅴ
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'cash', '?' => array('date' => date('Y-m', strtotime("-1 month")).'-01')));?>">
                    <div class="tile bg-green-meadow">
                        <div class="tile-body">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="tile-object">
                            <div class="name">
                                買掛現金
                            </div>
                            <div class="number">
                                Ⅶ
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'report_card', '?' => array('date' => date('Y-m', strtotime("-1 month")).'-01')));?>">
                    <div class="tile bg-purple-studio">
                        <div class="tile-body">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <div class="tile-object">
                            <div class="name">
                                売上成績
                            </div>
                            <div class="number">
                                Ⅳ
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'export'));?>">
                    <div class="tile bg-blue-hoki">
                        <div class="tile-body">
                            <i class="fa fa-file-excel-o"></i>
                        </div>
                        <div class="tile-object">
                            <div class="name">
                                エクセル出力
                            </div>
                            <div class="number">
                                Ⅵ
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?echo $this->Html->url(array('controller'=>'admin', 'action'=>'index'));?>">
                    <div class="tile bg-grey-cascade">
                        <div class="corner">
                        </div>
                        <div class="check">
                        </div>
                        <div class="tile-body">
                            <i class="fa fa-cogs"></i>
                        </div>
                        <div class="tile-object">
                            <div class="name">
                                各種設定
                            </div>
                            <div class="number">
                               Ⅶ
                            </div>
                        </div>
                    </div>
                </a>
                <div class="tile bg-red-sunglo">
                    <div class="tile-body">
                        <i class="fa fa-plane"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                            Projects
                        </div>
                        <div class="number">
                            34
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
        });
    </script>
</div>