<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>XZBox | Error <?php echo $this->code; ?> </title><link rel="stylesheet" href="<?php echo base_url; ?>assets/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url; ?>assets/css/app.css"><meta name="viewport" content="width=device-width, initial-scale=1"><style>html, body {background-color: #35404f;color: #ffffff;overflow: hidden;height: 100%;}.container {top: calc(50% - 100px);position: relative;}.logo {float: right !important;}</style></head><body><div class="container"><div class="row"><div class="col-md-6 col-sm-6 col-xs-6"><a href="<?php echo base_url; ?>"><img class="logo" alt="XZbox logo" title="XZbox" width="100px" src="<?php echo base_url; ?>assets/img/logo-small.png"></a></div><div class="col-md-6 col-sm-6 col-xs-6"><h1><?php echo $this->code; ?>!</h1><small><?php echo $this->message; ?></small></div></div></div><script src="<?php echo base_url; ?>assets/js/jquery.min.js"></script><script src="<?php echo base_url; ?>assets/js/bootstrap.min.js"></script></body></html>