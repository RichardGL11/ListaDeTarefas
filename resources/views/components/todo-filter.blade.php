<div>
    <form method="GET" action="/dashboard" class="mb-4">
        <div>
            <select name="status" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="PENDENTE" {{ request('status') == 'PENDENTE' ? 'selected' : '' }}>Pendente</option>
                <option value="CONCLUIDO" {{ request('status') == 'CONCLUIDO' ? 'selected' : '' }}>Concluido</option>
                <option value="EXCLUIDO" {{ request('status') == 'EXCLUIDO' ? 'selected' : '' }}>Excluido</option>
            </select>
        </div>
    </form></div>
