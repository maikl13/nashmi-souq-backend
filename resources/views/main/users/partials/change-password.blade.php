<div class="tab-pane fade" id="change-password" role="tabpanel">
    <div class="light-shadow-bg post-ad-box-layout1 myaccount-store-settings myaccount-detail">
        <div class="light-box-content">
            <form action="/account/change-password" method="post" enctype="multipart/form-data" class="ajax">
                @csrf
                @method('put')
                <div class="post-section basic-information">
                    <div class="post-ad-title">
                        <i class="fas fa-user"></i>
                        <h3 class="item-title">تغيير كلمة المرور</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">كلمة المرور الحالية <span>*</span></label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="password" name="password" placeholder="كلمة المرور الحالية" value="{{ old('password') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">كلمة المرور الجديدة <span>*</span></label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="new_password" type="password" name="new_password" placeholder="كلمة المرور الجديدة" value="{{ old('new_password') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">تأكيد كلمة المرور <span>*</span></label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control" id="new_password_confirmation" type="password" name="new_password_confirmation" placeholder="تأكيد كلمة المرور" value="{{ old('new_password_confirmation') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post-section">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="submit-btn">تغيير</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>