<?php
//try{
  $dsn = 'mysql:dbname=myfriend;host=localhost';
    
  // 接続するためのユーザー情報
  $user = 'root';
  $password = '';

  // DB接続オブジェクトを作成
  $dbh = new PDO($dsn,$user,$password);

  // 接続したDBオブジェクトで文字コードutf8を使うように指定
  $dbh->query('SET NAMES utf8');

  if(isset($_POST)&&!empty($_POST)){
      if(isset($_POST['update'])){
          $sql='UPDATE `friends` SET `friend_id`='.$_POST['friend_id'].',`friend_name`="'.$_POST['friend_name'].'",`area_id`='.$_POST['area_id'].',
              `gender`='.$_POST['gender'].',`age`='.$_POST['age'].',`created`="'.$_POST['created'].'" WHERE id='.$_POST['id'];
          $stmt = $dbh->prepare($sql);
          $stmt ->execute();
      }else{
          var_dump($_POST);
          $sql='INSERT INTO `friends`(`friend_id`, `friend_name`, `area_id`, `gender`, `age`, `created`)
              VALUES (null,"'.$_POST['name'].'","'.$_POST['area_table_id'].'","'.$_POST['gender'].'","'.$_POST['age'].'",now())';
          $stmt = $dbh->prepare($sql);
          $stmt ->execute();
      }
  }
  
  //友達人数を集計する
  $fr = array();
  $ssql='SELECT `areas`.`area_id`,`areas`.`area_name`,COUNT(`friends`.`friend_id`)AS friend_cnt FROM `areas`
        LEFT OUTER JOIN `friends`ON `areas`.`area_id`= `friends`.`area_id`WHERE 1 GROUP BY `areas`.`area_id`';
  $stmt = $dbh->prepare($ssql);
  $stmt ->execute(); 
  while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if($rec==false){
      break;
    }
    $fr[] = $rec;
  }
  
  if (isset($_POST)&&!empty($_POST['search_friend'])) {
    $sql = 'SELECT * FROM `friends` WHERE `friend_name` LIKE "%name%"';
    $stmt = $dbh->prepare($sql);
    $stmt ->execute();
    $friends = $rec;
  }
 // $ql = 'SELECT `areas`.`area_id`,`areas`.`area_name`,COUNT(`friends`.`friend_id`)AS friend_cnt FROM `areas`
 //        LEFT OUTER JOIN `friends`ON `areas`.`area_id`= `friends`.`area_id`WHERE 1 GROUP BY `areas`.`area_id`';
 // $stmt = $dbh ->prepare($ql);
 // $stmt -> execute();

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
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
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
      <legend>都道府県一覧</legend>
        <table class="table table-striped table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th><div class="text-center">id</div></th>
              <th><div class="text-center">県名</div></th>
              <th><div class="text-center">人数</div></th>
            </tr>
          </thead>
          <tbody>
            <!-- id, 県名を表示 -->
            <tr>
              <?php
            foreach($fr as $post){ ?>
              <!--for($i=0;$i<47;$i++){?>-->
              <td><div class="text-center"><?php echo $post['area_id'] ?></div></td>
              <td><div class="text-center"><a href="show.php?area_id=<?php echo $post['area_id']; ?>"><?php echo $post['area_name'] ?></a></div></td>
              <td><div class="text-center"><?php echo $post['friend_cnt']; ?></div></td>
            </tr>
            <?php } ?>
            <!--<tr>
              <td><div class="text-center">2</div></td>
              <td><div class="text-center"><a href="show.html">青森</a></div></td>
              <td><div class="text-center">7</div></td>
            </tr>
            <tr>
              <td><div class="text-center">3</div></td>
              <td><div class="text-center"><a href="show.html">岩手</a></div></td>
              <td><div class="text-center">2</div></td>
            </tr>
            <tr>
              <td><div class="text-center">4</div></td>
              <td><div class="text-center"><a href="show.html">宮城</a></div></td>
              <td><div class="text-center">6</div></td>
            </tr>
            <tr>
              <td><div class="text-center">5</div></td>
              <td><div class="text-center"><a href="show.html">秋田</a></div></td>
              <td><div class="text-center">8</div></td>
            </tr>-->
          </tbody>
        </table>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<!--<?php
//}//catch(Exception $e){
  //echo "サーバーエラーにより障害が発生しております。";
//}?>
 -->