<aside class="bg-dark lt b-r b-light aside-md hidden-print" id="nav">
    <section class="vbox">
        <section class="w-f scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                <div class="clearfix wrapper dk nav-user hidden-xs">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="thumb avatar pull-left m-r">
                        <img src="{{asset('assets/images/a0.png')}}" class="dker" alt="...">
                        <i class="on md b-black"></i>
                      </span>
                            <span class="hidden-nav-xs clear">
                        <span class="block m-t-xs">
                          <strong class="font-bold text-lt text-capitalize" style="text-transform: capitalize">{{ Auth::user()->username }}</strong>
                          <b class="caret"></b>
                        </span>
                        <span class="text-muted text-xs block" style="text-transform: capitalize">{{Auth::user()->roles->first()->display_name}}</span>
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
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="ajaxModal" >Deconnexion</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
                        <li class="{{ Request::path() == '/' ? 'active' : '' }}">
                            <a href="{{url('/')}}" class="auto">
                                <i class="i i-statistics icon">
                                </i>
                                <span class="font-bold">Tableau de bord</span>
                            </a>
                        </li>
                        @if(Auth::user()->hasRole(['technical_Manager', 'responsable_garages','administrator','chef_stock']))
                        <li class="{{ Request::path() == 'performance/performance' ? 'active' : '' }} {{ Request::path() == 'performance/diagnostic' ? 'active' : '' }}
                        {{ Request::path() == 'performance/repair' ? 'active' : '' }} {{ Request::path() == 'performance/visit' ? 'active' : '' }}
                        {{ Request::path() == 'performance/revision' ? 'active' : '' }} {{ Request::path() == 'performance/test' ? 'active' : '' }}
                        {{ Request::path() == 'performance/test' ? 'active' : '' }}">
                            <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                                <i class="i i-pin icon">
                                </i>
                                <span class="font-bold">Prestation</span>
                            </a>
                            <ul class="nav dk">
                                <li class="{{ Request::path() == 'performance/performance' ? 'active' : '' }}"><a href="{{route('performance.index')}}" class="auto">
                                        <i class="i i-dot"></i><span>Etat Vehicule</span></a>
                                </li>
                                <li class="{{ Request::path() == 'performance/diagnostic' ? 'active' : '' }}"><a href="{{url('/performance/diagnostic')}}" class="auto">
                                        <i class="i i-dot"></i><span>Diagnostique</span></a>
                                </li>
                                <li class="{{ Request::path() == 'performance/repair' ? 'active' : '' }}"><a href="{{url('/performance/repair')}}" class="auto">
                                        <i class="i i-dot"></i><span>Reparation</span></a>
                                </li>
                                <li class="{{ Request::path() == 'performance/visit' ? 'active' : '' }}"><a href="{{url('/performance/visit')}}" class="auto">
                                        <i class="i i-dot"></i><span>Visite Technique</span></a>
                                </li>
                                <li class="{{ Request::path() == 'performance/revision' ? 'active' : '' }}"><a href="{{url('/performance/revision')}}" class="auto">
                                        <i class="i i-dot"></i><span>Revision</span></a>
                                </li>
                                <li class="{{ Request::path() == 'performance/test' ? 'active' : '' }}"><a href="{{url('/performance/test')}}" class="auto">
                                        <i class="i i-dot"></i><span>Essai apres travaux</span></a>
                                </li>
                            </ul>
                        </li>



                        <li class="{{ Request::path() == 'approval/approval' ? 'active' : '' }} {{ Request::path() == 'approval/output' ? 'active' : '' }}">
                            <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                                <i class="i i-lab icon">
                                </i>
                                <span class="font-bold">Approbation</span>
                            </a>
                            <ul class="nav dk">
                                <li class="{{ Request::path() == 'approval/approval' ? 'active' : '' }}"><a href="{{route('approval.index')}}" class="auto">
                                        <i class="i i-dot"></i><span>Pièces en attente</span></a>
                                </li>
                                <li class="{{ Request::path() == 'approval/output' ? 'active' : '' }}"><a href="{{url('approval/output')}}" class="auto">
                                        <i class="i i-dot"></i><span>Bon de sortie</span></a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->hasRole(['magasinier', 'administrator','chef_stock','responsable_achat']))

                        <li class="{{ Request::path() == 'stock/stock' ? 'active' : '' }} {{ Request::path() == 'stock/stock/create' ? 'active' : '' }} {{ Request::path() == 'stock/action' ? 'active' : '' }}
                        {{ Request::path() == 'stock/inventory' ? 'active' : '' }}">
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
                                <li class="{{ Request::path() == 'stock/stock' ? 'active' : '' }}"><a href="{{route('stock.index')}}" class="auto">
                                        <i class="i i-dot"></i><span>Nouveau</span></a>
                                </li>
                                <li class="{{ Request::path() == 'stock/action' ? 'active' : '' }}"><a href="{{url('stock/action')}}" class="auto">
                                        <i class="i i-dot"></i><span>Entrées / Sorties</span></a>
                                </li>
                                <li class="{{ Request::path() == 'stock/stock/create' ? 'active' : '' }}"><a href="{{route('stock.create')}}" class="auto">
                                        <i class="i i-dot"></i><span>Liste</span></a>
                                </li>
								 <li class="{{ Request::path() == 'stock/inventory' ? 'active' : '' }}"><a href="{{url('stock/inventory')}}" class="auto">
                                        <i class="i i-dot"></i><span>Inventaire</span></a>
                                </li>
                            </ul>
                        </li>


                        <li class="{{ Request::path() == 'supplier/supplier' ? 'active' : '' }} {{ Request::path() == 'supplier/supplier/create' ? 'active' : '' }}">
                            <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                                <b class="badge bg-info text-black pull-right" id="count_supplier">{{App\Supplier::count()}}</b>
                                <i class="i i-user2 icon">
                                </i>
                                <span class="font-bold">Gestion fournisseur</span>
                            </a>
                            <ul class="nav dk">
                                <li class="{{ Request::path() == 'supplier/supplier' ? 'active' : '' }}"><a href="{{url('supplier/supplier')}}" class="auto">
                                        <i class="i i-dot"></i><span>Informations</span></a>
                                </li>
                                <li class="{{ Request::path() == 'supplier/supplier/create' ? 'active' : '' }}"><a href="{{url('supplier/supplier/create')}}" class="auto">
                                        <i class="i i-dot"></i><span>Gestion</span></a>
                                </li>
                            </ul>
                        </li>

                        @endif
                        @if(Auth::user()->hasRole([ 'administrator','computing']))
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">Gestion des Acces</div>
                        <li class="{{ Request::path() == 'users/user' ? 'active' : '' }} {{ Request::path() == 'users/account' ? 'active' : '' }}">
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
                                <li class="{{ Request::path() == 'users/user' ? 'active' : '' }}"><a href="{{route('user.index')}}" class="auto">
                                        <i class="i i-dot"></i><span>Employés</span></a>
                                </li>
                                <li class="{{ Request::path() == 'users/account' ? 'active' : '' }}"><a href="{{url('users/account')}}" class="auto">
                                        <i class="i i-dot"></i><span>Liste des comptes</span></a>
                                </li>
                            </ul>
                        </li>
                       @endif

                        <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">Parametrage</div>
                        <li class="{{ Request::path() == 'setting/setting' ? 'active' : '' }} {{ Request::path() == 'setting/stock' ? 'active' : '' }} {{ Request::path() == 'setting/warehouse' ? 'active' : '' }}">
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

                                <li class="{{ Request::path() == 'setting/setting' ? 'active' : '' }}"><a href="{{route('setting.index')}}" class="auto">
                                        <i class="i i-dot"></i><span>Vehicule</span></a>
                                </li>
                                <li class="{{ Request::path() == 'setting/stock' ? 'active' : '' }}"><a href="{{url('setting/stock')}}" class="auto">
                                        <i class="i i-dot"></i><span>Stock</span></a>
                                </li>

                                <li class="{{ Request::path() == 'setting/warehouse' ? 'active' : '' }}"><a href="{{url('setting/warehouse')}}" class="auto">
                                        <i class="i i-dot"></i><span>Entrepôt</span></a>
                                </li>

                            </ul>
                        </li>

                    </ul>

                    <div class="line dk hidden-nav-xs"></div>
                    <div class="text-muted text-xs hidden-nav-xs padder m-t-sm m-b-sm">Documents</div>
                    <ul class="nav">
                        <li class="{{ Request::path() == 'consult_archives' ? 'active' : '' }}">
                            <a href="{{url('consult_archives')}}" >
                                <i class="i i-circle-sm text-info-dk"></i>
                                <span>Archives</span>
                            </a>
                        </li>
                        <li class="{{ Request::path() == 'getdocument' ? 'active' : '' }}">
                            <a href="{{url('getdocument')}}">
                                <i class="i i-circle-sm text-success-dk"></i>
                                <span>Documents techniques</span>
                            </a>
                        </li>
                        <li class="{{ Request::path() == 'gethistorical' ? 'active' : '' }}">
                            <a href="{{url('gethistorical')}}">
                                <i class="i i-circle-sm text-danger-dk"></i>
                                <span>Historique</span>
                            </a>
                        </li>
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
                    </ul>

                    <!--<div class="text-muted text-xs hidden-nav-xs padder m-t-sm m-b-sm">Circles</div>
                    <ul class="nav">
                        <li>
                            <a href="#">
                                <i class="i i-circle-sm-o text-success-lt"></i>
                                <span>College</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="i i-circle-sm-o text-warning"></i>
                                <span>Social</span>
                            </a>
                        </li>
                    </ul> -->



                </nav>

                <!-- / nav -->
            </div>
        </section>

        <footer class="footer hidden-xs no-padder text-center-nav-xs">
            <a href="#" data-toggle="ajaxModal" class="btn btn-icon icon-muted btn-inactive pull-right m-l-xs m-r-xs hidden-nav-xs">
                <i class="i i-logout"></i>
            </a>
            <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
                <i class="i i-circleleft text"></i>
                <i class="i i-circleright text-active"></i>
            </a>
        </footer>
    </section>
</aside>