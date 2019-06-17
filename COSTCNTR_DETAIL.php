<?
include_once "inc/auth.inc.php";
include_once "inc/utility_all.php";

$query = "SELECT SAP_DEPT_ID FROM department WHERE DEPT_ID=" . $_SESSION["LOGIN_DEPT_ID"];
$cursor = exequery(TD::conn(), $query);
if ($ROW = mysql_fetch_row($cursor))
  $SAP_DEPT_ID = $ROW[0];

$query2 = "SELECT BYNAME FROM `user` WHERE `user_id`='" . $_SESSION["LOGIN_USER_ID"] . "'";
$cursor2 = exequery(TD::conn(), $query2);
if ($ROW2 = mysql_fetch_row($cursor2))
  $SAP_ID = $ROW2[0];

// echo $SAP_DEPT_ID;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>详情</title>
    <link rel="stylesheet" href="./layui/css/layui.css">
    <style>
        .container {
      padding: 20px 0;
      width: 1170px;
      margin-left: 310px;
    }

    .select-item {
      float: left;
    }

    .select-item .layui-form-label {
      width: auto;
    }

    .select-item-first .layui-form-label {
      width: 80px;
    }
    
    .layui-table-view .layui-table th {
        background-color: #f2f2f2;
    }

    .layui-table-view .layui-table td{
      background-color: #fff;
    }

    .layui-table-cell,
    .layui-table-tool-panel li {
      overflow: unset;
      text-overflow: unset;
    }

    .tree-box {
      position: absolute;
      top: 40px;
      left: 50%;
      margin-left: -890px;
      width: 300px;
      height: 500px;
      overflow: auto;
      border: 1px solid #aaa;
    }
    </style>
</head>

