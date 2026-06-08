<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;

 
class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data buku dari database
        $bukus = Buku::latest()->get();
        
        // Statistik untuk card
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        // Daftar tahun terbit untuk filter dropdown
        $daftarTahun = Buku::select('tahun_terbit')->distinct()->orderBy('tahun_terbit', 'desc')->pluck('tahun_terbit');
        
        // Return view dengan data
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'daftarTahun'
        ));
    }
 
    public function search(Request $request)
    {
        $query = Buku::query();

        //Keyword (Judul, Pengarang, Penerbit)
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%$keyword%")
                  ->orWhere('pengarang', 'like', "%$keyword%")
                  ->orWhere('penerbit', 'like', "%$keyword%");
            });
        }

        //Kategori Dropdown
        $query->when($request->filled('kategori'), function($q) use ($request) {
            $q->where('kategori', $request->input('kategori'));
        });

        //Tahun Terbit Dropdown
        $query->when($request->filled('tahun_terbit'), function($q) use ($request) {
            $q->where('tahun_terbit', $request->input('tahun_terbit'));
        });

        //Ketersediaan Stok
        $query->when($request->filled('stok'), function($q) use ($request) {
            if ($request->input('stok') === 'tersedia') {
                $q->where('stok', '>', 0);
            } elseif ($request->input('stok') === 'habis') {
                $q->where('stok', 0);
            }
        });

        $bukus = $query->latest()->get();

        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        $daftarTahun = Buku::select('tahun_terbit')->distinct()->orderBy('tahun_terbit', 'desc')->pluck('tahun_terbit');
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'daftarTahun'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Akan diimplementasi di pertemuan 12
        return view('buku.create');
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
            // Create buku baru dengan validated data
            Buku::create($request->validated());
        
            // Redirect dengan success message
            return redirect()->route('buku.index') ->with('success', 'Buku berhasil ditambahkan!');
                         
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back() ->withInput() ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }
 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find buku by ID, throw 404 if not found
        $buku = Buku::findOrFail($id);
        
        // Return view detail buku
        return view('buku.show', compact('buku'));
    }
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $buku->update($request->validated());
        
            return redirect()->route('buku.index') ->with('success', 'Buku berhasil diupdate!');
                         
        } catch (\Exception $e) {
            return redirect()->back() ->withInput() ->with('error', 'Gagal mengupdate buku: ' . $e->getMessage());
        }
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
        $buku = Buku::findOrFail($id);
        $judulBuku = $buku->judul;
        
        // Delete buku
        $buku->delete();
        
        // Redirect dengan success message
        return redirect()->route('buku.index')
                         ->with('success', "Buku '{$judulBuku}' berhasil dihapus!");
                         
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }
    
    /**
     * Filter buku berdasarkan kategori.
     */
    public function filterKategori($kategori)
    {
        $bukus = Buku::where('kategori', $kategori)->latest()->get();
        
        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();
        
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategori'
        ));
    }

    /**
     * Bulk delete buku.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->buku_ids;

        if (empty($ids) && $request->has('buku_ids')) {
            $ids = $request->input('buku_ids');
        }

        $primaryKey = (new Buku)->getKeyName();

        Buku::whereIn($primaryKey, $ids)->delete();
        return redirect()->route('buku.index')->with('success', count($ids) . ' buku berhasil dihapus.');
    }

    /**
     * Export buku ke CSV.
     */
    public function export()
    {
        $bukus = Buku::all();
        
        $filename = 'buku_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($bukus) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'Kode Buku', 'Judul', 'Kategori', 'Pengarang', 
                'Penerbit', 'Tahun', 'ISBN', 'Harga', 'Stok'
            ]);
            
            // Data
            foreach ($bukus as $buku) {
                fputcsv($file, [
                    $buku->kode_buku,
                    $buku->judul,
                    $buku->kategori,
                    $buku->pengarang,
                    $buku->penerbit,
                    $buku->tahun_terbit,
                    $buku->isbn,
                    $buku->harga,
                    $buku->stok,
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}