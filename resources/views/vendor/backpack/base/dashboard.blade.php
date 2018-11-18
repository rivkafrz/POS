@extends('backpack::layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
              <div class="box-body">
                <p class="lead">Welcome {{ Auth::user()->employee->employee_name }}</p>
                <p>You are logged in with <strong>{{ Auth::user()->email }}</strong></p>
              </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="{{ Auth::user()->hasRole('admin') ? 'col-md-6' : 'col-md-8' }}">
            <div class="box box-default">
                <div class="box-body">
                  <div class="row">
                        <div class="col-xs-offset-3 col-md-offset-5">
                            <img src="{{ url ('logo.jpg') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center text-danger" style="padding-top: 20px">
                            <p><strong><em> PT PRIMAJASA PERDANARAYAUTAMA</em></strong></p>
                        </div>
                    </div>
                    
                    <p class="text-justify">
                        PT Primajasa Perdanarayautama didirikan pada tanggal 6 September 1991, dipimpin oleh H. Amir Mahpud, SE. sebagai Direktur Utama. PT Primajasa Perdanarayautama menyelenggarakan kegiatan pokok perusahaan yaitu dalam bidang Angkutan Umum (Public Transportation) yang meliputi Angkutan Kota Antar Propinsi (AKAP), Angkutan Kota Dalam Propinsi 
                        (AKDP), Taksi, Pariwisata dan Angkutan Karyawan.PT Primajasa Perdanarayautama berafiliasi dengan perusahaan besar yaitu Group Mayasari Bhakti Utama sebagai salah satu pelopor perusahaan Angkutan Umum Bus Kota di Jakarta sejak tahun 1967 dan yang terbesar sampai dengan sekarang, dipimpin oleh H. Mahpud sebagai Presiden Direktur.
                    </p>
                </div>
            </div>
        </div>
        @if (Auth::user()->hasRole('admin'))
            @include('partials._history')
            @else
            @include('partials._setting')
        @endif
@endsection
