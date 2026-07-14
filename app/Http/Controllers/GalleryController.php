public function index(Request $request)
{
    dd('Halo! Controller ini berfungsi!'); // TAMBAHKAN BARIS INI
    
    $query = Gallery::with('destination');
    // ... sisa kode di bawahnya
}