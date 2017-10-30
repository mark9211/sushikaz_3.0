<?
# CSS files
echo $this->Html->css('assets/global/plugins/datatables/datatables.min.css');
echo $this->Html->css('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');
echo $this->Html->css('assets/global/css/components.min.css');
# JS files
echo $this->Html->script('assets/global/scripts/datatable.js');
echo $this->Html->script('assets/global/plugins/datatables/datatables.min.js');
echo $this->Html->script('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');
//echo $this->Html->script('assets/pages/scripts/table-datatables-buttons.min.js');

?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>買掛現金 <small>windows 8 style tiles examples</small></h1>
                </div>
                <div class="page-toolbar">
                    <!-- BEGIN THEME PANEL -->
                    <div class="btn-group btn-theme-panel">
                        <a href="#form_modal2" class="btn dropdown-toggle" data-toggle="modal">
                            <span class="badge badge-default" style="background: red;">日付変更</span>
                            <i class="icon-calendar"></i>
                        </a>
                    </div>
                    <!-- END THEME PANEL -->
                </div>
                <div id="form_modal2" class="modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">日付選択</h4>
                            </div>
                            <div class="modal-body">
                                <div id="formBd"></div>
                                <style type="text/css">
                                    .ui-state-active{background: #4DB2B6;}
                                    .ui-datepicker{width: 100%; font-family: 'Monda', sans-serif; text-align: center; background: #48C2C2; margin: 0 0 10px 0}
                                    .ui-datepicker a{color: #fff;}
                                    .ui-datepicker-calendar{width: 100%;}
                                    .ui-datepicker-group{margin: 0 0 10px 0;background: #48C2C2;}
                                    .ui-datepicker-header {color: #fff;padding: 15px;text-transform: uppercase;letter-spacing: 3px;}
                                    .ui-datepicker-calendar thead th{color: #fff; padding:10px;}
                                    .ui-datepicker-calendar th,.ui-datepicker-calendar td{font-size: 14px; color: #378F8F; text-align: center;}
                                    .ui-datepicker-calendar td span{display: block; padding:10px;}
                                    .ui-datepicker-calendar td a{color: #fff; display: block; padding:10px;}
                                    .ui-datepicker-title{clear: both;}
                                    .ui-datepicker-prev{float: left;}
                                    .ui-datepicker-next{float: right;}
                                </style>
                                <script>
                                    $(function(){
                                        //パラメータ取得
                                        var url = location.href;
                                        var parameters = url.split("?");
                                        var params = parameters[1].split("&");
                                        var paramsArray = [];
                                        for ( i = 0; i < params.length; i++ ) {
                                            neet = params[i].split("=");
                                            paramsArray.push(neet[0]);
                                            paramsArray[neet[0]] = neet[1];
                                        }
                                        var queryDate = paramsArray["date"];

                                        // DATE PICKER
                                        $('#formBd').datepicker({
                                            dateFormat: "yy-mm-dd",
                                            onSelect: function(dateText, inst){
                                                var date  = dateText;
                                                var str = date.split('-');
                                                var month = str[0]+'-'+str[1]+'-01';
                                                var url   = location.href;
                                                var parameters    = url.split("?");
                                                var dateJob = parameters[1].split("=");
                                                if (date != dateJob[1]) {
                                                    window.location.href = '?date='+month;
                                                };
                                            }
                                        });
                                        $('#formBd').datepicker("setDate", queryDate);

                                    });
                                </script>
                            </div>
                            <div class="modal-footer">
                                <h5 class="modal-title">日付をタップしてください</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PAGE TITLE -->
            </div>
        </div>
        <div class="page-container">
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="container">
                    <!-- BEGIN PAGE BREADCRUMBS -->
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="#">More</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="#">Tables</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span>Datatables</span>
                        </li>
                    </ul>
                    <!-- END PAGE BREADCRUMBS -->
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase">支払入力（<?echo date('Y年m月', strtotime($date));?>分）</span>
                                        </div>
                                        <div class="tools"></div>
                                    </div>
                                    <div class="portlet-body">
                                        <form id="tableForm" role="form" action="" method="post">
                                            <input type="hidden" class="date" value="<?echo $date;?>">
                                            <table class="table table-striped table-hover table-bordered" id="sample_1" style="border-bottom-color: #e7ecf1">
                                                <thead>
                                                <tr>
                                                    <th> Num </th>
                                                    <th> 分類 </th>
                                                    <th> 各支払先 </th>
                                                    <?foreach($association_arr as $association):?>
                                                        <th><?echo $association['Location']['name'];?>（<?echo $association['Attribute']['name'];?>）</th>
                                                    <?endforeach;?>
                                                    <th> 合計 </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?$num=0;$cell_arr=array(1=>5,2=>39,3=>51,4=>58,5=>63,6=>69);$type_arr=array();?>
                                                    <?foreach($kaikake_stores as $kaikake_store):?>
                                                        <tr>
                                                            <?$type=$kaikake_store['Type'];?>
                                                            <td> <?if(!in_array($type['id'],$type_arr)){$type_arr[]=$type['id'];$num=$cell_arr[$type['id']];echo $num;}else{$num++;echo $num;}?> </td>
                                                            <td> <?echo $kaikake_store['Type']['name'];?> </td>
                                                            <td> <?echo $kaikake_store['KaikakeStore']['name'];?> </td>
                                                            <?foreach($association_arr as $association):?>
                                                                <?$id=$association['Association']['id'];?>
                                                                <?if($kaikake_store['IntermediateOne'][$id]==true):?>
                                                                <td class="clickable">
                                                                    <?if(isset($kaikake_store['Today'][$id])):?>
                                                                        <span><?echo $kaikake_store['Today'][$id]['KaikakeFee']['fee'];?></span>
                                                                        <input type="text" placeholder="金額を入力してください" class="form-control input-small inputNumber invisible" value="" style="display: none;">
                                                                    <?else:?>
                                                                        <input type="text" placeholder="金額を入力してください" class="form-control input-small inputNumber visible <?if($id==4&&$num!=16&&$num!=50&&$num!=68){echo "separate";}?>" value="" style="display: block;">
                                                                    <?endif;?>
                                                                    <input type="hidden" class="association" value="<?echo $id;?>">
                                                                    <input type="hidden" class="store" value="<?echo $kaikake_store['KaikakeStore']['id'];?>">
                                                                </td>
                                                                <?else:?>
                                                                    <td>×</td>
                                                                <?endif;?>
                                                            <?endforeach;?>

                                                            <td class="totalSum">
                                                                <?if(isset($kaikake_store['Total'])){echo $kaikake_store['Total'];}?>
                                                            </td>
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
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN Tanaoroshi -->
                    <div class="page-content-inner">
                        <div class="row">
                            <?foreach($stocking_types as $key => $stocking_type_arr):?>
                                <div class="col-md-3">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class="portlet light ">
                                        <div class="portlet-title">
                                            <div class="caption font-dark">
                                                <i class="icon-pin font-dark"></i>
                                                <span class="caption-subject bold uppercase">棚卸（ <?echo $associations[$key]['Location']['name'].' '.$associations[$key]['Attribute']['name'];?>）</span>
                                            </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="portlet-body flip-scroll">
                                            <form role="form" action="" method="post">
                                                <input type="hidden" name="date" value="<?echo $date;?>">
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead class="flip-content">
                                                    <tr>
                                                        <th width="30%">
                                                            分類
                                                        </th>
                                                        <th width="35%">
                                                            前月
                                                        </th>
                                                        <th class="35%">
                                                            今月
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?foreach($stocking_type_arr as $stocking_type):?>
                                                        <tr>
                                                            <td>
                                                                <?echo $stocking_type['StocktakingType']['name']?>
                                                            </td>
                                                            <td class="numeric">
                                                                <input name="Stocktaking[<?echo $key;?>][<?echo $stocking_type['StocktakingType']['id'];?>][last_month]" class="form-control" type="text" value="<?if(isset($stocking_type['ThisMonth'])){echo $stocking_type['ThisMonth']['Stocktaking']['last_month'];}else{echo 0;}?>">
                                                            </td>
                                                            <td class="numeric">
                                                                <input name="Stocktaking[<?echo $key;?>][<?echo $stocking_type['StocktakingType']['id'];?>][this_month]" class="form-control" type="text" value="<?if(isset($stocking_type['ThisMonth'])){echo $stocking_type['ThisMonth']['Stocktaking']['this_month'];}else{echo 0;}?>">
                                                            </td>
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
                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                    <!-- END Tanaoroshi -->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<script>
    // AJAX
    $(function(){

        // 入力済みのinputをtextへ
        $(".inputNumber").blur(function(){
            var value = $(this).val();

            if(value!=''){
                // 値分割処理（和光指定）
                var association_id = $(this).parent().find(".association").val();
                if(association_id==3){
                    // 存在判定
                    if($(this).parent().parent().find(".separate").length!=0){
                        if(value%2==0){
                            value = value/2;
                            $(this).parent().parent().find(".separate").val(value);
                        }else{
                            value = Math.floor(value/2);
                            $(this).parent().parent().find(".separate").val(value);
                            value++;
                        }
                        $(this).parent().parent().find(".separate").css('display', 'block');
                        $(this).parent().parent().find(".separate").parent().find("span").remove();
                        $(this).parent().parent().find(".separate").removeClass("invisible");
                        $(this).parent().parent().find(".separate").addClass("visible");
                        $(this).parent().parent().find(".separate").focus();
                    }
                }


                $(this).parent().append('<span>'+value+'</span>');
                $(this).css('display', 'none');
                $(this).removeClass("visible");
                $(this).addClass("invisible");

                // AJAX
                var store_id = $(this).parent().find(".store").val();
                var date = $('.date').val();
                var array = {0:association_id, 1:store_id, 2:date, 3:value};
                // Function
                ajaxSend(array);

                // Total Calculate
                var total = 0;
                var spans = $(this).parent().parent().find("span");
                if(spans.length!=0){
                    spans.each(function(){
                        //console.log(parseInt($(this).text()));
                        total += parseInt($(this).text());
                    });
                }
                $(this).parent().parent().find(".totalSum").text(total);
            }
        });

        // 再クリック時にinput復活
        $(".clickable").click(function(){
            if($(this).find("input").css('display')=='none'){
                var value = $(this).find("span").text();
                //console.log(value);
                $(this).find("span").remove();
                $(this).find(".inputNumber").val(value);
                $(this).find(".inputNumber").attr("value", value);

                $(this).find(".inputNumber").css('display', 'block');
                $(this).find(".inputNumber").removeClass("invisible");
                $(this).find(".inputNumber").addClass("visible");
                // Focus
                $(this).find(".inputNumber").focus();
            }
        });

        function ajaxSend(array){
             $.ajax({
             url: "<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'ajax2'));?>",
             type:'POST',
             data: array
             }).done(function(data, textStatus, jqXHR){
                 //var obj = jQuery.parseJSON(data);
                 //console.log(obj);
             }).fail(function(data, textStatus, errorThrown){
                 alert(textStatus); //エラー情報を表示
                 // console.log(errorThrown.message); //例外情報を表示
             }).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
                 // alert(textStatus);
                 // Post処理(inputが全て埋まったら)
                 /*
                 if($("#sample_1").find(".visible").length==0){
                     $("#tableForm").submit();
                 }
                 */
             });
        }

    });

    // TABLE
    var TableDatatablesButtons = function () {

        var initTable1 = function () {
            var table = $('#sample_1');

            var oTable = table.dataTable({

                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "_START_ ~ _END_ 件表示 (_TOTAL_ 件中)",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered1 from _MAX_ total entries)",
                    "lengthMenu": "_MENU_ 件",
                    "search": "検索:",
                    "zeroRecords": "No matching records found"
                },

                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},


                buttons: [
                    { extend: 'print', className: 'btn dark btn-outline' },
                    { extend: 'copy', className: 'btn red btn-outline' },
                    //{ extend: 'pdf', className: 'btn green btn-outline' },
                    //{ extend: 'excel', className: 'btn yellow btn-outline ' },
                    { extend: 'csv', className: 'btn purple btn-outline '},
                    { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'},
                    {
                        text: 'Excel',
                        className: 'btn yellow btn-outline',
                        action: function ( e, dt, node, config ) {
                            // body or header
                            var array = dt.buttons.exportData().body;
                            var postForm = function(url, data) {
                                var $form = $('<form/>', {'action': url, 'method': 'post'});
                                // 日付
                                $form.append($('<input/>', {'type': 'hidden', 'name': 'date', 'value': $('.date').val()}));
                                for(var key in data) {
                                    $form.append($('<input/>', {'type': 'hidden', 'name': key, 'value': data[key]}));
                                }
                                $form.appendTo(document.body);
                                $form.submit();
                            };
                            postForm("<?echo $this->Html->url(array('controller'=>'member_profiles', 'action'=>'excel2'));?>", array);

                        }
                    }
                ],

                // setup responsive extension: http://datatables.net/extensions/responsive/
                responsive: true,

                //"ordering": false,
                //"paging": false, disable pagination

                "order": [
                    [0, 'asc']
                ],

                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": -1,

                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });
        }

        var initTable2 = function () {
            var table = $('#sample_2');

            var oTable = table.dataTable({

                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "_START_ ~ _END_ 件表示 (_TOTAL_ 件中)",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered1 from _MAX_ total entries)",
                    "lengthMenu": "_MENU_ 件",
                    "search": "検索:",
                    "zeroRecords": "No matching records found"
                },

                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},

                buttons: [
                    { extend: 'print', className: 'btn default' },
                    { extend: 'copy', className: 'btn default' },
                    { extend: 'pdf', className: 'btn default' },
                    { extend: 'excel', className: 'btn default' },
                    { extend: 'csv', className: 'btn default' },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            //dt.ajax.reload();
                            alert('Custom Button');
                        }
                    }
                ],

                responsive: true,

                "order": [
                    [0, 'asc']
                ],

                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 20,

                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });
        }

        return {
            //main function to initiate the module
            init: function () {
                if (!jQuery().dataTable) {
                    return;
                }
                initTable1();
                initTable2();
            }
        };

    }();

    jQuery(document).ready(function() {
        TableDatatablesButtons.init();
    });

</script>