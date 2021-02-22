@if (!request()->store->is_active_store())
    <div class="card">
        <div class="card-body text-right py-4" dir="rtl">
            <span class="d-inline-block pt-3">لقد انتهى الإشتراك الخاص بك, برجاء تجديد الاشتراك</span>
            <a href="{{ route('subscribe', auth()->user()->store_slug) }}" class="btn btn-primary py-2 px-5 float-left">تجديد الاشتراك</a>
            <div class="clearfix"></div>
        </div>
    </div>
@elseif (request()->store->is_about_to_end())
    <div class="card">
        <div class="card-body text-right py-4" dir="rtl">
            <span class="d-inline-block pt-3">إشتراكك على وشك الإنتهاء , برجاء تجديد الاشتراك</span>
            <a href="{{ route('subscribe', auth()->user()->store_slug) }}" class="btn btn-primary py-2 px-5 float-left">تجديد الاشتراك</a>
            <div class="clearfix"></div>
        </div>
    </div>
@elseif (request()->store->in_grace_period())
    <div class="card">
        <div class="card-body text-right py-4" dir="rtl">
            <span class="d-inline-block pt-3">لقد انتهى الإشتراك الخاص بك, أنت الآن في فترة السماح, برجاء تجديد الاشتراك لتجنب إيقاف المتجر</span>
            <a href="{{ route('subscribe', auth()->user()->store_slug) }}" class="btn btn-primary py-2 px-5 float-left">تجديد الاشتراك</a>
            <div class="clearfix"></div>
        </div>
    </div>
@endif