<div class="main-container col1-layout home-content-container">

            <ol class="breadcrumb" style="margin-bottom:0;text-align:left;8px 5px 8px 20px;margin:0">
              <li><a href="<?=url(['/'])?>">HOME</a></li>
              <li class="active">ABOUT US</li>
            </ol>
        </div>
        <div class="main home-content">

<style type="text/css">

li.res_li:hover{
    background-color: #E28903;
}

li.res_li:hover a.resources_link:hover{
    color: #FFF!important;
}


.res_ul{
display: inline;
list-style-type: none;
height: 138px;
width: 179px;
margin-right: auto;
margin-left: auto;
}

.res_li{

border: thin solid #CCC;
margin: 10px;
list-style-type: none;
height: 138px;
width: 179px;
padding-top: 61px;
float: left;
font-size: 10pt;
font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
text-align: center;}

</style>

        <div class="row columns-layout nova-mg-pd">
            <div class="col-main col-md-12 nova-mg-pd">
                <div class="page-title category-title">
                <h1>About Us</h1>
                </div>
                    <div class="category-description std">
                        <div class="ul">
                            <ul class="res_ul">

                                <?php 
                                    $lists = postList(3);

                                 ?>

                                 <?php foreach ($lists as $v): ?>
                                    <li class="res_li"><a class="resources_link" href="<?=$v['url']?>"><?=$v['title']?></a></li>
                                 <?php endforeach ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
