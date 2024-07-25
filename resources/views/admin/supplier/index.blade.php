@extends('layouts.master', ['title' => 'Supplier'])

@section('content')
<x-container>
    <div class="col-12 col-lg-8">
        <x-card title="DAFTAR SUPPLIER" class="card-body p-0">
            <x-table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Supplier</th>
                        <th>No Hp</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $i => $supplier)
                    <tr>
                        <td>{{ $i + $suppliers->firstItem() }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->telp }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>
                            @can('update-supplier')
                            <x-button-modal :id="$supplier->id" title="" icon="edit" style=""
                                class="btn btn-info btn-sm" />
                            <x-modal :id="$supplier->id" title="Edit - {{ $supplier->name }}">
                                <form action="{{ route('admin.supplier.update', $supplier->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <x-input name="name" type="text" title="Nama Supplier" placeholder="Nama Supplier"
                                        :value="$supplier->name" />
                                    <x-input name="telp" type="text" title="Telp Supplier" placeholder="Telp Supplier"
                                        :value="$supplier->telp" />
                                    <x-input name="address" type="text" title="Alamat Supplier"
                                        placeholder="Alamat Supplier" :value="$supplier->address" />
                                    <x-button-save title="Simpan" icon="save" class="btn btn-primary" />
                                </form>
                            </x-modal>
                            @endcan
                            @can('delete-supplier')
                            <x-button-delete :id="$supplier->id" :url="route('admin.supplier.destroy', $supplier->id)"
                                title="" class="btn btn-danger btn-sm" />
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-table>
        </x-card>
    </div>
    @can('create-supplier')
    <div class="col-12 col-lg-4">
        <x-card title="TAMBAH SUPPLIER" class="card-body">
            <form action="{{ route('admin.supplier.store') }}" method="POST">
                @csrf
                <x-input name="name" type="text" title="Nama Supplier" placeholder="Nama Supplier"
                    :value="old('name')" />
                <x-input name="telp" type="text" title="Telp Supplier" placeholder="Telp Supplier"
                    :value="old('telp')" />
                

                <div class="form-group">
                    <label class="form-label" for="provinsi">Provinsi</label>
                    <select class="form-control" id="provinsi" name="provinsi">
                        <option value="">Silahkan Pilih</option>
                    </select>
                </div>
                <div class="mt-3 form-group">
                    <label class="form-label" for="kota">Kota</label>
                    <select class="form-control" id="kota" name="kota">
                        <option value="">Silahkan Pilih</option>
                    </select>
                </div>
                <div class="mt-3 form-group">
                    <label class="form-label" for="kecamatan">Kecamatan</label>
                    <select class="form-control" id="kecamatan" name="kecamatan">
                        <option value="">Silahkan Pilih</option>
                    </select>
                </div>
                <div class="mt-3 mb-3 form-group">
                    <label class="form-label" for="kelurahan">Kelurahan</label>
                    <select class="form-control" id="kelurahan" name="kelurahan">
                        <option value="">Silahkan Pilih</option>
                    </select>
                </div>
                <div class="mt-3 mb-3 form-group">
                    <label class="form-label" for="address">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="4" readonly></textarea>
                </div>

                <x-button-save title="Simpan" icon="save" class="btn btn-primary" />
            </form>
        </x-card>
    </div>
    @endcan
</x-container>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let selectedProvinsi = '';
let selectedKota = '';
let selectedKecamatan = '';
let selectedKelurahan = '';

