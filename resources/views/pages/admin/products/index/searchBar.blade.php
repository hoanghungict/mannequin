<form method="get" accept-charset="utf-8" action="{!! action('Admin\ProductController@index') !!}">
    {!! csrf_field() !!}
    <div class="row search-input">
        <div class="col-md-7" style="margin-bottom: 10px;">
            <div class="search-input-text">
                <input type="text" name="p_search_keyword" class="form-control" placeholder="Search here" id="psearch-keyword" value="{{ $keyword }}">
                <button type="submit" class="btn">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</form>