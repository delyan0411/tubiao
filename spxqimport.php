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
        <title>商品需求导入</title>
        <script src="http://192.168.1.101:8800/module/DatePicker/WdatePicker.js"></script>
    </head>
    <body>
<h1>商品需求导入</h1>

//http://localhost:22674 192.168.1.88:8086
<form id="wu-form-stuInfo" ACTION="http://192.168.1.88:8086/QHDJ.ashx?t=Impexcel" METHOD="POST"  enctype="multipart/form-data">
  重复导入会覆盖当天导入的内容
    <input type="file" id="xlsimport" name="xlsimport"  />
    <input type="hidden" id="drr" name="drr"  value="<? echo $SAP_ID ?>" />
    <input name="mySent" value="导入"  type="button" onclick="formsubmit()" />
</form>
<a href="商品需求导入模板.xls">下载商品需求导入模板</a>
<!-- 门店名称	门店电话	提交人姓名	商品编码	商品名称	规格	生产厂家	顾客需求	可否替代 -->
<hr/>
日期:<input type="text" id="begin_time" name="begin_time" size="10"  onclick="WdatePicker()">
<input name="xc" value="查询"  type="button" onclick="cx()" />
<table class="qhdj-table">
    <thead>
      <tr>
        <th>门店名称</th>
        <th>门店电话</th>
        <th>提交人姓名</th>
        <th>商品编码</th>
        <th>商品名称</th>
        <th>规格</th>
        <th>生产厂家</th>
        <th>顾客需求</th>
        <th>可否替代</th>
        <th>回复人</th>
        <th>回复时间</th>
        <th>回复内容</th>
        <th>备注</th>
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
        alert("请选择日期");
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
        alert("请选择导入文件");
        return false;
    }
    var form = $('#wu-form-stuInfo');
       // 提交表单
       form.submit(); 
}
</script>
</body>
</html>