<body>
    <div class="layui-container container">
    <div class="layui-form">
      <!-- <div class="layui-form-item">
                <label class="layui-form-label">公司代码</label>
                <div class="layui-input-block">
                    <input type="text" id="ggdm" name="title" required lay-verify="required" placeholder="请输入标题"
                        autocomplete="off" class="layui-input" value="1000">
                </div>
            </div> -->
      <div class="tree-box">
        <ul id="dept" class="ztree" style="float: left;"></ul>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label" style="width: 100%;text-align: center;font-size:22px;">九洲集团成本中心明细</label>
        <div class="cbzxlist" style="display:inline;"></div>
        <!-- <div class="layui-inline">
                    <select name="city" lay-verify="required" id="qj">
                        <option value="BT">区间</option>
                        <option value="EQ">单个(多个不连续的,)</option>
                    </select>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">范围</label>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" id="ks" value="1000100000" name="price_min" placeholder="请输入id" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" id="js" value="1000299999" name="price_max" placeholder="请输入id" autocomplete="off" class="layui-input">
                    </div>
                </div> -->
      </div>

            <div class="layui-form-item select-list">
                <div class="select-item select-item-first">
                    <label class="layui-form-label">年</label>
                    <div class="layui-inline">
                        <select name="city" lay-verify="required" id="nian">
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                        </select>
                    </div>
                </div>
                <div class="select-item">
                    <label class="layui-form-label">月</label>
                    <div class="layui-inline">
                        <select name="city" id="yue" lay-verify="required">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>
               <!-- <div class="select-item">
                    <label class="layui-form-label">包含报废资产</label>
                    <div class="layui-inline">
                        <select name="city" id="bhbfzc" lay-verify="required">
                            <option value="">否</option>
                            <option value="x">是</option>
                        </select>
                    </div>
                </div>-->
                <div class="select-item">
                    <button class="layui-btn search-btn">查询</button>
                </div>
                <div class="select-item" style="margin-left: 10px;">
                    <input class="layui-btn" value="导出" type="button" onclick="formsubmit()"/>
                </div>
            </div>
        </div>
        
        <table class="layui-hide" id="demo" lay-filter="test"></table>
    </div>
    
    <script src="./layui/layui.all.js" charset="gb2312" ></script>
    <link rel="stylesheet" href="ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="jquery-2.2.4.js"></script>
  <script type="text/javascript" src="ztree/js/jquery.ztree.core.js"></script>
  <script type="text/javascript" src="ztree/js/jquery.ztree.excheck.js"></script>
  <script>
      var zsurl = "http://192.168.1.88:8086/";
    var url = zsurl;


    var settingcbzx = {
      data: {
        simpleData: {
          enable: true
        }
      },
      check: {
        enable: true,
        chkStyle: "checkbox",
        chkboxType: {
          "Y": "ps",
          "N": "ps"
        }
      }
      // check: {
      // 	enable: true
      // }

    };

    function formsubmit(){
        var qjz = '';
            var data=[];           
            var cbzx=$.fn.zTree.getZTreeObj("dept");
            if(cbzx){
             var nodes=cbzx.getCheckedNodes(true);             
             var v="";             
            for(var i=0;i<nodes.length;i++){
              var item={};
            v+=nodes[i].name + ",";
            //console.log("节点id:"+nodes[i].id+";;;节点名称"+nodes[i].name+";;;;父节点:"+nodes[i].pid+";;;;shibushifu节点:"+nodes[i].isParent+"");
                 if (i == 0) {
                    qjz = nodes[i].id;
                } else {
                    qjz += ',' + nodes[i].id;
                }
            }
            }
        var form = $('<form></form>');
    // 设置属性 I_BUKRS: ggdm,I_YEAR:nian,I_MONTH:yue,OPTION:qj,LOW:ks,HIGH:js
    var newUrl = 'http://192.168.1.88:8086/handler1.ashx?t=COSTCNTR_DETAILEXP';
    form.attr('action', newUrl);
    form.attr('method', 'post');
//I_BUKRS: ggdm,I_YEAR:nian,I_PERIO:yue,I_DEAKT:bhbfzc,OPTION:qj,LOW:ks,HIGH:js
    // 创建Input
    var I_BUKRS_input = $('<input  name="I_BUKRS" type="hidden" />');
    I_BUKRS_input.attr('value',  1000);
    // 附加到Form
    form.append(I_BUKRS_input);

     // 创建Input
     var I_YEAR_input = $('<input  name="I_YEAR" type="hidden" />');
     I_YEAR_input.attr('value', $("#nian option:selected").val());
    // 附加到Form
    form.append(I_YEAR_input);

     // 创建Input
     var I_PERIO_input = $('<input  name="I_MONTH" type="hidden" />');
     I_PERIO_input.attr('value', $("#yue option:selected").val() );
    // 附加到Form
    form.append(I_PERIO_input);

     // 创建Input
     var OPTION_input = $('<input  name="OPTION" type="hidden" />');
     OPTION_input.attr('value',  'EQ');
    // 附加到Form
    form.append(OPTION_input);

    // 创建Input
    var LOW_input = $('<input  name="LOW" type="hidden" />');
    LOW_input.attr('value',  qjz);
    // 附加到Form
    form.append(LOW_input);

    // 创建Input
    var HIGH_input = $('<input  name="HIGH" type="hidden" />');
    HIGH_input.attr('value',  '');
    // 附加到Form
    form.append(HIGH_input);

    $(document.body).append(form);
    console.log(form.html())
    // 提交表单
    form.submit();
    }


    $(document).ready(function() {

      $.ajax({
        url: url + "Dept_Cbzx.ashx?t=GetUserCbzx&uid=<? echo $SAP_ID ?> &deptid=<? echo $SAP_DEPT_ID ?> ",
        type: 'post',
        success: function(data) {
          var zNodes = data;
          $.fn.zTree.init($("#dept"), settingcbzx, zNodes);
          var treeObj=$.fn.zTree.getZTreeObj("dept");
            treeObj.checkAllNodes(true);
        }
      })
    });
        layui.use(['table'], function() {
            table = layui.table
            search(layui.table);

            $(".search-btn").on("click", function() {
                search(layui.table);
            })
        })

        function search (table) {
            //var ggdm = $("#ggdm").val(); //公司代码
            var ggdm = "1000"; //公司代码
            //var qj = $("#qj option:selected").val(); //区间
            var qj = "EQ"; //区间
            //所有的checkbox选中项
            var qjz = '';
            var data=[];           
            var cbzx=$.fn.zTree.getZTreeObj("dept");
            if(cbzx){
             var nodes=cbzx.getCheckedNodes(true);             
             var v="";
             
            for(var i=0;i<nodes.length;i++){
              var item={};
            v+=nodes[i].name + ",";
            //console.log(nodes[i].id); //获取选中节点的值
            console.log("节点id:"+nodes[i].id+";;;节点名称"+nodes[i].name+";;;;父节点:"+nodes[i].pid+";;;;shibushifu节点:"+nodes[i].isParent+"");
            // item.id=nodes[i].id;
            // item.name=nodes[i].name;
            // item.pid=nodes[i].pid;
            // item.isParent=nodes[i].isParent==true?1:0;
            // data.push(item);
            //console.log("节点id:"+nodes[i].id+"节点名称"+v);
                 if (i == 0) {
                    qjz = nodes[i].id;
                } else {
                    qjz += ',' + nodes[i].id;
                }
            }
            }
            console.log(qjz);
            var ks = qjz; //开始
            //var js = $("#js").val(); //结束
            var js = ""; //结束
            var nian = $("#nian option:selected").val(); //年
            var yue = $("#yue option:selected").val(); //月
            var bhbfzc = $("#bhbfzc option:selected").val(); //包含报废资产
            //&I_BUKRS=" + ggdm + "&I_YEAR=" + nian +"&I_MONTH=" + yue + "&OPTION=" + qj + "&LOW=" + ks + "&HIGH=" +js + "
            var url = "http://192.168.1.88:8086/handler1.ashx?t=COSTCNTR_DETAIL";

            table.render({
                elem: '#demo'
                ,width: 1200
                ,height: 600
                ,url: url //数据接口
                ,method:"post"
                ,where: {I_BUKRS: ggdm,I_YEAR:nian,I_MONTH:yue,OPTION:qj,LOW:ks,HIGH:js}
                ,title: '用户表'
                , text: {
    none: '暂无相关数据' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
  }
                ,cols: [[ //表头
                {field: 'RBUKRS', width: 86, title: '公司代码'}
                ,{field: 'GJAHR', width: 86, title: '财年'}
                ,{field: 'POPER', width: 86, title: '过账期间'}
                ,{field: 'BELNR', width: 114, title: '会计凭证号码'}
                ,{field: 'DOCLN', width: 86, title: '行项目'}
                ,{field: 'RACCT', width: 104, title: '科目号'}
                ,{field: 'RACCTTXT', width: 236, title: '科目号描述'}
                ,{field: 'RCNTR', width: 110, title: '成本中心'}
                ,{field: 'RCNTRTXT', width: 311, title: '成本中心描述'}
                ,{field: 'PRCTR', width: 108, title: '利润中心'}
                ,{field: 'PRCTRTXT', width: 226, title: '利润中心描述'}
                ,{field: 'WSL', width: 110, title: '金额'}
                ,{field: 'SGTXT', width: 388, title: '项目文本'}
                ,{field: 'BUDAT', width: 103, title: '凭证中的过账日期'}
                ]]
            });
        }
        
    </script>
</body>

</html>