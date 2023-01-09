<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $images = Image::all();

        return response()->json([
            'success' => true,
            'message' =>'List Semua Gambar',
            'data'    => $images
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filepath'   => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'barang_id' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'namafile dan id Barang Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {
            $filename = $request->file('filepath')->getClientOriginalName();
            $destination_path = 'image';
            $image = 'B-' . time() . $filename;

            if ($request->file('filepath')->move($destination_path, $image)) {
                $uploadepath=$destination_path."/".$image;
                $images = Image::create([
                    'barang_id'     => $request->input('barang_id'),
                    'filepath'   => $uploadepath,
                    'kategori'     => $request->input('kategori'),
                    'keterangan'   => $request->input('keterangan'),
                ]);

                if ($images) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Gambar Berhasil Disimpan!',
                        'data' => $images
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data Gambar Gagal Disimpan!',
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gambar Gagal Diuploade!',
                ], 400);
            }

        }

    }
    public function show($id)
    {
        $images = Image::find($id);

        if ($images) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Gambar!',
                'data'      => $images
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gambar Tidak Ditemukan!',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'filepath'   => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'barang_id' => 'required',
        ]);
        $image_path = $request->file('filepath')->store('image', 'public');

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Kode dan Nama Barang Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $images = Image::whereId($id)->update([
                'barang_id'     => $request->input('barang_id'),
                'filepath'   => $image_path,
                'kategori'     => $request->input('kategori'),
                'keterangan'   => $request->input('keterangan'),
            ]);

            if ($images) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Images Berhasil Diupdate!',
                    'data' => $images
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Image Gagal Diupdate!',
                ], 400);
            }

        }
    }
    public function destroy($id)
    {
        $images = Image::whereId($id)->first();
        $deletedfile = File::delete($images->filepath);
        
        if ($deletedfile) {
            $images->delete();

            if ($images) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Image Berhasil Dihapus!',
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Data Image di database tidak Ditemukan!',
                ], 400);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Image tidak Ditemukan!',
            ], 400);

        }

    }
}