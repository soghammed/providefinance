<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('part2/test1', function(){
    /**
    * @Author: Dennis L.
    * @Test: 1
    * @TimeLimit: 5 minutes
    * @Tes;ng: Reflec;on
    * @Task: Make $mySecret public using Reflec;on. */
    // Please write some code to output the secret. You cannot adjust the visibility of the variable.
    final class ReflectionTest {
        private $mySecret = 'I have 99 problems. This isn\'t one of them.'; 

    }

    $rp = new ReflectionProperty('ReflectionTest', 'mySecret');
    $rt = new ReflectionTest;
    $rp->setAccessible(true);
    echo $rp->getValue($rt);
});

Route::get('part2/test2', function(){
    /**
    * @Author: Dennis L.
    * @Test: 2
    * @TimeLimit: 10 minutes * @Testing: Closures
    */
    /**
    * When this method runs, it should return valid dates in the following format: DD/MM/YYYY. */
    function changeDateFormat(array $dates): array
    {
        $listOfDates = []; 
        $closure = function($date) use(&$listOfDates){
            $dateObj = null;
            $dateInTime = strtotime($date);
            array_push($listOfDates, $dateInTime ? date("d/m/Y", $dateInTime) : 'Invalid format');
        };

        // Don't edit anything else! 
        array_map($closure, $dates);
        return $listOfDates; 
    }

    var_dump(changeDateFormat(array("2010/03/30", "15/12/2016", "11-15-2012", "20130720")));

});

Route::get('part2/test3', function(){
    /**
    * @Author: Dennis L.
    * @Test: 3
    * @TimeLimit: 15 minutes * @Tes;ng: Recursion
    */
    $count = 0;
    function numberOfItems(array $arr, string $needle) : int{
        // Write some code to tell me how many of my selected fruit is in these lovely nested arrays.
        global $count;
        for($i = 0; $i < count($arr); $i++){
            if(is_array($arr[$i])){
                numberOfItems($arr[$i], $needle);
            }else if($arr[$i] == $needle){
                $count++;
            }
        }

        return $count;
    }
    
    $arr = ['apple', ['banana', 'strawberry', 'apple', ['banana', 'strawberry', 'apple']]]; 
    echo numberOfItems($arr, 'apple') . PHP_EOL;
        
});

Route::get('part2/test4', function(){
    /**
    * @Author: Dennis L.
    * @Test: 4
    * @TimeLimit: 30 minutes
    * @Tes;ng: Input Sanita;on */
    // Fix this so there are no SQL Injec;on asacks, no chance for a man-in-the-middle asack (e.g., use something to determine if the input was changed), and limit the chances of
    // brute-forcing this creden;al system to gain entry. Feel free to change any part of this code.
    
    $username = isset($_GET['username']) && trim($_GET['username']) != '' ? $_GET['username'] : ''; 
    $password = isset($_GET['password']) && trim($_GET['password']) != '' ? $_GET['password'] : ''; 
    $password = md5($password);
    $pdo = new PDO('sqlite::memory:'); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("CREATE TABLE users (username VARCHAR(255), password VARCHAR(255))");

    $rootPassword = md5("secret");

    $insert_query = "";
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES ('root', :password)");
    $stmt->bindParam(":password", $rootPassword);
    $stmt->execute();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :pass");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pass", $password);
    $stmt->execute();

    if (count($stmt->fetchAll())) {
        echo "Access granted to $username!<br>\n";
    } else {
        echo "Access denied for $username!<br>\n"; 
    }
});

Route::get('/products', 'ProductController@index');
Route::get('/product/{slug}', 'ProductController@show');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
