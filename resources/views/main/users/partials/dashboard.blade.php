<div class="tab-pane fade show active" id="dashboard" role="tabpanel">
    <div class="myaccount-dashboard light-shadow-bg">
        <div class="light-box-content">
            <div class="media-box">
                <div class="item-img">
                    <img src="{{ Auth::user()->profile_picture() }}" width="90" height="90" alt="avatar">
                </div>
                <div class="item-content text-center text-lg-right">
                    <h3 class="item-title">أهلا، {{ Auth::user()->name }}</h3>
                    <div class="item-email text-muted"><span></span>{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="static-report">
                <h3 class="report-title">تقرير العضوية</h3>
                <div class="report-list">
                    <div class="report-item">
                        <label>حالة الحساب</label>
                        <div class="item-value">{{ Auth::user()->status() }}</div>
                    </div>
                </div>
                <div class="report-list">
                    <div class="report-item">
                        <label>تاريخ التسجيل</label>
                        <div class="item-value">{{ Auth::user()->created_at->format('d-m-Y h:i:s') }} {{ Auth::user()->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
            
            @include('main.users.partials.balance')

        </div>
    </div>
</div>