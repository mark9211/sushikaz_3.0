<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>各種設定
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body flip-scroll">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <?= $this->Html->link('買掛支払先（登録・削除）', array('controller'=>'admin', 'action'=>'kaikake_store'));?>
                            </li>
                            <li class="list-group-item">
                                <?= $this->Html->link('買掛支払先（店舗紐付）', array('controller'=>'admin', 'action'=>'intermediate_one'));?>
                            </li>
                            <li class="list-group-item">
                                <?= $this->Html->link('定額支出先（数値入力）', array('controller'=>'admin', 'action'=>'intermediate_three'));?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>