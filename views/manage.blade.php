<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>sessions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs4/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 5%;
            padding: 0px 50px;
        }

        svg {
            cursor:pointer;
        }

    </style>
</head>
<body style="background: #f9f9f9">
    <div class="container" style="margin-top:5%">
        <table id="sessions" class="table table-striped border border-2" style="width:100%;">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Type</th>
                    <th>Expiry time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>@php $counter = 0; @endphp
                @foreach($data as $type => $values)
                    @foreach($values as $key => $value)
                    <tr>
                        <td>{{$key}}</td>
                        @switch($type)  
                            @case('HASH')  
                                <td>  
                                    <select class="p-1">  
                                        @foreach($value as $hashKey => $hashVal)  
                                            <option>{{ $hashKey }}: {{ $hashVal }}</option>  
                                        @endforeach  
                                    </select>  
                                </td>  
                                @break  
                            @case('LIST')  
                            @case('ZSET')  
                                <td>  
                                    <select class="p-1">  
                                        @foreach($value as $listVal)  
                                            <option>{{ $listVal }}</option>  
                                        @endforeach  
                                    </select>  
                                </td>  
                                @break  
                            @case('SET')
                                <td>{{ $value[0] }}</td>  
                                @break    
                            @case('STRING')  
                                <td>{{ $value }}</td>  
                                @break  
                        @endswitch
                        
                        <td>{{$type}}</td>
                        <td>    
                            {{($ttl = Illuminate\Support\Facades\Redis::ttl($key)) == -1 ? 'No expiration set' :  "{$ttl} seconds"}}  
                        </td>                          
                        <td>
                        <svg data-bs-toggle="modal" data-bs-target="#deleteModal{{$counter}}" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17px" height="17px" viewBox="0 -0.5 21 21" version="1.1">
                            
                            <title>delete [#1487]</title>
                            <desc>Created with Sketch.</desc>
                            <defs>

                            </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Dribbble-Light-Preview" transform="translate(-179.000000, -360.000000)" fill="#000000">
                                        <g id="icons" transform="translate(56.000000, 160.000000)">
                                            <path d="M130.35,216 L132.45,216 L132.45,208 L130.35,208 L130.35,216 Z M134.55,216 L136.65,216 L136.65,208 L134.55,208 L134.55,216 Z M128.25,218 L138.75,218 L138.75,206 L128.25,206 L128.25,218 Z M130.35,204 L136.65,204 L136.65,202 L130.35,202 L130.35,204 Z M138.75,204 L138.75,200 L128.25,200 L128.25,204 L123,204 L123,206 L126.15,206 L126.15,220 L140.85,220 L140.85,206 L144,206 L144,204 L138.75,204 Z" id="delete-[#1487]">

                            </path>
                                        </g>
                                    </g>
                                </g>
                        </svg>

                        </td>
                    </tr>
                    @php $counter++; @endphp
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @php $counter = 0; @endphp
        @foreach($data as $type => $values)
        @foreach($values as $key => $value)

        <div class="modal fade" id="deleteModal{{$counter}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{route('redis.delete', ['key' => $key])}}" type="button" class="btn btn-danger">Delete</a>
                </div>
                </div>
            </div>
        </div>
        @php $counter++; @endphp
        @endforeach
        @endforeach
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-2.2.2/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#sessions').DataTable();
        });
    </script>
</body>
</html>
