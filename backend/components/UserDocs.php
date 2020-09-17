<?php


namespace backend\components;


class UserDocs
{
    public $_monthsList = [
    "1"=>"Январь","2"=>"Февраль","3"=>"Март",
    "4"=>"Апрель","5"=>"Май", "6"=>"Июнь",
    "7"=>"Июль","8"=>"Август","9"=>"Сентябрь",
    "10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь"];

    public function getDocsHtml($fio , array $payment, $number, $date)
    {
        $summ = 0;
        $strHtml = "
            <html xmlns:o='urn:schemas-microsoft-com:office:office'
            xmlns:x='urn:schemas-microsoft-com:office:excel'
            xmlns='http://www.w3.org/TR/REC-html40'>
            <head>
            <meta http-equiv=Content-Type content='text/html; charset=utf-8'>
            <meta name=ProgId content=Excel.Sheet>
            <meta name=Generator content='Microsoft Excel 14'>
            <link rel=File-List href='Акт.files/filelist.xml'>
            <style id='Акт_22958_Styles'>
            <!--table
                {mso-displayed-decimal-separator:'\,';
                mso-displayed-thousand-separator:' ';}
            .xl1522958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:general;
                vertical-align:bottom;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl6522958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:general;
                vertical-align:bottom;
                border-top:1.0pt solid windowtext;
                border-right:none;
                border-bottom:none;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl6622958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:right;
                vertical-align:top;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl6722958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:10.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:1;
                mso-number-format:General;
                text-align:general;
                vertical-align:bottom;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl6822958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:general;
                vertical-align:bottom;
                border-top:none;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl6922958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:right;
                vertical-align:bottom;
                border-top:none;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl7022958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:7.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:1;
                mso-number-format:General;
                text-align:right;
                vertical-align:bottom;
                border-top:none;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl7122958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:Standard;
                text-align:right;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:.5pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl7222958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:Standard;
                text-align:right;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl7322958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:Standard;
                text-align:right;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:1.0pt solid windowtext;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl7422958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:left;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:.5pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:normal;}
            .xl7522958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:left;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:normal;}
            .xl7622958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:left;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:.5pt solid windowtext;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:normal;}
            .xl7722958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:0;
                text-align:right;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:.5pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl7822958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:0;
                text-align:right;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl7922958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:0;
                text-align:right;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:.5pt solid windowtext;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl8022958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:left;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:.5pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl8122958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:left;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:.5pt solid windowtext;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl8222958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:Standard;
                text-align:right;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:.5pt solid windowtext;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl8322958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:0;
                text-align:center;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:none;
                border-bottom:.5pt solid windowtext;
                border-left:1.0pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl8422958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:0;
                text-align:center;
                vertical-align:top;
                border-top:.5pt solid windowtext;
                border-right:.5pt solid windowtext;
                border-bottom:.5pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl8522958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:14.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:general;
                vertical-align:middle;
                border-top:none;
                border-right:none;
                border-bottom:1.0pt solid windowtext;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl8622958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:general;
                vertical-align:middle;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl8722958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:general;
                vertical-align:top;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:normal;}
            .xl8822958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:400;
                font-style:italic;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:general;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:normal;}
            .xl8922958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:center;
                vertical-align:middle;
                border-top:1.0pt solid windowtext;
                border-right:none;
                border-bottom:none;
                border-left:1.0pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl9022958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:center;
                vertical-align:middle;
                border-top:none;
                border-right:none;
                border-bottom:none;
                border-left:1.0pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl9122958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:center;
                vertical-align:middle;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl9222958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:center;
                vertical-align:middle;
                border-top:1.0pt solid windowtext;
                border-right:none;
                border-bottom:none;
                border-left:.5pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl9322958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:center;
                vertical-align:middle;
                border-top:none;
                border-right:none;
                border-bottom:none;
                border-left:.5pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl9422958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:center;
                vertical-align:middle;
                border-top:1.0pt solid windowtext;
                border-right:1.0pt solid windowtext;
                border-bottom:none;
                border-left:.5pt solid windowtext;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl9522958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:General;
                text-align:center;
                vertical-align:middle;
                border-top:none;
                border-right:1.0pt solid windowtext;
                border-bottom:none;
                border-left:none;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl9622958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:center;
                vertical-align:bottom;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:normal;}
            .xl9722958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:204;
                mso-number-format:Standard;
                text-align:right;
                vertical-align:top;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl9822958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:9.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:1;
                mso-number-format:General;
                text-align:general;
                vertical-align:bottom;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:normal;}
            .xl9922958
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:8.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:general;
                vertical-align:bottom;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:normal;}
            -->
            </style>
            </head>
            
            <body>
            <!--[if !excel]>&nbsp;&nbsp;<![endif]-->
            <div id='Акт_22958' align=center x:publishsource='Excel'>
            <table border=0 cellpadding=0 cellspacing=0 width=693 style='border-collapse:
             collapse;table-layout:fixed;width:528pt'>
             <col width=21 span=33 style='mso-width-source:userset;mso-width-alt:896;
             width:16pt'>
             <tr height=28 style='mso-height-source:userset;height:21.0pt'>
              <td colspan=31 height=28 class=xl8522958 width=651 style='height:21.0pt;
              width:496pt'>Акт № {$number}<span style='mso-spacerun:yes'>      </span>за<span
              style='mso-spacerun:yes'>     </span>{$this->_monthsList[(int)$date["m"]]} {$date["y"]} г.</td>
              <td class=xl1522958 width=21 style='width:16pt'></td>
              <td class=xl1522958 width=21 style='width:16pt'></td>
             </tr>
             <tr height=15 style='height:11.25pt'>
              <td height=15 class=xl1522958 style='height:11.25pt'></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=44 style='mso-height-source:userset;height:33.0pt'>
              <td colspan=4 height=44 class=xl8622958 style='height:33.0pt'>Исполнитель:</td>
              <td colspan=28 class=xl8722958 width=588 style='width:448pt'>ООО
              &quot;Компания &quot;Инвентрейд&quot;, Адрес :<span
              style='mso-spacerun:yes'>   </span>119361, Россия, г. Москва, ул. Наташи
              Ковшовой,д.29 оф.26 ИНН 7729730960 КПП 772901001 тел.+ 7 499 7920109 эл.
              Почта info@jobscanner.online</td>
              <td class=xl1522958></td>
             </tr>
             <tr height=9 style='mso-height-source:userset;height:6.95pt'>
              <td height=9 class=xl1522958 style='height:6.95pt'></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=37 style='mso-height-source:userset;height:27.75pt'>
              <td colspan=4 height=37 class=xl8622958 style='height:27.75pt'>Заказчик:</td>
              <td colspan=28 class=xl8822958 width=588 style='width:448pt'>{$fio}</td>
              <td class=xl1522958></td>
             </tr>
             <tr height=9 style='mso-height-source:userset;height:6.95pt'>
              <td height=9 class=xl1522958 style='height:6.95pt'></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=15 style='mso-height-source:userset;height:11.25pt'>
              <td colspan=2 rowspan=2 height=30 class=xl8922958 style='height:22.5pt'>№</td>
              <td colspan=17 rowspan=2 class=xl9222958>Наименование работ, услуг</td>
              <td colspan=3 rowspan=2 class=xl9222958>Кол-во</td>
              <td colspan=2 rowspan=2 class=xl9222958>Ед.</td>
              <td colspan=4 rowspan=2 class=xl9222958>Цена</td>
              <td colspan=4 rowspan=2 class=xl9422958>Сумма</td>
              <td class=xl1522958></td>
             </tr>
             <tr height=15 style='mso-height-source:userset;height:11.25pt'>
              <td height=15 class=xl1522958 style='height:11.25pt'></td>
             </tr>";
            $n=0;
             foreach ($payment as $k => $pay){
                 $n=$k+1;
                 $summ+= $pay['summ'] * $pay['count'];
                 $strHtml .="<tr height=15 style='mso-height-source:userset;height:11.25pt'>
              <td colspan=2 height=15 class=xl8322958 style='border-right:.5pt solid black;
              height:11.25pt'>{$n}</td>
              <td colspan=17 class=xl7422958 width=357 style='border-right:.5pt solid black;
              border-left:none;width:272pt'>{$pay["name"]}</td>
              <td colspan=3 class=xl7722958 style='border-right:.5pt solid black;
              border-left:none'>{$pay["count"]}</td>
              <td colspan=2 class=xl8022958 style='border-right:.5pt solid black;
              border-left:none'>дн.</td>
              <td colspan=4 class=xl7122958 style='border-right:.5pt solid black;
              border-left:none'>{$pay["summ"]},00</td>
              <td colspan=4 class=xl7122958 style='border-right:1.0pt solid black;
              border-left:none'>".$pay["summ"]*$pay["count"].",00</td>
              <td class=xl1522958></td>
             </tr>";
             }
             $strHtml.="<tr height=9 style='mso-height-source:userset;height:6.95pt'>
              <td height=9 class=xl6522958 style='height:6.95pt'>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl6522958>&nbsp;</td>
              <td class=xl1522958></td>
             </tr>
             <tr height=17 style='mso-height-source:userset;height:12.75pt'>
              <td height=17 class=xl1522958 style='height:12.75pt'></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl6622958>Итого:</td>
              <td colspan=4 class=xl9722958>{$summ},00</td>
              <td class=xl1522958></td>
             </tr>
             <tr height=17 style='mso-height-source:userset;height:12.75pt'>
              <td height=17 class=xl1522958 style='height:12.75pt'></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl6622958>Без налога (НДС)</td>
              <td colspan=4 class=xl6622958>-</td>
              <td class=xl1522958></td>
             </tr>
             <tr height=9 style='mso-height-source:userset;height:6.95pt'>
              <td height=9 class=xl1522958 style='height:6.95pt'></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=15 style='mso-height-source:userset;height:11.25pt'>
              <td colspan=32 height=15 class=xl1522958 style='height:11.25pt'>Всего оказано
              услуг ".count($payment).", на сумму {$summ},00<span style='mso-spacerun:yes'>     </span>руб</td>
              <td class=xl1522958></td>
             </tr>
             <tr height=17 style='mso-height-source:userset;height:12.75pt'>
              <td colspan=31 height=17 class=xl8722958 width=651 style='height:12.75pt;
              width:496pt'>{$this->number2string($summ)}<span style='mso-spacerun:yes'>             
              </span><span style='mso-spacerun:yes'>    </span>00<span
              style='mso-spacerun:yes'>       </span>копеек</td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=16 style='mso-height-source:userset;height:12.0pt'>
              <td height=16 class=xl1522958 style='height:12.0pt'></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=57 style='mso-height-source:userset;height:42.75pt'>
              <td colspan=33 height=57 class=xl9822958 width=693 style='height:42.75pt;
              width:528pt'>Заказчик имеет право предъявить претензии по объему, качеству и
              срокам оказания услуг в течение 14 рабочих дней с даты настоящего Акта. При
              отсутствии претензии в указанный срок вышеперечисленные услуги считаются
              оказанными<span style='mso-spacerun:yes'>  </span>в полном объеме в
              соответсвии с условиями Пользовательского соглашения.<span
              style='mso-spacerun:yes'> </span></td>
             </tr>
             <tr height=17 style='mso-height-source:userset;height:12.75pt'>
              <td height=17 class=xl1522958 style='height:12.75pt'></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=17 style='mso-height-source:userset;height:12.75pt'>
              <td height=17 class=xl6722958 colspan=5 style='height:12.75pt'>ИСПОЛНИТЕЛЬ</td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl6722958 colspan=4>ЗАКАЗЧИК</td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=17 style='mso-height-source:userset;height:12.75pt'>
              <td colspan=16 height=17 class=xl9922958 width=336 style='height:12.75pt;
              width:256pt'>Генеральный директор ООО &quot;Компания &quot;Инвентрейд&quot;</td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958>{$fio}</td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <tr height=48 style='mso-height-source:userset;height:36.0pt'>
              <td height=48 class=xl6822958 style='height:36.0pt'>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6922958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl7022958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl6822958>&nbsp;</td>
              <td class=xl1522958></td>
             </tr>
             <tr height=17 style='mso-height-source:userset;height:12.75pt'>
              <td colspan=16 height=17 class=xl9622958 width=336 style='height:12.75pt;
              width:256pt'>Хандамиров В.А.</td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
              <td class=xl1522958></td>
             </tr>
             <![if supportMisalignedColumns]>
             <tr height=0 style='display:none'>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
              <td width=21 style='width:16pt'></td>
             </tr>
             <![endif]>
            </table>
            </div>
            </body>
            </html>
            ";
        return $strHtml;
    }

    private function number2string($number) {

        // обозначаем словарь в виде статической переменной функции, чтобы
        // при повторном использовании функции его не определять заново
        static $dic = array(

            // словарь необходимых чисел
            array(
                -2	=> 'две',
                -1	=> 'одна',
                1	=> 'один',
                2	=> 'два',
                3	=> 'три',
                4	=> 'четыре',
                5	=> 'пять',
                6	=> 'шесть',
                7	=> 'семь',
                8	=> 'восемь',
                9	=> 'девять',
                10	=> 'десять',
                11	=> 'одиннадцать',
                12	=> 'двенадцать',
                13	=> 'тринадцать',
                14	=> 'четырнадцать' ,
                15	=> 'пятнадцать',
                16	=> 'шестнадцать',
                17	=> 'семнадцать',
                18	=> 'восемнадцать',
                19	=> 'девятнадцать',
                20	=> 'двадцать',
                30	=> 'тридцать',
                40	=> 'сорок',
                50	=> 'пятьдесят',
                60	=> 'шестьдесят',
                70	=> 'семьдесят',
                80	=> 'восемьдесят',
                90	=> 'девяносто',
                100	=> 'сто',
                200	=> 'двести',
                300	=> 'триста',
                400	=> 'четыреста',
                500	=> 'пятьсот',
                600	=> 'шестьсот',
                700	=> 'семьсот',
                800	=> 'восемьсот',
                900	=> 'девятьсот'
            ),

            // словарь порядков со склонениями для плюрализации
            array(
                array('рубль', 'рубля', 'рублей'),
                array('тысяча', 'тысячи', 'тысяч'),
                array('миллион', 'миллиона', 'миллионов'),
                array('миллиард', 'миллиарда', 'миллиардов'),
                array('триллион', 'триллиона', 'триллионов'),
                array('квадриллион', 'квадриллиона', 'квадриллионов'),
                // квинтиллион, секстиллион и т.д.
            ),

            // карта плюрализации
            array(
                2, 0, 1, 1, 1, 2
            )
        );

        // обозначаем переменную в которую будем писать сгенерированный текст
        $string = array();

        // дополняем число нулями слева до количества цифр кратного трем,
        // например 1234, преобразуется в 001234
        $number = str_pad($number, ceil(strlen($number)/3)*3, 0, STR_PAD_LEFT);

        // разбиваем число на части из 3 цифр (порядки) и инвертируем порядок частей,
        // т.к. мы не знаем максимальный порядок числа и будем бежать снизу
        // единицы, тысячи, миллионы и т.д.
        $parts = array_reverse(str_split($number,3));

        // бежим по каждой части
        foreach($parts as $i=>$part) {

            // если часть не равна нулю, нам надо преобразовать ее в текст
            if($part>0) {

                // обозначаем переменную в которую будем писать составные числа для текущей части
                $digits = array();

                // если число треххзначное, запоминаем количество сотен
                if($part>99) {
                    $digits[] = floor($part/100)*100;
                }

                // если последние 2 цифры не равны нулю, продолжаем искать составные числа
                // (данный блок прокомментирую при необходимости)
                if($mod1=$part%100) {
                    $mod2 = $part%10;
                    $flag = $i==1 && $mod1!=11 && $mod1!=12 && $mod2<3 ? -1 : 1;
                    if($mod1<20 || !$mod2) {
                        $digits[] = $flag*$mod1;
                    } else {
                        $digits[] = floor($mod1/10)*10;
                        $digits[] = $flag*$mod2;
                    }
                }

                // берем последнее составное число, для плюрализации
                $last = abs(end($digits));

                // преобразуем все составные числа в слова
                foreach($digits as $j=>$digit) {
                    $digits[$j] = $dic[0][$digit];
                }

                // добавляем обозначение порядка или валюту
                $digits[] = $dic[1][$i][(($last%=100)>4 && $last<20) ? 2 : $dic[2][min($last%10,5)]];

                // объединяем составные числа в единый текст и добавляем в переменную, которую вернет функция
                array_unshift($string, join(' ', $digits));
            }
        }

        // преобразуем переменную в текст и возвращаем из функции, ура!
        return join(' ', $string);
    }
}