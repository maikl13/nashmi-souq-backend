<div class="tab-pane fade" id="account-detail" role="tabpanel">
    <div class="light-shadow-bg post-ad-box-layout1 myaccount-store-settings myaccount-detail">
        <div class="light-box-content">
            <form action="/account/edit" method="post" enctype="multipart/form-data" class="ajax">
                @csrf
                @method('put')
                <div class="post-section basic-information">
                    <div class="post-ad-title">
                        <i class="fas fa-user"></i>
                        <h3 class="item-title">البيانات الأساسية</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">إسم المستخدم <span>*</span></label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="username" type="text" name="username" placeholder="إسم المستخدم" value="{{ old('username') ? old('username') : Auth::user()->username }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">الإسم <span>*</span></label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="name" type="text" name="name" placeholder="الإسم" value="{{ old('name') ? old('name') : Auth::user()->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">البريد الإلكتروني <span>*</span></label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="email" type="email" name="email" placeholder="البريد الإلكتروني" value="{{ old('email') ? old('email') : Auth::user()->email }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">رقم الهاتف</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="phone" type="tel" name="phone" placeholder="رقم الهاتف" value="{{ old('phone') ? old('phone') : Auth::user()->phone }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">الدولة</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <select name="country" id="country" class="form-control">
                                        @foreach(App\Models\Country::get() as $country)
                                            <option value="{{ $country->id }}" {{ Auth::user()->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">الصورة الشخصية</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group text-right">
                                <input class="form-control profile-picture" id="profile_picture" type="file" accept="image/*" name="profile_picture">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">كلمة المرور الحالية <span>*</span></label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control" id="password" type="password" name="password" placeholder="كلمة المرور الحالية" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post-section">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="submit-btn">تحديث</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>