document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk mengambil data provinsi dari API
    function fetchProvinsi() {
        fetch('/admin/billing-address/provinsi')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const provinsiOptions = data.provinsi;
                const selectProvinsi = document.getElementById('provinsi');
                selectProvinsi.innerHTML = '<option value="">Silahkan Pilih</option>';

                provinsiOptions.forEach((provinsi) => {
                    let option = document.createElement('option');
                    option.value = provinsi.id;
                    option.textContent = provinsi.nama;
                    selectProvinsi.appendChild(option);
                });

                // Panggil fungsi untuk memuat kota berdasarkan provinsi saat halaman dimuat
                const provinsiId = selectProvinsi.value;
                getKotaByProvinsi(provinsiId);
            })
            .catch(error => console.error('Error fetching provinsi:', error));
    }

    // Fungsi untuk mengambil data kota berdasarkan provinsi yang dipilih
    function getKotaByProvinsi(provinsiId) {
        fetch(`/admin/billing-address/kota/${provinsiId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const kotaOptions = data.kota_kabupaten;
                const selectKota = document.getElementById('kota');
                selectKota.innerHTML = '<option value="">Silahkan Pilih</option>';

                kotaOptions.forEach((kota) => {
                    let option = document.createElement('option');
                    option.value = kota.id;
                    option.textContent = kota.nama;
                    selectKota.appendChild(option);
                });

                // Panggil fungsi untuk memuat kecamatan berdasarkan kota yang dipilih
                const kotaId = selectKota.value;
                getKecamatanByKota(kotaId);
            })
            .catch(error => console.error('Error fetching kota:', error));
    }

    // Fungsi untuk mengambil data kecamatan berdasarkan kota yang dipilih
    function getKecamatanByKota(kotaId) {
        fetch(`/admin/billing-address/kecamatan/${kotaId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const kecamatanOptions = data.kecamatan;
                const selectKecamatan = document.getElementById('kecamatan');
                selectKecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';

                kecamatanOptions.forEach((kecamatan) => {
                    let option = document.createElement('option');
                    option.value = kecamatan.id;
                    option.textContent = kecamatan.nama;
                    selectKecamatan.appendChild(option);
                });

                // Panggil fungsi untuk memuat kelurahan berdasarkan kecamatan yang dipilih
                const kecamatanId = selectKecamatan.value;
                getKelurahanByKecamatan(kecamatanId);
            })
            .catch(error => console.error('Error fetching kecamatan:', error));
    }

    // Fungsi untuk mengambil data kelurahan berdasarkan kecamatan yang dipilih
    function getKelurahanByKecamatan(kecamatanId) {
        fetch(`/admin/billing-address/kelurahan/${kecamatanId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const kelurahanOptions = data.kelurahan;
                const selectKelurahan = document.getElementById('kelurahan');
                selectKelurahan.innerHTML = '<option value="">Pilih Kelurahan</option>';

                kelurahanOptions.forEach((kelurahan) => {
                    let option = document.createElement('option');
                    option.value = kelurahan.id;
                    option.textContent = kelurahan.nama;
                    selectKelurahan.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching kelurahan:', error));
    }

    function updateAddressInput() {
        const addressInput = document.getElementById('address');
        addressInput.value = `${selectedProvinsi}, ${selectedKota}, ${selectedKecamatan}, ${selectedKelurahan}`;
    }
    // Panggil fungsi untuk mengambil data provinsi saat halaman dimuat
    fetchProvinsi();

    // Tambahkan event listener untuk memanggil fungsi-fungsi ketika ada perubahan pada dropdown
    document.getElementById('provinsi').addEventListener('change', function() {
        selectedProvinsi = this.options[this.selectedIndex].text;
        selectedKota = ''; // Reset nilai kota, kecamatan, dan kelurahan karena provinsi berubah
        selectedKecamatan = '';
        selectedKelurahan = '';
        updateAddressInput();

        const provinsiId = this.value;
        getKotaByProvinsi(provinsiId);
    });

    // Tambahkan event listener untuk memperbarui nilai selectedKota
    document.getElementById('kota').addEventListener('change', function() {
        selectedKota = this.options[this.selectedIndex].text;
        selectedKecamatan = ''; // Reset nilai kecamatan dan kelurahan karena kota berubah
        selectedKelurahan = '';
        updateAddressInput();

        const kotaId = this.value;
        getKecamatanByKota(kotaId);
    });

    // Tambahkan event listener untuk memperbarui nilai selectedKecamatan
    document.getElementById('kecamatan').addEventListener('change', function() {
        selectedKecamatan = this.options[this.selectedIndex].text;
        selectedKelurahan = '';
        updateAddressInput();

        const kecamatanId = this.value;
        getKelurahanByKecamatan(kecamatanId);
    });

    // Tambahkan event listener untuk memperbarui nilai selectedKelurahan
    document.getElementById('kelurahan').addEventListener('change', function() {
        selectedKelurahan = this.options[this.selectedIndex].text;
        updateAddressInput();
    });
});
</script>
@endsection