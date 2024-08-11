<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class NilaiController extends Controller
{
    public function RT()
    {
        $results = DB::select("
                SELECT 
                n.nama,
                n.nisn,
                    SUM(
                    CASE 
                        WHEN n.pelajaran_id = (
                            SELECT pelajaran_id 
                            FROM nilai 
                            WHERE nama_pelajaran = 'Artistic' LIMIT 1
                        ) AND n.nama_pelajaran <> 'Pelajaran Khusus'
                        THEN n.skor
                        ELSE 0
                    END
                ) AS artistic,
                  SUM(
                    CASE 
                        WHEN n.pelajaran_id = (
                            SELECT pelajaran_id 
                            FROM nilai 
                            WHERE nama_pelajaran = 'Conventional' LIMIT 1
                        ) AND n.nama_pelajaran <> 'Pelajaran Khusus'
                        THEN n.skor
                        ELSE 0
                    END
                ) AS conventional,
                SUM(
                    CASE 
                        WHEN n.pelajaran_id = (
                            SELECT pelajaran_id 
                            FROM nilai 
                            WHERE nama_pelajaran = 'Realistic' LIMIT 1
                        ) AND n.nama_pelajaran <> 'Pelajaran Khusus'
                        THEN n.skor
                        ELSE 0
                    END
                ) AS realistic,
                  SUM(
                    CASE 
                        WHEN n.pelajaran_id = (
                            SELECT pelajaran_id 
                            FROM nilai 
                            WHERE nama_pelajaran = 'Enterprising' LIMIT 1
                        ) AND n.nama_pelajaran <> 'Pelajaran Khusus'
                        THEN n.skor
                        ELSE 0
                    END
                ) AS enterprising,
                SUM(
                    CASE 
                        WHEN n.pelajaran_id = (
                            SELECT pelajaran_id 
                            FROM nilai 
                            WHERE nama_pelajaran = 'Investigative' LIMIT 1
                        ) AND n.nama_pelajaran <> 'Pelajaran Khusus'
                        THEN n.skor
                        ELSE 0
                    END
                ) AS investigative,
                SUM(
                    CASE 
                        WHEN n.pelajaran_id = (
                            SELECT pelajaran_id 
                            FROM nilai 
                            WHERE nama_pelajaran = 'Social' LIMIT 1
                        ) AND n.nama_pelajaran <> 'Pelajaran Khusus'
                        THEN n.skor
                        ELSE 0
                    END
                ) AS social
            FROM 
                nilai n
            WHERE 
                n.materi_uji_id = 7
            GROUP BY 
                n.nama, n.nisn
            ORDER BY 
                n.nama;
            ");

        $data = collect($results)->map(function ($item) {
            return [
                'nama' => $item->nama,
                'nisn' => $item->nisn,
                'nilaiRt' => [
                    'artistic' => (int) $item->artistic,
                    'conventional' => (int) $item->conventional,
                    'enterprising' => (int) $item->enterprising,
                    'investigative' => (int) $item->investigative,
                    'realistic' => (int) $item->realistic,
                    'social' => (int) $item->social,
                ]

            ];
        });
        return response()->json($data);
    }
    public function ST()
    {
        $results = DB::select("
                SELECT 
                    n.nama,
                    n.nisn,
                    SUM(
                        CASE 
                            WHEN n.pelajaran_id = 44 THEN n.skor * 41.67
                            WHEN n.pelajaran_id = 45 THEN n.skor * 29.67
                            WHEN n.pelajaran_id = 46 THEN n.skor * 100
                            WHEN n.pelajaran_id = 47 THEN n.skor * 23.81
                            ELSE 0
                        END
                    ) AS total,
                    SUM(
                        CASE 
                            WHEN n.pelajaran_id = 44 THEN n.skor * 41.67
                            ELSE 0
                        END
                    ) AS verbal,
                    SUM(
                        CASE 
                            WHEN n.pelajaran_id = 45 THEN n.skor * 29.67
                            ELSE 0
                        END
                    ) AS kuantitatif,
                    SUM(
                        CASE 
                            WHEN n.pelajaran_id = 46 THEN n.skor * 100
                            ELSE 0
                        END
                    ) AS penalaran,
                    SUM(
                        CASE 
                            WHEN n.pelajaran_id = 47 THEN n.skor * 23.81
                            ELSE 0
                        END
                    ) AS figural
                FROM 
                    nilai n
                WHERE 
                    n.materi_uji_id = 4
                GROUP BY 
                    n.nama, n.nisn
                ORDER BY 
                    total DESC;
            ");

        $data = collect($results)->map(function ($item) {
            $item->total = number_format($item->total, 2);
            return ['nama' => $item->nama, 'nisn' => $item->nisn, 'total' => $item->total, 'listNilai' => [
                'figural' => $item->figural,
                'kuantitatif' => $item->kuantitatif,
                'penalaran' => $item->penalaran,
                'verbal' => $item->verbal,
            ]];
        });

        return response()->json($data);
    }
}
