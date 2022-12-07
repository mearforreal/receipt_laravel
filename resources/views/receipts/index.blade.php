@extends('layouts.app')

@section('content')

@include('receipts.alert')
<div class="container">
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal" @guest disabled @endguest >
    Загрузить
  </button>
    
    <table class="table" id="data-table">
        <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Пользователь</th>
              <th scope="col">Фото</th>
              <th scope="col">Тип </th>
              <th scope="col">Код  </th>
              <th scope="col">Статус   </th>
            </tr>
          </thead>
          <tbody>

            @forelse ($receipts as $receipt)
            <tr class="data-tr">
                <th scope="row">{{$receipt->id}}</th>
                <td>{{$receipt->user->name}}</td>
                <td>  <img src="{{route('receipt.image', ['fileName' => $receipt->foto])}}" alt="receipt.image" width="100" height="100"/> </td>
                <td>{{$receipt->type->value}}</td>
                {{-- <td>{{$receipt->code}}</td> --}}
                @if($receipt->created_at->diffInDays(\Carbon\Carbon::now()) < 7)
                <td>{{substr($receipt->code,0,strlen($receipt->code)/2). '-'. substr($receipt->code,strlen($receipt->code)/2,strlen($receipt->code))}}</td>
                @else
                <td>Не учавствует на этой неделе</td>
                @endif
                
                <td>{{$receipt->status->value}}</td>
              </tr>
            @empty
                <tr>
                    <td align="center" colspan="6" id="tr-no-data">Нет данных</td>
                </tr>
            @endforelse
            
            
          </tbody>
      </table>
  
      {{ $receipts->links() }}
</div>

@include('receipts.create')
@endsection