@extends('./admin/dashboard')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">product Table</h6>
                    <table class="table">
                        <thead>

                            <tr>
                                <th scope="col">name</th>
                                <th scope="col">quantity</th>
                                <th scope="col"> des</th>
                                <th scope="col">image</th>
                                <th scope="col">price</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $n)
                                <tr>
                                    <td>{{ $n->name }}</td>

                                    <td><input type="number" id="qty"
                                            value="{{ session()->get('quantity_' . $n->id, 1) }}" max="{{ $n->quantity }}"
                                            min="1"
                                            onchange="handleChange(this, {{ $n->price }}, {{ $n->id }})"></td>

                                    <td>{{ $n->des }}</td>
                                    <td>
                                        <img src="{{ asset('prod/' . $n->image) }}" alt="" width="50px"
                                            height="50px" class="rounded-circle">
                                    </td>

                                    </td>
                                    <td id="prodPrice">{{ session()->get('price_' . $n->id, $n->price) }}</td>
                                    <td>
                                        <a href="/products/{{ $n->id }}/delete" class="btn btn-danger">delete</a>
                                    </td>


                                </tr>
                            @endforeach
                            <script>
                                function handleChange(getNode, getPrice, getProdId) {
                                    // var totalPrice = getNode.value * getPrice;
                                    // console.log(getNode.parentElement.parentElement)
                                    // getNode.parentElement.parentElement.children[4].innerHTML = totalPrice
                                    fetch('/update-session', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                productId: getProdId,
                                                quantity: getNode.value,
                                                prodPrice: getPrice
                                            })
                                        }).then(response => {
                                            return response.json();
                                            if (response.ok) {
                                                console.log('Quantity updated in session.');
                                                // Calculate and update total price
                                                // var totalPrice = quantity * getPrice;
                                                //   getNode.parentElement.parentElement.children[4].innerHTML = totalPrice
                                                // input.parentElement.parentElement.children[4].innerHTML = totalPrice;
                                            } else {
                                                console.error('Failed to update quantity in session.');
                                            }
                                        })
                                        .then(data => {
                                                getNode.parentElement.parentElement.children[4].innerHTML = data
                                                hanldeTotalPrice()
                                            }



                                        )
                                        .catch(error => {
                                            console.error('Error updating quantity:', error);
                                        });


                                }
                            </script>
                        </tbody>


                    </table>
                    <h6 style="text-align: right; ">Total Price: <span
                            id="totalPrice">{{ session()->get('totalPrice', 0) }}</span> </h6>
                    <script>
                        function hanldeTotalPrice() {
                            var prodPrices = document.querySelectorAll('#prodPrice');
                            let totalSum = 0;
                            prodPrices.forEach(function(element) {
                                totalSum += parseInt(element.innerHTML);
                            });
                            // console.log(prodPrices)
                            fetch('/update-totalPrice', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        totalPrice: totalSum,

                                    })
                                }).then(response => {
                                    return response.json();
                                    if (response.ok) {
                                        console.log('Quantity updated in session.');
                                        // Calculate and update total price
                                        // var totalPrice = quantity * getPrice;
                                        //   getNode.parentElement.parentElement.children[4].innerHTML = totalPrice
                                        // input.parentElement.parentElement.children[4].innerHTML = totalPrice;
                                    } else {
                                        console.error('Failed to update quantity in session.');
                                    }
                                })
                                .then(data => {
                                        console.log("total" + data);
                                        document.getElementById("totalPrice").innerHTML = data
                                    }

                                )
                                .catch(error => {
                                    console.error('Error updating quantity:', error);
                                });


                        }
                        hanldeTotalPrice()
                    </script>
                    <a href="/products/checkout">Proceed to Checkout</a>
                </div>
            </div>
        @endsection
