<html>

<head>
    <meta charset="utf-8">
    <title>Global Invoice</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	@include('reports.style-pickup')

</head>

<body>
    <header>
        <div class="container">
            <img src="{{ asset('pdf-log.png') }}">
            <div class="centered">
                <p>Stromstr. 31, 10551 Berlin • Tel.: 030/ 398 873 40 • Mobil: 0171 / 15 87 82 6</p>
                <p>info@global-reparaturservice.de • www.waschmaschine-reparatur-berlin.com</p>
            </div>
        </div>
    </header>

    <article>
        <div class="check">
            <div class="check-group">
                <input type="checkbox" id="1" onclick="selectOnlyThis(this.id)"  @checked($order->type == 1) >
                <label for="1">Reparaturauftrag</label>
            </div>
            <div class="check-group">
                <input type="checkbox" id="2" onclick="selectOnlyThis(this.id)"  @checked($order->type == 3) >
                <label for="2">Rechnung</label>
            </div>
            <div class="check-group">
                <input type="checkbox" id="3" onclick="selectOnlyThis(this.id)">
                <label for="3">Verkauf</label>
            </div>
            <div class="check-group">
                <input type="checkbox" id="4" onclick="selectOnlyThis(this.id)"  @checked($order->type == 2) >
                <label for="4">Ankauf</label>
            </div>
        </div>

        <div style="display: flex;isplay: flex;justify-content: space-between;">
            <h1>Rechnungsempfänger</h1>
            <table class="meta meta-right" style="margin: 0">
                <tr>
                    <th>
                        <h4>Datum</h4>
                    </th>
                    <td>
                        <span class="wordbr" contenteditable>  {{ $order->visit_time }} </span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="meta meta-left">
            <tr>
                <th>
                    <span>Name</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable> {{ $order->customer->name }} </span>
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
                    <span>Plz.</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable> {{ $order->postal_code }}  </span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Gbd.teil</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable> {{ $order->customer->part_of_building }} </span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Telefon</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable>
                        {{ $order->customer->telephone }} 
                    </span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Mobil</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable> {{ $order->order_phone_number }}   </span>
                </td>
            </tr>
        </table>

        <table class="meta meta-right">
            <tr>
                <th>
                    <h4>Marke</h4>
                </th>
                <td>
                    <span class="wordbr" contenteditable>  {{ $order->brand }} </span>
                </td>
            </tr>
        </table>

        <div class="row">
            @foreach ($devices->chunk(4) as $group)
				   <div class="column">
					@foreach ($group as $item)
					<div class="check-group2">
						<input type="checkbox" id="{{ $item->name }}" @checked($order->devices->contains('id',$item->id)) >
						<label for="Waschmaschine">{{ $item->name }}</label>
					</div>
					@endforeach
				   </div>
			@endforeach
        </div>
        
        <div class="check">
            @foreach ($questions as $item)
				<div class="check-group2">
					<input type="checkbox" id="{{ $item->name }}"  @checked($order->questions->contains('id',$item->id))>
					<label for="{{ $item->name }}"> {{ $item->name }} </label>
				</div>
				@endforeach
        </div>
        <hr class="solid">
        <div style="font-family: 'Linotype Ergo W01 Compressed'">
            <div class="row">
                <div class="column" style=" width: 68%;min-height: 10%; padding-bottom: 0;">
                    <table class="info">
                        <thead>
                            <tr>
                                <th>Information</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="wordbr" contenteditable> {{ $order->information }}  </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="column" style=" width: 25%; text-align: center; min-height: 106px; ">
                    <table class="meta meta-left" style=" width: 100%; margin: 55px 0px 0px 0px; ">
                        <tr>
                            <td style=" text-align: center;font-size: 20px; ">
                                <span class="wordbr" contenteditable> 
                                    {{ number_format($order->subtotal,2)}} €
                                </span>
                            </td>
                        </tr>
                    </table>
                    <span style="color: #1275bc; font-size: 14px;font-weight: 600;">Netto Gesamt</span>
                </div>
            </div>
            <div class="row">
                <div class="column" style="padding-bottom: 6px;width: 68%;">
                    <table class="inventory" style=" border-spacing: 0px; ">
                        <thead>
                            <tr>
                                <th>
                                    <span>Warenbezeichnug</span>
                                </th>
                                <th>
                                    <span>Menge</span>
                                </th>
                                <th>
                                    <span>Preis</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
									
								<tr>
									<td>
										<span class="wordbr" contenteditable> {{ $item->title }} </span>
									</td>
									<td>
										<span class="wordbr" contenteditable> {{ $item->quantity }} </span>
									</td>
									<td>
										<span class="wordbr" contenteditable> {{ $item->price }} </span>
									</td>
								</tr>

								@endforeach
                        </tbody>
                    </table>
                    <div class="box">
                        <div class="row">
                            <div class="column" style="width: 100%;padding: 0px;">
                                <table class="meta meta-left" style=" width: 59%; ">
                                    <tbody>
                                        <tr>
                                            <th class="txt1">
                                                <span>Anzahlung in Höhe von: </span>
                                            </th>
                                            <td>
                                                <span class="wordbr" contenteditable="">
                                                    {{ number_format($order->paid_amount,2)}} €
                                                </span>
                                            </td>
                                            <td class="euro">
                                                <span>€</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="txt1">
                                                <span>Reparatur genehmigt bis: </span>
                                            </th>
                                            <td>
                                                <span class="wordbr" contenteditable="">
                                                    {{ number_format($order->max_maintenance_price,2)}} €
                                                </span>
                                            </td>
                                            <td class="euro">
                                                <span>€</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="column" style="padding: 4px;width: 100%;">
                                <div>
                                    <p style=" font-size: 0.79rem; font-weight: 700;">Im Falle einer Auftragsstornierung werden dem Kunden pauschal 89,00 € als Aufwandsentschädigung in Rechnung gestellt.*</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="add">+</a>
                </div>
                <div class="column" style=" width: 25%; text-align: center;">
                    <div>
                        <table class="meta meta-left" style=" width: 100%; margin: 19px 0px 0px 0px; ">
                            <tr>
                                <td style=" text-align: center;font-size: 20px; ">
										<span class="wordbr" contenteditable>
                                           {{ number_format($order->vat,2)}} €
                                        </span>
                                </td>
                            </tr>
                        </table>
                        <span style="color: #1275bc; font-size: 14px;font-weight: 600;">19% MwSt.:</span>
                    </div>
                    <div>
                        <table class="meta meta-left" style=" width: 100%; margin: 31px 0px 0px 0px; ">
                            <tr>
                                <td style=" text-align: center;font-size: 20px; ">
                                    <span class="wordbr" contenteditable>
                                        {{ number_format($order->total,2)}} €
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <span style="color: #1275bc; font-size: 14px;font-weight: 600;">*Endbetrag:</span>
                    </div>
                    <div style=" font-size: 12px; text-align: left; padding-top: 14px; ">
                        <p>Auf die von uns ausgewechselten Teile gewähren wir 12 Monate Garantie. Diese Rechnung gilt als Garantieschein. Bei Beschädigung des Garantiesiegels kann eine Garantieleistung nicht erbracht werden</p>
                    </div>
                </div>
            </div>
            <div class="check2">
                <div class="check-group3" style="margin-left: 10px;">
                    <input type="checkbox" id="Bar" @checked($order->payment_way ==1) >
                    <label for="Bar">Bar</label>
                </div>
                <div class="check-group3" style=" padding-left: 34px; ">
                    <input type="checkbox" id="EC" @checked($order->payment_way ==2) >
                    <label for="EC">EC</label>
                </div>
                <div class="check-group3" style=" padding-left: 34px; ">
                    <input type="checkbox" id="Überweisung" @checked($order->payment_way ==3) >
                    <label for="Überweisung">Überweisung</label>
                </div>
            </div>
            <div class="check2" style="justify-content: space-between;">
                <div class="check-group4">
                    <input type="checkbox" id="Betrag"  @checked($order->is_amount_received) >
                    <label for="Betrag">Betrag dankend erhalten</label>
                </div>
                <div class="check-group4">
                    <input type="checkbox" id="Ware" @checked($order->is_customer_confirm)  >
                    <label for="Ware">Ware in einwandfreiem Zustand erhalten. Richtigkeit aller Angaben. <br> Vom einwandfreien Funktionieren des Gerätes habe ich mich überzeugt </label>
                </div>
            </div>
            <div class="row">
                <div class="column2" style="  margin-left: 13px; ">
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
    </article>

    <aside style="font-family: 'Linotype Ergo W01 Compressed'">
        <div class="footer">
            <p>Bankverbindung: Postbank | Kto.Nr.: 790 33 31 21 | BLZ: 100 100 10 | IBAN: DE03 1001 0010 0790 3331 21 | St.Nr.: 34 25 000 383 | Inh. M. Sc. R. Cerrahoglu</p>
        </div>
        <div class="ft">
            <img style="width: 94%;padding: 15px;text-align: center;"  src="{{  asset('pdf.png') }}">
        </div>
    </aside>

    <script>
        window.print();
    </script>
</body>

</html>
