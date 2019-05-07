<?
include_once "inc/auth.inc.php";
include_once "inc/utility_all.php";

 $query = "SELECT SAP_DEPT_ID FROM department WHERE DEPT_ID=".$_SESSION["LOGIN_DEPT_ID"];
$cursor = exequery(TD::conn(), $query);
if($ROW=mysql_fetch_row($cursor))
$SAP_DEPT_ID=$ROW[0];

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

        .layui-table-cell,
        .layui-table-tool-panel li {
            overflow: unset;
            text-overflow: unset;
        }
    </style>
</head>

<body>
    <div class="layui-container container">
        <div class="layui-form">
            <!-- <div class="layui-form-item">
                <label class="layui-form-label">��˾����</label>
                <div class="layui-input-block">
                    <input type="text" id="ggdm" name="title" required lay-verify="required" placeholder="���������"
                        autocomplete="off" class="layui-input" value="1000">
                </div>
            </div> -->
            <div class="layui-form-item">
                <label class="layui-form-label">�ɱ�����</label>
                <div class="cbzxlist" style="display:inline;"></div>
                <!-- <div class="layui-inline">
                    <select name="city" lay-verify="required" id="qj">
                        <option value="BT">����</option>
                        <option value="EQ">����(�����������,)</option>
                    </select>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">��Χ</label>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" id="ks" value="1000100000" name="price_min" placeholder="������id" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" id="js" value="1000299999" name="price_max" placeholder="������id" autocomplete="off" class="layui-input">
                    </div>
                </div> -->
            </div>

            <div class="layui-form-item select-list">
                <div class="select-item select-item-first">
                    <label class="layui-form-label">��</label>
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
                    <label class="layui-form-label">��</label>
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
                <div class="select-item">
                    <label class="layui-form-label">���������ʲ�</label>
                    <div class="layui-inline">
                        <select name="city" id="bhbfzc" lay-verify="required">
                            <option value="">��</option>
                            <option value="X">��</option>
                        </select>
                    </div>
                </div>
                <div class="select-item">
                    <button class="layui-btn search-btn">��ѯ</button>
                </div>
            </div>
        </div>


        <table class="layui-hide" id="demo" lay-filter="test"></table>

    </div>

    <script src="./layui/layui.all.js"></script>
    <script src="http://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous"></script>
    <script>
        layui.use(['table'], function () {
            table = layui.table
            //search(layui.table);


            $.ajax({
                url: "http://192.168.1.88:8086/Dept_Cbzx.ashx?t=GETCbzxDeptList",
                type: 'post',
                data: { sap_dept_id: <?echo $SAP_DEPT_ID ?> },
                success: function (data) {
                    //$(".cbzxlist").html("");
                    if (data.code == 0) {
                        if (data.CBZX_ID_STR) {
                            var str = data.CBZX_ID_STR;
                            var arr = str.split(",");
                            var checkhtml = "";
                            var arrids = [];
                            $.each(arr, function (index, data) {
                                var arr2 = data.split("|");
                                //ulhtml+="<li class=\"inp\">"+arr2[0]+"</li>";             
                                checkhtml += "<input type=\"checkbox\" name=\"cbzx\" title=\"" + arr2[0] + "\" lay-skin=\"primary\" value=\"" + arr2[1] + "\" />";
                                //console.log(checkhtml);    
                            });
                            $(".cbzxlist").html(checkhtml);
                            //������¼���һ�¾Ϳ�����
                            layui.use('form', function () {
                                var form = layui.form;
                                //���ݵ�type�����޸�
                                form.render('checkbox');
                            });
                        }
                    }
                }
            })

            $(".search-btn").on("click", function () {
                search(layui.table);
            })
        })
        function search(table) {
            //var ggdm = $("#ggdm").val(); //��˾����
            var ggdm = "1000"; //��˾����
            //var qj = $("#qj option:selected").val(); //����
            var qj = "EQ"; //����
            //���е�checkboxѡ����
            var qjz = '';
            $('input:checkbox[name=cbzx]:checked').each(function (k) {
                if (k == 0) {
                    qjz = $(this).val();
                } else {
                    qjz += ',' + $(this).val();
                }
            })
            console.log(qjz);
            var ks = qjz; //��ʼ
            //var js = $("#js").val(); //����
            var js = ""; //����
            var nian = $("#nian option:selected").val(); //��
            var yue = $("#yue option:selected").val(); //��
            var bhbfzc = $("#bhbfzc option:selected").val(); //���������ʲ�

            var url = "http://192.168.1.88:8086/handler1.ashx?t=SLTANLA&I_BUKRS=" + ggdm + "&I_YEAR=" + nian +
                "&I_PERIO=" + yue + "&I_DEAKT=" + bhbfzc + "&OPTION=" + qj + "&LOW=" + ks + "&HIGH=" +
                js + "";

            table.render({
                elem: '#demo'
                , width: 1200
                , height: 600
                , url: url //���ݽӿ�
                , title: '�û���'
                , cols: [[ //��ͷ
                    { field: 'BUKRS', width: 86, title: '��˾����' }
                    , { field: 'ANLN1', width: 125, title: '�ʲ�����' }
                    , { field: 'TXT50', width: 327, title: '�ʲ�����' }
                    , { field: 'ANLKL', width: 86, title: '�ʲ�����' }
                    , { field: 'TXK20', width: 162, title: '�ʲ������' }
                    , { field: 'KOSTL', width: 109, title: '�ɱ�����' }
                    , { field: 'KTEXT', width: 185, title: '�ɱ���������' }
                    , { field: 'LIFNR', width: 94, title: '��Ӧ�̴���' }
                    , { field: 'NAME1', width: 199, title: '��Ӧ������' }
                    , { field: 'ZRZRQ', width: 103, title: '��������' }
                    , { field: 'AFABG', width: 103, title: 'ʹ������' }
                    , { field: 'DEAKT', width: 103, title: '�������' }
                    , { field: 'STORT', width: 86, title: '�ʲ��ص�' }
                    , { field: 'MENGE', width: 86, title: '����' }
                    , { field: 'ZZCYZ', width: 104, title: '�ʲ�ԭֵ' }
                    , { field: 'ZLJZJ', width: 98, title: '�ۼ��۾�' }
                    , { field: 'ZDQZJ', width: 90, title: '�����۾�' }
                    , { field: 'ZSYSM', width: 144, title: '�ƻ�ʹ���������£�' }
                    , { field: 'ZYSYSM', width: 144, title: '��ʹ���������£�' }
                    , { field: 'ZSYSYSM', width: 144, title: 'ʣ��ʹ���������£�' }
                    , { field: 'ZQCYZ', width: 98, title: '�ڳ�ԭֵ' }
                    , { field: 'ZYZZJ', width: 104, title: 'ԭֵ����' }
                    , { field: 'ZYZJS', width: 86, title: 'ԭֵ����' }
                    , { field: 'ZQMYZ', width: 104, title: '��ĩԭֵ' }
                    , { field: 'ZQCYE', width: 138, title: '�ۼ��۾��ڳ����' }
                    , { field: 'ZBNZJE', width: 98, title: '�����۾ɶ�' }
                    , { field: 'ZQMLJZJ', width: 108, title: '��ĩ�ۼ��۾�' }
                    , { field: 'ZQCJE', width: 86, title: '�ڳ�����' }
                    , { field: 'ZQMJZ', width: 104, title: '��ĩ��ֵ' }

                ]]
            });
        }

    </script>
</body>

</html>