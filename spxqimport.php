<?
include_once "inc/auth.inc.php";
include_once "inc/utility_all.php";

$query2 = "SELECT BYNAME FROM `user` WHERE `user_id`='" . $_SESSION["LOGIN_USER_ID"] . "'";
$cursor2 = exequery(TD::conn(), $query2);
if ($ROW2 = mysql_fetch_row($cursor2))
  $SAP_ID = $ROW2[0];

// echo $SAP_DEPT_ID;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
        <title>��Ʒ������</title>
        <script src="http://192.168.1.101:8800/module/DatePicker/WdatePicker.js"></script>
    </head>
    <body>
<h1>��Ʒ������</h1>

//http://localhost:22674 192.168.1.88:8086
<form id="wu-form-stuInfo" ACTION="http://192.168.1.88:8086/QHDJ.ashx?t=Impexcel" METHOD="POST"  enctype="multipart/form-data">
  �ظ�����Ḳ�ǵ��쵼�������
    <input type="file" id="xlsimport" name="xlsimport"  />
    <input type="hidden" id="drr" name="drr"  value="<? echo $SAP_ID ?>" />
    <input name="mySent" value="����"  type="button" onclick="formsubmit()" />
</form>
<a href="��Ʒ������ģ��.xls">������Ʒ������ģ��</a>
<!-- �ŵ�����	�ŵ�绰	�ύ������	��Ʒ����	��Ʒ����	���	��������	�˿�����	�ɷ���� -->
<hr/>
����:<input type="text" id="begin_time" name="begin_time" size="10"  onclick="WdatePicker()">
<input name="xc" value="��ѯ"  type="button" onclick="cx()" />
<table class="qhdj-table">
    <thead>
      <tr>
        <th>�ŵ�����</th>
        <th>�ŵ�绰</th>
        <th>�ύ������</th>
        <th>��Ʒ����</th>
        <th>��Ʒ����</th>
        <th>���</th>
        <th>��������</th>
        <th>�˿�����</th>
        <th>�ɷ����</th>
        <th>�ظ���</th>
        <th>�ظ�ʱ��</th>
        <th>�ظ�����</th>
        <th>��ע</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <script type="text/javascript" src="jquery-2.2.4.js"></script>
  <script>
    function cx(){
      var begin=$("#begin_time").val();
    if(!begin){
        alert("��ѡ������");
        return false;
    }
      $.ajax({
        url: "http://192.168.1.88:8086/QHDJ.ashx?t=GETSpxqList&uid=<? echo $SAP_ID ?>&begin_time="+begin+"",
        type: 'get',
        success: function(res) {
          var html = '';
          var list = res.data;         
          for(var i = 0; i < list.length; i++) {
            var item = list[i];
            
            html += '<tr>' + 
            '<td>' + item.mdmc + '</td>' +
            '<td>' + item.mddh + '</td>' +
            '<td>' + item.tjrxm + '</td>' +
            '<td>' + item.spbm + '</td>' +
            '<td>' + item.spmc + '</td>' +
            '<td>' + item.gg + '</td>' +
            '<td>' + item.sccj + '</td>' + 
            '<td>' + item.gkxq + '</td>' + 
            '<td>' + item.kftd + '</td>' +
            '<td>' + item.hfr + '</td>' + 
            '<td>' + item.hfsj + '</td>' + 
            '<td>' + item.hfnr + '</td>'+
            '<td>' + item.bz + '</td>' 
          }
          $(".qhdj-table tbody").html(html);          
        }
      })
    }
  </script>



<script>


function formsubmit(){
    var file = $('#xlsimport').val();
    if(!file){
        alert("��ѡ�����ļ�");
        return false;
    }
    var form = $('#wu-form-stuInfo');
       // �ύ��
       form.submit(); 
}
</script>
</body>
</html>