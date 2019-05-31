

 <?
include_once "inc/auth.inc.php";
include_once "inc/utility_all.php";

//  $query = "SELECT SAP_DEPT_ID FROM department WHERE DEPT_ID=".$_SESSION["LOGIN_DEPT_ID"];
// $cursor = exequery(TD::conn(), $query);
// if($ROW=mysql_fetch_row($cursor))
// $SAP_DEPT_ID=$ROW[0];

$query2 = "SELECT BYNAME FROM `user` WHERE `user_id`='".$_SESSION["LOGIN_USER_ID"]."'";
$cursor2 = exequery(TD::conn(), $query2);
if($ROW2=mysql_fetch_row($cursor2))
$SAP_ID=$ROW2[0];

// echo $SAP_DEPT_ID;
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>����</title>
  <style>
    .order-table {
      width: 100%;
      border-collapse:collapse;
    }
    .order-table thead{
      background-color: lightsteelblue;
      
    }
    .order-table th {
      padding: 10px 0;
      white-space: nowrap;
    }
    .order-table tbody tr:nth-of-type(odd) {
      background-color: #f5f5f5;
    }
    .order-table td {
      padding: 10px;
      font-size: 14px;
    }
    .state-green {
      color: green;
      font-weight: bold;
    }
    .state-grey {
      color: gray;
    }
  </style>
</head>
<body>
  <table class="order-table">
    <thead>
      <tr>
        <th>������</th>
        <th>�ŵ�����</th>
        <th>�������</th>
        <th>֧����ʽ</th>
        <th>֧��ʱ��</th>
        <th>����ʱ��</th>
        <th>����״̬</th>
        <th>������ϸ</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>

  <script type="text/javascript" src="jquery-2.2.4.js"></script>
  <script>
    $(function() {
      $.ajax({
        url: 'http://192.168.1.88:8086/DZ_MD.ashx?t=GetDZOrder&UID=<?echo $SAP_ID ?>',
        type: 'get',
        success: function(res) {
          var html = '';
          var list = res.body.order_list;
          var orderStatus = {
            "0": "�ȴ���Ҹ���",
            "1": "�ȴ���Ҹ���",
            "2": "����Ѹ���",
            "3": "�����ѷ���",
            "4": "������",
            "10": "�����ر�",
            "11": "�����ɹ�",
            "12": "�˶�������",
            "13": "�˻�������"
          }
          for(var i = 0; i < list.length; i++) {
            var item = list[i];
            var flag = item.total_state == "2" || item.total_state == "3" || item.total_state == "4" || item.total_state == "11";
            var stateColor = flag ? "state-green" : "state-grey";
            
            html += '<tr>' + 
            '<td>' + item.order_no + '</td>' +
            '<td>' + item.store_name + '</td>' +
            '<td>' + item.order_money + '</td>' +
            '<td>' + item.pay_type_name + '</td>' +
            '<td>' + item.pay_time + '</td>' +
            '<td>' + item.add_time + '</td>' +
            '<td class=' + stateColor +  '>' + orderStatus[item.total_state] + '</td>' + 
            '<td>';
            for (var j = 0; j < item.ordersdetails.length; j++) {
              var detail = item.ordersdetails[j];
              html +=  detail.product_code + 
              ' / ' +
              detail.product_name +
              ' / ' +
              detail.sale_num +
              ' / ' +
              detail.deal_price +
              '\n';
            }
            html += '</td>' +
            '</tr>';
          }

          $(".order-table tbody").html(html);
          
        }
      })
    })
  </script>
</body>
</html>