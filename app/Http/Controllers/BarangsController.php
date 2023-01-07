<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangsController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();

        return response()->json([
            'success' => true,
            'message' =>'List Semua Barang',
            'data'    => $barangs
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kodebarang'   => 'required',
            'namabarang' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Kode dan Nama Barang Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $barangs = Barang::create([
                'kodebarang'     => $request->input('kodebarang'),
                'namabarang'   => $request->input('namabarang'),
                'satuan'     => $request->input('satuan'),
                'hargabeli'   => $request->input('hargabeli'),
                'hargajual'   => $request->input('hargajual'),
                'jumlah'     => $request->input('jumlah'),
                'deskripsi'   => $request->input('deskripsi'),
            ]);

            if ($barangs) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Barang Berhasil Disimpan!',
                    'data' => $barangs
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Barang Gagal Disimpan!',
                ], 400);
            }

        }
    }
    public function show($id)
    {
        $barangs = Barang::find($id);

        if ($barangs) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Barang!',
                'data'      => $barangs
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan!',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kodebarang'   => 'required',
            'namabarang' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Kode dan Nama Barang Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $barangs = Barang::whereId($id)->update([
                'kodebarang'     => $request->input('kodebarang'),
                'namabarang'   => $request->input('namabarang'),
                'satuan'     => $request->input('satuan'),
                'hargabeli'   => $request->input('hargabeli'),
                'hargajual'   => $request->input('hargajual'),
                'jumlah'     => $request->input('jumlah'),
                'deskripsi'   => $request->input('deskripsi'),
            ]);

            if ($barangs) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Barang Berhasil Diupdate!',
                    'data' => $barangs
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Barang Gagal Diupdate!',
                ], 400);
            }

        }
    }
    public function destroy($id)
    {
        $barangs = Barang::whereId($id)->first();
            $barangs->delete();

        if ($barangs) {
            return response()->json([
                'success' => true,
                'message' => 'Data Barang Berhasil Dihapus!',
            ], 200);
        }

    }
}