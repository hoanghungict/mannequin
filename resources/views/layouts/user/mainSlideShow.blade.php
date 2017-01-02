@include('layouts.user.styles')
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" ng-controller="Home">
    <!-- Indicators -->
    <ol class="carousel-indicators slide-show-pagination">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox" style="min-width: 1150px;">
        <div class="item active">
            <div class="slide-show-content">
                <div class="slide-show-image">
                    <img src="{!! \URLHelper::asset('libs/userlte/products/pic1.jpg', 'user') !!}" alt="">


                </div>
                <div class="carousel-caption slide-show-text">
                    <h1><strong>Mannequin Nam</strong></h1>
                    <h2>Hàng Sài Gòn</h2>
                    <p>Rơi không vỡ, bảo hành 1 đổi 1 trong 1 tháng</p>
                    <p><strong>1.050.000</strong> VNĐ</p>
                </div>
            </div>
        </div>

        <div class="item">
            <div class="slide-show-content">
                <div class="slide-show-image">
                    <img src="{!! \URLHelper::asset('libs/userlte/products/pic2.jpg', 'user') !!}" alt="">

                </div>
                <div class="carousel-caption slide-show-text">
                    <h1><strong>Mannequin Nam</strong></h1>
                    <h2>Hàng Sài Gòn</h2>
                    <p>Rơi không vỡ, bảo hành 1 đổi 1 trong 1 tháng</p>
                    <p><strong>1.050.000</strong> VNĐ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="right carousel-control slide-show-right" href="#carousel-example-generic" role="button" data-slide="prev">  </a>
    <a class="left carousel-control slide-show-left" href="#carousel-example-generic" role="button" data-slide="next">  </a>
</div>  