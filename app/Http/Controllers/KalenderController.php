<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Carbon\Carbon;


class KalenderController extends Controller
{
    public function getEvents()
    {
        // Mengambil semua data dari model
        $data = Kegiatan::all();

        // Menyusun data dalam format event
        $events = [];
        foreach ($data as $row) {
            $events[] = [
                'id'          => $row->id,
                'title'       => $row->judul,
                'start'       => $row->tanggalMulai,
                'end'         => Carbon::parse($row->tanggalSelesai)->addDay()->toDateString(),
                'description' => $row->deskripsi,
                'extendedProps' => [
                    'lokasi'        => $row->lokasi,
                    'keterangan'    => $row->keterangan,
                    'jenisPeserta'  => $row->jenisPeserta,
                    'jumlahPeserta' => $row->jumlahPeserta,
                ]
            ];
        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'judul'          => 'required|string',
                'tanggalMulai'   => 'required|date',
                'tanggalSelesai' => 'required|date',
                'deskripsi'      => 'required|string',
                'lokasi'         => 'required|string',
                'keterangan'     => 'required|string',
                'jenisPeserta'   => 'required|string',
                'jumlahPeserta'  => 'required|integer|min:1',
            ]);
            
            /////////CREATE kegiatan /////////
            $kegiatan = Kegiatan::create([
                'judul' => $request->judul,
                'tanggalMulai' => $request->tanggalMulai,
                'tanggalSelesai'=> $request->tanggalSelesai,
                'deskripsi'=> $request->deskripsi,
                'lokasi'=> $request->lokasi,
                'keterangan'=> $request->keterangan,
                'jenisPeserta'=> $request->jenisPeserta,
                'jumlahPeserta'=> $request->jumlahPeserta
            ]);
    
            return response()->json([
                "status" => true,
                "message" => "create successful",
                "data" => $kegiatan
            ], 200);

        }catch(Exception $e){
            return response()->json([
                "status" => false,
                "message" => "Something went wrong",
                "data" => $e->getMessage()
            ], 200);
        }
    }

    public function delete($id)
    {
        try{
            $kegiatan = Kegiatan::find($id);
            $kegiatan->delete();
            return response()->json([
                "status" => true,
                "message" => "delete successful",
                "data" => $kegiatan
            ], 200);
        }catch(Exception $e){
            return response()->json([
                "status" => false,
                "message" => "Something went wrong",
                "data" => $e->getMessage()
            ], 200);
        }
    }
}
