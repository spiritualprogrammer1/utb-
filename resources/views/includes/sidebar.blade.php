<aside class="bg-dark lt b-r b-light aside-md hidden-print" id="nav">
    <section class="vbox">
        <?php $site=\Illuminate\Support\Facades\Auth::user()->employee->site_id;
        ?>
        <section class="w-f scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px"
                 data-railOpacity="0.2">
                <div class="clearfix wrapper dk nav-user hidden-xs">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="thumb avatar pull-left m-r">
                    @if(isset(Auth::user()->employee->image) and !empty(Auth::user()->employee->image))
                              <img src="{{asset('picture_employe/'.Auth::user()->employee->image)}}" class="dker" alt="...">
                              <i class="on md b-black"></i>
                          @else
                              <img src="{{asset('logo/pcture_user.png')}}" class="dker" alt="...">
                              <i class="on md b-black"></i>
                          @endif
                        <i class="on md b-black"></i>
                      </span>
                            <span class="hidden-nav-xs clear">
                        <span class="block m-t-xs">
                          <strong class="font-bold text-lt text-capitalize"
                                  style="text-transform: capitalize">{{ Auth::user()->username }}</strong>
                          <b class="caret"></b>
                        </span>
                        <span class="text-muted text-xs block"
                              style="text-transform: capitalize">{{Auth::user()->employee->service->name}}</span>
                      </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li>
                                <span class="arrow top hidden-nav-xs"></span>
                                <a href="#">Parametres</a>
                            </li>
                            <li>
                                <a href="#">Profil</a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="badge bg-danger pull-right">3</span>
                                    Notifications
                                </a>
                            </li>
                            <li>
                                <a href="#">Aide</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   data-toggle="ajaxModal">Deconnexion</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                    <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">Menu</div>
                    <ul class="nav nav-main" data-ride="collapse">

                        <!-- **** HOME LINK **** -->
                        <li class="{{ Request::path() == '/' ? 'active' : '' }}">
                            <a href="{{url('/')}}" class="auto">
                                <i class="i i-statistics icon"></i>
                                <span class="font-bold">Tableau de bord</span>
                            </a>
                        </li>
                        <!-- **** END **** -->

                        <!-- **** STATE LINK **** -->
                        @if(Auth::user()->can('Reception du car'))
                        <li class="{{ Request::path() == 'state/home' ? 'active' : '' }}">
                            <a href="{{url('state/home')}}" class="auto">
                                <i class="fa fa-truck icon"></i>
                                <span class="font-bold">Reception du car</span>

                            </a>
                        </li>
                        @endif
                        <!-- **** END **** -->

                        <!-- **** DIAGNOSTIC LINK **** -->
                        @if(Auth::user()->can('diagnostique'))
                        <li class="{{ Request::path() == 'diagnostic/home' ? 'active' : '' }}">
                            <a href="{{url('diagnostic/home')}}" class="auto">
                                <i class="fa fa-bug"></i><span>Diagnostique</span>
                                <b class="badge bg-danger pull-right" id="count_diagnostique">
                                    {{App\State::where('state', '1')->count()}}
                                </b>
                            </a>
                        </li>
                        @endif
                        <!-- **** END **** -->

                        <!-- **** SERVICES LINKS **** -->
                        @if(Auth::user()->can(['reparation','revision','visite_technique']))
                        <li class="{{ Request::path() == 'repair/home' ? 'active' : '' }}
                        {{ Request::path() == 'revision/home' ? 'active' : '' }}
                        {{ Request::path() == 'visit/home' ? 'active' : '' }}">
                            <a href="#" class="auto">
                                <span class="pull-right text-muted">
                                  <i class="i i-circle-sm-o text"></i>
                                  <i class="i i-circle-sm text-active"></i>
                                </span>
                                <i class="i i-pin icon"></i>
                                <span class="font-bold">Prestation</span>
                            </a>
                            <ul class="nav dk">
                                @if(Auth::user()->can('reparation'))
                                <li class="{{ Request::path() == 'repair/home' ? 'active' : '' }}">
                                    <a href="{{url('repair/home')}}" class="auto">
                                        <i class="i i-dot"></i><span>Reparation</span>
                                        <b class="badge bg-info pull-right" title="Reparation en cours" id="count_repaircours">
                                            {{App\Repair::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count() }}
                                        </b>
                                        <b class="badge bg-warning pull-right" title="Reparation en atteinte" id="count_repairattente">
                                       {{App\Diagnostic::whereBetween('active', ['1','2'])->where('type','1')->count()}}
                                        </b>

                                    </a>
                                </li>
                                @endif
                                    @if(Auth::user()->can('revision'))
                                <li class="{{ Request::path() == 'revision/home' ? 'active' : '' }}">
                                    <a href="{{url('revision/home')}}" class="auto">
                                        <i class="i i-dot"></i><span>Revision</span>
                                        <b class="badge bg-info pull-right" title="Revision en cours" id="count_revisioncours">
                                            {{App\Revision::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count()}}
                                        </b>
                                        <b class="badge bg-warning pull-right" title="Revision en attente" id="count_attenterevision">
                                            {{App\Diagnostic::whereBetween('active', ['1','2'])->where('type','2')->count() }}
                                        </b>
                                    </a>
                                </li>
                                    @endif
                                    @if(Auth::user()->can('visite_technique'))
                                <li class="{{ Request::path() == 'visit/home' ? 'active' : '' }}">
                                    <a href="{{url('visit/home')}}" class="auto">
                                        <i class="i i-dot"></i><span>Visite Technique</span>
                                        <b class="badge bg-info pull-right" title="Visite en cours" id="count_visitoncours">
                                            {{App\Visit_technique::where('state', '1')->orWhere('state', '2')->count() }}
                                        </b>
                                        <b class="badge bg-warning pull-right" title="Visite en attente" id="count_visitattente">
                                            {{App\Diagnostic::whereBetween('active', ['1','2'])->where('type', '3')->count()}}
                                        </b>
                                    </a>
                                </li>
                                    @endif
                            </ul>
                        </li>
                        @endif
                        <!-- **** END **** -->

                        <!-- **** AFTER WORKS LINK **** -->
                        @if(Auth::user()->can('essai apres travaux'))
                        <li class="{{ Request::path() == 'afterworks/home' ? 'active' : '' }}">
                            <a href="{{url('afterworks/home')}}" class="auto">
                                <i class="fa fa-thumbs-up icon"></i><span>Essai apres travaux</span>
                                <b class="badge bg-info pull-right" title="essai visit " id="testVisit">
                                   {{App\Visit_technique::where('state', '3')->count()}}
                                </b>
                                <b class="badge bg-info pull-right" title="essai revision " id="testRevision">
                                    {{App\Revision::where('state', '3')->count()}}
                                </b>
                                <b class="badge bg-warning pull-right" title="essai reparation" id="testRepair">
                                    {{App\Repair::where('state', '3')->count()}}
                                </b>
                            </a>
                        </li>
                    @endif
                        <!-- **** END **** -->

                       <!-- **** APPROVAL LINKS **** -->
                        @if(Auth::user()->can('approbation des pieces'))
                        <li class="{{ Request::path() == 'approval/home/create' ? 'active' : '' }}
                        {{ Request::path() == 'approval/home' ? 'active' : '' }}">
                            <a href="#" class="auto">
                                    <span class="pull-right text-muted">
                                      <i class="i i-circle-sm-o text"></i>
                                      <i class="i i-circle-sm text-active"></i>
                                    </span>
                                <i class="fa fa-gavel icon"></i>
                                <span class="font-bold">Approbation</span>
                            </a>
                            <ul class="nav dk">
                                <li class="{{ Request::path() == 'approval/home/create' ? 'active' : '' }}">
                                    <a href="{{url('approval/home/create')}}" class="auto">
                                        <i class="i i-dot"></i><span>Sortie des pièces</span>
                                        <b class="badge bg-danger pull-right" title="approbation Sortie des pièces" id="approvalpiece">
                                            {{App\Demand::where('state', '0')->count() }}
                                        </b>
                                    </a>
                                </li>
                                <li class="{{ Request::path() == 'approval/home' ? 'active' : '' }}">
                                    <a href="{{url('approval/home')}}" class="auto">
                                        <i class="i i-dot"></i><span>Authorisation sortie</span>
                                        <b class="badge bg-warning pull-right" title="bon de sortie visit" id="aftertestvisit">
                                            {{App\Visit_technique::where('state', '5')->count() }}
                                        </b>
                                        <b class="badge bg-info pull-right" title="bon de sortie revision" id="aftertestrevision">
                                            {{App\Revision::where('state', '5')->count() }}
                                        </b>
                                        <b class="badge bg-success pull-right" title="bon de sortie reparation" id="aftertestrepair">
                                            {{App\Repair::where('state', '5')->count() }}
                                        </b>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <!-- **** END **** -->

                        @if(Auth::user()->can('gestion de stocks'))
                        <li class="{{ Request::path() == 'stock/stock' ? 'active' : '' }} {{ Request::path() == 'stock/home/create' ? 'active' : '' }}
                        {{ Request::path() == 'stock/output' ? 'active' : '' }} {{ Request::path() == 'stock/input' ? 'active' : '' }}
                        {{ Request::path() == 'stock/inventory' ? 'active' : '' }} {{ Request::path() == 'stock/delivery' ? 'active' : '' }}
                        {{ Request::path() == 'stock/back' ? 'active' : '' }} {{ Request::path() == 'stock/listing' ? 'active' : '' }}
                        {{ Request::path() == 'supplier/supplier' ? 'active' : '' }} {{ Request::path() == 'supplier/supplier/create' ? 'active' : '' }}

                        {{ Request::path() == 'stock/excelstock' ? 'active' : '' }}  {{ Request::path() == 'stock/createengine' ? 'active' : '' }} {{ Request::path() == 'stock/tire' ? 'active' : '' }}

