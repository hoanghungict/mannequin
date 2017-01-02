
<div class="t-sort-title" style=" margin-right: 20px; ">
    Sắp xếp theo
    <i class="fa fa-angle-down"></i>
    <div class="t-sort-dropdown">
        <ul>
            <li><a href="?page=3&sort=name&direction=asc">Bán chạy nhất</a></li>
            <li><a href="?page=3&sort=name&direction=asc">Hàng mới về</a></li>
            <li><a href="?page=3&sort=name&direction=asc">Giá giảm dần</a></li>
            <li><a href="?page=3&sort=name&direction=asc">Giá tăng dần</a></li>
        </ul>
    </div>
</div>

<script>
    $(document).on('click', function(){
        if( $(".t-sort-title").hasClass('ope') ) {
            $(".t-sort-title").removeClass('ope');
        } else {
            $(".t-sort-dropdown").hide();
        }
    });
    $(".t-sort-title").on('click', function(){
        $(".t-sort-dropdown").toggle();
        $(".t-sort-title").toggleClass('ope');
    });
</script>