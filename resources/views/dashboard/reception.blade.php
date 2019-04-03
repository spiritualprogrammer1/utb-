@section('title') Magasinier @endsection
@extends('layouts.master')
@section('content')
<section class="hbox stretch">
    <section>
        <section class="vbox">
            <section class="scrollable padder">
                <section class="row m-b-md">
                    <div class="col-sm-6">
                        <h3 class="m-b-xs text-black">Tableau de bord  </h3>
                        <small>Bienvenu a vous, <span
                                style="text-transform: capitalize">{{ Auth::user()->username }}</span>, <i
                                class="fa fa-map-marker fa-lg text-primary"></i> Abidjan
                        </small>
                    </div>

                </section>


            </section>
        </section>
    </section>


</section>

<!-- Modal -->

<!-- /.Live preview-->
@include('dashboard.modaldashbord')
@endsection
