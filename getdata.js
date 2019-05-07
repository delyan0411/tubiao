function getRatio(now, old) {
    if (now < old) {
        return '降低' + ((old - now) / old * 100).toFixed(2) + '%'
    } else if (now > old) {
        return '增长' + ((now - old) / old * 100).toFixed(2) + '%'
    }
}

function getData(options, callback) {

    $.ajax({
        url: options.url,
        type: 'get',
        dataType: 'json',
        success: function (res) {
            var zrw, ze, tbxse, hbxse;

            //获取当月天数
            var now = new Date();
            var month = now.getMonth() + 1;
            var year = now.getFullYear();
            var day = now.getDate();
            
            var d = new Date(year, month, 0);
            var days = d.getDate()
            
            //当日占比
            var proportion = (day - 1) / days;

            var flag = ((options.date.indexOf(year) != -1) && (options.date.indexOf(month) != -1));
            if (options.tag === 'xs') {
                zrw = parseFloat(res.zrwe);
                ze = parseFloat(res.zxse);
                tbxse = parseFloat(res.tbxse);
                hbxse = parseFloat(res.hbxse);

                if (flag) {
                    tbxse = tbxse * proportion;
                    hbxse = hbxse * proportion;
                }
                
                $(".xsRatio").html("同比" + getRatio(ze, tbxse) + "，环比" + getRatio(ze, hbxse));
                
            } else if (options.tag === 'ml') {
                zrw = parseFloat(res.zmlerw);
                ze = parseFloat(res.zmle);
                tbxse = parseFloat(res.tbmle);
                hbxse = parseFloat(res.hbmle);

                if (flag) {
                    tbxse = tbxse * proportion;
                    hbxse = hbxse * proportion;
                }

                $(".mlRatio").html("同比" + getRatio(ze, tbxse) + "，环比" + getRatio(ze, hbxse));
            } else if (options.tag === 'yxs') {
                zrw = parseFloat(res.yyrew);
                ze = parseFloat(res.yyxse);
                tbxse = parseFloat(res.yytbxse);
                hbxse = parseFloat(res.yyhbxse);

                if (flag) {
                    tbxse = tbxse * proportion;
                    hbxse = hbxse * proportion;
                }

                $(".xsRatio").html("同比" + getRatio(ze, tbxse) + "，环比" + getRatio(ze, hbxse));
                
            } else if (options.tag === 'yml') {
                zrw = parseFloat(res.yymlerw);
                ze = parseFloat(res.yymle);
                tbxse = parseFloat(res.yytbmle);
                hbxse = parseFloat(res.yyhbmle);

                if (flag) {
                    tbxse = tbxse * proportion;
                    hbxse = hbxse * proportion;
                }

                $(".mlRatio").html("同比" + getRatio(ze, tbxse) + "，环比" + getRatio(ze, hbxse));
                
            }

            var histogramDom = document.getElementById(options.histogramId)
            var dashBoardDom = document.getElementById(options.dashBoardId)
            var charts = []

            //生成柱状图
            var myChart = echarts.init(histogramDom);
            option = {
                title: {
                    text: options.title
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    // data: ['', '', '', options.zrw, options.ze]
                    data: ['', '', options.tbtl, options.zetl, options.hbtl]
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                yAxis: {
                    type: 'value',
                    boundaryGap: [0, 0.01],
                    axisLabel: {
                        formatter: function (value) {
                            return value + '万元';
                        }
                    },
                    splitLine: {
                        show: false
                    }
                },
                xAxis: {
                    type: 'category',
                    data: [options.date],
                    axisTick: {
                        alignWithLabel: true
                    },
                    axisLabel: {
                    }
                },
                series: [
                    {
                        name: options.tbtl,
                        type: 'bar',
                        data: [tbxse.toFixed(2)],
                        label: {
                            normal: {
                                show: true,
                                position: 'insideRight'
                            }
                        }
                    },
                    {
                        name: options.zetl,
                        type: 'bar',
                        data: [ze.toFixed(2)],
                        label: {
                            normal: {
                                show: true,
                                position: 'insideRight'
                            }
                        }
                    },
                    {
                        name: options.hbtl,
                        type: 'bar',
                        data: [hbxse.toFixed(2)],
                        label: {
                            normal: {
                                show: true,
                                position: 'insideRight'
                            }
                        }
                    },
                    {
                        name: '高点',
                        type: 'line',
                        data: [(zrw * 1.1).toFixed(2)],
                        markLine: {
                            silent: true,
                            data: [ {
                                yAxis: (zrw * 1.1).toFixed(2)
                            }],
                            lineStyle: {
                                width: 2
                            },
                            label: {
                                position: 'middle',
                                formatter: '高点: {c}'
                            }
                        }
                    },
                    {
                        name: '总任务',
                        type: 'line',
                        data: [(zrw * 1.0).toFixed(2)],
                        markLine: {
                            silent: true,
                            data: [ {
                                yAxis: (zrw * 1.0).toFixed(2)
                            }],
                            lineStyle: {
                                width: 2
                            },
                            label: {
                                position: 'middle',
                                formatter: '总任务: {c}'
                            }
                        }
                    },
                    {
                        name: '低点',
                        type: 'line',
                        data: [(zrw * 0.9).toFixed(2)],
                        markLine: {
                            silent: true,
                            data: [{
                                yAxis: (zrw * 0.9).toFixed(2)
                            }],
                            lineStyle: {
                                width: 2
                            },
                            label: {
                                position: 'middle',
                                formatter: '低点: {c}'
                            }
                        }
                    }

                ]
            }

            if (option && typeof option === "object") {
                myChart.setOption(option, true);
                charts.push(myChart);
            }

            //生成仪表盘
            var ratio = (ze / zrw * 100).toFixed(2);
            var myChart = echarts.init(dashBoardDom);
            option = {
                tooltip: {
                    formatter: "{a} <br/>{b} : {c}%"
                },
                series: [{
                    name: '业务指标',
                    type: 'gauge',
                    detail: {
                        formatter: '{value}%'
                    },
                    data: [{
                        value: ratio,
                        name: '完成率'
                    }]
                }]
            };

            if (option && typeof option === "object") {
                myChart.setOption(option, true);
                charts.push(myChart);
            }

            window.onresize = function () {
                for (var i = 0; i < charts.length; i++) {
                    charts[i].resize();
                }
            }

            if (callback) {
                callback();
            }
        }

        
    })
}

function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){return pair[1];}
    }
    return(false);
}