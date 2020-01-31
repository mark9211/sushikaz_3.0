<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container">
                <!-- 新規追加 -->
                <?= $this->Form->create(false, array('controller'=>'admin','action'=>'kaikake_store_add'));?>
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-plus"></i>買掛先追加
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body flip-scroll">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">表示順</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-list-ol"></i>
                                        </span>
                                        <input type="number" class="form-control" placeholder="100" name="rank" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label">種類</label>
                                <div class="form-group">
                                    <select class="form-control" name="type_id">
                                        <option value="">選択してください</option>
                                        <?if(isset($stocktaking_types)):?>
                                            <?foreach ($stocktaking_types as $stocktaking_type):?>
                                                <option value="<?= $stocktaking_type['StocktakingType']['id']; ?>"><?= $stocktaking_type['StocktakingType']['name']; ?></option>
                                            <?endforeach;?>
                                        <?endif;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">買掛先名</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="〇〇商店" name="name" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label">送信</label>
                                <div class="form-group">
                                    <button type="submit" class="btn green">登録する</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end();?>
                <!-- 新規追加 終了 -->
                <!-- 表示・削除 -->
                <?= $this->Form->create(false, array('controller'=>'admin','action'=>'kaikake_store_edit'));?>
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i>買掛先一覧
                        </div>
                        <button type="submit" class="btn yellow">更新する</button>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body flip-scroll">
                        <?if(isset($kaikake_stores)):?>
                            <?foreach($kaikake_stores as $kaikake_store):?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-list-ol"></i>
                                            </span>
                                            <input type="number" class="form-control" placeholder="100" name="store[<?=$kaikake_store['KaikakeStore']['id'];?>][rank]" value="<?=$kaikake_store['KaikakeStore']['rank'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" name="store[<?=$kaikake_store['KaikakeStore']['id'];?>][type_id]">
                                            <option value="">選択してください</option>
                                            <?if(isset($stocktaking_types)):?>
                                                <?foreach ($stocktaking_types as $stocktaking_type):?>
                                                    <option value="<?= $stocktaking_type['StocktakingType']['id']; ?>" <?if($kaikake_store['KaikakeStore']['type_id']==$stocktaking_type['StocktakingType']['id']){echo "selected";}?>><?= $stocktaking_type['StocktakingType']['name']; ?></option>
                                                <?endforeach; ?>
                                            <?endif;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-home"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="〇〇商店" name="store[<?=$kaikake_store['KaikakeStore']['id'];?>][name]" value="<?=$kaikake_store['KaikakeStore']['name'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?= $this->Html->url(array('controller'=>'admin', 'action'=>'kaikake_store_delete', '?' => array('id' => $kaikake_store['KaikakeStore']['id'])));?>"'>
                                    </div>
                                </div>
                            </div>
                            <?endforeach;?>
                        <?endif;?>
                    </div>
                </div>
                <?= $this->Form->end();?>
                <!-- 表示・削除 終了 -->
            </div>
        </div>
    </div>
</div>