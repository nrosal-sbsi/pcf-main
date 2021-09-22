<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Request for Quotation Form</title>
    <style>
        body {
            font-family: 'Arial';
            font-size: 9px;
            text-transform: uppercase;
        }

        .date {
            float: right !important;
        }

        .headerTable {
            margin-left: auto;
            margin-right: auto;
            padding: 5px;
            margin-top: 30px;
        }

        .institutionTable {
            position: relative;
            top: 30px;
        }

        .attnTable {
            position: relative;
            top: 50px;
            width: 100%;
        }

        .itemTable,
        .itemTable td,
        .itemTable th {
            border: 1px solid;
        }

        .itemTable {
            border: 1px solid;
            border-collapse: collapse;
            width: 100%;
            position: relative;
            top: 70px;
        }

        .itemTable th,
        .itemTable td {
            padding: 5px;
            text-align: center;
        }

        .inclusionTable {
            position: relative;
            top: 80px;
        }

        .termsTable {
            width: 100%;
            position: relative;
            top: 100px;
        }

        .thanksTable {
            position: relative;
            top: 110px;
            width: 100%;
        }

        .signatoryTable {
            width: 100%;
            position: relative;
            top: 160px;
        }

    </style>

</head>
<body>
    <div class="date">
        {{ Carbon\Carbon::parse($pcfList[0]->date)->format('F d, Y') }}
    </div>

    <table class="headerTable">
        <tbody>
            <tr>
                <td style="text-align: center; font-weight:bold; ">Q U O T A T I O N</td>
            </tr>
            <tr>
                <td style="text-align: center;">AS THE DISTRIBUTER OF</td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">{{ $pcfList[0]->supplier }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">PRODUCTS IN THE PHILIPPINES</td>
            </tr>
        </tbody>
    </table>
    <table class="institutionTable">
        <tbody>
            <tr>
                <td style="font-weight: bold">
                    {{ $pcfList[0]->institution }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ $pcfList[0]->address }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="attnTable">
        <tbody>         
            <tr>
                <td style="font-weight: bold" width="15%">ATTN:</td>
                <td></td>
            </tr>            
            <tr>
                <td style="font-weight: bold">THRU:</td>
                <td></td>
            </tr>  
        </tbody>
    </table>

    <table class="itemTable">
        <thead style="background-color: #122D60 ; color: white">
            <tr>
                <th>ITEM CODE</th>
                <th>ITEM DESCRIPTION</th>
                <th>QTY (PER YEAR)</th>
                <th>UNIT PRICE</th>
                <th>TOTAL SALES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pcfList as $request)
            <tr>
                <td>{{ $request->item_code }}</td>
                <td>{{ $request->description }}</td>
                <td>{{ $request->quantity }}</td>
                <td>{{ number_format($request->sales,2) }}</td>
                <td>{{ number_format($request->total_sales,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="inclusionTable">
        <tbody>         
            <tr>
                <td style="font-weight: bold">PACKAGE INCLUSIONS:</td>
                <td></td>
            </tr> 
        </tbody>
    </table>

    <table class="termsTable">
        <tbody>         
            <tr>
                <td style="font-weight: bold" width="15%">TERMS:</td>
                <td>{{ $pcfList[0]->terms }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold">VALIDITY:</td>
                <td>{{ $pcfList[0]->validity }}</td>
            </tr> 
            <tr>
                <td style="font-weight: bold">DELIVERY:</td>
                <td>{{ $pcfList[0]->delivery }}</td>
            </tr> 
            <tr>
                <td style="font-weight: bold">WARRANTY:</td>
                <td>{{ $pcfList[0]->warranty }}</td>
            </tr> 
        </tbody>
    </table>
    <table class="thanksTable">
        <tbody>
            <tr>
                <td style="text-align: center; font-weight:bold; font-style: italic ">
                    Thank you for giving us the opportunity to be of service!
                </td>
            </tr>
        </tbody>
    </table>

    <table class="signatoryTable" style="margin: 0 auto; text-align:center">
        <tr>
            <td style="font-weight: bold;">IRYNE I. DE LEON</td>
            <td style="font-weight: bold;">PERSEVERANDA A. IBEA, CPA</td>
        </tr>
        <tr>
            <td>National Sales Manager</td>
            <td>Chief Finance Officer</td>
        </tr>
 </table>
</body>

</html>