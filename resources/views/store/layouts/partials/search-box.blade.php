<div class="col">
<div class="row store-search">
    <div class="search-box-layout1 col-xl-8 col-lg-10 col-md-12 mx-auto">
        <form action="/products">
            <div class="row no-gutters">
                <div class="col-lg-10 form-group">
                    <div class="input-search-btn search-keyword">
                        <i class="fas fa-text-width"></i>
                        <input type="text" class="form-control" placeholder="أدخل كلمة للبحث ..." name="q" value="{{ request()->q }}">
                    </div>
                </div>
                <div class="col-lg-2 form-group">
                    <button type="submit" class="submit-btn"><i class="fas fa-search"></i>بحث</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>