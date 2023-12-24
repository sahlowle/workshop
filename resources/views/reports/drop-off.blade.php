<html>

<head>
    <meta charset="utf-8">
    <title>Global Invoice</title>
    @include('reports.style-pickup')
</head>

@php
    $mainOrder = $order;
@endphp

<body id="photo">
    <header>
        <div class="container">
            <img src="{{ asset('dropOff-logo.png') }}">
            <div class="centered1">
                <p>GLOBAL Reparaturservice | Stromstraße 31 | 10551 Berlin - Tiergarten</p>
                <p>Tel.: 030/ 398 873 40 | Mobil: 0171/ 15 87 826 | info@global-reparaturservice.de<br>www.waschmaschine-reparatur-berlin.com</p>
            </div>
        </div>
    </header>

    <article>

        <div style="display: flex;isplay: flex;justify-content: space-between;">
            <div style=" width: 35%;height: 0; ">
                <img src="{{ asset("shape.png") }}" style="width: 164%;">
                <div class="rechnung">
                    <span>Rechnung</span>
                </div>

            </div>
            <div style=" display: grid; padding-left: 46%; ">
            <table class="meta meta-right" style="width: 100%;margin: 0">
                <tr>
                    <th style=" width: 8%; ">
                        <h4 class="f16">Datum:</h4>
                    </th>
                    <td style=" width: 31%; ">
                        <span class="wordbr" contenteditable> {{ $order->visit_time }} </span>
                    </td>
                </tr>
            </table>
            <table class="meta meta-right" style="width: 100%;margin: 0">

                <tr>
                    <th>
                        <h4 class="f16">Auftrags-Nr.:</h4>
                    </th>
                    <td style=" width: 16%; ">
                        <span class="wordbr" contenteditable>  {{ $order->reference_no }} </span>
                    </td>
                </tr>
            </table>
                </div>
        </div>


        <div style=" margin-left: 48px; ">
            <div class="check3">
                <div class="check-group5">
                    <input type="checkbox" id="5" onclick="selectOnlyThis(this.id)" checked>
                    <label for="5">Reparatur</label>
                </div>
                <div class="check-group5">
                    <input type="checkbox" id="6" onclick="selectOnlyThis(this.id)">
                    <label for="6">Verkauf</label>
                </div>
                <div class="check-group5">
                    <input type="checkbox" id="7" onclick="selectOnlyThis(this.id)">
                    <label for="7">Ankauf</label>
                </div>
                <table class="meta meta-right" style="width: 38%;margin: 0">
                    <tr>
                        <th>
                            <h4 class="f16">Rechnungs-Nr.: </h4>
                        </th>
                        <td style="width: 10%;">
                            <span class="wordbr" contenteditable> {{ $order->pickup_order_ref }}  </span>
                        </td>
                    </tr>
                </table>
            </div>



            <div style=" display: flex; ">

                <h1 style="margin-right: 46.7%;font-size: 12px;">Rg. Empf.</h1>

                <h1 style="font-size: 12px;">Leist. Adresse</h1>
            </div>
            <table class="meta meta-left">
                <tr>
                    <th>
                        <span>Firma</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable> {{ $order->customer->company_name }}  </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Name</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable> {{ $order->customer->name }}  </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Adresse</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable> {{ $order->address }} </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Plz. </span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable> {{ $order->postal_code }}  </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Gebäudeteil</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable>  {{ $order->customer->part_of_building }} </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Telefon</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable> {{ $order->customer->telephone }}  </span>
                    </td>
                </tr>
            </table>


            <table class="meta meta-left" style=" margin: 0; width: 47%; float: right;">
                <tr>
                    <th>
                        <span>Firma</span>
                    </th>
                    <td>

                        <span class="wordbr" contenteditable>
                            {{ $order->pickupAddress ? $order->pickupAddress->company_name : "N\A"}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Name</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable> 
                            {{ $order->pickupAddress ? $order->pickupAddress->name : "N\A"}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Adresse</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable>
                            &nbsp;&nbsp;&nbsp;
                            {{ $order->pickupAddress ? $order->pickupAddress->address : "N\A"}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Plz.</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable>
                            {{ $order->pickupAddress ? $order->pickupAddress->postal_code : "N\A"}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Gebäudeteil</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $order->pickupAddress ? $order->pickupAddress->part_of_building : "N\A"}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span>Telefon</span>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable>
                            &nbsp;&nbsp;
                            {{ $order->pickupAddress ? $order->pickupAddress->telephone : "N\A"}}
                        </span>
                    </td>
                </tr>
            </table>

            <div class="row">
                <div class="column">
                </div>
            </div>


            <hr class="solid2">


            <div class="check" style=" justify-content: space-between;">

                <table class="meta meta-left" style=" width: 26%;padding-bottom: 11px;">
                    <tr>
                        <th style="width: 23%;padding: 0;">
                            <span style=" font-weight: 700; font-size: 16px; ">Marke </span>
                        </th>
                        <td style=" padding: 0; ">
                            <span class="wordbr" contenteditable> 
                                &nbsp;  &nbsp;  &nbsp;
                                {{ $order->brand }}
                            </span>
                        </td>
                    </tr>
                </table>

                @php
                if ($order->type==3) {
                 $order = \App\Models\Order::where('reference_no',$order->pickup_order_ref)->first();
                }
            @endphp

            @foreach ($devices->take(3) as $item)
            <div class="check-group6">
                <input type="checkbox" id="{{ $item->name }}" @checked($order->devices->contains('id',$item->id)) >
                <label for="Waschmaschine">{{ $item->name }}</label>
            </div>
            @endforeach
            </div>


            <div class="check" style=" display: flex; justify-content: space-between; ">

                @foreach ($devices->skip(3) as $item)
            <div class="check-group6">
                <input type="checkbox" id="{{ $item->name }}" @checked($order->devices->contains('id',$item->id)) >
                <label for="Waschmaschine">{{ $item->name }}</label>
            </div>
            @endforeach

            </div>



            <div style="font-family: 'Linotype Ergo W01 Compressed'">

                <table class="info">
                    <thead>
                        <tr>
                            <th>Artikelbeschreibung (An- & Verkauf)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 0;height: 35px;border-width: 1px 0 0 0;">
                                <span class="wordbr warnt" contenteditable>24 Monate Garantie auf die ausgetauschten Teile außer Eigenverschulden & Verschleiß</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top: 0; height: 64px">
                                <span class="wordbr" contenteditable></span>
                            </td>
                        </tr>
                    </tbody>
                </table>



                <div style=" padding-top: 10px; ">
                    <table class="inventory" style=" border-spacing: 0px; ">
                        <thead>
                            <tr>
                                <th>
                                    <span>Warenbezeichnug (Reparaturauftrag)</span>
                                </th>
                                <th style="width: 3%;text-align: center;">
                                    <span>Menge</span>
                                </th>
                                <th style="width: 7%;text-align: center;">
                                    <span>Preis</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    <span class="wordbr" >
                                        {{ $item->title }}
                                    </span>
                                </td>
                                <td>
                                    <span class="wordbr" >
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td>
                                    <span class="wordbr" >
                                        {{ number_format($item->price,2) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>


                    <div class="row">
                        <div class="column" style="width: 87.24%;padding: 0">
                            <div class="box" style="width: 100%;border-right: 0px;">
                                <div class="row">
                                    <div class="column" style="width: 82%;font-size: 10px;color: #1778bd;">
                                        <p> Auf die von uns ausgewechselten Teile gewähren wir 12 Monate Garantie. Diese Rechnung gilt als Garantieschein.<br>
                                            Bei Beschädigung des Garantiesiegels kann eine Garantieleistung nicht erbracht werden.</p>
                                    </div>
                                    <div class="column" style="width: 11%;">
                                        <div>
                                            <p style="font-size: 0.89rem;font-weight: 700;color: #0264b7;">Netto Gesamt</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column" style="width: 10%;padding: 0">
                            <div class="box" style="width:100%;padding: 12px 9.4px 6px 10px;text-align: center;">
                                <p style="font-size: 0.7rem;font-family: 'Open Sans', sans-serif;font-weight: 100;color: #000000;">
                                    {{ number_format($order->subtotal,2) }} €
                                </p>
                            </div>

                        </div>
                    </div>
                    <a class="add">+</a>
                </div>

                <div class="check2" style="justify-content: space-between;">
                    <div class="row" style=" width: 100%; ">
                        <div class="column2" style="width: 17%;margin-top: 16px;">
                            <div class="check-group4" style=" padding: 0; width: 100%;margin-bottom: 0; ">
                                <input type="checkbox" id="Betrag" @checked($order->is_amount_received)>
                                <label for="Betrag">Betrag dankend erhalten</label>
                            </div>
                        </div>
                        <div class="column2" style="width: 60%;margin-top: 16px;">
                            <div class="check-group4" style=" padding: 0; width:100%;margin-bottom: 0; ">
                                <input type="checkbox" id="Ware" @checked($order->is_customer_confirm) >
                                <label for="Ware">Ware in einwandfreiem Zustand erhalten.Vom einwandfreien Funktionieren des Gerätes habe ich mich überzeugt </label>
                            </div>
                        </div>
                        <div class="column2" style="width: 10.25%;margin-top: 16px;">
                            <p style="font-size: 0.89rem;font-weight: 700;color: #0264b7;">+ 19% MwSt.</p>
                        </div>
                        <div class="column2" style="width:9.9%;">
                            <div class="box" style="width:100%;padding: 12px 10px 6px 10px;text-align: center; ">
                                <p style="font-size: 0.7rem;font-family: 'Open Sans', sans-serif;font-weight: 100;color: #000000;" contenteditable>
                                    {{ number_format($order->vat,2) }} €
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="column2" style=" width: 74%; ">

                        <div class="row">
                            <div class="column2">
                                <div class="box1" style=" border-right: 0;">
                                    <span class="wordbr" contenteditable>Unterschrift desTechnikers</span>
                                </div>
                            </div>
                            <div class="column2">
                                <div class="box1">
                                    <span class="wordbr" contenteditable>Unterschrift des Kunden: Ich bestätige die Richtigkeit der Angaben und erkenne die Rückseitig abgedruckten Allgemeinen Geschäftsbedingungen für Unterhaltungselektronik und Haushaltsgeräte Handwerk - Einzelhandel an.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column2" style=" width: 26%; ">

                        <div class="row">
                            <div class="column2" style=" width: 51%; ">
                                <p style="font-size: 0.89rem;font-weight: 700;color: #0264b7;margin-left: 28%;margin-top: 12px;">Gesamtbetrag</p>
                            </div>
                            <div class="column2" style=" width: 38.2% ">
                                <div class="box" style="width:100%;padding: 12px 10px 6px 10px;text-align: center;border-bottom: 4px solid #1074bc;">
                                    <p style="font-size: 0.7rem;font-family: 'Open Sans', sans-serif;font-weight: 100;color: #000000;" contenteditable>
                                        {{ number_format($order->total,2) }} €
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="check2" style=" margin-top: 6%; ">
                            <div class="check-group3" style="padding-right: 6px;;">
                                <input type="checkbox" id="Bar" @checked($mainOrder->payment_way ==1)  >
                                <label for="Bar">Bar</label>
                            </div>
                            <div class="check-group3" style="padding-right: 9px;"@checked($mainOrder->payment_way ==2)  >
                                <input type="checkbox" id="EC">
                                <label for="EC">EC</label>
                            </div>
                            <div class="check-group3" style="padding-right: 0px;" @checked($mainOrder->payment_way ==3)  >
                                <input type="checkbox" id="Überweisung">
                                <label for="Überweisung">Überweisung</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </article>
    <aside style="font-family: 'Linotype Ergo W01 Compressed'">
        <div class="footer">
            <p>Bankverbindung: Postbank | Kto.Nr.: 790 33 31 21 | BLZ: 100 100 10 | IBAN: DE03 1001 0010 0790 3331 21 | St.Nr.: 34 25 000 383 | Inh. M. Sc. R. Cerrahoglu</p>
        </div>
        <div class="ft">
            <img style="width: 100%;padding: 15px;text-align: center;" src="{{  asset('pdf.png') }}">
        </div>
    </aside>

    
</body>

<script src= 
"https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js"> 
    </script> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>


    <script>
        window.print();

        // function takeshot() { 

        //     html2canvas(document.body,{
              
        //     height: window.outerHeight + window.innerHeight,
        //     windowHeight: window.outerHeight + window.innerHeight
        //     }).then(function(canvas) {
        //       document.body.appendChild(canvas);
        //       alert('d');

        // //       var img = canvas.toDataURL();
        // // window.open(img);
        // canvas.toBlob(function(blob) {
        //   window.saveAs(blob, 'pdd.jpg');
        // });
        //  });
            
        // } 

    //     function saveAsPDF() {
    //         alert('s');

    //         var htmlRef =document.body;
    //     html2canvas(document.body, {        
    //         scrollX: -window.scrollX,
    //     scrollY: -window.scrollY,
    //     windowWidth: document.documentElement.offsetWidth,
    //     windowHeight: htmlRef.scrollHeight,
    //   }).then((canvas) => {
    //     const img = new Image();

    //     const image = canvas
    //       .toDataURL("image/png");

    //       var width = 1075;
    //      // Add 25px to account for the top margin
    //      var height = 1553;

    //      var doc = new jsPDF({
    //            unit: 'px',
    //            format: 'a4'
    //         }); // using defaults: orientation=portrait, unit=mm, size=A4
    //       var widthScale = width * .375;
    //         var heightScale = height * .375;
    //         doc.addImage(image, 'PNG', 20, 25, widthScale, heightScale);
    //       doc.save('myPage.pdf'); //Download the rendered PDF.
    //   });
    // }

        // setTimeout(() => {
        //     saveAsPDF();
        // }, 5000);
    </script>

</html>
