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
            <div class="centered" style="color:red">
                <p>Stromstr. 31, 10551 Berlin • Tel.: 030/ 398 873 40 • Mobil: 0171 / 15 87 82 6</p>
                <p>info@global-reparaturservice.de • www.waschmaschine-reparatur-berlin.com</p>
            </div>
        </div>
    </header>
    <article>
        <div class="row">
            <div class="check-group">
                <input type="checkbox" id="1" onclick="selectOnlyThis(this.id)">
                <label for="1">Reparaturauftrag</label>
            </div>
            <div class="check-group">
                <input type="checkbox" id="2" onclick="selectOnlyThis(this.id)">
                <label for="2">Rechnung</label>
            </div>
            <div class="check-group">
                <input type="checkbox" id="3" onclick="selectOnlyThis(this.id)">
                <label for="3">Verkauf</label>
            </div>
            <div class="check-group">
                <input type="checkbox" id="4" onclick="selectOnlyThis(this.id)">
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
                        <span class="wordbr" contenteditable></span>
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
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Adresse</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Plz.</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Gbd.teil</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Telefon</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
            <tr>
                <th>
                    <span>Mobil</span>
                </th>
                <td>
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
        </table>
        <table class="meta meta-right">
            <tr>
                <th>
                    <h4>Marke</h4>
                </th>
                <td>
                    <span class="wordbr" contenteditable></span>
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="column">
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
            <div class="column">
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
        <div class="check">
            <div class="check-group2">
                <input type="checkbox" id="Gehäuseschäden vorhanden">
                <label for="Gehäuseschäden vorhanden">Gehäuseschäden vorhanden</label>
            </div>
            <div class="check-group2">
                <input type="checkbox" id="Reparaturauftrag durch Kunden erteilt">
                <label for="Reparaturauftrag durch Kunden erteilt">Reparaturauftrag durch Kunden erteilt</label>
            </div>
            <div class="check-group2">
                <input type="checkbox" id="Gerät abgeholt">
                <label for="Gerät abgeholt">Gerät abgeholt</label>
            </div>
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
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="column" style=" width: 25%; text-align: center; min-height: 106px; ">
                    <table class="meta meta-left" style=" width: 100%; margin: 55px 0px 0px 0px; ">
                        <tr>
                            <td style=" text-align: center;font-size: 20px; ">
                                <span class="wordbr" contenteditable></span>
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
                                    <span>Endpreis</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
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
                                            <td>
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
                                    <span class="wordbr" contenteditable></span>
                                </td>
                            </tr>
                        </table>
                        <span style="color: #1275bc; font-size: 14px;font-weight: 600;">19% MwSt.:</span>
                    </div>
                    <div>
                        <table class="meta meta-left" style=" width: 100%; margin: 31px 0px 0px 0px; ">
                            <tr>
                                <td style=" text-align: center;font-size: 20px; ">
                                    <span class="wordbr" contenteditable></span>
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
                    <input type="checkbox" id="Bar">
                    <label for="Bar">Bar</label>
                </div>
                <div class="check-group3" style=" padding-left: 34px; ">
                    <input type="checkbox" id="EC">
                    <label for="EC">EC</label>
                </div>
                <div class="check-group3" style=" padding-left: 34px; ">
                    <input type="checkbox" id="Überweisung">
                    <label for="Überweisung">Überweisung</label>
                </div>
            </div>
            <div class="check2" style="justify-content: space-between;">
                <div class="check-group4">
                    <input type="checkbox" id="Betrag">
                    <label for="Betrag">Betrag dankend erhalten</label>
                </div>
                <div class="check-group4">
                    <input type="checkbox" id="Ware">
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
            <img style="width: 94%;padding: 15px;text-align: center;" src="{{ asset('pdf.png') }}">
        </div>
    </aside>
</body>

</html>
