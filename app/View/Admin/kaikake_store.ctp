<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container">
                <!-- 新規追加 -->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>買掛先追加
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body flip-scroll">
                        <form class="form-horizontal form-bordered" role="form" method="post" action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label">種類</label>
                                    <div class="form-group">
                                        <select class="form-control" name="">
                                            <option value="">選択してください</option>
                                            <? foreach ($stocktaking_types as $stocktaking_type): ?>
                                                <option value="<?= $stocktaking_type['StocktakingType']['id']; ?>"><?= $stocktaking_type['StocktakingType']['name']; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">表示順</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-list-ol"></i>
                                            </span>
                                            <input type="number" class="form-control" placeholder="100" name="" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">買掛先名</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-home"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="Enter Name" name="" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
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

            </div>
        </div>
    </div>
</div>