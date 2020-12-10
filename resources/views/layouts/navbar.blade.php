<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <a class="navbar-brand" href="{{ '' }}">
        <i class="fab fa-ethereum"></i>
        <small>VC</small>
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item nav-lg {{ !isset($active) ? 'active' : '' }}">
                <a class="nav-link btn-sm btn-primary" href="{{ '' }}">
                    <i class="fas fa-home"></i>
                    Home
                </a>
            </li>
        </ul>
    </div>

    <div class="btn-group dropleft">
        <button class="btn btn-outline-light btn-sm" type="button" id="dropPerfil" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropPerfil">
            <div class="dropdown-item dropright">
                <a class="btn" href="{{ '#' }}" title="Configuração padrão do sistema.">
                    Configurações
                </a>
            </div>
            <div class="dropdown-divider"></div>
            <div class="dropdown-item dropright d-flex justify-content-center">
                <form class="form-inline my-2 my-lg-0" action="{{ route('users.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn" title="Sair">Sair</button>
                </form>
            </div>
        </div>
    </div>

</nav>