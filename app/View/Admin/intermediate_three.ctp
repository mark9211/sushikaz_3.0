<?

?>
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
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
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-pin font-dark"></i>
                                        <span class="caption-subject bold uppercase">定額支出先</span>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title="">
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body flip-scroll">
                                    <form role="form" action="" method="post">
                                        <table class="table table-bordered table-striped table-condensed flip-content">
                                            <thead class="flip-content">
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    名称
                                                </th>
                                                <?foreach($associations as $association):?>
                                                    <th><?echo $association['Location']['name'];?>（<?echo $association['Attribute']['name'];?>）</th>
                                                <?endforeach;?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?$num=0;?>
                                                <?foreach($expense_df_types as $expense_df_type):?>
                                                    <tr>
                                                        <td><?$num++;echo $num;?></td>
                                                        <td><?echo $expense_df_type['ExpenseDfType']['name'];?></td>
                                                        <?if($expense_df_type['Intermediate']!=null):?>
                                                            <?foreach($expense_df_type['Intermediate'] as $intermediate_three):?>
                                                                <td><input name="IntermediateThree[<?echo $expense_df_type['ExpenseDfType']['id'];?>][<?echo $intermediate_three['association_id'];?>]" class="form-control" type="text" value="<?echo $intermediate_three['cost'];?>" placeholder="金額を入力してください"></td>
                                                            <?endforeach;?>
                                                        <?else:?>
                                                            <?foreach($associations as $association):?>
                                                                <td><input name="IntermediateThree[<?echo $expense_df_type['ExpenseDfType']['id'];?>][<?echo $association['Association']['id'];?>]" class="form-control" type="text" value="" placeholder="金額を入力してください"></td>
                                                            <?endforeach;?>
                                                        <?endif;?>
                                                    </tr>
                                                <?endforeach;?>
                                            </tbody>
                                        </table>
                                        <div class="form-actions noborder">
                                            <button type="submit" class="btn blue">更新</button>
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