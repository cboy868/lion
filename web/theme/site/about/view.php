        <div class="main-container col1-layout home-content-container">

            <ol class="breadcrumb" style="margin-bottom:0;text-align:left;8px 5px 8px 20px;margin:0">
              <li><a href="<?=url(['/'])?>">Home</a></li>
              <li><a href="<?=url(['/home/about'])?>">About Us</a></li>
              <li class="active"><?=$post['title']?></li>
            </ol>

            <div class="main home-content">
                <div class="row columns-layout nova-mg-pd">
                    <div class="col-main col-md-12 nova-mg-pd">
                        <div class="page-title category-title">
                            <h1><?=$post['title']?></h1>
                        </div>

                        <div class="category-description std">
                            <?=$post['body']?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
