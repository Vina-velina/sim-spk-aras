@extends('admin.layouts.app')

@section('tittle', 'Dashboard')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Dashboard', 'active' => 'Index'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <!--div-->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Total Master Kriteria</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>{{ $total_masterKriteria }} Kriteria</h3>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Total Data Debitur</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>{{ $total_debitur }} Debitur</h3>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Total Periode Pelaksanaan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>{{ $total_periode }} Periode</h3>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <!--/div-->
        </div>
        <div class="row row-sm">
            <!--div-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Selamat Datang Di SIM SPK ARAS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Sistem Informasi Manajemen Pendukung Keputusan dengan metode ARAS adalah sebuah Sistem Informasi
                            yang digunakan untuk membantu dalam pengambilan keputusan bagi Koperasi Mitra Abhinaya
                            Sejahtera, utamanya dalam pelaksanaan program kerja pemberian penghargaan bagi Debitur Terbaik
                            guna meningkatkan minat pembayaran tagihan. Berikut merupakan informasi akun anda</p>
                        <table>
                            <tr>
                                <td>Nama Akun</td>
                                <td>:</td>
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <td>Login Sebagai</td>
                                <td>:</td>
                                <td>{!! \App\Helpers\CutText::cutUnderscore(ucWords(Auth::user()->role_user)) !!}</td>
                            </tr>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <!--/div-->
        </div>
    </div>
@endsection
