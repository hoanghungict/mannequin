
<div class="t-pagination">
    <!--Content here-->
</div>

<script>
    var     tPaginationContent = '';

    var     currentPage = 2,
            sort        = 'name',
            direction   = 'asc',
            pageCount   = 10;

    tPaginationContent  += '<a href="?' + (currentPage - 1) + '&sort=' + sort + '&direction=' + direction + '">' +
                        '<i class="fa fa-angle-left"></i>' +
                        '</a>';

    tPaginationContent  += '<div class="t-pagination-number">';
    tPaginationContent  += 'Page ' + currentPage + ' / ' + pageCount;
    tPaginationContent  += '<i class="fa fa-angle-down"></i>';
    tPaginationContent  += '<div class="t-pagination-dropdown">';
    tPaginationContent  += '<ul>';

    for( i = 1; i <= pageCount; i++ ) {
        if( i == currentPage ) {
            tPaginationContent  += '<li>Page ' + i + '<i style="font-size: 10px; margin-left: 10px; color: #337ab7;" class="fa fa-check"></i></li>';
        } else {
            tPaginationContent  += '<li>';
            tPaginationContent  += '<a href="?page=' + i + '&sort=' + sort + '&direction=' + direction + '">Page ' + i + '</a>';
            tPaginationContent  += '</li>';
        }
    }

    tPaginationContent  += '</ul>';
    tPaginationContent  += '</div>';
    tPaginationContent  += '</div>';


    tPaginationContent  += '<a href="?page=' + (currentPage + 1) + '&sort=' + sort + '&direction=' + direction + '">' +
                        '<i class="fa fa-angle-right"></i>' +
                        '</a>';

    $('.t-pagination').append(tPaginationContent);

    $(document).on('click', function(){
        if( $(".t-pagination-number").hasClass('ope') ) {
            $(".t-pagination-number").removeClass('ope');
        } else {
            $(".t-pagination-dropdown").hide();
        }
    });
    $(".t-pagination-number").on('click', function(){
        $(".t-pagination-dropdown").toggle();
        $(".t-pagination-number").toggleClass('ope');
    });
</script>