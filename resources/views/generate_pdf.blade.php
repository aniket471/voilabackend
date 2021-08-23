<!DOCTYPE html>
<html>

<head>
    <title>Generate Pdf</title>
    <style>

    </style>
</head>

<body>

    <div>
        <h1 style="margin-left: 5%;">{{ $heading}}
        </h1>
        <p style="text-align: right;margin-top: -3.5%;margin-right: 5%;">{{$date}}</p>
        <hr style="margin-right: 5%; margin-left:5%;border:1px solid">
    </div>

    <div>
        <h2 style="margin-left: 5%;"> Here s your receipt for your ride {{$riderName}}</h2>

        <h5 style="margin-left: 5%;">We hope you enjoyed your ride this morning.</h5>
    </div>

    <div style="margin-top: 2%;">
        <h1 style="margin-left: 5%;">Total</h1>
        <p style="text-align: right;margin-top: -3.5%;margin-right: 5%;">{{$tripRate}}</p>
        <hr size=" 1.5" noshade style="margin-right: 5%; margin-left:5%;size:30%;border:1px solid">
    </div>

    <div style="margin-top: 2%;">
        <h5 style="margin-left: 5%;color:grey">Trip Charges</h5>
        <p style="text-align: right;margin-top: -3.5%;margin-right: 5%;">{{$tripRate}}</p>
        <hr size="1.5" noshade style="margin-right: 5%; margin-left:5%;size:30%;border:1px solid">
    </div>

    <div style="margin-top: 3%;">
        <h3 style="margin-left: 5%;">Subtotal</h3>
        <p style="text-align: right;margin-top: -3.5%;margin-right: 5%;">{{$tripRate}}</p>
        <p style="margin-left: 5%;font-size:11.5px;">Booking Fee</p>
        <p style="text-align: right;margin-top: -2.5%;margin-right: 5%;">{{$tripRate}}</p>
        <hr size="1.5" noshade style="margin-right: 5%; margin-left:5%;size:30%;border:1px solid">
    </div>

    <hr size="1.5" noshade style="margin-right: 5%; margin-left:5%;size:30%;margin-top:4%;border:1px solid">

    <div>

        <h3 style="margin-left: 5%;">Amount Charged</h3>

        <h4 style="margin-left: 5%; color:gray">Paytm </h4>
        <p style="text-align: right;margin-top: -3.5%;margin-right: 5%;">{{$tripRate}}</p>
        <p style="margin-left: 5%;color:gray">A temporary hold of ₹167.66 was placed on your payment method Paytm. This is not a charge and will be removed. It should disappear from your
            bank statement shortly.
        </p>

        <p style="margin-left: 5%;">Visit the trip page for more information, including invoices (where available)
        </p>

        <hr size="1.5" noshade style="margin-right: 5%; margin-left:5%;size:30%;margin-top:4%;border:1px solid">
    </div>

    <div>
    <h5 style="margin-left: 5%;">VoilaGo 12.74 kilometers | 25</h5>
    <p style="margin-left: 10%;">{{$time}} | {{$pickup_address}}</p>
    <p style="margin-left: 10%;">{{$time}} | {{$drop_address}}</p>
    </div>

<div>
<p style="margin-left: 5%;color:gray;font-size:45%">Fares are inclusive of GST. Please download the tax invoice from the trip detail page for a full tax breakdown.</p>
</div>

</body>

</html>