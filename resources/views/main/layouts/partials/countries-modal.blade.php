<div class="modal fade modal-location" id="modal-country" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-0 pt-5">
            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span class="fas fa-times" aria-hidden="true"></span>
            </button>
            <div class="text-right m-0 p-2" style="max-width: 550px;">
                <div class="d-flex flex-wrap">
                    @foreach (App\Models\Country::get() as $country)
                        <a href="/c/{{ $country->code }}" class="badge-light px-2 py-1 m-1 d-inline-block" style="border: 1px solid #eaedf1; flex-grow: 1;">
                            <img src="https://flagcdn.com/w40/{{ $country->code }}.png" width="24" style="opacity: .7;" />
                            سوق {{ $country->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>