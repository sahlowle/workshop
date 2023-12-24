<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Global Invoice</title>
    <link rel="stylesheet" href="style.css">
    @include('style')
    <script src="script.js"></script>
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

        <div class="check-group inline" style=" margin-right: 10%;margin-bottom: 5px; ">
            <input type="checkbox" id="1" onclick="selectOnlyThis(this.id)">
            <label for="1">Reparaturauftrag</label>
        </div>
        <div class="check-group inline" style=" margin-right: 10%;margin-bottom: 5px; ">
            <input type="checkbox" id="2" onclick="selectOnlyThis(this.id)">
            <label for="2">Rechnung</label>
        </div>
        <div class="check-group inline" style=" margin-right: 10%; margin-bottom: 5px;">
            <input type="checkbox" id="3" onclick="selectOnlyThis(this.id)">
            <label for="3">Verkauf</label>
        </div>
        <div class="check-group inline" style="margin-bottom: 5px;">
            <input type="checkbox" id="4" onclick="selectOnlyThis(this.id)">
            <label for="4">Ankauf</label>
        </div>

        <div>

            <h1 class="inline" style=" margin-right: 65.4%;margin-bottom:1%;  ">Rechnungsempfänger</h1>

            <div class="inline">
                <table class="  meta meta-right" style=" margin-bottom:1%;   width: 572.9%;table-layout: unset;">
                    <tr>
                        <th>
                            <h4>Datum</h4>
                        </th>
                        <td style="max-width: 10px;overflow: hidden;">
                            <span class="wordbr">sdfasdfasfds</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>




        <table class="meta meta-left">
            <tr>
                <th>
                    <span>Name</span>
                </th>
                <td style="max-width: 10px;overflow: hidden;">
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Adresse</span>
                </th>
                <td style="max-width: 10px;overflow: hidden;">
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Plz.</span>
                </th>
                <td style="max-width: 10px;overflow: hidden;">
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Gbd.teil</span>
                </th>
                <td style="max-width: 10px;overflow: hidden;">
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Telefon</span>
                </th>
                <td style="max-width: 10px;overflow: hidden;">
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Mobil</span>
                </th>
                <td style="max-width: 10px;overflow: hidden;">
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
        </table>

        <div class="row" style="margin-left:50%;width:100%">
            <table class="meta meta-right" style="margin-right:53%;width:47%;margin-bottom:3%;">
                <tr>
                    <th>
                        <h4>Marke</h4>
                    </th>
                    <td style="max-width: 10px;overflow: hidden;">
                        <span class="wordbr" contenteditable></span>
                    </td>
                </tr>
            </table>
            <div class="column" style="margin-top:4%;margin-bottom:0%;">
                <div class="check-group2">
                    <input type="checkbox" id="Waschmaschine">
                    <label for="Waschmaschine">Waschmaschine</label>
                </div>
                <div class="check-group2">
                    <input type="checkbox" id="Trockner">
                    <label for="Trockner">Trockner</label>
                </div>
                <div class="check-group2">
                    <input type="checkbox" id="Gastronomie">
                    <label for="Gastronomie">Gastronomie</label>
                </div>
                <div class="check-group2">
                    <input type="checkbox" id="Kaffeemaschine">
                    <label for="Kaffeemaschine">Kaffeemaschine</label>
                </div>
            </div>
            <div class="column" style="margin-top:4%;margin-bottom:0%;">
                <div class="check-group2">
                    <input type="checkbox" id="Geschirrspüler">
                    <label for="Geschirrspüler">Geschirrspüler</label>
                </div>
                <div class="check-group2">
                    <input type="checkbox" id="Herd/Ceran./MW">
                    <label for="Herd/Ceran./MW">Herd/Ceran./MW</label>
                </div>
                <div class="check-group2">
                    <input type="checkbox" id="DAH">
                    <label for="DAH">DAH</label>
                </div>
                <div class="check-group2">
                    <input type="checkbox" id="Kühlschrank">
                    <label for="Kühlschrank">Kühlschrank</label>
                </div>
            </div>
        </div>

        <div class="inline check-group2" style="margin-right:2%">
            <input type="checkbox" id="Gehäuseschäden vorhanden">
            <label for="Gehäuseschäden vorhanden">Gehäuseschäden vorhanden</label>
        </div>
        <div class="inline check-group2" style="margin-right:1%">
            <input type="checkbox" id="Reparaturauftrag durch Kunden erteilt">
            <label for="Reparaturauftrag durch Kunden erteilt">Reparaturauftrag durch Kunden erteilt</label>
        </div>
        <div class="inline check-group2">
            <input type="checkbox" id="Gerät abgeholt">
            <label for="Gerät abgeholt">Gerät abgeholt</label>
        </div>






        <hr class="solid">
        <div style="font-family: 'Linotype Ergo W01 Compressed'">
            <div class="row">
                <div class="column" style=" width: 68%;min-height: 8%; padding-bottom: 0;">
                    <table class="info">
                        <thead>
                            <tr>
                                <th>Information</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="max-width: 10px;overflow: hidden;">
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>



                <div class="column" style=" width: 25%; text-align: center; min-height: 106px; ">

                    <table class="meta meta-left" style=" position: unset;table-layout: unset;width: 100%; margin: 45px 0px 0px 0px; ">
                        <tr>
                            <td style=" text-align: center;font-size: 20px; ">
                                <span class="wordbr" contenteditable></span>
                            </td>
                        </tr>
                    </table>
                    <div style="margin-top:50%;">
                        <span style="color: #1275bc; font-size: 14px;font-weight: 600;">Netto Gesamt</span>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="column" style="padding-bottom: 0px;width: 68%;padding-top: 0;">
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
                                    <span>Endpreis</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="max-width: 10px;overflow: hidden;">
                                    <span class="wordbr" contenteditable> </span>
                                </td>
                                <td style="max-width: 10px;overflow: hidden;">
                                    <span class="wordbr" contenteditable> </span>
                                </td>
                                <td style="max-width: 10px;overflow: hidden;">
                                    <span class="wordbr" contenteditable> </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="cut">-</a>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="cut">-</a>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="cut">-</a>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="cut">-</a>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="cut">-</a>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                                <td>
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="box" style="min-height: 15%; width:511.5px">
                        <div class="row">
                            <div class="column" style="width: 100%;padding: 0px;">
                                <table class="meta meta-left" style=" width: 59%; ">
                                    <tbody>
                                        <tr>
                                            <th class="txt1">
                                                <span>Anzahlung in Höhe von: </span>
                                            </th>
                                            <td style="max-width: 10px;overflow: hidden;">
                                                <span class="wordbr" contenteditable=""></span>
                                            </td>
                                            <td class="euro">
                                                <span>€</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="txt1">
                                                <span>Reparatur genehmigt bis: </span>
                                            </th>
                                            <td style="max-width: 10px;overflow: hidden;">
                                                <span class="wordbr" contenteditable=""></span>
                                            </td>
                                            <td class="euro">
                                                <span>€</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="column" style="padding: 4px;width: 100%;">
                                <div style="margin-top:10%">
                                    <p style=" font-size: 0.58rem; font-weight: 500;">Im Falle einer Auftragsstornierung werden dem Kunden pauschal 89,00 € als Aufwandsentschädigung in Rechnung gestellt.*</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column" style=" width: 25%; text-align: center;">
                    <div>
                        <table class="meta meta-left" style=" width: 100%; margin: 15px 0px 0px 0px; ">
                            <tr>
                                <td style=" text-align: center;font-size: 20px; ">
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                        </table>
                        <div style="margin-top:30%;">
                        <span style="color: #1275bc; font-size: 14px;font-weight: 600;">19% MwSt.:</span>
                        </div>
                    </div>


                    <div>
                        <table class="meta meta-left" style=" width: 100%; margin: 30px 0px 0px 0px; ">
                            <tr>
                                <td style=" text-align: center;font-size: 20px; ">
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                        </table>
                        <div style="margin-top:40%;">
                            <span style="color: #1275bc; font-size: 14px;font-weight: 600;">*Endbetrag:</span>
                        </div>
                    </div>
                    <div style=" font-size: 12px; font-weight: 50;text-align: left; padding-top: 14px; ">
                        <p>Auf die von uns ausgewechselten Teile gewähren wir 12 Monate Garantie. Diese Rechnung gilt als Garantieschein. Bei Beschädigung des Garantiesiegels kann eine Garantieleistung nicht erbracht werden</p>
                    </div>



                </div>
            </div>
            <div>
                <div class="inline check-group3" style="margin-left: 10px;">
                    <input type="checkbox" id="Bar">
                    <label for="Bar">Bar</label>
                </div>
                <div class="inline check-group3" style=" padding-left: 34px; ">
                    <input type="checkbox" id="EC">
                    <label for="EC">EC</label>
                </div>
                <div class="inline check-group3" style=" padding-left: 34px; ">
                    <input type="checkbox" id="Überweisung">
                    <label for="Überweisung">Überweisung</label>
                </div>
            </div>
            <div>
                <div class="inline check-group4">
                    <input type="checkbox" id="Betrag">
                    <label for="Betrag">Betrag dankend erhalten</label>
                </div>
                <div class="inline check-group4"style="width:50%;padding-right: 0;margin-left:75px;">
                    <input type="checkbox" id="Ware">
                    <label for="Ware">Ware in einwandfreiem Zustand erhalten. Richtigkeit aller Angaben. <br> Vom einwandfreien Funktionieren des Gerätes habe ich mich überzeugt </label>
                </div>
            </div>
            <div class="row">
                <div class="column2" style="  margin-left: 13px; ">
                    <div class="box1" style=" border-right: 0; ">
                        <span style="font-weight: 50;" class="wordbr" contenteditable>Unterschrift desTechnikers</span>
                    </div>
                </div>
                <div class="column2">
                    <div class="box1" >
                        <span style="font-weight: 50;" class="wordbr"  >Unterschrift des Kunden: Ich bestätige die Richtigkeit der Angaben und erkenne die Rückseitig abgedruckten Allgemeinen Geschäftsbedingungen für Unterhaltungselektronik und Haushaltsgeräte Handwerk - Einzelhandel an.</span>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <aside style="font-family: 'Linotype Ergo W01 Compressed'">
        <div class="footer" >
            <p style="font-size">Bankverbindung: Postbank | Kto.Nr.: 790 33 31 21 | BLZ: 100 100 10 | IBAN: DE03 1001 0010 0790 3331 21 | St.Nr.: 34 25 000 383 | Inh. M. Sc. R. Cerrahoglu</p>
        </div>
        <div class="ft">
            <img style="width: 94%;padding: 15px;text-align: center;" src="{{ asset('pdf.png') }}">
        </div>
    </aside>
</body>

</html>
