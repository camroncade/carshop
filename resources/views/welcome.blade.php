<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CarShop</title>
  <style>
    h1 {
      text-align: center;
      margin-bottom: 2em;
    }

    .container {
      max-width: 1024px;
      padding: 0 2em;
      margin: 0 auto;
    }

    table {
      width: 100%;
    }

    th,
    td {
      padding: .5em 1em;
    }

    thead th {
      border-bottom: 1px solid #ccc;
    }

    tbody tr:nth-child(odd) {
      background-color: #efe;
    }

    label {
      display: inline-block;
      margin-right: 1em;
    }

    select {
      display: block;
    }

    .filters {
      margin: 2em 0;
    }

    pre {
      padding: 2em 0;
      color: red;
    }
  </style>
</head>

<body>
  {{-- @dump($orderableColumns, $request, $makes, $models, $cars) --}}
  <div class="container">
    <h1>CarShop</h1>
    <div class="filters">
      <form method="GET" action="">
        <label>
          Make
          <select name="make" onchange="this.form.submit()">
            <option value="">Filter by Make</option>
            @foreach ($makes as $make)
            <option value="{{$make}}" <?php if($request->make === $make) echo ' selected' ; ?>>
              {{$make}}
            </option>
            @endforeach
          </select>
        </label>
        <label>
          Model
          <select name="model" onchange="this.form.submit()">
            <option value="">Filter by Model</option>
            @foreach ($models as $model)
            <option value="{{$model}}" <?php if($request->model === $model) echo ' selected' ; ?>>
              {{$model}}
            </option>
            @endforeach
          </select>
        </label>
        <label>
          Sort By
          <select name="sort" onchange="this.form.submit()">
            @foreach ($orderableColumns as $column)
            <option value="{{$column->value}}" <?php if($request->sort === $column->value) echo ' selected' ; ?>>
              {{$column->label}}
            </option>
            @endforeach
          </select>
        </label>
        @if(!$cars->count())
        <a href="{{ url('/') }}">Reset Filters</a>
        @endif
      </form>
      @if($errors->any())
      <pre>
        {{$errors}}
      </pre>
      @endif
    </div>
    <table>
      <thead>
        <tr>
          @foreach ($orderableColumns as $column)
          <th>{{$column->label}}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach ($cars as $car)
        <tr>
          @foreach ($orderableColumns as $column)
          <td>
            @if($column->label === 'Price')
            ${{ number_format($car->{$column->value}) }}
            @else
            {{ $car->{$column->value} }}
            @endif
          </td>
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>

</html>
