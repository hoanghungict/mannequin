<section id="navigation">
    <div class="nav-content">
        <div id="categories">
            <ul>
                <li><a href="#/">Trang Chủ</a></li>
                <li><a href="{!! route('product') !!}">Mannequin</a></li>
                <li>Mắc quần áo</li>
                <li>Sản phẩm khác</li>
                <li>Liên hệ</li>
            </ul>
        </div>

        <div id="FbLogin">
            <img src="{!! \URLHelper::asset('libs/userlte/banner/login-with-fb.png', 'user') !!}" alt="">


        </div>

        <div id="Search">
            <div class="search-input">
                <input type="text" placeholder="Bạn cần tìm sản phẩm gì ?">
            </div>
            <div class="search-icon">
                <i class="fa fa-search"></i>
            </div>
        </div>
    </div>
</section>