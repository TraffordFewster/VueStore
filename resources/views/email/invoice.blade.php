<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        
        h1,h4 {
            text-align: center;
        }

        .container{
            margin: 0 5%;
        }

        .invoiceDetails h2, .invoiceDetails h3{
            margin: 0;
        }
        table {
            margin-top: 16px;
            width: 100%;
        }
        th {
            text-align: left;
        }

    </style>
</head>
<body>
    <div>
        <h1>Invoice #{{$invoice->id}}</h1>
        <h4>Addressed to {{$invoice->billToName}}</h4>
    </div>
    <hr>
    <div class="container">
        <div class="invoiceDetails">
            <h2>{{$invoice->billToName}}</h2>
            <h3>{{$invoice->billToAddr1}}</h3>
            <h3>{{$invoice->billToAddr2}}</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price Per</th>
                    <th>Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                @foreach ($invoice->products as $product)
                    <tr>
                        <td>{{$product->product->name}}</td>
                        <td>£{{$product->product->price}}</td>
                        <td>{{$product->amount}}</td>
                        <td>£{{$product->product->price * $product->amount}}</td>
                    </tr>
                    <?php $total +=  $product->product->price * $product->amount ?>
                @endforeach
            </tbody>
        </table>
        <h3>Total due: £{{$total}}</h3>
        <h3>To be paid by {{$invoice->dueDate}}</h3>
    </div>
    <hr>
    
</body>
</html>