<?php
// MyAPI.php
// Selama berhubungan dengan data pada tabel, selalu dipanggil
// File koneksi

use LDAP\Result;

require_once "koneksi.php";

if ($_GET['function']) {     // Jika parameter function dikirim
    $_GET['function']();     // Jalankan parameter
}

function get_penerbit()
{
    global $connection;

    $data = array();

    $query = $connection->query("SELECT * FROM tb_penerbit");

    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }
    $response = $data;
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_penerbit()
{
    global $connection;

    // Buat parameter form-data array key pada postman
    $datArr = array('nama_penerbit' => '', 'alamat_penerbit' => '');

    // Periksa apakah semua parameter form-data array sesuai
    // dan menggunakan method POST
    $check_match = count(array_intersect_key($_POST, $datArr));

    // Jika semua parameter sudah sesuai lakukan insert data
    if ($check_match == count($datArr)) {
        $nama = $_POST['nama_penerbit'];
        $alamat = $_POST['alamat_penerbit'];

        $result = mysqli_query(
            $connection,
            "INSERT INTO tb_penerbit(nama_penerbit, alamat_penerbit)
        VALUES('$nama', '$alamat')"
        );

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Insert success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Insert Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}


function delete_penerbit()
{
    global $connection;
    $id = $_GET['id'];

    $result = mysqli_query(
        $connection,
        "DELETE FROM tb_penerbit WHERE kode_penerbit = '$id'"
    );

    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Delete success'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Delete Failed'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_buku()
{
    global $connection;

    $data = array();


    // Menampilkan semua data yang ada ditable buku
    // $query = $connection->query("SELECT * FROM tb_buku");
    $query = $connection->query("SELECT tb_buku.kode_buku,tb_buku.judul_buku,tb_buku.tahun_terbit,tb_penerbit.kode_penerbit,tb_penerbit.nama_penerbit,tb_penerbit.alamat_penerbit 
    FROM tb_buku Join tb_penerbit On tb_buku.kode_penerbit = tb_penerbit.kode_penerbit");

    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }
    $response = $data;
    header('Content-Type: application/json');
    echo json_encode($response);
}


function delete_buku()
{
    global $connection;
    $id = $_GET['id'];

    $result = mysqli_query(
        $connection,
        "DELETE FROM tb_buku WHERE kode_buku  = '$id'"
    );

    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Delete success'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Delete Failed'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_buku()
{
    global $connection;

    // Buat parameter form-data array key pada postman
    $datArr = array('judul_buku' => '', 'tahun_terbit' => '', 'kode_penerbit' => '');

    // Periksa apakah semua parameter form-data array sesuai
    // dan menggunakan method POST
    $check_match = count(array_intersect_key($_POST, $datArr));

    // Jika semua parameter sudah sesuai lakukan insert data
    if ($check_match == count($datArr)) {
        $judul = $_POST['judul_buku'];
        $tahun = $_POST['tahun_terbit'];
        $kode = $_POST['kode_penerbit'];

        $result = mysqli_query(
            $connection,
            "INSERT INTO tb_buku(judul_buku, tahun_terbit, kode_penerbit)
        VALUES('$judul', '$tahun', '$kode')"
        );

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Insert success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Insert Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_buku()
{
    global $connection;

    // Buat parameter form-data array key pada postman
    $datArr = array('judul_buku' => '', 'tahun_terbit' => '', 'kode_penerbit' => '');

    // Periksa apakah semua parameter form-data array sesuai
    // dan menggunakan method POST
    $check_match = count(array_intersect_key($_POST, $datArr));

    // Jika semua parameter sudah sesuai lakukan insert data
    if ($check_match == count($datArr)) {
        $judul = $_POST['judul_buku'];
        $tahun = $_POST['tahun_terbit'];
        $kode = $_POST['kode_penerbit'];


        $id = $_GET['id'];
        $result = mysqli_query(
            $connection,
            "UPDATE tb_buku SET judul_buku = '$judul',
            tahun_terbit =  '$tahun',
            kode_penerbit =  '$kode'
            WHERE kode_buku = '$id'
            "
        );

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Update success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Update Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}