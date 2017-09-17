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
                        <table grid-manager="table_one"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<!-- GridManager_2.3.14 Scripts -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/GridManager/js/GridManager.js"></script>
<script type="text/javascript">
    var table = $("table[grid-manager='table_one']");
    table.GM({
        ajax_url: 'http://liuyi.com/admin/gold/post_data'
        , ajax_type: 'POST'
        , query: {pluginId: 1}
        , supportAjaxPage: true
        , disableCache: true
        , supportSorting:true
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
                key: 'time',
                text: '时间',
                sorting: 'DESC'
            }
        ]
    });
</script>

