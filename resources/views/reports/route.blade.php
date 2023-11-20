<!DOCTYPE html><html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    @include('reports.style')
     </head>
     <body >




    <header>
        <div class="row d-flex align-items-center">
            <div class="col-md-5">
                <span class="app-brand-logo demo">
                  <img src="{{ public_path().'/assets/img/logo.png' }}" style="max-height: 80px">
      
                  </span>
            </div>
            <div class="col-md-7">
                <span style="align-content: center">
                    GLOBAL Reparaturservice | Stromstraße 31 | 10551 Berlin - Tiergarten
                    Tel.: 030/ 398 873 40 | Mobil: 0171/ 15 87 826 | info@global-reparaturservice.de
                    www.waschmaschine-reparatur-berlin.com
                </span>
            </div>
        </div>
    </header>
    <div class="container ">
        <div class="row">
            <div class="col-md-7">
                <div class="title">
                    <h3>Rechnung</h3>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Reparatur</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                    <label class="form-check-label" for="inlineCheckbox2">Verkauf</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                    <label class="form-check-label" for="inlineCheckbox3">Ankauf</label>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form">
                    <div>
                        <label class="w-40">Datum : </label>
                        <input type="text" name="" id="" value="{{ $order->visit_time }}">
                    </div>
                    <div>
                        <label class="w-40">Auftrags-Nr.: </label>
                        <input type="text" name="" id="" value="{{ $order->reference_no }}">
                    </div>
                    <div>
                        <label class="w-40">Rechnungs-Nr.: </label>
                        <input type="text" name="" id="" value="{{ $order->id }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <span class="header-title">Rg. Empf</span>
                <div class="form">
                    <div>
                        <label>Firma</label>
                        <input type="text" name="" id="" value="{{ $order->driver->name }}">
                    </div>
                    <div>
                        <label>Name</label>
                        
                            <input type="text" name="" id="" value="{{ $order->driver->name }}">
                        
                    </div>
                    <div>
                        <label>Adresse</label>
                        
                            <input type="text" name="" id="" value="{{ $order->driver->address }}">
                        
                    </div>
                    <div>
                        <div class="w-50">
                            <label class="w-35">Plz</label>
                            
                                <input type="text" name="" id="">
                            

                        </div>
                        <div class="w-50">
                            <label class="w-35">Gebäudeteil</label>
                            
                                <input type="text" name="" id="">
                            
                        </div>
                    </div>
                    <div>
                        <label>Telefon</label>
                        
                            <input type="text" name="" id="" value="{{ $order->driver->phone }}">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <span class="header-title">Leist. Adresse</span>
                <div class="form">
                    <div>
                        <label>Firma</label>
                        <input type="text" name="" id="" value="{{ $order->customer->name }}">
                    </div>
                    <div>
                        <label>Name</label>
                        
                            <input type="text" name="" id="" value="{{ $order->customer->name }}">
                        
                    </div>
                    <div>
                        <label>Adresse</label>
                        
                            <input type="text" name="" id="" value="{{ $order->customer->address }}">
                        
                    </div>
                    <div>
                        <div class="w-50">
                            <label class="w-35">Plz</label>
                            
                                <input type="text" name="" id="">
                            

                        </div>
                        <div class="w-50">
                            <label class="w-35">Gebäudeteil</label>
                            
                                <input type="text" name="" id="">
                            
                        </div>
                    </div>
                    <div>
                        <label>Telefon</label>
                        
                            <input type="text" name="" id="" value="{{ $order->customer->phone }}">
                        
                    </div>
                </div>
            </div>
            <div class="border-line"></div>

            <div class="col-md-6 d-flex">
                <div class="form w-62 pr-3">
                    <div>
                        <label>Marke </label>
                        <input type="text" name="" id="">
                    </div>
                </div>
                <div class="form-check form-check-inline w-35">
                    <input class="form-check-input" type="checkbox" id="inlineWaschmaschine" value="option1" checked="">
                    <label class="form-check-label color-000000" for="inlineWaschmaschine">Waschmaschine </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-check-inline w-45">
                    <input class="form-check-input" type="checkbox" id="inlineGeschirrspüler" value="option1">
                    <label class="form-check-label color-000000" for="inlineGeschirrspüler">Geschirrspüler</label>
                </div>
                <div class="form-check form-check-inline w-45">
                    <input class="form-check-input" type="checkbox" id="inlineHerd" value="option2">
                    <label class="form-check-label color-000000" for="inlineHerd">Herd/Ceranfeld</label>
                </div>
            </div>

            <div class="col-md-6  my-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineGastronomie" value="option1">
                    <label class="form-check-label color-000000" for="inlineGastronomie">Gastronomie</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineDAH" value="option2">
                    <label class="form-check-label color-000000" for="inlineDAH">DAH</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineTrockner" value="option2">
                    <label class="form-check-label color-000000" for="inlineTrockner">Trockner</label>
                </div>
            </div>

            <div class="col-md-6  my-4">
                <div class="form-check form-check-inline w-45">
                    <input class="form-check-input" type="checkbox" id="inlineKühlschrank" value="option1">
                    <label class="form-check-label color-000000" for="inlineKühlschrank">Kühlschrank</label>
                </div>
                <div class="form-check form-check-inline w-45">
                    <input class="form-check-input" type="checkbox" id="inlineKaffeemaschine" value="option2">
                    <label class="form-check-label color-000000" for="inlineKaffeemaschine">Kaffeemaschine</label>
                </div>
            </div>
        </div>
        <div class="section-02">
            <h5>Artikelbeschreibung (An- &amp; Verkauf)</h5>
            <div class="mb-3">
                {{-- <label for="exampleFormControlTextarea1" class="form-label"></label> --}}
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"> 
                    {{ $order->description }}
                </textarea>
            </div>
        </div>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Warenbezeichnug (Reparaturauftrag)</th>
                        <th> Menge </th>
                        <th> Endpreis </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->reports as $item)
                    <tr>
                        <td> {{ $item->title }} </td>
                        <td> {{ $item->description }} </td>
                        <td> {{ $item->price }} </td>
                        
                    </tr>
                    @endforeach
                
                   
                </tbody>
                <tfoot>
                    <tr>
                        <td class="background-ffffff color-0e69a8 " colspan="2">
                            <div class="d-flex justify-content-between">
                                <span>
                                    Auf die von uns ausgewechselten Teile gewähren wir 12 Monate Garantie.
                                    Diese Rechnung gilt als Garantieschein.
                                </span>
                                <span>Netto Gesamt </span>
                            </div>
                        
                        0.00 D
                        </td>
                    </tr>
                    <tr class="border-0">
                        <td class="background-ffffff border-0" colspan="2">
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label for="inlineRadio1">Betrag dankend erhalten</label>
                                </div>
                                <div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                    <label for="inlineRadio2">Ware in einwandfreiem Zustand
                                        erhalten.Vom einwandfreien Funktionieren des Gerätes habe ich mich
                                        überzeugt</label>
                                </div>
                                <span class="color-0e69a8 z-index">+ 19% MwSt.</span>
                            </div>
                        </td>
                        
                        <td class="border-box">
                            @if ($order->reports->isNotEmpty())
                                {{ $order->reports->sum('price')  * 0.19 }}
                            @else
                                0.00
                            @endif
                        </td>
                    </tr>
                    <tr class="border-0 background-ffffff">
                        <td class="background-ffffff border-0">
                            <div class="d-flex align-items-center box w-95">
                                <div class="box-footer d-flex">
                                    <span>Unterschrift des Technikers </span>
                                    <span>Unterschrift des Kunden: Ich bestätige die Richtigkeit der Angaben und erkenne
                                        die rückseitig abgedruckten Allgemeinen Geschäftsbedingungen für
                                        Unterhaltungselektronik und Haushaltsgeräte von Handwerk - Einzelhandel an.
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex radio-table">
                                <div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineBar" value="option1">
                                    <label for="inlineBar">Bar</label>
                                </div>
                                <div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineEC" value="option2">
                                    <label for="inlineEC">WEC</label>
                                </div>
                                <div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineÜberweisung" value="option2">
                                    <label for="inlineÜberweisung">Überweisung</label>
                                </div>
                            </div>
                        </td>


                        
                        <td class="background-ffffff color-0e69a8 border-0 ges">
                            Gesamtbetrag
                        </td>
                        
                        <td class="border-box border-1 background-0e69a8">
                            <div>
                                @if ($order->reports->isNotEmpty())
                                <span>  {{ $order->reports->sum('price')  - ( $order->reports->sum('price')  * 0.19) }} D</span>
                                @else
                                0.00
                                @endif
                            </div>
                        </td>
                        
                    </tr>
                </tfoot>
            </table>
        </div>
        <h6>Bankverbindung: Postbank | Kto.Nr.: 790 33 31 21 | BLZ: 100 100 10 | IBAN: DE03 1001 0010 0790 3331 21 |
            St.Nr.: 34 25 000 383 | Inh. M. Sc. R. Cerrahoglu</h6>
    </div>



</body></html>