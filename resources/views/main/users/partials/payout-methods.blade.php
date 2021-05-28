
<div class="tab-pane fade" id="payout-methods" role="tabpanel">
    <div class="light-shadow-bg post-ad-box-layout1 myaccount-store-settings">
        <div class="light-box-content">
            <form action="/account/update-payout-methods" method="post" enctype="multipart/form-data" class="ajax">
                @csrf
                @method('PUT')
                <div class="post-section payout-methods-information">
                    <div class="post-ad-title">
                        <i class="fas fa-folder-open"></i>
                        <h3 class="item-title">وسائل سحب الرصيد</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">حساب بنكي</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="bank_account" type="text" name="bank_account" placeholder="رقم الحساب البنكي" value="{{ old('bank_account') ? old('bank_account') : Auth::user()->bank_account }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">باي بال</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="paypal" type="email" name="paypal" placeholder="بريدك الالكتروني ع الباي بال" value="{{ old('paypal') ? old('paypal') : Auth::user()->paypal }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if(
                        (auth()->check() && optional(auth()->user()->country)->code == 'eg') || 
                        (auth()->guest() && optional(country())->code == 'eg')
                    )
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="control-label">فودافون كاش <span>**</span></label>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" id="vodafone_cash" type="tel" name="vodafone_cash" placeholder="رقم فوادفون كاش" value="{{ old('vodafone_cash') ? old('vodafone_cash') : Auth::user()->vodafone_cash }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="control-label">حوالة البريد المصري <span>**</span></label>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" id="national_id" type="text" name="national_id" placeholder="رقمك القومي المكون من 14 رقم" value="{{ old('national_id') ? old('national_id') : Auth::user()->national_id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <i>** متاحة داخل مصر فقط</i>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
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