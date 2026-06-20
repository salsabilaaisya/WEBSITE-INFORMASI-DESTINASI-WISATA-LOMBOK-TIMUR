<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Destination;

class DestinationIndex extends Component
{
    use WithPagination;

    // Properti untuk fitur pencarian live search
    public $search = '';

    // Reset pagination ke halaman 1 setiap kali user mengetik di kolom pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Fungsi untuk menghapus destinasi langsung dari tabel
    public function delete($id)
    {
        $destination = Destination::find($id);
        if ($destination) {
            $destination->delete();
            session()->flash('success', 'Destinasi berhasil dihapus!');
        }
    }

    public function render()
    {
        // Mengambil data destinasi beserta kategorinya, di-filter berdasarkan input pencarian
        $destinations = Destination::with('category')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('location', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.destination-index', [
            'destinations' => $destinations
        ]);
    }
}