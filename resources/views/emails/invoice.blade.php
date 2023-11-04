<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <style>
      body {
        font-family: Arial, Helvetica, sans-serif;
        background: rgb(204,204,204); 
      }
page[size="A4"] {
  background: white;
  /* width: 21cm; */
  height: 27.3cm;
  display: block;
  /* margin: 0 auto; */
  /* margin-bottom: 0.5cm; */
  /* box-shadow: 0 0 0.5cm rgba(0,0,0,0.5); */
}
@media print {
  body, page[size="A4"] {
    margin: 0;
    box-shadow: 0;
  }
}
    </style>
    <title>Invoice </title>
  </head>
  <body> 
   <page size="A4">
    <div style="padding: 10px;">
      <table style="width: 100%;">
        <tr style="width: 100%;">
          <td style="width: 50%;">
            <label style="font-size: 40px; font-weight: bold;">
              #{{ $order->id }}
            </label>
          </td>
          <td style="width: 50%; text-align: right;">
            <span class="app-brand-logo demo">
              <img src="{{ public_path().'/assets/img/logo.png' }}" style="max-height: 55px">

            </span>
          </td>
        </tr>
      </table>
      <table style="width: 100%; margin: 10px 0px;">
        <tr style="width: 100%;">
          <td style="width: 33%; line-height: 25px;">
            <label>From</label><br />
            <label style="font-weight: bold; font-size: 15px;">
              Global Reparaturservice Ingenieurbetrieb  
            </label>
            <br />
           Germany <br />
            Berlin <br />
          </td>
          <td style="width: 33%; line-height: 25px;">
            <label>To</label><br />
            <label style="font-weight: bold; font-size: 15px;">
              {{ $order->customer->name }}
            </label><br />
            {{ $order->customer->address }} <br />
            {{ $order->customer->city }} <br />
          </td>
          <td style="width: 33%; margin: auto;">
            @if ($order->is_paid)
              <span style="
                font-weight: bold;
                padding: 10px;
                color: #68ba6d;
                border: 4px #68ba6d solid;
                ">
                PAID
              </span>
            @else
            <span style="
                font-weight: bold;
                padding: 10px;
                color: red;
                border: 4px red solid;
                ">
                NOT PAID
              </span>
            @endif
            

          </td>
        </tr>
      </table>
      <table style="width: 100%;">
        <tr style="background: #224e71; color: white;">
          <th style="padding: 10px;">
            Description
          </th>
          <th>
            Amount
          </th>
          
          <th>
            Total
          </th>
        </tr>
        <tr>
          <td>
            {{ $order->maintenance_device }}
          </td>
          <td>
            {{ $order->amount }}
          </td>
          <td>
            {{ $order->amount }}
          </td>
        </tr>
      </table>

    </div>
   </page>
  </body>
</html>
