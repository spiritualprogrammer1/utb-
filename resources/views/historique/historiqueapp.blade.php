@section('title') historique App @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox bg-light dker" id="page">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-file-plus"></i>Hisrorique de l'application</p>

            </div>
        </header>

        <section class="scrollable padder"><br>
            <section class="panel panel-default">
                <header class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                    </div>
                </header>
                <div class="table-responsive">
                    <table class="table datatable table-striped b-t b-light capitalize" id="repairTable">
                        <thead>
                        <tr>

                            <th>Employé</th>
                            <th>Service</th>
                            <th>Operation effectuée</th>
                        </tr>
                        </thead>
                        <tbody id="repairRow">


                        @foreach($processe as $key=>$process)
                            @foreach($process->revisionHistory  as $histor)
                                <?php $user=App\User::find($histor->user_id); ?>

                                <tr id="">
                                    <td>{{$histor->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($histor->key == 'created_at' && !$histor->old_value)
                                        <td> etat du car effectué le {{($histor->created_at->format('d-m-Y'))}}  a {{($histor->created_at->format('H:i'))}}   </td>
                                    @else
                                        <td >modification  du champ {{$histor->fieldName()}}  de valeur  <b style="color: #a30921;">{{ $histor->oldValue() }} </b> a <b style="color: #a30921;">{{ $histor->newValue() }}</b>  le {{($histor->created_at->format('d-m-Y'))}} a  {{($histor->created_at->format('H:i'))}}   </td>
                                    @endif

                                </tr>

                            @endforeach
                        @endforeach


                        @foreach($diagnostics as $key=>$diagnostic)
                            @foreach($diagnostic->revisionHistory  as $hist)
                                <?php $diagnostic=App\Diagnostic::find($hist->revisionable_id); ?>
                                <?php $user=App\User::find($hist->user_id); ?>

                                <tr id="">
                                    <td>{{$hist->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>

                                    @if($hist->key == 'created_at' && !$hist->old_value)
                                        <td> le diagnostic dont l'OT est <b style="color: #a30921;">{{$diagnostic->statee->reference}}</b> a été effectué le  {{($hist->created_at->format('d-m-Y'))}}  a {{($hist->created_at->format('H:i'))}} </td>
                                    @else
                                        <td> le diagnostic dont l'OT est <b style="color: #a30921;">{{$diagnostic->statee->reference}}</b> a été effectué le  {{($hist->created_at->format('d-m-Y'))}}  a {{($hist->created_at->format('H:i'))}} </td>
                                    @endif

                                </tr>

                            @endforeach
                        @endforeach



                        @foreach($repairs as $key=>$repair)
                            @foreach($repair->revisionHistory  as $historyse)
                                <?php $diagnostic=App\Diagnostic::find($repair->diagnostic_id);
                                $process=$diagnostic->statee->reference;
                                ?>
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && !$hist->old_value)
                                        <td > la reparation   <b style="color: #a30921;">{{$process}}</b> a été enregistré le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @else
                                        <td >la reparation est en cours </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach


                        @foreach($revisions as $key=>$revision)
                            @foreach($revision->revisionHistory  as $historyse)
                                <?php $diagnostic=App\Diagnostic::find($revision->diagnostic_id);
                                $process=$diagnostic->statee->reference;
                                ?>
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && !$hist->old_value)
                                        <td > la revision   <b style="color: #a30921;">{{$process}}</b> a été enregistré le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @else
                                        <td >la revision est en cours </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach


                        @foreach($visite_techniques as $key=>$visite_technique)
                            @foreach($visite_technique->revisionHistory  as $historyse)
                                <?php $diagnostic=App\Diagnostic::find($visite_technique->diagnostic_id);
                                $process=$diagnostic->statee->reference;
                                ?>
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && !$hist->old_value)
                                        <td > la visite technique   <b style="color: #a30921;">{{$process}}</b> a été enregistré le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @else
                                        <td >la visite technique est en cours </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach



                        @foreach($suppliers as $key=> $supplier)
                            @foreach($supplier->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && $historyse->key != 'name' && !$hist->old_value && $historyse->key != 'type' &&  $historyse->key != 'country_id' && $historyse->key != 'site_id')
                                        <td > un  fournisseur   a été enregistré le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'country_id')
                                        <td >le pays du fournisseur {{$supplier->name}} a été modifié  </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'name' && $historyse->old_value)
                                        <td >le nom  du fournisseur {{$supplier->name}} a été modifier  de   <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b style="color: #a30921;">{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'site_id' && !$historyse->old_value)
                                        <td >le site  du fournisseur {{$supplier->name}} a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b style="color: #a30921;">{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'type' && !$hist->old_value)
                                        <td >le type  du fournisseur {{$supplier->name}} a été modifier  de valeur  @if($historyse->oldValue()==1) <?php $val='particuler'; ?> @else <?php $val='fournisseur'; ?>  @endif  <b style="color: #a30921;">{{ $val}} @if($historyse->newValue()==1) <?php $vale='particuler'; ?> @else <?php $vale='fournisseur'; ?>  @endif  </b> a <b>{{$vale}}</b>  le {{($histor->created_at->format('d-m-Y'))}} a  {{($histor->created_at->format('H:i'))}}  </td>


                                    @else

                                        <td >modification  du champ {{$historyse->fieldName()}} du fournisseur  de valeur  <b>{{$historyse->oldValue() }} </b> à <b>{{$historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} à  {{($historyse->created_at->format('H:i'))}}  </td>


                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                        @foreach($employes as $key=> $employe)
                            @foreach($employe->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at'  && !$hist->old_value )
                                        <td > un  employé   a été enregistré le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @else

                                        <td >modification des données du'employé  le {{($historyse->created_at->format('d-m-Y'))}} à  {{($historyse->created_at->format('H:i'))}}  </td>


                                    @endif
                                </tr>
                            @endforeach
                        @endforeach


                        @foreach($brands as $key=> $brand)
                            @foreach($brand->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at'  && !$hist->old_value )
                                        <td > une marque   a été enregistré le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @else

                                        <td >le nom de la marque a été modifié   de   <b style="color: #a30921;">{{$historyse->oldValue() }} </b> à <b style="color: #a30921;">{{$historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} à  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @endif
                                </tr>
                            @endforeach
                        @endforeach

                        @foreach($models as $key=> $model)
                            @foreach($supplier->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && $historyse->key != 'name' && !$hist->old_value && $historyse->key != 'place_number' &&  $historyse->key != 'genre_id' && $historyse->key != 'caburant_id' && $historyse->key != 'brand_id')
                                        <td > un  model   a été enregistré le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'name')
                                        <td >le nom du model a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b>{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'place_number' && $historyse->old_value)
                                        <td >le nombre de place du model  a été modifier  de   <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b style="color: #a30921;">{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'genre_id' && !$historyse->old_value)
                                        <td >le genre du model  a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b style="color: #a30921;">{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'brand_id' && !$hist->old_value)
                                        <td >la marque du model  a été modifier  de valeur  @if($historyse->oldValue()==1) <?php $val='particuler'; ?> @else <?php $val='fournisseur'; ?>  @endif  <b style="color: #a30921;">{{ $val}} @if($historyse->newValue()==1) <?php $vale='particuler'; ?> @else <?php $vale='fournisseur'; ?>  @endif  </b> a <b>{{$vale}}</b>  le {{($histor->created_at->format('d-m-Y'))}} a  {{($histor->created_at->format('H:i'))}}  </td>


                                    @else

                                        <td >modification  du champ {{$historyse->fieldName()}} du model  de valeur  <b style="color: #a30921;">{{$historyse->oldValue() }} </b> à <b style="color: #a30921;">{{$historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} à  {{($historyse->created_at->format('H:i'))}}  </td>


                                    @endif
                                </tr>
                            @endforeach
                        @endforeach


                        @foreach($services as $key=> $service)
                            @foreach($service->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && $historyse->key != 'name' && !$hist->old_value && $historyse->key != 'display_name' )
                                        <td > un  service   a été enregistré le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'name')
                                        <td >le nom du service a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b style="color: #a30921;">{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'display_name' && $historyse->old_value)
                                        <td >la description du service  a été modifier  de   <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b style="color: #a30921;">{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @else

                                        <td >modification de service  <b style="color: #a30921;">{{$historyse->oldValue() }} </b> à <b style="color: #a30921;">{{$historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} à  {{($historyse->created_at->format('H:i'))}}  </td>


                                    @endif
                                </tr>
                            @endforeach
                        @endforeach


                        @foreach($postes as $key=> $poste)
                            @foreach($poste->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && $historyse->key != 'name' && !$hist->old_value && $historyse->key != 'service_id' && $historyse->key != 'price' )
                                        <td > un  poste   a été crée le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'service_id')
                                        <td>le service du poste  a été modifier  de valeur    le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'price' && $historyse->old_value)
                                        <td >le prix du poste  a été modifier  de   <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b style="color: #a30921;">{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @else

                                        <td >modification de poste  <b style="color: #a30921;">{{$historyse->oldValue() }} </b> à <b style="color: #a30921;">{{$historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} à  {{($historyse->created_at->format('H:i'))}}  </td>


                                    @endif
                                </tr>
                            @endforeach
                        @endforeach

                        @foreach($subcategorys as $key=> $subcategory)
                            @foreach($subcategory->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && $historyse->key != 'name' && $historyse->key != 'category_id')
                                        <td > une sous categorie de la piece    a été crée le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'name')
                                        <td >le libelle de la sous  categorie piece  a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b>{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'category_id')
                                        <td >la categorie de la sous  categorie piece  a été modifier   le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @else

                                        <td >la sous  categorie piece   <b style="color: #a30921;">{{$historyse->oldValue() }} </b> à <b style="color: #a30921;">{{$historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} à  {{($historyse->created_at->format('H:i'))}}  </td>


                                    @endif
                                </tr>
                            @endforeach
                        @endforeach



                        @foreach($sites as $key=> $site)
                            @foreach($site->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && $historyse->key != 'name')
                                        <td > un site    a été crée le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'name')
                                        <td >le libelle site  a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b>{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @else

                                        <td >la ville du site a été modifier de  <b style="color: #a30921;">{{$historyse->oldValue() }} </b> à <b>{{$historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} à  {{($historyse->created_at->format('H:i'))}}  </td>


                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                        @foreach($entreprises as $key=> $entreprise)
                            @foreach($entreprise->revisionHistory  as $historyse)
                                <?php $user=App\User::find($historyse->user_id); ?>

                                <tr id="">
                                    <td>{{$historyse->userResponsible()->first_name}}</td>
                                    <td>{{strtoupper($user->employee->service->name)}}</td>
                                    @if($historyse->key == 'created_at' && $historyse->key != 'name')
                                        <td > les données de l'entreprise    ont été enregistrer le  {{($historyse->created_at->format('d-m-Y'))}}  a {{($historyse->created_at->format('H:i'))}} </td>
                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'name')
                                        <td >le libelle de l'entreprise  a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b>{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'picture ')
                                        <td >l'image de l'entreprise  a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b>{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'display_name ')
                                        <td >la definition du sigle l'entreprise  a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b>{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @elseif($historyse->key !='created_at'  && $historyse->key == 'footer ')
                                        <td >le pieds du page  a été modifier  de valeur  <b style="color: #a30921;">{{ $historyse->oldValue() }} </b> a <b>{{ $historyse->newValue() }}</b>  le {{($historyse->created_at->format('d-m-Y'))}} a  {{($historyse->created_at->format('H:i'))}}  </td>

                                    @endif
                                </tr>
                            @endforeach
                        @endforeach



                        </tbody>
                    </table>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                    </div>
                </footer>
            </section>
        </section>


    </section>

@endsection