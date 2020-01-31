<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container">
                <!-- 新規追加 -->
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
                        <form class="form-bordered" role="form" method="post" action="">
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <label class="control-label">種類</label>
                                    <div class="form-group">
                                        <select class="form-control" name="type_id">
                                            <option value="">選択してください</option>
                                            <? foreach ($stocktaking_types as $stocktaking_type): ?>
                                                <option value="<?= $stocktaking_type['StocktakingType']['id']; ?>"><?= $stocktaking_type['StocktakingType']['name']; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-1">
                                    <label class="control-label">登録</label>
                                    <div class="form-group">
                                        <button type="submit" class="btn green">登録する</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- 表示・削除 -->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i>買掛先一覧
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body flip-scroll">
                        <?foreach($kaikake_stores as $kaikake_store):?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-list-ol"></i>
                                            </span>
                                            <input type="number" class="form-control" placeholder="100" name="rank" value="<?=$kaikake_store['KaikakeStore']['rank'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="type_id">
                                            <option value="">選択してください</option>
                                            <?foreach ($stocktaking_types as $stocktaking_type):?>
                                                <option value="<?= $stocktaking_type['StocktakingType']['id']; ?>" <?if($kaikake_store['KaikakeStore']['type_id']==$stocktaking_type['StocktakingType']['id']){echo "selected";}?>><?= $stocktaking_type['StocktakingType']['name']; ?></option>
                                            <?endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-home"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="〇〇商店" name="name" value="<?=$kaikake_store['KaikakeStore']['name'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label class="control-label">更新</label>
                                    <div class="form-group">
                                        <input type="button" value="削除する" class="btn blue" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'admin', 'action'=>'kaikake_store_delete', '?' => array('id' => $kaikake_store['KaikakeStore']['id'])));?>"'>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'admin', 'action'=>'kaikake_store_delete', '?' => array('id' => $kaikake_store['KaikakeStore']['id'])));?>"'>
                                    </div>
                                </div>
                            </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>