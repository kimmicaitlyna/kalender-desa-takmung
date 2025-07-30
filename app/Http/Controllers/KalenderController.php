<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Carbon\Carbon;


class KalenderController extends Controller
{

    public function getEvents()
    {
        $data = Kegiatan::all();

        $events = [];
        foreach ($data as $row) {
            $events[] = [
                'id'          => $row->id,
                'title'       => $row->judul,
                'start'       => $row->tanggalMulai,
                'end'         => Carbon::parse($row->tanggalSelesai)->addDay()->toDateString(), // untuk tampilan kalender
                'description' => $row->deskripsi,
                'extendedProps' => [
                    'lokasi'             => $row->lokasi,
                    'keterangan'         => $row->keterangan,
                    'jenisPeserta'       => $row->jenisPeserta,
                    'jumlahPeserta'      => $row->jumlahPeserta,
                    'tanggalMulaiAsli'   => $row->tanggalMulai,
                    'tanggalSelesaiAsli' => $row->tanggalSelesai,
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
                'deskripsi'      => 'nullable|string',
                'lokasi'         => 'nullable|string',
                'keterangan'     => 'nullable|string',
                'jenisPeserta'   => 'nullable|string',
                'jumlahPeserta'  => 'nullable|integer',
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

    public function update(Request $request, $id)
    {
        try{
            $kegiatan = Kegiatan::find($id);
            if (!$kegiatan) {
                return response()->json([
                    "status" => false,
                    "message" => "Kegiatan not found"
                ], 404);
            }

            $request->validate([
                'judul'          => 'nullable|string',
                'tanggalMulai'   => 'nullable|date',
                'tanggalSelesai' => 'nullable|date',
                'deskripsi'      => 'nullable|string',
                'lokasi'         => 'nullable|string',
                'keterangan'     => 'nullable|string',
                'jenisPeserta'   => 'nullable|string',
                'jumlahPeserta'  => 'nullable|integer|min:1',
            ]);

            $kegiatan->update($request->only([
                'judul',
                'tanggalMulai',
                'tanggalSelesai',
                'deskripsi',
                'lokasi',
                'keterangan',
                'jenisPeserta',
                'jumlahPeserta',
            ]));


            return response()->json([
                "status" => true,
                "message" => "update successful",
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
