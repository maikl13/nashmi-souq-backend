<!--=====================================-->
<!--=       Modal Start                 =-->
<!--=====================================-->
<div class="modal fade modal-location" id="modal-location" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span class="fas fa-times" aria-hidden="true"></span>
            </button>
            <div class="location-list">
                <h4 class="item-title">الموقع</h4>
                <ul>
                    <?php $states = country() ? country()->states : []; ?>
                    @foreach($states as $state)
                        <li><a href="#" class="state-id" data-id="{{ $state->id }}">{{ $state->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-location" id="modal-category" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span class="fas fa-times" aria-hidden="true"></span>
            </button>
            <div class="location-list">
                <h4 class="item-title">القسم</h4>
                <ul>
                    @foreach(App\Models\Category::orderBy('name')->get() as $category)
                        <li>
                            <a href="#" class="category-id" data-id="{{ $category->id }}"><span class="item-icon"><img src="{{ $category->category_image(['size'=>'xxs']) }}" alt="icon"></span>{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>