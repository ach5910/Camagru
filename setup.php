<?php
include 'database.php';
// $dbhost = 'localhost:8080';
// $dbuser = "root";
// $dbpass = "root";
// $con = mysql_connect('localhost', $dbuser, $dbpass);

// if (!$con){
// 	die('Could not connect: ' .mysql_error());
// }

// echo 'Connect Successfully';
// mysql_close($con);

// class camagru_mysqli extends mysqli {
//     public function __construct($dsn, $user, $pass) {
//         parent::__construct($dsn, $user, $pass);

//         if (mysqli_connect_error()) {
//             die('Connect Error (' . mysqli_connect_errno() . ') '
//                     . mysqli_connect_error());
//         }
//     }
//     public function read_user($name){
//         if ($result = $this->query('SELECT * FROM Users WHERE name="'.$name.'"'))
//         {
//             echo $result->num_rows.PHP_EOL;
//             while ($obj = $result->fetch_object()){
//                 printf ("%s %s (%s)\n", $obj->name, $obj->password, $obj->email);
//             }
            
//         }
//         else
//         {
//             echo "Error on result\n";
//         }
//     }
//     public function user_name_avail($name){
//         if ($result = $this->query('SELECT * FROM Users WHERE name="'.$name.'"')){
//             if ($result->num_rows === 0)
//                 return TRUE;
//         }
//         return FALSE;
//     }
//     public function create_user($name, $pw, $email){
//         if ($res = $this->query('INSERT INTO Users (name, password, email) VALUES ("'.$name.'", "'.$pw.'", "'.$email.'")')){
//             printf ("Added %s %s (%s)\n", $name, $pw, $email);
//         }
//         else {
//             echo "Error on add\n";
//         }
//     }
//     public function add_users_from_csv(){
//         if(file_exists("private/passwd"))
//         {
//             $accounts = unserialize(file_get_contents("private/passwd"));
//             foreach ($accounts as $name => $acct)
//             {
//                 if ($this->user_name_avail($name))
//                     $this->create_user($name, $acct['passwd'], $acct['email']);
//             }
//         }
//     }
// }

class User {
    public $name;
    public $password;
    public $email;

    public function info(){
        return $this->name.' '.$this->password.' '.$this->email;
    }
}

