@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Pembayaran Infaq</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="/donate" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Jumlah Donasi</label>
                            <input type="number" id="amount" name="amount" class="form-control" required min="1000">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="anonymousToggle" onchange="toggleNameInput()">
                            <label class="form-check-label" for="anonymousToggle">Sembunyikan nama saya (Hamba Allah)</label>
                        </div>
                        <div class="form-group" id="nameField">
                            <label for="name">Nama (optional)</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Lanjutkan Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleNameInput() {
        var checkbox = document.getElementById('anonymousToggle');
        var nameField = document.getElementById('nameField');
        var nameInput = document.getElementById('name');
        if (checkbox.checked) {
            nameField.style.display = 'none';
            nameInput.value = 'Hamba Allah';
        } else {
            nameField.style.display = 'block';
            nameInput.value = '';
        }
    }
</script>
@endsection
