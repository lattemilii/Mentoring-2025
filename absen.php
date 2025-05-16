<?php
include("db.php");
date_default_timezone_set('Asia/Jakarta');


if (isset($_POST['confirm'])) {
    $Kode_Absen = $_POST['Kode_Absen'];
    $waktu_absen = date('Y-m-d H:i:s');
    $stmt = $db->prepare("UPDATE panitia SET Kehadiran_P2 = 'Hadir', Waktu_Absen = ? WHERE Kode_Absen = ?");
    $stmt->bind_param("ss", $waktu_absen, $Kode_Absen);
    $stmt->execute();
    header("Location: absen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Absensi Mentoring 2025</title>
  <script>
    function fetchDetails() {
      const kode = document.getElementById("Kode_Absen").value;

      if (kode.trim() === "") {
        document.getElementById("nama").innerText = "";
        document.getElementById("divisi").innerText = "";
        document.getElementById("kode_display").innerText = "";
        document.getElementById("confirmSection").style.display = "none";
        return;
      }

      fetch("get_panitia.php?kode=" + encodeURIComponent(kode))
        .then(res => res.json())
        .then(data => {
          document.getElementById("nama").innerText = data.Nama;
          document.getElementById("divisi").innerText = data.Divisi;
          document.getElementById("kode_display").innerText = kode;
          document.getElementById("hiddenKode").value = kode;

          if (data.Nama !== "") {
            document.getElementById("confirmSection").style.display = "block";
          } else {
            document.getElementById("confirmSection").style.display = "none";
          }
        });
    }
  </script>
</head>
<body>
  <h1>Absensi Panitia Mentoring 2025</h1>

  <?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Berhasil absen!</p>
  <?php endif; ?>

  <form action="absen.php" method="post">
    <label for="Kode_Absen">Kode Absen/NIM:</label>
    <input type="text" id="Kode_Absen" name="Kode_Absen" oninput="fetchDetails()">
    <br><br>

    <div>
      <label>Nama:</label>
      <div id="nama"></div>

      <label>Divisi:</label>
      <div id="divisi"></div>

      <label>Kode Absen:</label>
      <div id="kode_display"></div>
    </div>

    <div id="confirmSection" style="display: none;">
      <input type="hidden" id="hiddenKode" name="Kode_Absen">
      <br>
      <button type="submit" name="confirm">Confirm</button>
    </div>
  </form>
</body>
</html>
