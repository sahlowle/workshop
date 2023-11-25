<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>
    .text-whiet {
      color: white;
    }

    header {
      background-color: #0e69a8;
      height: 7rem
    }

    .form-inline {
      display: flex;
      flex-flow: row wrap;
      align-items: center;
    }

    .form-inline label {
      margin: 5px 10px 5px 0;
    }

    .form-inline input {
      vertical-align: middle;
      /* margin: 5px 10px 5px 0; */
      /* padding: 10px; */
      background-color: #fff;
      /* border: 1px solid #ddd; */
    }

    .form-inline button {
      padding: 10px 20px;
      background-color: dodgerblue;
      border: 1px solid #ddd;
      color: white;
      cursor: pointer;
    }

    input[type="text"] {
      /* width: 60%; */
      border-top: 0;
      border-left: 0;
      border-right: 0;
      background-color: #cae6ff96;
      text-align: right;
    }

    .w-40 {
      width: 40%
    }

    table {
      width: 100%;

    }

    .header-title {
      /* margin: 10px; */
      /* text-align: center; */
    }

    .border-line {
      width: 100%;
      background-color: #0e69a8;
      height: 3px;
      margin: 1.5rem 0;
    }

    .table table {
      border: 1px solid black;
    }

    .table th {
      border: 1px solid black;
    }

    .table td {
      border: 1px solid black;
    }

    .form-control {
      display: block;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #212529;
      background-color: #cae6ff96
    }

    .red {
      color: red;
      font-weight: 100;
    }
    body {
      /* width: 21cm;
    height: 29.7cm;
    margin: 0 auto;
    margin-bottom: 0.5cm; */
    }


