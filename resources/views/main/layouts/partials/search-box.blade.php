<div class="search-box-layout1 shadow">
    <form action="/listings">
        <input type="hidden" value="" name="states[]">
        <input type="hidden" value="" name="categories[]">
        <div class="row no-gutters">
            <div class="col-lg-3 form-group">
                <div class="input-search-btn search-location" data-toggle="modal" data-target="#modal-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <label class="location-label">اختر الموقع</label>
                </div>
            </div>
            <div class="col-lg-3 form-group">
                <div class="input-search-btn search-category" data-toggle="modal" data-target="#modal-category">
                    <i class="fas fa-tags"></i>
                    <label class="category-label">اختر التصنيف</label>
                </div>
            </div>
            <div class="col-lg-4 form-group">
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