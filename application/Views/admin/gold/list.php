<style>
    /*修复列表底部错位问题*/
    .dataTables_info{
        float:none;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>黄金大数据</h3>
            </div>

            <!--            <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div>-->
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>列表</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-1 col-sm-1 col-xs-12">类型</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <select class="form-control" id="variety">
                                        <option value="">请选择</option>
                                        <?php foreach ($variety as $key => $value) :?>
                                        <option value="<?php echo $value['variety']?>"><?php echo $value['variety']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <label class="control-label col-md-1 col-sm-1 col-xs-12">最高价</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="text" class="form-control" placeholder="请输入数字" id="maxpri">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-1 col-sm-1 col-xs-12" style="padding-top: 22px;">开盘价</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" id="openpri" name="example_name" value="" />
                                </div>
                            </div>
                            </br>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
                                    <button type="button" class="btn btn-default" onclick="reset_fun();">重 置</button>
                                    <button type="button" class="btn btn-success" onclick="submit_search();">检 索</button>
                                </div>
                            </div>
                        </form>
                        <div class="ln_solid"></div>
                        <table grid-manager="table_one"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<!-- 隐藏值 -->
<input id="openpriMin" value="<?php echo $openpriMin['openpri']?>" hidden="">
<input id="openpriMax" value="<?php echo $openpriMax['openpri']?>" hidden="">
<!-- /隐藏值 -->

<!-- GridManager_2.3.14 Scripts -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/GridManager/js/GridManager.js"></script>
<!-- Ion.RangeSlider -->
<script src="<?php echo base_url()?>assets/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#time_new').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePickerSeconds: true,
            singleClasses: "picker_3",
            locale: {
                applyLabel: '确定',
                cancelLabel: '取消',
                format: 'YYYY-MM-DD HH:mm:ss',
                daysOfWeek: '日_一_二_三_四_五_六'.split('_'),
                monthNames: '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'.split('_'),
            }
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });

    
    // 开盘价滑块配置
    $("#openpri").ionRangeSlider({
        hide_min_max: true,
        keyboard: true,
        min: <?php echo $openpriMin['openpri']?>,
        max: <?php echo $openpriMax['openpri']?>,
        from: <?php echo $openpriMin['openpri']?>,
        to: <?php echo $openpriMax['openpri']?>,
        type: 'double',
        step: 0.01,
        prefix: "¥",
        grid: true,
        onChange: function (data) {
            $("#openpriMin").val(data.from);
            $("#openpriMax").val(data.to)
        }
    });
    var slider = $("#openpri").data("ionRangeSlider");

    // 初始化旧数据，下面修改modal会用到
    var old_data;
    
    // 列表参数配置
    var table = $("table[grid-manager='table_one']");
    table.GM({
        ajax_url: '<?php echo base_url() ?>/admin/gold/post_data'
        , ajax_type: 'POST'
        , supportRemind: true
        , query: {pluginId: 1}
        , supportAjaxPage: true
        , supportSorting: true
        , height: '100%'
        , columnData: [
            {
                key: 'variety',
                remind: '这里可以显示说明',
                text: '类型',
                sorting: ''
            }, {
                key: 'latestpri',
                text: '最新价',
                sorting: ''
            }, {
                key: 'openpri',
                text: '开盘价',
                sorting: ''
            }, {
                key: 'maxpri',
                text: '最高价',
                sorting: ''
            }, {
                key: 'minpri',
                text: '最低价',
                sorting: ''
            }, {
                key: 'limit',
                text: '涨跌幅',
                sorting: ''
            }, {
                key: 'yespri',
                text: '昨收价',
                sorting: ''
            }, {
                key: 'totalvol',
                text: '总成交量',
                sorting: ''
            }, {
                key: 'time',
                text: '时间',
                sorting: 'DESC'
            }, {
                key: 'operation',
                text: '操作',
                remind: '对该数据进行操作',
                template: function(nodeData, rowData){
                     // nodeData: 当前单元格的渲染数据
                    // rowData: 当前单元格所在行的渲染数据
                    return '<button type="button" class="btn btn-success btn-xs" onclick="update_modal_show(' + rowData.id + ');">&nbsp;&nbsp;修改&nbsp;&nbsp;</button>';
                }
            }
        ]
    });

    // 修改modal弹出
    function update_modal_show (id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>/admin/gold/get_row",
            data: "id=" + id,
            dataType: "json",
            success: function(result){
                console.log(result);
                if (result == null) {
                    new PNotify({
                        title: '出错啦(╯﹏╰)',
                        text: '刷新下试试或联系我们管理员吧',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                } else {
                    $("#variety_new").find("option[value='" + result.variety + "']").attr("selected",true);
                    $("#latestpri_new").val(result.latestpri);
                    $("#openpri_new").val(result.openpri);
                    $("#time_new").val(result.time);
                    $('#update_modal').modal('show');
                }
            }
        });
    }
    
    // 检索
    function submit_search() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>/admin/gold/post_check",
            data: "maxpri=" + $("#maxpri").val(),
            dataType: "json",
            success: function(result){
                if(result.maxpri){
                    new PNotify({
                        title: '输入 错误',
                        text: result.maxpri,
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                } else {
                    start_search();
                }
            }
        });
    }
    
    // 检索提出：感觉别的地方还能调用
    function start_search() {
        // 执行检索
        var _query = {
                variety: $("#variety").val(),
                openpriMin: $("#openpriMin").val(),
                openpriMax: $("#openpriMax").val(),
                maxpri: $("#maxpri").val()
        };
        table.GM('setQuery', _query, function(){
            new PNotify({
                title: '检索 成功',
                text: '理解能力不错哦~ 继续努力^_^',
                type: 'success',
                styling: 'bootstrap3'
            });
        });
    }
    
    // 重置
    function reset_fun () {
        $("#variety").find("option[value='']").attr("selected",true);
        $("#maxpri").val('');
        slider.reset();
        start_search();
    }
</script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="update_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">修改</h4>
        </div>
        <div class="modal-body">
            <form data-parsley-validate class="form-horizontal form-label-left">
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">类 型 <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" id="variety_new">
                            <?php foreach ($variety as $key => $value) :?>
                            <option value="<?php echo $value['variety']?>"><?php echo $value['variety']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">最 新 价 <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="latestpri_new" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">开 盘 价 <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="openpri_new" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">时 间 <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control has-feedback-left" id="time_new">
                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
          <button type="button" class="btn btn-success">保 存</button>
        </div>
      </div>
    </div>
</div>
