<!doctype html>
<html>
	<head>
		<title>Welcome to CodeIgniter</title>

		<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
		<script src="<?php echo base_url('js/echarts.min.js'); ?>"></script>
		<script src="<?php echo base_url('js/zepto.min.js'); ?>"></script>
	</head>
	<body>

		<style {csp-style-nonce}>
			div.logo {
				height: 200px;
				width: 155px;
				display: inline-block;
				opacity: 0.08;
				position: absolute;
				top: 2rem;
				left: 50%;
				margin-left: -73px;
			}
			body {
				height: 100%;
				background: #fafafa;
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				color: #777;
				font-weight: 300;
			}
			h1 {
				font-weight: lighter;
				letter-spacing: 0.8;
				font-size: 3rem;
				margin-top: 145px;
				margin-bottom: 0;
				color: #222;
			}
			.wrap {
				max-width: 1024px;
				margin: 5rem auto;
				padding: 2rem;
				background: #fff;
				text-align: center;
				border: 1px solid #efefef;
				border-radius: 0.5rem;
				position: relative;
			}
			.version {
				margin-top: 0;
				color: #999;
			}
			.guide {
				margin-top: 3rem;
				text-align: left;
			}
			pre {
				white-space: normal;
				margin-top: 1.5rem;
			}
			code {
				background: #fafafa;
				border: 1px solid #efefef;
				padding: 0.5rem 1rem;
				border-radius: 5px;
				display: block;
			}
			p {
				margin-top: 1.5rem;
			}
			.footer {
				margin-top: 2rem;
				border-top: 1px solid #efefef;
				padding: 1em 2em 0 2em;
				font-size: 85%;
				color: #999;
			}
			a:active,
			a:link,
			a:visited {
				color: #dd4814;
			}
		</style>
		<div id="main" style="width: 1000px;height:400px;"></div>
	    <script type="text/javascript">
	        // 基于准备好的dom，初始化echarts实例
	        var myChart = echarts.init(document.getElementById('main'));

	        // 指定图表的配置项和数据
	        var option = {
	            title: {
	                text: '黄金数据AU99.99'
	            },
	            tooltip: {
					show: true,
			        feature: {
			            dataZoom: {
			                yAxisIndex: 'none'
			            },
			            dataView: {readOnly: false},
			            magicType: {type: ['line', 'bar']},
			            restore: {},
			            saveAsImage: {}
			        }
				},
	            legend: {
	                data:['AU99.99']
	            },
	            xAxis: {
	                data: []
	            },
	            yAxis: {
					min:function (value) {
						return value.min - 0.2;
					},
					max:function (value) {
						return value.max + 0.2;
					},
					splitNumber:5
				}
	        };

	        // 使用刚指定的配置项和数据显示图表。
	        myChart.setOption(option);

			function get_data() {
				$.ajax({
					url:"<?php echo base_url('home/get_data'); ?>",
					type:"GET",
					dataType:"json",
					success:function(data, status, xhr){
						// 填入数据
						myChart.setOption({
							xAxis: {
								data: data.time
							},
							series: [{
								name: 'AU99.99',
								type: 'line',
								data: data.latestpri,
								markPoint: {
									data: [
										{type: 'max', name: '最大值'},
										{type: 'min', name: '最小值'}
									]
								},
								markLine: {
									data: [
										{type: 'average', name: '平均值'}
									]
								}
							}]
						});
					},
					error:function(xhr, type){
						alert(type);
					}
				})
			}
			get_data();
			window.setInterval(function(){
				get_data();
			},60000);

	    </script>

	</body>
</html>
