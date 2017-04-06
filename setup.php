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

class CamagruPDO extends PDO {
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
    public function get_comment_info_str($file_id){
        $comment_str = '';
        $stmt = $this->prepare('SELECT * FROM Comments WHERE file_id=?');
        $stmt->execute([$file_id]);
        while ($res = $stmt->fetch()){
            $comment_str .= $this->get_user_name($res['author_id']).': '.$res['published'].
            ';'.$res['content']."\n";
        }
        return $comment_str;
    }
    public function get_user_by_email($email){
        $stmt = $this->prepare('SELECT * FROM Users WHERE email=?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public function update_password($user_id, $password){
        $stmt = $this->prepare('UPDATE Users SET password=? WHERE id=?');
        $stmt->execute([$password, $user_id]);
    }
    public function validate_login($user_name, $password){
        $stmt = $this->prepare('SELECT * FROM Users Where name=?');
        $stmt->execute([$user_name]);
        if ($res = $stmt->fetch())
        {
            if ($res['password'] === $password)
                return TRUE;
        }
        return FALSE;
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
    public function get_user_name($id){
        $stmt = $this->prepare('SELECT name FROM Users WHERE id=?');
        $stmt->execute([$id]);
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
        $stmt->execute([$file_name, $path, $user_id]);
    }
    public function get_image_name($file_id){
        $stmt = $this->prepare('SELECT img_name FROM Gallery WHERE id=?');
        $stmt->execute([$file_id]);
        $res = $stmt->fetchColumn();
        return $res;
    }
    public function populate_user_gallery($user_name){
        $image_array = array();
        $user_id = $this->get_user_id($user_name);
        $stmt = $this->prepare('SELECT img_path FROM Gallery WHERE user_id=? ORDER BY img_name DESC');
        $stmt->execute([$user_id]);
        while ($res = $stmt->fetchColumn())
        {
            $image_array[] = $res."\n";
        }
        return $image_array;

    }
    public function populate_main_gallery(){
        $image_array = array();
        $stmt = $this->prepare('SELECT img_path FROM Gallery ORDER BY img_name DESC');
        $stmt->execute();
        while ($res = $stmt->fetchColumn())
        {
            $image_array[] = $res."\n";
        }
        return $image_array;

    }
    public function get_image_by_path($path){
        $stmt = $this->prepare('SELECT * FROM Gallery WHERE img_path=?');
        $stmt->execute([$path]);
        return $stmt->fetch();
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
        $stmt = $this->prepare('INSERT INTO Comments (file_id, img_user_id, content, author_id, published) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$image_id, $img_usr_id, $text, $auth_id, $date]);
    }
    public function add_like($fn, $usr, $auth){
        $img_usr_id = $this->get_user_id($usr);
        $auth_id = $this->get_user_id($auth);
        $image_id = $this->get_image_id($fn);
        $stmt = $this->prepare('INSERT INTO Likes (file_id, img_user_id, likedby_id) VALUES (?, ?, ?)');
        $stmt->execute([$image_id, $img_usr_id, $auth_id]);
    }
    public function unlike($id){
        $stmt = $this->prepare('DELETE FROM Likes WHERE id=?');
        $stmt->execute([$id]);
    }
    public function get_like_count($file_id){
        $stmt = $this->prepare('SELECT COUNT(*) FROM Likes WHERE file_id=?');
        $stmt->execute([$file_id]);
        return $stmt->fetchColumn();
    }
    public function get_liked_by($file_id){
        $likedby_str = '';
        $stmt = $this->prepare('SELECT likedby_id FROM Likes WHERE file_id=?');
        $stmt->execute([$file_id]);
        while ($res = $stmt->fetchColumn())
        {
            $likedby_str .= $this->get_user_name($res)."\n";
        }
        return $likedby_str;
    }
    public function toggle_like($file_id, $likeby_name, $user_name){
        $likeby_id = $this->get_user_id($likeby_name);
        $stmt = $this->prepare('SELECT id FROM Likes WHERE file_id=? AND likedby_id=?');
        $stmt->execute([$file_id, $likeby_id]);
        if ($id = $stmt->fetchColumn())
            $this->unlike($id);
        else
            $this->add_like($this->get_image_name($file_id), $user_name, $likeby_name);
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
    public function add_likes_from_csv(){
        
        if (file_exists('private/image_data'))
        {
            $img_data = unserialize(file_get_contents('private/image_data'));
            foreach ($img_data as $user => $img_array)
            {
                foreach ($img_array as $file_name => $like_array)
                {
                   foreach ($like_array['like'] as $liked_by)
                   {
                        $this->add_like($file_name, $user, $liked_by);
                   } 
                }   
            }
        }
              
    }
    
}
// printf ("%s %s (%s)\n", $DBDSN, $DBUSER, $DBPASS);
// $mypdo = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
// echo $mypdo->get_liked_by(19);
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
// echo 'what';

// if ($mypdo->validate_login('Aaron', '1f4c694705d4b8a30da09de147e5901b482002030409e183db704d203413545b925e277f7ccb8f6229ba68ad1c18f7d35b50f01c4f52977a0fe70d280b5376fc'))
//     echo "Cor\n";
// else
//     echo "Incor\n";
// if ($mypdo->validate_login('Aaron', '1f4c694705d4b8a30da09de147e5901b482002030409e183db704d203413545b925e277f7ccb8f6229ba68ad1c18f7d35b50f01c4f52977a0fe70d280b5376f'))
//     echo "Incor\n";
// else
//     echo "Cor\n";
// if ($mypdo->validate_login('Aron', '1f4c694705d4b8a30da09de147e5901b482002030409e183db704d203413545b925e277f7ccb8f6229ba68ad1c18f7d35b50f01c4f52977a0fe70d280b5376fc'))
//     echo "Incor\n";
// else
//     echo "Cor\n";

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
