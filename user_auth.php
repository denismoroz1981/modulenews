<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 12.06.18
 * Time: 6:22
 */



define('SALT','123456');

if (!empty($_SESSION['username'])) {
    $userInfo = 'You entered as <b>'.$_SESSION['username'].'</b><br>';
    $userInfo .= '<form action="logout.php" method="get">';
    $userInfo .= '<input type="submit" value="Logout" class="btn btn-primary">';
    $userInfo .= '</form>';


} else {
    $userInfo = <<<TEXT
                <form role="form" action="" method="post">
				<div class="form-group">
					                                                                        
					<label for="exampleInputLogin">
                        Login
					</label>
					<input name="login" class="form-control" id="Login">
				</div>                                                                                                                                                                                                                                                                                                      
				<div class="form-group">
					 
					<label for="exampleInputPassword1">
                        Password
					</label>
					<input name="password" type="password" class="form-control" id="exampleInputPassword1">
				</div>
				
				<button type="submit" class="btn btn-primary">
                    Register / Login
				</button>
			</form>
TEXT;

}

function checkUser($login,$password)
{
    global $dbn;

    $stuc = $dbn->prepare('SELECT * FROM users WHERE username=?');
    $stua = $dbn->prepare("INSERT INTO users SET `username` = ?, `password` = ?");

    $stuc->execute(array($login));
    $user_info = $stuc->fetch();
    echo var_export($user_info);

    if (empty($user_info)) {
        $password = md5(trim(strip_tags($password)) . SALT);
        $stua->execute(array(trim(strip_tags($login)), $password));
        $stuc->execute(array($login));
        $user_info = $stuc->fetch();

    } else {
        //echo var_export(\password_verify($password,$user_info['password']));
        if (!md5(trim(strip_tags($password)) . SALT) == $user_info['password']) {


            return "<p>Wrong password. Try again.<p>";
            exit;
        }
    }
    $_SESSION['username'] = $user_info['username'];
    $_SESSION['user_id'] = $user_info['id'];

    //echo "<meta http-equiv='refresh' content='0'>";
    header('location:/');


}





if (!empty($_POST['login']))
{
    echo checkUser($_POST['login'],$_POST['password']);


    //  header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    //exit;
}






