<style>
    body {
        background-color: #E4E2F5;
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    .footer-content {
        overflow: hidden; /* contains floated elements */
    }
    .footer-left {
        float: left;
        font-size: 12px;
    }
    .footer-right {
        float: right;
        font-size: 12px;
    }
</style>

<?php
date_default_timezone_set('Asia/Manila');
$datetime = date('Y-m-d H:i:s A');
?>

<body> 
    <h3><?= $data['header'][0] ?></h3>
    <p><?= $data['content'][0] ?></p>
    <br><br>
    <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 

    <footer>
        <div class="footer-content">
            <p class="footer-left"><?= $data['footer'][0] ?></p>
            <p class="footer-right"><b>Server Date</b>: <?= $datetime ?></p>
        </div>
    </footer>     
</body>
