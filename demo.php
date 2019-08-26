
 <?
include_once "inc/auth.inc.php";
include_once "inc/utility_all.php";

 $query = "SELECT SAP_DEPT_ID FROM department WHERE DEPT_ID=".$_SESSION["LOGIN_DEPT_ID"];
$cursor = exequery(TD::conn(), $query);
if($ROW=mysql_fetch_row($cursor))
$SAP_DEPT_ID=$ROW[0];

$query2 = "SELECT BYNAME FROM `user` WHERE `user_id`='".$_SESSION["LOGIN_USER_ID"]."'";
$cursor2 = exequery(TD::conn(), $query2);
if($ROW2=mysql_fetch_row($cursor2))
$SAP_ID=$ROW2[0];

// echo $SAP_DEPT_ID;
 ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>demo</title>
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
        .search-name,
        .search-no {
            float: left;
          padding-left: 80px;
          overflow: hidden;
        }
        .search-name input,
        .search-no input {
          width: 300px;
          height: 34px;
          padding: 0 5px;
          float: left;
        }
        .search-box {
            overflow: hidden;
        }
    </style>
</head>

<body>

    <div class="layui-container container">
        <div class="layui-form">
            <div class="tree-box">
                <ul id="dept" class="ztree"  style="float: left;"></ul>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 100%;text-align: center;font-size:22px;">���޼��Ź̶��ʲ��嵥</label>
                <div class="cbzxlist" style="display:inline;"></div>
            </div>
            <div class="layui-form-item select-list">
                <div class="select-item select-item-first">
                    <label class="layui-form-label">��</label>
                    <div class="layui-inline">
                        <select name="nian" lay-verify="required" id="nian">
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                        </select>
                    </div>
                </div>
                <div class="select-item">
                    <label class="layui-form-label">��</label>
                    <div class="layui-inline">
                        <select name="yue" id="yue" lay-verify="required">
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
                <div class="select-item">
                    <label class="layui-form-label">���������ʲ�</label>
                    <div class="layui-inline">
                        <select name="bhbfzc" id="bhbfzc" lay-verify="required">
                            <option value="">��</option>
                            <option value="X">��</option>
                        </select>
                    </div>
                </div>
                <div class="select-item">
                    <button class="layui-btn search-btn">��ѯ</button>
                    <input type="hidden" value="" id="test"/>
                </div>
                <div class="select-item" style="margin-left: 10px;">
                    <input class="layui-btn" value="����" type="button" onclick="formsubmit()"/>
                </div>
            </div>
            <div class="search-box">
                <div class="search-no">
                    <input type="text" id="no-input" placeholder="�������ʲ�����">
                    <button class="layui-btn search-no-btn">����</button>
                </div>
                <div class="search-name">
                    <input type="text" id="desc-input" placeholder="�������ʲ�����">
                    <button class="layui-btn search-name-btn">����</button>
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
          var testurl="http://localhost:22674/";
    var zsurl="http://192.168.1.88:8086/";
    var url=zsurl;
   
  
		var settingcbzx = {
			data: {
				simpleData: {
					enable: true
				}
      },
      check:{
        enable: true,
		chkStyle: "checkbox",
		chkboxType: { "Y": "ps", "N": "ps" }
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
                 if (i == 0) {
                    qjz = nodes[i].id;
                } else {
                    qjz += ',' + nodes[i].id;
                }
            }
            }
        var form = $('<form></form>');
    // ��������
    var newUrl = 'http://192.168.1.88:8086/handler1.ashx?t=SLTANLAEXP';
    form.attr('action', newUrl);
    form.attr('method', 'post');
