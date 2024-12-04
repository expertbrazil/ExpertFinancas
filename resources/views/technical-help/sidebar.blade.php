<div class="card">
    <div class="card-header">
        <h5>Menu de Ajuda</h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <a href="{{ route('technical-help.index') }}" 
               class="list-group-item list-group-item-action {{ request()->routeIs('technical-help.index') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Início
            </a>
            <a href="{{ route('technical-help.diagram') }}" 
               class="list-group-item list-group-item-action {{ request()->routeIs('technical-help.diagram') ? 'active' : '' }}">
                <i class="fas fa-project-diagram me-2"></i> Diagramas de Fluxo
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('technical-help.search') }}" method="GET" class="mb-0">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar ajuda..." value="{{ request('q') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>
