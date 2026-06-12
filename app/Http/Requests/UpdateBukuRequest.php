<?php
 
namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\KodeBukuFormat;
 
class UpdateBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get buku ID from route parameter
        $bukuId = $this->route('buku');
        
        return [
            'kode_buku' => 'required|string|max:20|unique:buku,kode_buku,' . $bukuId, new KodeBukuFormat,
            'judul' => 'required|string|max:200',
            'kategori' => 'required|in:Programming,Database,Web Design,Networking,Data Science',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20',
            'harga' => 'required|numeric|min:0',

            // Jika tahun terbit < 2000, stok maksimal 5
            'stok' => 'required|integer|min:0', $this->input('tahun_terbit') < 2000 ? 'max:5' : 'Untuk buku terbit sebelum tahun 2000, stok maksimal 5',
            'deskripsi' => 'nullable|string',

            // Jika kategori "Programming", field bahasa harus "Inggris"
            'bahasa' => 'required|string|max:20', $this->input('kategori') === 'Programming' ? 'in:Inggris' : 'Jika kategori "Programming", harus menggunakan bahasa inggris',
        ];
    }
 
    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'kode_buku.required' => 'Kode buku wajib diisi.',
            'kode_buku.unique' => 'Kode buku sudah digunakan.',
            'judul.required' => 'Judul buku wajib diisi.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'harga.required' => 'Harga buku wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'stok.max' => 'Untuk buku terbit sebelum tahun 2000, stok maksimal 5.',
            'bahasa.required' => 'Bahasa wajib diisi.',
            'bahasa.in' => 'Jika kategori "Programming", harus menggunakan bahasa inggris.',
        ];
    }
}