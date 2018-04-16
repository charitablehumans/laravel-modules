@extends('cms::backend/layouts/media_iframe')

@section('content')
    <form action="https://apps.myshortcart.com/payment/request-payment/" class="hidden" method="post" name="order">
        <div class="box">
            <div class="box-header hidden with-border"></div>
            <div class="box-body">
                <div class="form-group">
                    <label>BASKET</label>
                    <input class="form-control" name="BASKET" placeholder="Gold,70000.00,1,70000.00;Administration fee,5000.00,1,5000.00" type="text" value="{{ request()->old('BASKET', $dokuMyshortcartTransaction->BASKET) }}" />
                </div>
                <div class="form-group">
                    <label>STOREID</label>
                    <input class="form-control" name="STOREID" placeholder="0015DTVA" type="text" value="{{ request()->old('STOREID', $dokuMyshortcartTransaction->STOREID) }}" />
                </div>
                <div class="form-group">
                    <label>TRANSIDMERCHANT</label>
                    <input class="form-control" name="TRANSIDMERCHANT" placeholder="000001" type="text" value="{{ request()->old('TRANSIDMERCHANT', $dokuMyshortcartTransaction->TRANSIDMERCHANT) }}" />
                </div>
                <div class="form-group">
                    <label>AMOUNT</label>
                    <input class="form-control" name="AMOUNT" placeholder="75000.00" type="text" value="{{ request()->old('AMOUNT', $dokuMyshortcartTransaction->AMOUNT) }}" />
                </div>
                <div class="form-group">
                    <label>URL</label>
                    <input class="form-control" name="URL" placeholder="http://www.yourwebsite.com/" type="text" value="{{ request()->old('URL', $dokuMyshortcartTransaction->URL) }}" />
                </div>
                <div class="form-group">
                    <label>WORDS</label>
                    <input class="form-control" name="WORDS" placeholder="febc0f139e58fa8b7ca7c04c9ddc22f0aed92e6d" type="text" value="{{ request()->old('WORDS', $dokuMyshortcartTransaction->WORDS) }}" />
                </div>
                <div class="form-group">
                    <label>CNAME</label>
                    <input class="form-control" name="CNAME" placeholder="Ismail Danuarta" type="text" value="{{ request()->old('CNAME', $dokuMyshortcartTransaction->CNAME) }}" />
                </div>
                <div class="form-group">
                    <label>CEMAIL</label>
                    <input class="form-control" name="CEMAIL" placeholder="ismail@gmail.com" type="text" value="{{ request()->old('CEMAIL', $dokuMyshortcartTransaction->CEMAIL) }}" />
                </div>
                <div class="form-group">
                    <label>CWPHONE</label>
                    <input class="form-control" name="CWPHONE" placeholder="0210000011" type="text" value="{{ request()->old('CWPHONE', $dokuMyshortcartTransaction->CWPHONE) }}" />
                </div>
                <div class="form-group">
                    <label>CHPHONE</label>
                    <input class="form-control" name="CHPHONE" placeholder="0210980901" type="text" value="{{ request()->old('CHPHONE', $dokuMyshortcartTransaction->CHPHONE) }}" />
                </div>
                <div class="form-group">
                    <label>CMPHONE</label>
                    <input class="form-control" name="CMPHONE" placeholder="081298098090" type="text" value="{{ request()->old('CMPHONE', $dokuMyshortcartTransaction->CMPHONE) }}" />
                </div>
                <div class="form-group">
                    <label>CCAPHONE</label>
                    <input class="form-control" name="CCAPHONE" placeholder="02109808009" type="text" value="{{ request()->old('CCAPHONE', $dokuMyshortcartTransaction->CCAPHONE) }}" />
                </div>
                <div class="form-group">
                    <label>CADDRESS</label>
                    <input class="form-control" name="CADDRESS" placeholder="Jl. Jendral Sudirman Plaza Asia Office Park Unit 3" type="text" value="{{ request()->old('CADDRESS', $dokuMyshortcartTransaction->CADDRESS) }}" />
                </div>
                <div class="form-group">
                    <label>CZIPCODE</label>
                    <input class="form-control" name="CZIPCODE" placeholder="12345" type="text" value="{{ request()->old('CZIPCODE', $dokuMyshortcartTransaction->CZIPCODE) }}" />
                </div>
                <div class="form-group">
                    <label>SADDRESS</label>
                    <input class="form-control" name="SADDRESS" placeholder="Pengadegan Barat V no 17F" type="text" value="{{ request()->old('SADDRESS', $dokuMyshortcartTransaction->SADDRESS) }}" />
                </div>
                <div class="form-group">
                    <label>SZIPCODE</label>
                    <input class="form-control" name="SZIPCODE" placeholder="12217" type="text" value="{{ request()->old('SZIPCODE', $dokuMyshortcartTransaction->SZIPCODE) }}" />
                </div>
                <div class="form-group">
                    <label>SCITY</label>
                    <input class="form-control" name="SCITY" placeholder="JAKARTA" type="text" value="{{ request()->old('SCITY', $dokuMyshortcartTransaction->SCITY) }}" />
                </div>
                <div class="form-group">
                    <label>SSTATE</label>
                    <input class="form-control" name="SSTATE" placeholder="DKI" type="text" value="{{ request()->old('SSTATE', $dokuMyshortcartTransaction->SSTATE) }}" />
                </div>
                <div class="form-group">
                    <label>SCOUNTRY</label>
                    <input class="form-control" name="SCOUNTRY" placeholder="784" type="text" value="{{ request()->old('SCOUNTRY', $dokuMyshortcartTransaction->SCOUNTRY) }}" />
                </div>
                <div class="form-group">
                    <label>BIRTHDATE</label>
                    <input class="form-control" name="BIRTHDATE" placeholder="1988-06-16" type="text" value="{{ request()->old('BIRTHDATE', $dokuMyshortcartTransaction->BIRTHDATE) }}" />
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <input class="btn btn-default btn-sm" type="submit" value="@lang('cms::cms.save')" />
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
    $('form').submit();
    </script>
@endpush
