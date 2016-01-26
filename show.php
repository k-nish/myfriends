<?php 
  $dsn = 'mysql:dbname=myfriend;host=localhost';
    
  // 接続するためのユーザー情報
  $user = 'root';
  $password = '';

  // DB接続オブジェクトを作成
  $dbh = new PDO($dsn,$user,$password);

  // 接続したDBオブジェクトで文字コードutf8を使うように指定
  $dbh->query('SET NAMES utf8');
  
  // var_dump($_GET['area_id']);
  $area_id = $_GET['area_id'];

  //都道府県名を表示するためのSQL文
  $sql='SELECT `area_name` FROM `areas` WHERE `area_id`='.$area_id;
  // var_dump($sql);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute();
  $area = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($area);
  //友達リストを表示する
  //$sql='SELECT*FROM posts WHERE 1 ORDER BY `id` DESC' ;
  $sql='SELECT * FROM `friends` WHERE `area_id`='.$area_id;
  //var_dump($sql);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute();
  $friends = array();

  //男女の人数をカウント
  $male = 0;
  $female = 0;

  while(1){

  //実行結果として得られたデータを表示
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if($rec == false){
          break;
  }
  $friends[]=$rec;
  if ($rec['gender'] == 1) {
    $male++;
  }
  if ($rec['gender']==2) {
    $female++;
  }
  // echo $male;
  // echo $female;
  }
  //var_dump($friends);
  //データベースから切断
  $dbh=null;


 ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
  <!-- <nav class="navbar navbar-default navbar-fixed-top"> -->
      <!-- <div class="container"> -->
          <!-- Brand and toggle get grouped for better mobile display -->
          <!-- <div class="navbar-header page-scroll"> -->
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
      <legend><?php echo $area['area_name']; ?>の友達</legend>
      <div class="well">男性：<?php echo $male; ?>名　女性：<?php echo $female; ?>名</div>
        <table class="table table-striped table-hover table-condensed">
          <thead>
            <tr>
              <th><div class="text-center">名前</div></th>
              <th><div class="text-center"></div></th>
            </tr>
          </thead>
          <tbody>
            <!-- id, 県名を表示 -->
            <?php  
            foreach ($friends as $fri ) { ?>
            <tr>
              <td><div class="text-center"><?php echo $fri['friend_name']; ?></div></td>
              <td>
                <div class="text-center">
                  <a href="edit.html"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="javascript:void(0);" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            <?php } ?>
            <!--<tr>
              <td><div class="text-center">小林　花子</div></td>
              <td>
                <div class="text-center">
                  <a href="edit.html"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="javascript:void(0);" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            <tr>
              <td><div class="text-center">佐藤　健</div></td>
              <td>
                <div class="text-center">
                  <a href="edit.html"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="javascript:void(0);" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>-->
          </tbody>
        </table>

        <input type="button" class="btn btn-default" value="新規作成" onClick="location.href='new.php?id=<?php echo $area_id; ?>'">
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
