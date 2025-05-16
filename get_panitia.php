<?php
include("db.php");

$response = ['Nama' => '', 'Divisi' => ''];

if (isset($_GET['kode'])) {
    $Kode_Absen = $_GET['kode'];
    $stmt = $db->prepare("SELECT Nama, Divisi FROM panitia WHERE Kode_Absen = ?");
    $stmt->bind_param("s", $Kode_Absen);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $response['Nama'] = $data['Nama'];
        $response['Divisi'] = $data['Divisi'];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
