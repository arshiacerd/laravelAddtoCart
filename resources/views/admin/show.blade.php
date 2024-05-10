@extends('./admin/dashboard')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Basic Table</h6>
                    <table class="table">
                        <thead>

                            <tr>
                                <th scope="col">name</th>
                                <th scope="col">price</th>
                                <th scope="col">quantity</th>
                                <th scope="col"> des</th>
                                <th scope="col">image</th>
                                <th scope="col">status</th>
                                <th scope="col">ACTION</th>
                                <th scope="col">stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prod as $n)
                                <tr>
                                    <td>{{ $n->name }}</td>
                                      <td>{{ $n->price }}</td>
                                    <td>{{ $n->des }}</td>
                                    <td>
                                        <img src="{{ asset('prod/' . $n->image) }}" alt="" width="50px"
                                            height="50px" class="rounded-circle">
                                    </td>
                                    <td> <a href="proood/{{ $n->id }}"
                                            class="btn btn-sm btn-{{ $n->status ? 'success' : 'danger' }}">
                                            {{ $n->status ? 'Enable' : 'Disable' }}
                                        </a>
                                    </td>
                                    </td>
                                    <td><a href="" class="btn btn-danger">update</a>
                                        <a href="products/{{ $n->id }}/delete" class="btn btn-danger">delete</a>
                                    </td>
                                    <td>
                                        <a href="products/{{ $n->id }}/cart" class="btn btn-danger">add to cart</a>
                                    </td>
                                    <td>
                                        {{ $n->quantity ==0 ? 'Out of Stock' : 'In Stock' }}
                                    
                                </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        @endsection
