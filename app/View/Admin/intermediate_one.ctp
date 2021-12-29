<?
#BEGIN PAGE LEVEL PLUGINS
echo $this->Html->css('assets/global/plugins/icheck/skins/all.css');
#BEGIN PAGE LEVEL PLUGINS
echo $this->Html->script('assets/global/plugins/icheck/icheck.min.js');
echo $this->Html->script('assets/pages/scripts/form-icheck.min.js');

?>
<style>label{font-size: 12px;}</style>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>各種設定
                        <small>icheck controls</small>
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMBS -->
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="index.html">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">Components</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Date & Time Pickers</span>
                    </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption">
                                                <i class="icon-globe font-red"></i>
                                                <span class="caption-subject font-red bold uppercase">買掛カテゴリー</span>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#portlet_tab_2_1" data-toggle="tab"> <?echo $tab_1['StocktakingType']['name'];?> </a>
                                                </li>
                                                <li>
                                                    <a href="#portlet_tab_2_2" data-toggle="tab"> <?echo $tab_2['StocktakingType']['name'];?> </a>
                                                </li>
                                                <li>
                                                    <a href="#portlet_tab_2_3" data-toggle="tab"> <?echo $tab_3['StocktakingType']['name'];?> </a>
                                                </li>
                                                <li>
                                                    <a href="#portlet_tab_2_4" data-toggle="tab"> <?echo $tab_4['StocktakingType']['name'];?> </a>
                                                </li>
                                                <li>
                                                    <a href="#portlet_tab_2_5" data-toggle="tab"> <?echo $tab_5['StocktakingType']['name'];?> </a>
                                                </li>
                                                <li>
                                                    <a href="#portlet_tab_2_6" data-toggle="tab"> <?echo $tab_6['StocktakingType']['name'];?> </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="portlet_tab_2_1">
                                                    <div class="skin skin-square">
                                                        <form class="form-horizontal form-bordered" role="form" method="post" action="">
                                                            <div class="form-body">
                                                                <?foreach($tab_1['Store'] as $store):?>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">
                                                                            <strong><?= $store['KaikakeStore']['name'];?></strong>
                                                                        </label>
                                                                        <div class="col-md-10">
                                                                            <div class="input-group">
                                                                                <div class="icheck-inline">
                                                                                    <?foreach($associations as $association):?>
                                                                                        <?$flag=0;foreach($store['Association'] as $a){if($a==$association['Association']['id']){$flag=1;}}?>
                                                                                        <label>
                                                                                            <input type="hidden" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="">
                                                                                            <input type="checkbox" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="<?= $association['Association']['id']?>" class="icheck" data-checkbox="icheckbox_square-blue" <?if($flag==1){echo "checked";}?>> <?= $association['Location']['name'];?>（<?= $association['Attribute']['name'];?>）
                                                                                        </label>
                                                                                    <?endforeach;?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?endforeach;?>
                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn green">送信</button>
                                                                <button type="button" class="btn default">キャンセル</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="portlet_tab_2_2">
                                                    <div class="skin skin-square">
                                                        <form class="form-horizontal form-bordered" role="form" method="post" action="">
                                                            <div class="form-body">
                                                                <?foreach($tab_2['Store'] as $store):?>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">
                                                                            <strong><?= $store['KaikakeStore']['name'];?></strong>
                                                                        </label>
                                                                        <div class="col-md-9">
                                                                            <div class="input-group">
                                                                                <div class="icheck-inline">
                                                                                    <?foreach($associations as $association):?>
                                                                                        <?$flag=0;foreach($store['Association'] as $a){if($a==$association['Association']['id']){$flag=1;}}?>
                                                                                        <label>
                                                                                            <input type="hidden" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="">
                                                                                            <input type="checkbox" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="<?= $association['Association']['id']?>" class="icheck" data-checkbox="icheckbox_square-green" <?if($flag==1){echo "checked";}?>> <?= $association['Location']['name'];?>（<?= $association['Attribute']['name'];?>）
                                                                                        </label>
                                                                                    <?endforeach;?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?endforeach;?>
                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn green">送信</button>
                                                                <button type="button" class="btn default">キャンセル</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="portlet_tab_2_3">
                                                    <div class="skin skin-square">
                                                        <form class="form-horizontal form-bordered" role="form" method="post" action="">
                                                            <div class="form-body">
                                                                <?foreach($tab_3['Store'] as $store):?>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">
                                                                            <strong><?= $store['KaikakeStore']['name'];?></strong>
                                                                        </label>
                                                                        <div class="col-md-9">
                                                                            <div class="input-group">
                                                                                <div class="icheck-inline">
                                                                                    <?foreach($associations as $association):?>
                                                                                        <?$flag=0;foreach($store['Association'] as $a){if($a==$association['Association']['id']){$flag=1;}}?>
                                                                                        <label>
                                                                                            <input type="hidden" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="">
                                                                                            <input type="checkbox" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="<?= $association['Association']['id']?>" class="icheck" data-checkbox="icheckbox_square-green" <?if($flag==1){echo "checked";}?>> <?= $association['Location']['name'];?>（<?= $association['Attribute']['name'];?>）
                                                                                        </label>
                                                                                    <?endforeach;?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?endforeach;?>
                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn green">送信</button>
                                                                <button type="button" class="btn default">キャンセル</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="portlet_tab_2_4">
                                                    <div class="skin skin-square">
                                                        <form class="form-horizontal form-bordered" role="form" method="post" action="">
                                                            <div class="form-body">
                                                                <?foreach($tab_4['Store'] as $store):?>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">
                                                                            <strong><?= $store['KaikakeStore']['name'];?></strong>
                                                                        </label>
                                                                        <div class="col-md-9">
                                                                            <div class="input-group">
                                                                                <div class="icheck-inline">
                                                                                    <?foreach($associations as $association):?>
                                                                                        <?$flag=0;foreach($store['Association'] as $a){if($a==$association['Association']['id']){$flag=1;}}?>
                                                                                        <label>
                                                                                            <input type="hidden" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="">
                                                                                            <input type="checkbox" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="<?= $association['Association']['id']?>" class="icheck" data-checkbox="icheckbox_square-green" <?if($flag==1){echo "checked";}?>> <?= $association['Location']['name'];?>（<?= $association['Attribute']['name'];?>）
                                                                                        </label>
                                                                                    <?endforeach;?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?endforeach;?>
                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn green">送信</button>
                                                                <button type="button" class="btn default">キャンセル</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="portlet_tab_2_5">
                                                    <div class="skin skin-square">
                                                        <form class="form-horizontal form-bordered" role="form" method="post" action="">
                                                            <div class="form-body">
                                                                <?foreach($tab_5['Store'] as $store):?>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">
                                                                            <strong><?= $store['KaikakeStore']['name'];?></strong>
                                                                        </label>
                                                                        <div class="col-md-9">
                                                                            <div class="input-group">
                                                                                <div class="icheck-inline">
                                                                                    <?foreach($associations as $association):?>
                                                                                        <?$flag=0;foreach($store['Association'] as $a){if($a==$association['Association']['id']){$flag=1;}}?>
                                                                                        <label>
                                                                                            <input type="hidden" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="">
                                                                                            <input type="checkbox" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="<?= $association['Association']['id']?>" class="icheck" data-checkbox="icheckbox_square-green" <?if($flag==1){echo "checked";}?>> <?= $association['Location']['name'];?>（<?= $association['Attribute']['name'];?>）
                                                                                        </label>
                                                                                    <?endforeach;?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?endforeach;?>
                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn green">送信</button>
                                                                <button type="button" class="btn default">キャンセル</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="portlet_tab_2_6">
                                                    <div class="skin skin-square">
                                                        <form class="form-horizontal form-bordered" role="form" method="post" action="">
                                                            <div class="form-body">
                                                                <?foreach($tab_6['Store'] as $store):?>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">
                                                                            <strong><?= $store['KaikakeStore']['name'];?></strong>
                                                                        </label>
                                                                        <div class="col-md-9">
                                                                            <div class="input-group">
                                                                                <div class="icheck-inline">
                                                                                    <?foreach($associations as $association):?>
                                                                                        <?$flag=0;foreach($store['Association'] as $a){if($a==$association['Association']['id']){$flag=1;}}?>
                                                                                        <label>
                                                                                            <input type="hidden" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="">
                                                                                            <input type="checkbox" name="tab[<?= $store['KaikakeStore']['id']?>][<?= $association['Association']['id']?>]" value="<?= $association['Association']['id']?>" class="icheck" data-checkbox="icheckbox_square-green" <?if($flag==1){echo "checked";}?>> <?= $association['Location']['name'];?>（<?= $association['Attribute']['name'];?>）
                                                                                        </label>
                                                                                    <?endforeach;?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?endforeach;?>
                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn green">送信</button>
                                                                <button type="button" class="btn default">キャンセル</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END PAGE CONTENT BODY -->
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

