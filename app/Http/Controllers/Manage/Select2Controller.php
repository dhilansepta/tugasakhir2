<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    public function selectBarang(Request $request)
    {
        $searchTerm = $request->get('q', ''); // Default to empty string if 'q' is not provided

        // Fetching barang that matches the search term
        $data = Barang::where('nama_barang', 'LIKE', '%' . $searchTerm . '%')->get();

        // Format the data for select2
        $results = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->nama_barang
            ];
        });

        return response()->json(['results' => $results]);
    }


    public function getData($id)
    {
        // Fetch the item by its ID
        $item = Barang::find($id);

        if (!$item) {
            // Return an error response if the item is not found
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Get related data based on the item
        $satuan = $item->satuan; // Assuming there's a relationship defined in the Barang model
        $kategori = $item->kategori; // Assuming there's a relationship defined in the Barang model
        $nama_barang = $item->nama_barang;

        return response()->json([
            'satuan' => $satuan ? $satuan->satuan : null, // Adjust this based on your model
            'kategori' => $kategori ? $kategori->kategori : null, // Adjust this based on your model
            'nama_barang' => $nama_barang
        ]);
    }
}
