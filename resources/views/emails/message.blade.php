<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Envío de Comprobante de Pago Electrónico</title>

<style type="text/css">
   img {
    max-width: 100%;
   }
   body {
    -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6;
   }
   body {
     background-color: #f6f6f6;
   }
   @media only screen and (max-width: 640px) {
      h1 {
        font-weight: 600 !important; margin: 20px 0 5px !important;
      }
       h2 {
        font-weight: 600 !important; margin: 20px 0 5px !important;
       }
       h3 {
         font-weight: 600 !important; margin: 20px 0 5px !important;
       }
       h4 {
         font-weight: 600 !important; margin: 20px 0 5px !important;
         }
       h1 {
        font-size: 22px !important;
       }
       h2 {
         font-size: 18px !important;
       }
       h3 {
          font-size: 16px !important;
       }
      .container {
        width: 100% !important;
        }
      .content {
           padding: 10px !important;
       }
       .content-wrap {
             padding: 10px !important;
        }
        .invoice {
            width: 100% !important;
         }
   }
</style>
</head>
<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6; background: #f6f6f6; margin: 0;">
<table class="body-wrap" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background: #f6f6f6; margin: 0;">
  <tr style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    <td class="container" width="600" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
      <div class="content" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
        <table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background: #fff; margin: 0; border: 1px solid #e9e9e9;">
          <tr style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td class="content-wrap" style="position: relative; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
              <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                
                <tr style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                  <td class="alert alert-warning" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: right; border-radius: 3px 3px 0 0; margin: 0; padding: 0 0 20px;" align="right" valign="top">
                    <img src="{{ $message->embed(public_path('img/logo_makim_doc.jpg')) }}" alt="" />
                  </td>
                </tr>
                <tr style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 40px;">
                  <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 0px;" valign="top">
                    <p>Estimado Cliente:</p>
                    <h4><strong> {{ $model->company->company_name }} </strong></h4>
                  </td>
                </tr>
                <tr style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                  <td class="content-block" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 60px;" valign="top">
                  <p>Informamos que su comprobante electrónico ha sido emitido exitosamente.</p>
                  <ul>
                    <li>{{ $model->document_type->description." ".$model->sn }}</li>
                    <li>Fecha de emisión: {{ date('d/m/Y', strtotime($model->issued_at)) }}</li>
                    <li>Total: {{ config('options.table_sunat.moneda_symbol.'.$model->currency_id) .' '.$model->total }}</li>
                  </ul>
                  <p>Puede descargar su comprobante en los formatos pdf y xml desde los siguientes enlaces:
                    <a href="{{ $r->links->pdf }}" class="btn btn-outline-secondary">{!! $icons['pdf'] !!} PDF</a>
                    <a href="{{ $r->links->xml }}" class="btn btn-outline-secondary">{!! $icons['xml'] !!} XML</a>
                  </p>

                  <br />
                  <p>Atentamente,</p>
                  <p>Servicio al cliente</p>
                  </td>
                </tr>
                <tr style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                  <td class="alert alert-warning" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; margin: 0; padding: 0px;" align="center" valign="top">
                    <img src="" alt="" />
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <div class="footer" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
        </div>
      </div>
    </td>
    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
  </tr>
</table>
</body>
</html>