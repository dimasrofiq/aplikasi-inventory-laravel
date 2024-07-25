<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function getProvinsi()
    {
        $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
        return $response->json();
    }

    public function getKotaByProvinsi($provinsi_id)
    {
        $response = Http::get("https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi={$provinsi_id}");
        return $response->json();
    }

    public function getKecamatanByKota($kota_id)
    {
        $response = Http::get("https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota={$kota_id}");
        return $response->json();
    }

    public function getKelurahanByKecamatan($kecamatan_id)
    {
        $response = Http::get("https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan={$kecamatan_id}");
        return $response->json();
    }
}
