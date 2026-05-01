<?php
$realm = 'Restricted area';
$servername = "localhost";
  $username = "u977112581_boardmodal";
  $password = "Boardmodal@123#$";
  $dbname = "u977112581_boardmodal";

//user => password
$users = array('admin' => 'gujcet@Data123?');

if(isset($_GET['logout'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo "<script>location = location.href.split('?')[0]</script>";
    die();
}

if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
    echo "cancelled ! <br /><a href=''>Retry</a>";
    die();
    // die('Text to send if user hits Cancel button');
}


// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']])){
        header('HTTP/1.1 401 Unauthorized');
        echo "Wrong Credentials! <br/><a href=''>Retry</a>";
        die();
    }


// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response){
    header('HTTP/1.1 401 Unauthorized');
    echo "Wrong Credentials! <br/><a href=''>Retry</a>";
    die();
}
// ok, valid username & password

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
    body{
        background: linear-gradient(45deg,#4158d0,#c850c0);
        font-family: 'Open Sans', sans-serif;
    }
    div{
        width: 80%;
        margin: 0 auto;
        border-radius: 10px;
        overflow: hidden;
    }
    table{
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    thead tr {
        background: #362f4b;
        color:#fff;
        height: 60px;
        font-size: 18px;
    }
    th,td{
        padding: 10px 20px;
    }
    tbody tr {
        background-color: #fff;
        /* color:#808080; */
    }
    tbody tr:nth-child(even) {
        background-color: #f5f5f5;
    }
    .btn,button {
        display: inline-block;
        margin: 20px;
        width: fit-content;
        text-decoration: none;
        background: #fff;
        color: #362f4b;
        padding: 10px;
        border-radius: 10px;
        border:none;
        font-size:16px;
        font-family: 'Open Sans', sans-serif;
        cursor: pointer;
    }
</style>
<div>
<table id="tbl">
    <thead>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Mobile</th>
            <th>Parent Mobile</th>
            <th>Medium</th>
            <th>School</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM `student_data1`";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $i=0;
        while ($row = mysqli_fetch_array($result)) {
            // print_r($row);
            ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $row['Name'] ?></td>
                <td><?php echo $row['Mobile'] ?></td>
                <td><?php echo $row['ParentMobile'] ?></td>
                <td><?php echo $row['Medium'] ?></td>
                <td><?php echo $row['School'] ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
</div>
<a href="?logout=1" class="btn">Logout</a>
<button onclick="ExportToExcel('xlsx')">Export</button>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('data.' + (type || 'xlsx')));
    }
</script>

<?php
// function to parse the http auth header
function http_digest_parse($txt)
{
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}
?>