<?php
    $subject = apply_filters('rayssa_mail_subject',$args['subject']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $subject ?></title>
    <style>
        .header{padding: 50px 50px 5px 50px;}
        .main-content-body{ padding: 5px 50px; }
        .footer{ padding: 5px 50px 50px 50px; }
        .footer p{
            text-align: center;
            font-size: 12px;
        }
        .header .logo, .header .title{
            text-align: center;
        }
        .header img{
            width: 220px;
            height: auto;
        }
        .capacity-results, .panels-calculation .step-1, .panels-calculation .step-2{
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .capacity-results .calc-result, 
        .panels-calculation .step-1 .calc-result,
        .panels-calculation .step-2 .calc-result
        {
            color: white;
            width: 40%;
            margin-bottom: 10px;
            padding: 10px 15px;
            text-align: center;
            border-radius: 7px;
        }
        .capacity-results .calc-result{
            background-color: #094B82;
        }
        .panels-calculation .step-1 .calc-result{
            background-color: #EC763E;
            
        }
        .panels-calculation .step-2 .calc-result{
            background-color: #6EC1E4;
            color: #54595F;
        }






        table.contact-data {
            width: 100%;
            background: #fff;
            -webkit-box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29);
            -moz-box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29);
            box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29);
            text-align: center; 
            border-collapse: separate;
            border-spacing: 1;  }
        table.contact-data thead {
            background: #094B82; 
            color: white; }
        table.contact-data thead td { padding: 5px 8px; }
        table.contact-data thead th {
            border: none;
            padding: 30px;
            font-size: 14px;
            color: #fff; }
        table.contact-data tbody tr {
            margin-bottom: 10px; }
        table.contact-data tbody th, table.contact-data tbody td {
            border: none;
            padding: 10px;
            font-size: 14px;
            background: #fff;
            vertical-align: middle;
            border-bottom: 2px solid #f8f9fd; }
        table.contact-data tbody th {
            background: #e8ebf8;
            border-bottom: 2px solid #e0e5f6; }
        table.contact-data thead td:first-of-type{
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;} 
        table.contact-data thead td:last-of-type{
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;} 

        /* artifacts */
        table.artifacts {
            width: 100%;
            background: #fff;
            -webkit-box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29);
            -moz-box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29);
            box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29);
            text-align: center; 
            border-collapse: separate;
            border-spacing: 1;  }
        table.artifacts thead {
            background: #094B82; 
            color: white; }
        table.artifacts thead td { padding: 5px 8px; }
        table.artifacts thead th {
            border: none;
            padding: 30px;
            font-size: 14px;
            color: #fff; }
        table.artifacts tbody tr {
            margin-bottom: 10px; }
        table.artifacts tbody th, table.artifacts tbody td {
            border: none;
            padding: 7px;
            font-size: 14px;
            background: #fff;
            vertical-align: middle;
            border-bottom: 2px solid #f8f9fd; }
        table.artifacts tbody th {
            background: #e8ebf8;
            border-bottom: 2px solid #e0e5f6; }
        table.artifacts thead td:first-of-type{
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;} 
        table.artifacts thead td:last-of-type{
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;}
        table.artifacts tbody tr:nth-of-type(odd) td{
            background-color: #086AD821;
        }

    </style>
</head>
<body>
    <?php do_action('rayssa_email_content_header'); ?>

    <?php do_action('rayssa_email_content_body'); ?>
    
    <?php do_action('rayssa_email_content_footer'); ?>
</body>
</html>