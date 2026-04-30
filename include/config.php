<?php
session_start();

include __DIR__ . '/../common/globalvariable.php';
include __DIR__ . '/../database/connect.php';
// include '../common/function.php';
// include '../common/validation.php';

// ✅ If not logged in → redirect
if (!isset($_SESSION['staff_id']) || strlen($_SESSION['staff_id']) == 0) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
} else {
    $staff_id = $_SESSION['staff_id'];

    $cmd = "SELECT 
                role.id AS role_id, 
                role.name AS role_name, 
                staff.name AS name, 
                staff.email AS user_email
            FROM tbl_staff AS staff
            LEFT JOIN tbl_role AS role ON staff.role_id = role.id
            WHERE staff.id = ?";

    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // ✅ Safely extract values
    $user_email = isset($row['user_email']) ? $row['user_email'] : '';
    $name = isset($row['name']) ? $row['name'] : '';
    $role_id = isset($row['role_id']) ? $row['role_id'] : '';
    $role_name = isset($row['role_name']) ? $row['role_name'] : '';

    // ✅ Check if any critical values are missing
    if (empty($user_email) || empty($name) || empty($role_id) || empty($role_name)) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

// Gujarat Cities for TADA Form Dropdowns
$gujarat_cities = [
    "Ahmedabad", "Surat", "Vadodara", "Rajkot", "Bhavnagar", "Jamnagar", "Junagadh", "Gandhinagar", "Gandhidham", "Anand", "Navsari", "Morbi", "Nadiad", "Bharuch", "Mehsana", "Bhuj", "Porbandar", "Valsad", "Vapi", "Gondal", "Veraval", "Godhra", "Patan", "Kalol", "Dahod", "Botad", "Amreli", "Deesa", "Jetpur", "Palanpur", "Surendranagar", "Sihor", "Modasa", "Viramgam", "Himatnagar", "Kadi", "Savarkundla", "Unjha", "Keshod", "Bardoli", "Mahuva", "Vyara", "Idar", "Visnagar", "Tharad", "Mansa", "Dehgam", "Petlad", "Kapadvanj", "Dabhoi", "Karjan", "Padra", "Waghodia", "Halol", "Lunawada", "Santrampur", "Balasinor", "Bayad", "Malpur", "Bhiloda", "Meghraj", "Talod", "Prantij", "Dhansura", "Khedbrahma", "Vadali", "Vijapur", "Satlasana", "Bechraji", "Jotana", "Chanasma", "Harij", "Sami", "Radhanpur", "Santalpur", "Vav", "Bhabhar", "Lakhani", "Suigam", "Deodar", "Dhanera", "Dantiwada", "Amirgadh", "Thasra", "Umreth", "Anklav", "Borsad", "Khambhat", "Tarapur", "Sojitra", "Dhandhuka", "Dholka", "Bavla", "Sanand", "Barwala", "Ranpur", "Mandal", "Detroj", "Vagra", "Amod", "Jambusar", "Hansot", "Ankleshwar", "Jhagadia", "Valia", "Netrang", "Dediapada", "Sagbara", "Nandod", "Tilakwada", "Garudeshwar", "Uchchhal", "Nizhar", "Songadh", "Valod", "Dolvan", "Kukurmunda", "Ahwa", "Subir", "Waghai", "Vansda", "Chikhli", "Gandevi", "Khergam"
];
sort($gujarat_cities);
?>