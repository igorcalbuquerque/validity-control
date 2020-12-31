<table class="table table-hover table-borderless text-center zoom-90 {{ $table_historic_class ?? '' }}">
    <thead>
        <th>
            <i class="far fa-calendar-alt"></i>
            Data
        </th>
        @if(!isset($is_historic))
        <th>
            <i class="far fa-clock"></i>
            Dias Restantes
        </th>
        @endif
        <th>
            <i class="fas fa-boxes"></i>
            Quantidade
        </th>
        <th>
            <i class="fas fa-pallet"></i>
            Lote
        </th>
        <th>
            @if(!isset($is_historic))
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalAddDate{{ $product->id }}"
                title="Adicionar uma data">
                <i class="fas fa-plus-circle"></i>
            </button>
            @endif
        </th>
    </thead>
    <tbody>
        @foreach($dates as $expdate)
        <tr>
            <td>
                <button type="button" class="btn" data-toggle="modal" data-target="#modalShowGrafic{{ $expdate->date }}"
                        title="Clique aqui para ver o gráfico.">
                    {{ $expdate->date }}
                </button>
            </td>
            @if(!isset($is_historic))
            <td>{{ $expdate->daysToExpire() }}</td>
            @endif
            <td>{{ $expdate->amount }}</td>
            <td>{{ $expdate->lote }}</td>
            <td>
            @if(!isset($is_historic))
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalEditDate{{ $expdate->id }}">
                        <i class="far fa-edit"></i>
                    </button>
                    <form action="{{ route('product.removeDate', $expdate) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger"onclick="return confirm('Deseja remover?');"
                                title="remover {{ $expdate->date }} ?">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            @endif
            </td>
        </tr>
        @include('components.modalEditDate', ['expdate' => $expdate])
        @endforeach
    </tbody>
</table>