@extends('layouts.master', ['title' => 'Add User'])

@section('content')
<x-container>
    <div class="row">
        <div class="col-12">
            <x-button-link title="Kembali" icon="arrow-left" :url="route('admin.user.index')" class="btn btn-dark mb-2"
                style="mr-1" />
            <x-card title="TAMBAH USER" class="card-body">
                <form action="{{ route('admin.user.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="masukan name anda" name="name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="masukan email anda" name="email">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Seksi</label>
                        <select class="form-select @error('department') is-invalid @enderror" name="department">
                            <option value="" selected>Silahkan Pilih</option>
                            <option value="Umum">Umum</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Marketing">Marketing</option>
                            <option value="HRD">HRD</option>
                            <option value="Pengiriman">Pengiriman</option>
                        </select>
                        @error('department')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role">
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="masukan kata sandi anda" name="password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="masukan konfirmasi kata sandi anda" name="password_confirmation">
                        @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                    </div>
                </form>
            </x-card>

        </div>
    </div>
</x-container>
@endsection