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
                                <label class="control-label col-md-1 col-sm-1 col-xs-12">开盘价</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Default Input">
                                </div>
                                <label class="control-label col-md-1 col-sm-1 col-xs-12">Default Input</label>
                                <div class="col-md-1 col-sm-1 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Default Input">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-1 col-sm-1 col-xs-12" style="padding-top: 22px;">开盘价</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" id="openpri" name="example_name" value="" />
                                </div>
                            </div></br>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
                                    <button type="button" class="btn btn-default" >重 置</button>
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
    });
    var slider = $("#openpri").data("ionRangeSlider");
    
    // 列表参数配置
    var table = $("table[grid-manager='table_one']");
    table.GM({
        ajax_url: '<?php echo base_url() ?>/admin/gold/post_data'
        , ajax_type: 'POST'
        , query: {pluginId: 1}
        , supportAjaxPage: true
        , disableCache: true
        , supportSorting: true
        , height: '100%'
        , columnData: [
            {
                key: 'variety',
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
            }
        ]
    });
    
    // 检索
    function submit_search() {
        console.log($("#variety").val());
        var _query = {
                variety: $("#variety").val(),
                openpriMin: $("#openpriMin").val(),
                openpriMax: $("#openpriMax").val()
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
</script>

