<?php
    $this->title = 'CONTACT US';
?>
<style type="text/css">
    .panel-group .panel{
        border-radius:1px;
        border:none;
    }
    .panel-heading{
        padding: 0;
    }
    .panel-title a{
        display: inline-block;;
        width:100%;
        padding: 10px 15px;
    }
    .panel-title a
    {
        color:#808080;
        font-weight:bold
    }
    .panel-title a.colls:hover,.panel-title a.colls.collapsed:hover
    {
        color:white !important;
        font-weight:bold;
        background-color:#E28903;
    }
    .panel-title a.colls{
        background-color:#E28903;
        color:white;
    }
    .panel-title a.colls.collapsed{
        background-color: #f5f5f5;
        color: #808080;
    }
    .panel-body{
       padding: 5px 0 15px 0px;
    }
</style>

<div class="main-container col1-layout home-content-container">
<ol class="breadcrumb" style="margin-bottom:0;text-align:left;8px 5px 8px 20px;margin:0">
  <li><a href="<?=url(['/'])?>">HOME</a></li>
  <li class="active">CONTACT US</li>
</ol>
<div class="main home-content">
    <div class="row columns-layout nova-mg-pd">
        <div class="col-main col-md-12 nova-mg-pd">
            <div class="page-title category-title">
                    <h1>Contact Us</h1>
            </div>
            <div class="row">
                <div class="panel-group col-md-8" id="accordion" role="tablist" aria-multiselectable="true">

                <?php 
                    $contacts = postList(2);
                 ?>

                 <?php $i=1;foreach ($contacts as $contact): ?>
                     <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                          <h4 class="panel-title">
                            <a class="<?php if ($i != 1): ?>collapsed<?php endif ?> colls" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$contact['id']?>" aria-expanded="false" aria-controls="collapseTwo">
                              > <?=$contact['title']?>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse<?=$contact['id']?>" class="panel-collapse collapse <?php if ($i == 1): ?>in<?php endif ?>" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                            <div class="std">
                            <table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                            <td width="250">
                            <h2><img src="<?=$contact['thumb']?>" alt="" width="202" height="203"></h2>
                            </td>
                            <td class="locDesc" align="left" valign="middle">
                            <h2><?=$contact['subtitle']?>:</h2>

                            <?=$contact['body']?>

                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </div>

                          </div>
                        </div>
                      </div>
                 <?php $i++; endforeach ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>