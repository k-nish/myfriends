<?php 
  $dsn = 'mysql:dbname=myfriend;host=localhost';
    
  // 接続するためのユーザー情報
  $user = 'root';
  $password = '';

  // DB接続オブジェクトを作成
  $dbh = new PDO($dsn,$user,$password);

  // 接続したDBオブジェクトで文字コードutf8を使うように指定
  $dbh->query('SET NAMES utf8');
 
  $area = array();

  $sql='SELECT * FROM `areas` WHERE 1';
  $stmt = $dbh->prepare($sql);
  $stmt ->execute();
  while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec==false) {
      break;
    }
    $area[] = $rec;
  }
  
  //var_dump($_GET['area_id']);
  //var_dump($_GET['id']);
  $area_id = $_GET['id'];
  $idarea=array();
  $sq='SELECT `area_name` FROM `areas` WHERE `area_id`='.$area_id;
  //var_dump($sq);
  $stmt = $dbh->prepare($sq);
  $stmt ->execute();
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  //var_dump($rec);
  $idarea=$rec;
  //var_dump($idarea['area_name']);
  
  //INSERT文
  if(isset($_POST)&&!empty($_POST)){
      var_dump($_POST);
      $sql='INSERT INTO `friends`(`friend_id`, `friend_name`, `area_id`, `gender`, `age`, `created`)
         VALUES (null,"'.$_POST['name'].'","'.$_POST['area_table_id'].'","'.$_POST['gender'].'","'.$_POST['age'].'",now())';
      $stmt = $dbh->prepare($sql);
      $stmt ->execute();
  }
 //sql終了
 $dbh = null;

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
  <!--<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <!-- <div class="navbar-header page-scroll"> -->
              <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> -->
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
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
        <legend>友達の登録</legend>
        <form method="post" action="index.php" class="form-horizontal" role="form">
            <!-- 名前 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">名前</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="例：山田　太郎">
              </div>
            </div>
            <!-- 出身 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">出身</label>
              <div class="col-sm-10">
                <select class="form-control" name="area_table_id">
                  <option value="<?php echo $area_id; ?>"><?php echo $idarea['area_name']; ?></option>
                    <?php foreach ($area as $areas) { ?>
                    <option value="<?php echo $areas['area_id'];?>"><?php echo $areas['area_name']; ?></option>
                    <?php } ?>
                  <!--<option value="2">青森</option>
                  <option value="3">岩手</option>
                  <option value="4">宮城</option>
                  <option value="5">秋田</option>-->
                </select>
              </div>
            </div>
            <!-- 性別 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">性別</label>
              <div class="col-sm-10">
                <select class="form-control" name="gender">
                  <option value="0">性別を選択</option>
                  <option value="1">男性</option>
                  <option value="2">女性</option>
                </select>
              </div>
            </div>
            <!-- 年齢 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">年齢</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="例：27">
              </div>
            </div>

          <input type="submit" class="btn btn-default" value="登録">
        </form>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