">
                            <a href="#" class="auto">
                                <span class="pull-right text-muted">
                                  <i class="i i-circle-sm-o text"></i>
                                  <i class="i i-circle-sm text-active"></i>
                                </span>
                                <i class="i i-stack icon">
                                </i>
                                <span class="font-bold">Gestion de stock</span>
                            </a>

                            <ul class="nav dk">
                                <li class="{{ Request::path() == 'stock/delivery' ? 'active' : '' }}"><a
                                            href="{{url('stock/delivery')}}" class="auto">
                                        <i class="fa fa-shopping-cart"></i><span>Bon de Livraison</span>
                                        <b class="badge bg-success pull-right" title="Total des pièces" id="totaldelivered">
                                            {{App\Delivery::whereMonth('delivered_at', date('m'))->whereYear('delivered_at', date('Y'))->count()}}
                                        </b>
                                    </a>
                                <li class="{{ Request::path() == 'stock/home/create' ? 'active' : '' }}   {{ Request::path() == 'stock/createengine' ? 'active' : '' }}  {{ Request::path() == 'stock/tire' ? 'active' : '' }}">
                                    <a href="#" class="auto">
                                        <span class="pull-right text-muted">
                                          <i class="i i-circle-sm-o text"></i>
                                          <i class="i i-circle-sm text-active"></i>
                                        </span>
                                        <i class="fa fa-plus-circle"></i><span>Nouveau stock</span>
                                    </a>
                                    <ul class="nav dker m-l-smd">
                                        <li class="{{ Request::path() == 'stock/home/create' ? 'active' : '' }}
                                        {{ Request::path() == 'stock/tire' ? 'active' : '' }}

                                        {{ Request::path() == 'stock/createengine' ? 'active' : '' }} ">
                                            <a href="{{url('stock/home/create')}}">
                                                <i class="i i-dot"></i>
                                                <span>Pieces</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('stock/tire')}}" >
                                                <i class="i i-dot"></i>
                                                <span>Pneu</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('stock/createengine')}}">
                                                <i class="i i-dot"></i>
                                                <span>Moteur</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="{{ Request::path() == 'stock/output' ? 'active' : '' }}
                                {{ Request::path() == 'stock/input' ? 'active' : '' }}
                                {{ Request::path() == 'stock/back' ? 'active' : '' }}">
                                    <a href="#" class="auto">
                                        <span class="pull-right text-muted">
                                          <i class="i i-circle-sm-o text"></i>
                                          <i class="i i-circle-sm text-active"></i>
                                        </span>
                                        <i class="fa fa-puzzle-piece"></i>
                                        <span>Entrées / Sorties</span>
                                    </a>
                                    <ul class="nav dker m-l-smd">
                                        <li class="{{ Request::path() == 'stock/output' ? 'active' : '' }}">
                                            <a href="{{url('stock/output')}}">
                                                <i class="i i-dot"></i>
                                                <span>Sortie de pieces</span>
                                                <b class="badge bg-danger pull-right" title="demande de pièce en attente" id="pieceenattente">
                                                    {{App\Demand::where('state', '1')->orWhere('state', '2')->count()}}
                                                </b>
                                            </a>
                                        </li>
                                        <li class="{{ Request::path() == 'stock/input' ? 'active' : '' }}">
                                            <a href="{{url('stock/input')}}">
                                                <i class="i i-dot"></i>
                                                <span>Entrées de stock</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::path() == 'stock/back' ? 'active' : '' }}">
                                            <a href="{{url('stock/back')}}">
                                                <i class="i i-dot"></i>
                                                <span>Retour de pieces</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="{{ Request::path() == 'stock/listing' ? 'active' : '' }}">
                                    <a href="{{url('stock/listing')}}" class="auto">
                                        <i class="fa fa-bars"></i><span>Liste</span>
                                        <b class="badge bg-info pull-right" title="Total des pièces" id="totalPiece">
                                            {{App\Stock::count() }}
                                        </b>
                                    </a>

                                </li>


                                </li>
                                <li class="{{ Request::path() == 'stock/excelstock' ? 'active' : '' }}"><a
                                            href="{{url('stock/excelstock')}}" class="auto">
                                        <i class=""></i><span>Importer stock</span></a>
                                </li>

                                <li class="{{ Request::path() == 'stock/inventory' ? 'active' : '' }}"><a
                                            href="{{url('stock/inventory')}}" class="auto">
                                        <i class="fa fa-refresh"></i><span>Inventaire</span></a>
                                </li>

                                <li class="{{ Request::path() == 'supplier/supplier' ? 'active' : '' }}
                                {{ Request::path() == 'supplier/supplier/create' ? 'active' : '' }}">
                                    <a href="#" class="auto">
                                        <span class="pull-right text-muted">
                                          <i class="i i-circle-sm-o text"></i>
                                          <i class="i i-circle-sm text-active"></i>
                                        </span>
                                        <i class="i i-user3"></i><span>Fournisseur</span>
                                    </a>
                                    <ul class="nav dker m-l-smd">
                                        <li class="{{ Request::path() == 'supplier/supplier' ? 'active' : '' }}">
                                            <a href="{{url('supplier/supplier')}}">
                                                <i class="i i-dot"></i>
                                                <span>Informations</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('supplier/supplier/create')}}">
                                                <i class="i i-dot"></i>
                                                <span>Gestion</span>

                                                <b class="badge bg-success pull-right" title="Total fournisseur" id="totalsupplier">
                                                    {{App\Supplier::where('site_id', $site)->count()}}
                                                </b>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        @endif

                        @if(Auth::user()->can('gestion des cars'))
                        <li class=" {{ Request::path() == 'vehicle/visit_expire' ? 'active' : '' }} {{ Request::path() == 'vehicle/vehicle/create' ? 'active' : '' }}
                        {{ Request::path() == 'vehicle/vehicle' ? 'active' : '' }} {{ Request::path() == 'vehicle/assurance_expire' ? 'active' : '' }}">
                            <a href="#" class="auto">
                                    <span class="pull-right text-muted">
                                      <i class="i i-circle-sm-o text"></i>
                                      <i class="i i-circle-sm text-active"></i>
                                    </span>
                                <i class="fa fa-bus">
                                </i>
                                <span class="font-bold">Gestion des cars</span>
                            </a>
                            <ul class="nav dk">
                                <li class="{{ Request::path() == 'vehicle/vehicle/create' ? 'active' : '' }}"><a
                                            href="{{url('vehicle/vehicle/create')}}" class="auto">
                                        <i class="i i-plus2"></i><span>Nouveau</span></a>
                                </li>
                                <li class="{{ Request::path() == 'vehicle/vehicle' ? 'active' : '' }}"><a
                                            href="{{url('vehicle/vehicle')}}" class="auto">
                                        <i class="i i-list2"></i><span>Liste de Cars</span>
                                        <b class="badge bg-info pull-right" title="Total fournisseur" id="totalsupplier">
                                            {{App\Bus::count()}}
                                        </b>
                                    </a>
                                </li>
                                <li class="{{ Request::path() == 'vehicle/assurance_expire' ? 'active' : '' }}"><a
                                            href="{{url('vehicle/assurance_expire')}}" class="auto">
                                        <i class="i i-asc"></i><span>Assurance</span></a>
                                </li>
                                <li class="{{ Request::path() == 'vehicle/visit' ? 'active' : '' }}"><a
                                            href="{{url('vehicle/visit_expire')}}" class="auto">
                                        <i class="i i-vcard"></i><span>Visite Technique</span></a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->can(['enregistrement des employés','liste des comptes','gestion des acces']))
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">Gestion des Acces</div>
                        <li class="{{ Request::path() == 'user/index' ? 'active' : '' }}
                        {{ Request::path() == 'user/role' ? 'active' : '' }}{{ Request::path() == 'user/permission' ? 'active' : '' }}
                        {{ Request::path() == 'user/index' ? 'active' : '' }} {{ Request::path() == 'user/account' ? 'active' : '' }}
                         {{ Request::path() == 'user/updateuser' ? 'active' : '' }}

                                ">
                            <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                                <i class="fa fa-lock icon">
                                </i>
                                <span class="font-bold">Gestion des comptes</span>
                            </a>
                            <ul class="nav dk">
                                @if(Auth::user()->can('enregistrement des employés'))
                                <li class="{{ Request::path() == 'user/index' ? 'active' : '' }}"><a
                                            href="{{url('user/index')}}" class="auto">
                                        <i class="i i-dot"></i><span>Utilisateurs</span></a>
                                </li>
                                @endif
                                    @if(Auth::user()->can('liste des comptes'))
                                <li class="{{ Request::path() == 'user/account' ? 'active' : '' }}"><a
                                            href="{{url('user/account')}}" class="auto">
                                        <i class="i i-dot"></i><span>Liste des comptes</span></a>
                                </li>
                                    @endif
                                    @if(Auth::user()->can('gestion des acces'))
                                <li class="{{ Request::path() == 'user/role' ? 'active' : '' }}"><a
                                            href="{{url('user/role')}}" class="auto">
                                        <i class="i i-dot"></i><span>Rôles & Permissions</span></a>

                                    @endif
                                    @if(Auth::user()->can('gestion des acces'))
                                <li class="{{ Request::path() == 'user/permission' ? 'active' : '' }}"><a href="{{url('user/permission')}}" class="auto">
                                        <i class="i i-dot"></i><span>Gestion des Acces</span></a>
                                </li>
                                    @endif


                                    @if(Auth::user()->can('gestion des acces'))
                                        <li class="{{ Request::path() == 'user/updateuser' ? 'active' : '' }}"><a href="{{url('user/updateuser')}}" class="auto">
                                                <i class="i i-dot"></i><span>Gestion des acces comptes</span></a>
                                        </li>
                                    @endif

                                {{--<li class="{{ Request::path() == 'user/role' ? 'active' : '' }}"><a--}}
                                            {{--href="{{url('user/role')}}" class="auto">--}}
                                        {{--<i class="i i-dot"></i><span>Gestion des acces</span></a>--}}
                                {{--</li>--}}
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->can(['parametrage des informations de l entréprise','parametrage des sites','parametrage des entrepots','parametrage des cars','parametrage des stocks','parametrage des services et postes']))
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">Parametrage</div>
                        <li class="{{ Request::path() == 'setting/service' ? 'active' : '' }}{{ Request::path() == 'setting/get_entreprise' ? 'active' : '' }}{{ Request::path() == 'setting/site' ? 'active' : '' }} {{ Request::path() == 'setting/vehicle' ? 'active' : '' }} {{ Request::path() == 'setting/stock' ? 'active' : '' }} {{ Request::path() == 'setting/warehouse' ? 'active' : '' }}">
                            <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                                <i class="i i-cog2 icon">
                                </i>
                                <span class="font-bold">Parametres</span>
                            </a>
                            <ul class="nav dk">
                                @if(Auth::user()->can('parametrage des cars'))
                                <li class="{{ Request::path() == 'setting/vehicle' ? 'active' : '' }}"><a
                                            href="{{url('setting/vehicle')}}" class="auto">
                                        <i class="i i-dot"></i><span>Cars</span></a>
                                </li>
                                @endif
                                    @if(Auth::user()->can('parametrage des stocks'))
                                <li class="{{ Request::path() == 'setting/stock' ? 'active' : '' }}"><a
                                            href="{{url('setting/stock')}}" class="auto">
                                        <i class="i i-dot"></i><span>Stock</span></a>
                                </li>
                                    @endif
                                    @if(Auth::user()->can('parametrage des services et postes'))
                                <li class="{{ Request::path() == 'setting/service' ? 'active' : '' }}"><a
                                            href="{{url('setting/service')}}" class="auto">
                                        <i class="i i-dot"></i><span>Service & Poste</span></a>
                                </li>
                                    @endif
                                    @if(Auth::user()->can('parametrage des entrepots'))
                                <li class="{{ Request::path() == 'setting/warehouse' ? 'active' : '' }}"><a
                                            href="{{url('setting/warehouse')}}" class="auto">
                                        <i class="i i-dot"></i><span>Entrepôt</span></a>
                                </li>
                                    @endif
                                    @if(Auth::user()->can('parametrage des sites'))
                                <li class="{{ Request::path() == 'setting/site' ? 'active' : '' }}"><a
                                            href="{{url('setting/site')}}" class="auto">
                                        <i class="i i-dot"></i><span>Site</span></a>
                                </li>
                                    @endif
                                    @if(Auth::user()->can('parametrage des informations de l entréprise'))
                                <li class="{{ Request::path() == 'setting/get_entreprise' ? 'active' : '' }}"><a
                                            href="{{url('setting/get_entreprise')}}" class="auto">
                                        <i class="i i-dot"></i><span>Information de l'entréprise</span></a>
                                </li>
                                    @endif

                            </ul>
                        </li>

                    </ul>
                    @endif

                        <li>


                            <ul class="nav dk">
                                <li class="{{ Request::path() == 'historic/index' ? 'active' : '' }}">
                                    <a href="{{url('historic/index')}}">
                                        <i class="i i-circle-sm text-danger-dk"></i>
                                        <span>Historique</span>
                                    </a>
                                </li>
                            </ul>


                            <a href="#" class="auto">
                                <span class="pull-right text-muted">
                                <i class="i i-circle-sm-o text"></i>
                                <i class="i i-circle-sm text-active"></i>
                                </span>
                                <i class="fa fa-file-text icon">
                                </i>
                                <span class="font-bold">Techniques</span>
                            </a>

                            <ul class="nav dk">
                                <li class="{{ Request::path() == 'reporting/index' ? 'active' : '' }}">
                                    <a href="{{url('reporting/index')}}">
                                        <i class="i i-circle-sm text-warning-dk"></i>
                                        <span>Reporting</span>
                                    </a>
                                </li>
                            </ul>

                        </li>








                    {{--@if(Auth::user()->can(['archives','documents techniques','historique']))--}}
                    {{--<div class="line dk hidden-nav-xs"></div>--}}
                    {{--<div class="text-muted text-xs hidden-nav-xs padder m-t-sm m-b-sm">Documents</div>--}}
                    {{--<ul class="nav">--}}
                        {{--@if(Auth::user()->can('archives'))--}}
                        {{--<li class="{{ Request::path() == 'consult_archives' ? 'active' : '' }}">--}}
                            {{--<a href="{{url('consult_archives')}}">--}}
                                {{--<i class="i i-circle-sm text-info-dk"></i>--}}
                                {{--<span>Archives</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('documents techniques'))--}}
                        {{--<li class="{{ Request::path() == 'getdocument' ? 'active' : '' }}">--}}
                            {{--<a href="{{url('getdocument')}}">--}}
                                {{--<i class="i i-circle-sm text-success-dk"></i>--}}
                                {{--<span>Documents techniques</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('historique'))--}}
                        {{--<li class="{{ Request::path() == 'gethistorical' ? 'active' : '' }}">--}}
                            {{--<a href="{{url('gethistorical')}}">--}}
                                {{--<i class="i i-circle-sm text-danger-dk"></i>--}}
                                {{--<span>Historique</span>--}}
                            {{--</a>--}}
                            {{--@endif--}}
                        {{--</li>--}}
                        <!--<li>
                            <a href="#">
                                <i class="i i-circle-sm text-success-dk"></i>
                                <span>Connection</span>
                            </a>
                        </li>
                        <li>
                            <a href=#">
                                <i class="i i-circle-sm text-danger-dk"></i>
                                <span>Projects</span>
                            </a>
                        </li>-->
                    {{--</ul>--}}
                        {{--@endif--}}




                </nav>

                <!-- / nav -->
            </div>
        </section>

        <footer class="footer hidden-xs no-padder text-center-nav-xs">
            <a href="#" data-toggle="ajaxModal"
               class="btn btn-icon icon-muted btn-inactive pull-right m-l-xs m-r-xs hidden-nav-xs">
                <i class="i i-logout"></i>
            </a>
            <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
                <i class="i i-circleleft text"></i>
                <i class="i i-circleright text-active"></i>
            </a>
        </footer>
    </section>
</aside>