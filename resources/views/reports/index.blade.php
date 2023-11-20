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
    header{
        background-color: #0e69a8; height: 7rem
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
}
.w-40{
    width: 40%
}


</style>
<body>
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

    <table>
        <tr style="width: 100%">
            <td style="max-width: 33%">
                <h1> Rechnung </h1>

                <div class="form-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                    <label class="form-check-label" for="inlineCheckbox1">Reparatur</label>
             
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Verkauf</label>
                    
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">Ankauf</label>
                </div>
            </td>


            <td   style="text-align: right; float:left">
                <div class="form">
                    <div>
                        <label class="w-40">Datum : </label>
                        <input type="text" name="" id="" value="2023-11-13 14:15:00">
                    </div>
                    <div>
                        <label class="w-40">Auftrags-Nr.: </label>
                        <input type="text" name="" id="" value="OF-654B52A57EBFB">
                    </div>
                    <div>
                        <label class="w-40">Rechnungs-Nr.: </label>
                        <input type="text" name="" id="" value="3">
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>