class Camagru_PDO extends PDO {
    public function __construct($dsn, $user, $pass) {
        parent::__construct($dsn, $user, $pass);
        try{
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            die($e->getMessage());
        }
    }
    public function read_user($name){
        if ($result = $this->query('SELECT * FROM Users WHERE name="'.$name.'"'))
        {
            echo $result->num_rows.PHP_EOL;
            while ($obj = $result->fetch_object()){
                printf ("%s %s (%s)\n", $obj->name, $obj->password, $obj->email);
            }
            
        }
        else
        {
            echo "Error on result\n";
        }
    }
    public function user_name_avail($name){
        $stmt = $this->prepare('SELECT COUNT(*) FROM Users WHERE name=?');
        $stmt->execute([$name]);
        if ($stmt->fetchColumn()){
                return FALSE;
        }
        return TRUE;
    }
    public function create_user($name, $pw, $email){
        $stmt = $this->prepare('INSERT INTO Users (name, password, email) VALUES (?, ?, ?)');
        $stmt->execute([$name, $pw, $email]);
    }
    public function add_users_from_csv(){
        if(file_exists("private/passwd"))
        {
            $accounts = unserialize(file_get_contents("private/passwd"));
            foreach ($accounts as $name => $acct)
            {
                if ($this->user_name_avail($name))
                    $this->create_user($name, $acct['passwd'], $acct['email']);
            }
        }
    }
    public function get_user_id($user_name){
        $stmt = $this->prepare('SELECT id FROM Users WHERE name=?');
        $stmt->execute([$user_name]);
        return $stmt->fetchColumn();
    }
    public function get_image_id($fn){
        $stmt = $this->prepare('SELECT id FROM Gallery WHERE img_name=?');
        $stmt->execute([$fn]);
        return $stmt->fetchColumn();
    }
    public function add_image($file_name, $path, $user_name){
        $user_id = $this->get_user_id($user_name);
        $stmt = $this->prepare('INSERT INTO Gallery (img_name, img_path, user_id) VALUES (?, ?, ?)');
        echo 'After insert '.$file_name.' '.$path.' '.$user_id.' '.$user_name."\n";
        $stmt->execute([$file_name, $path, $user_id]);
    }
    public function get_image($filename){
        $stmt = $this->prepare('SELECT * FROM Gallery WHERE img_name=?');
        $stmt->execute([$filename]);
        $res = $stmt->fetch();
        return $res['content'];
    }
    public function add_images_from_csv(){    
        $users_dir = './private/user_images/';
        if(file_exists($users_dir))
        {
            $dir = new DirectoryIterator($users_dir);
            foreach($dir as $user)
            {
                if(!$user->isDot())
                {
                    
                    $user_dir = new DirectoryIterator('./private/user_images/'.$user);
                    foreach ($user_dir as $img)
                    {
                        if (!$img->isDot())
                            $this->add_image($img, './private/user_images/'.$user.'/'.$img, $user);
                    }
                }
            }
        }
    }
    public function add_comment($fn, $usr, $text, $auth, $date){
        $img_usr_id = $this->get_user_id($usr);
        $auth_id = $this->get_user_id($auth);
        $image_id = $this->get_image_id($fn);
        $stmt = $this->prepare('INSERT INTO Comments (filename, img_user_id, content, author_id, published) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$fn, $img_usr_id, $text, $auth_id, $date]);
    }
    public function add_comments_from_csv(){
        if (file_exists('private/image_data'))
        {
            $img_data = unserialize(file_get_contents('private/image_data'));
            foreach ($img_data as $user => $img_array)
            {
                foreach($img_array as $file_name => $com_array)
                {
                    foreach($com_array['comments'] as $comment)
                    {
                        $this->add_comment($file_name, $user, $comment['content'], $comment['author'], $comment['date']);
                    }
                }
                
            }
        }
        
        
    }
    
}
printf ("%s %s (%s)\n", $DBDSN, $DBUSER, $DBPASS);
$mypdo = new Camagru_PDO($DBDSN, $DBUSER, $DBPASS);
// $mysqli->add_users_from_csv();

// $mysqli->read_user('Aaron');
// if ($mysqli->user_name_avail('Matt')){
//     $mysqli->create_user()
// }
// else
//     echo 'Taken';



/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
// if ($mysqli->connect_error) {
//     die('Connect Error (' . $mysqli->connect_errno . ') '
//             . $mysqli->connect_error);
// }


//  * Use this instead of $connect_error if you need to ensure
//  * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
 
// if (mysqli_connect_error()) {
//     die('Connect Error (' . mysqli_connect_errno() . ') '
//             . mysqli_connect_error());
// }

// echo 'Success... ' . $mysqli->host_info . "\n";


// if ($result = $mypdo->query('SELECT * FROM Users'))
// {
// 	$result->setFetchMode(PDO::FETCH_CLASS, 'User');
// 	while ($obj = $result->fetch()){
// 		printf ("%s \n", $obj->info());
// 	}

// }
// else
// {
// 	echo "Error on result\n";
// }

// if ($mypdo->user_name_avail('Aaron'))
//     echo 'Aaron Yes';
// else
//     echo 'Aaron No';
// if ($mypdo->user_name_avail('Matt'))
//     echo 'Matt Yes';
// else
//     echo 'Matt No';

// $imagetmp = addslashes (file_get_contents('merged.png'));
// $mypdo->add_image($imagetmp, 'merged.png');
// echo 'Aarons id = '.$mypdo->get_user_id('Aaron');
// echo 'blockos id = '.$mypdo->get_user_id('blockco');
$mypdo->add_comments_from_csv();
// $stmt = $mypdo->prepare('SELECT * FROM Users WHERE name=?');
// $stmt->execute(['Aaron']);
// $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
// $user = $stmt->fetch();
// if ($user)
//     printf("Search Aaron = %s\n", $user->info());

// $stmt = $mypdo->prepare('SELECT email FROM Users WHERE name=?');
// $stmt->execute(['Aaron']);
// $user = $stmt->fetch();
// if ($user)
//     printf("Search Aaron = %s\n", $user['email']);

// $stmt = $mypdo->prepare('SELECT * FROM Users WHERE name=?');
// $stmt->execute(['Matt']);
// $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
// $usr = $stmt->fetch();
// if ($usr)    
//     printf("Search Matt = %s\n", $usr->info());
// else
//     echo 'Nope';
?>