</style>
<body>

    {{-- header --}}
    <header class="text-whiet">
        <table>
            <tr>
                <td>
                    <img src="https://smart-intercom.de/assets/img/logo.png" style="max-height: 60px">
                </td>

                <td style="padding-left: 20%">
                    <p>
                        GLOBAL Reparaturservice | Stromstraße 31 |
                        <br>
                         10551 Berlin - Tiergarten Tel.: 030/ 398 873 40 
                         <br>
                         | Mobil: 0171/ 15 87 826 | info@global-reparaturservice.de www.waschmaschine-reparatur-berlin.com
                    </p>
                </td>
            </tr>
        </table>
    </header>
    
    {{-- end header --}}

     {{-- info --}}
    <table>
        <tr style=" width: 50%;">
            <td  style="70%">
                <h1> Rechnung </h1>

                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                    <label class="form-check-label red" for="inlineCheckbox1">Reparatur</label>
             
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label red" for="inlineCheckbox1">Verkauf</label>
                    
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label red" for="inlineCheckbox1">Ankauf</label>
                </div>
            </td>


            <td   style=" text-align: right; float:left">
                <div class="form">
                    <div>
                        <label class="w-40">Datum : </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->visit_time? $order->visit_time : "N\A" }}">
                    </div>
                    <div>
                        <label class="w-40">Auftrags-Nr.: </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->reference_no }}">
                    </div>
                    <div>
                        <label class="w-40">Rechnungs-Nr.: </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->id }}">
                    </div>
                </div>
            </td>
        </tr>
    </table>
    {{-- end info --}}

    {{-- driver & customer --}}
   <table>
    <tr style="width: 100%">

        <td style=" text-align: right; float:left; width:50%">    
                <div class="form" style=" float: letf;">
                    <h4 style="text-align: left">Rg. Empf</h4>
                    <div>
                        <label class="w-40">Firma </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->driver->name }}">
                    </div>

                    <div>
                        <label class="w-40">Name </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->driver->name }}">
                    </div>

                    <div>
                        <label class="w-40">Adresse </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->driver->address?  $order->driver->address: "N\A"}}">
                    </div>

                    <div>
                        <label class="w-40">Plz </label>
                        <input style="text-align: center" type="text" name="" id=""value="{{ $order->driver->city? $order->driver->city: "N\A" }}">
                    </div>

                    <div>
                        <label class="w-40">Telefon </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->driver->phone }}">
                    </div>

                </div>
        </td>

        <td style="text-align: right; float:right">
          
                <div class="form" >
                    <h4 style="text-align: center">Leist. Adresse</h4>
                    <div>
                        <label class="w-40">Firma </label>
                        <input style="text-align: center"  type="text" name="" id="" value="{{ $order->customer->name }}" >
                    </div>

                    <div>
                        <label class="w-40">Name </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->customer->name }}" >
                    </div>

                    <div>
                        <label class="w-40">Adresse </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->address }}">
                    </div>

                    <div>
                        <label class="w-40">Plz </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->customer->city ?  $order->customer->city : "N\A"}}">
                    </div>

                    <div>
                        <label class="w-40">Telefon </label>
                        <input style="text-align: center" type="text" name="" id="" value="{{ $order->customer->phone }}">
                    </div>

                </div>
        </td>
           
    </tr>
   </table>
    {{-- end driver & customer --}}

     
    <div class="border-line"></div>

     {{-- device --}}
     <table>
        <tr>
            <td colspan="2">
                <div>
                    <label class="w-40">Marke : </label>
                    <input type="text" name="" id="" value="..">
                </div>
            </td>

            <td>
                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                    <label class="form-check-label" for="inlineCheckbox1">Waschmaschine</label>
                </div>
            </td>

            <td>
                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Geschirrspüler</label>
                </div>
            </td>
            
            <td>
                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Herd/Ceranfeld</label>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Gastronomie</label>
                </div>
            </td>

            <td>
                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">DAH</label>
                </div>
            </td>
            
            <td>
                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Trockner</label>
                </div>
            </td>

            <td>
                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Kühlschrank</label>
                </div>
            </td>

            <td>
                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Kaffeemaschine</label>
                </div>
            </td>
        </tr>
     </table>
     {{-- end device --}}
     <br>
     {{-- description --}}
     <table class="table" style="background-color: #cae6ff96; border-collapse: collapse">
        <thead>
            <tr>
                <th style="text-align: left">
                    Artikelbeschreibung (An- & Verkauf)
                </th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <p class="form-control" id="exampleFormControlTextarea1" rows="5"> 
                       {{ $order->description }}
                    </p>
                </td>
            </tr>
        </tbody>
     </table>
     {{-- end description --}}

     <br>
     {{-- reports --}}
     <table class="table" style="background-color: #cae6ff96; border-collapse: collapse">
        <thead>
            <tr>
                <th>
                    Warenbezeichnug (Reparaturauftrag)
                </th>

                <th colspan="2">
                    Menge
                </th>
                
                <th >
                    Endpreis
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->reports as $item)
                    <tr>
                        <td> {{ $item->description }} </td>
                        <td colspan="2"> {{ $item->title }} </td>
                        <td> {{ $item->price }} </td>
                        
                    </tr>
            @endforeach

            @if ($order->amount)
            <tr>
                <td> @lang('Order Price') </td>
                <td colspan="2">@lang('Order Price') </td>
                <td> {{ $order->amount }} </td>
            </tr>
            @endif

            

            <tr>
                <td style="background-color: white; color: #1586e9d6">
                    <p>
                        Auf die von uns ausgewechselten Teile gewähren wir 12 Monate Garantie. Diese Rechnung gilt als Garantieschein. 
                        Bei Beschädigung des Garantiesiegels kann eine Garantieleistung nicht erbracht werden
                    </p>
                </td>

                <td style="background-color: white; color: #1586e9d6" colspan="2">
                    <h4>
                        Netto Gesamt
                    </h4>
                </td>

                <td >
                    @if ($order->reports->isNotEmpty())
                        {{ $order->reports->sum('price') }}
                    @else
                        0.00
                    @endif
                </td>
            </tr>

            <tr>
                <td style="background-color: white;">
                    <div class="form-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">Ware in einwandfreiem Zustand erhalten.Vom einwandfreien Funktionieren des Gerätes habe ich mich überzeugt</label>
                    </div>
                </td>

                <td style="background-color: white;">
                    <div class="form-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">Betrag dankend erhalten</label>
                    </div>
                    
                </td>

                <td style="background-color: white; color: #1586e9d6">
                    <span >
                        + 19% MwSt
                    </span>
                </td>

                @php
                    $total = $order->amount + $order->reports->sum('price');
                    $vat = $total  * 0.19;
                @endphp
                

                <td class="border-box">
                    @if ($total)
                        {{ $vat }}
                    @else
                        0.00
                    @endif
                </td>
            </tr>

            <tr>
                <td rowspan="2" style="background-color: white;">
                    Unterschrift des Technikers
                </td>

                <td rowspan="2" style="background-color: white;">
                    Unterschrift des Technikers
                </td>

                <td style="background-color: white; color: #1586e9d6">
                    
                        Gesamtbetrag
                   
                </td>

                <td >
                    <div>

                        @if ($total)
                        <span>  {{ $total  +  $vat }} </span>
                        @else
                            0.00
                        @endif
                      
                        
                        
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2"> 
                    <div class="form-inline">
                      <input class="form-check-input" type="radio" id="inlineCheckbox1" value="option1">
                      <label class="form-check-label" for="inlineCheckbox1">Überweisung</label>

                      <br>

                      <input class="form-check-input" type="radio" id="inlineCheckbox1" value="option1">
                      <label class="form-check-label" for="inlineCheckbox1">Bar</label>



                      <input class="form-check-input" type="radio" id="inlineCheckbox1" value="option1">
                      <label class="form-check-label" for="inlineCheckbox1">EC</label>

                    </div>
                </td>
            </tr>
        </tbody>
     </table>
     {{-- end reports --}}

     <p style="font-size: .8rem">
        Bankverbindung: Postbank | Kto.Nr.: 790 33 31 21 | BLZ: 100 100 10 | IBAN: DE03 1001 0010 0790 3331 21 | St.Nr.: 34 25 000 383 | Inh. M. Sc. R. Cerrahoglu
     </p>

     <div class="page_break" style="text-align:left">
        <img src="{{ asset('pdf.png') }}" style="width: 100%;
        height: 29.7cm; float:left">
     </div>

       

        
    
</body>
</html>