//I_BUKRS: ggdm,I_YEAR:nian,I_PERIO:yue,I_DEAKT:bhbfzc,OPTION:qj,LOW:ks,HIGH:js
    // ����Input
    var I_BUKRS_input = $('<input  name="I_BUKRS" type="hidden" />');
    I_BUKRS_input.attr('value',  1000);
    // ���ӵ�Form
    form.append(I_BUKRS_input);
    
  // ����Input
  var test_input = $('<input  name="test" type="hidden" />');
  test_input.attr('value', $("#test").val());
     form.append(test_input);

     // ����Input
     var I_YEAR_input = $('<input  name="I_YEAR" type="hidden" />');
     I_YEAR_input.attr('value', $("#nian option:selected").val());
    // ���ӵ�Form
    form.append(I_YEAR_input);

     // ����Input
     var I_PERIO_input = $('<input  name="I_PERIO" type="hidden" />');
     I_PERIO_input.attr('value', $("#yue option:selected").val() );
    // ���ӵ�Form
    form.append(I_PERIO_input);

     // ����Input
     var I_DEAKT_input = $('<input  name="I_DEAKT" type="hidden" />');
     I_DEAKT_input.attr('value',  $("#bhbfzc option:selected").val());
    // ���ӵ�Form
    form.append(I_DEAKT_input);

     // ����Input
     var OPTION_input = $('<input  name="OPTION" type="hidden" />');
     OPTION_input.attr('value',  'EQ');
    // ���ӵ�Form
    form.append(OPTION_input);

    // ����Input
    var LOW_input = $('<input  name="LOW" type="hidden" />');
    LOW_input.attr('value',  qjz);
    // ���ӵ�Form
    form.append(LOW_input);

        // ����Input
        var HIGH_input = $('<input  name="HIGH" type="hidden" />');
        HIGH_input.attr('value',  '');
    // ���ӵ�Form
    form.append(HIGH_input);

    $(document.body).append(form);
    console.log(form.html())
    // �ύ��
    form.submit();
    }

    $(document).ready(function(){
        getDateNow();
        layui.use('form',function(){
          layui.form.render('select');
        });
        $.ajax({
            url: url+"Dept_Cbzx.ashx?t=GetUserCbzx&uid=<?echo $SAP_ID ?>&deptid=<?echo $SAP_DEPT_ID ?> ",
            type: 'post',
            success: function (data) {
            var zNodes=data;
                $.fn.zTree.init($("#dept"), settingcbzx, zNodes);
                var treeObj=$.fn.zTree.getZTreeObj("dept");
                treeObj.checkAllNodes(true);
            }
        })
    });
        layui.use(['table'], function () {
            table = layui.table
            search(layui.table);

            $(".search-btn").on("click", function () {
                search(layui.table);
            })
            $(".search-name-btn").on("click", function() {
              var name = $("#desc-input").val().trim();
              search(layui.table, 'desc', name);
            })
            $(".search-no-btn").on("click", function() {
              var name = $("#no-input").val().trim();
              search(layui.table, 'no', name);
            })
        })

        function getDateNow() {
            var now = new Date();
            var year = now.getFullYear() + '';
            var month = (now.getMonth() + 1) + '';
            if (month < 10) {
              month = '0' + month;
            }
            $('#nian').val(year);
            $('#yue').val(month);
        }

        function search(table, type, descTxt) {
            //var ggdm = $("#ggdm").val(); //��˾����
            var ggdm = "1000"; //��˾����
            //var qj = $("#qj option:selected").val(); //����
            var qj = "EQ"; //����
            //���е�checkboxѡ����
            var qjz = '';
            var data=[];           
            var cbzx=$.fn.zTree.getZTreeObj("dept");
            if(cbzx){
             var nodes=cbzx.getCheckedNodes(true);             
             var v="";
             
            for(var i=0;i<nodes.length;i++){
              var item={};
            v+=nodes[i].name + ",";
            //console.log(nodes[i].id); //��ȡѡ�нڵ��ֵ
            // console.log("�ڵ�id:"+nodes[i].id+";;;�ڵ�����"+nodes[i].name+";;;;���ڵ�:"+nodes[i].pid+";;;;shibushifu�ڵ�:"+nodes[i].isParent+"");
            // item.id=nodes[i].id;
            // item.name=nodes[i].name;
            // item.pid=nodes[i].pid;
            // item.isParent=nodes[i].isParent==true?1:0;
            // data.push(item);
            //console.log("�ڵ�id:"+nodes[i].id+"�ڵ�����"+v);
                 if (i == 0) {
                    qjz = nodes[i].id;
                } else {
                    qjz += ',' + nodes[i].id;
                }
            }
            }
            console.log(qjz);
            var ks = qjz; //��ʼ
            //var js = $("#js").val(); //����
            var js = ""; //����
            var nian = $("#nian option:selected").val(); //��
            var yue = $("#yue option:selected").val(); //��
            var bhbfzc = $("#bhbfzc option:selected").val(); //���������ʲ�

            //var url = "http://192.168.1.88:8086/handler1.ashx?t=SLTANLA&I_BUKRS=" + ggdm + "&I_YEAR=" + nian +
            //   "&I_PERIO=" + yue + "&I_DEAKT=" + bhbfzc + "&OPTION=" + qj + "&LOW=" + ks + "&HIGH=" +
            //    js + "";
            var test= $("#test").val();
            var url = "http://192.168.1.88:8086/handler1.ashx?t=SLTANLA&test="+test+"";
            table.render({
                elem: '#demo'
                , width: 1200
                , height: 600
                , url: url //���ݽӿ�
                ,method:"post"
                ,where: {I_BUKRS: ggdm,I_YEAR:nian,I_PERIO:yue,I_DEAKT:bhbfzc,OPTION:qj,LOW:ks,HIGH:js}
                , title: '�û���'
                , text: {
    none: '�����������' //Ĭ�ϣ������ݡ�ע��������Ϊ layui 2.2.5 ��ʼ����
                }
                ,parseData: function(res) {
                  var result;
                  if (res.data.length > 0) {
                    result = res.data.filter(function(item){
                        if (type === 'desc') {
                            return item.TXT50.indexOf(descTxt) != -1;
                        } else if (type === 'no') {
                            return item.ANLN1.indexOf(descTxt) != -1;
                        } else {
                            return item;
                        }
                    })
                  }
                  return {
                    "code": res.code, //�����ӿ�״̬
                    "msg": res.msg, //������ʾ�ı�
                    "data": result //���������б�
                  };
                }
                , cols: [[ //��ͷ
                    { field: 'BUKRS', width: 86, title: '��˾����' }
                    , { field: 'ANLN1', width: 125, title: '�ʲ�����' }
                    , { field: 'TXT50', width: 327, title: '�ʲ�����' }
                    , { field: 'KOSTL', width: 109, title: '�ɱ�����' }
                    , { field: 'KTEXT', width: 185, title: '�ɱ���������' }
                    , { field: 'ZRZRQ', width: 103, title: '��������' }
                    , { field: 'STORT', width: 86, title: '������' }
                    // , { field: 'MENGE', width: 86, title: '����' }
                    , { field: 'ZQMYZ', width: 104, title: '�ʲ�ԭֵ' }
                    , { field: 'ZDQZJ', width: 90, title: '�����۾�' }
                    , { field: 'ZQMJZ', width: 104, title: '��ĩ��ֵ' }

                ]]
            });
        }

    </script>
</body>

</html>