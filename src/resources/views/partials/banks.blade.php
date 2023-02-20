<style>

    /* IMAGE STYLES */
    [type=radio] + img {
        cursor: pointer;
        padding: 10px;
    }

    /* CHECKED STYLES */

    [type=radio]:checked + img {
        outline: 2px solid #4E4E4E;
    }

</style>
@foreach($countries as $country)
    <h1 style="font-size:18px;margin-top:40px;margin-left:10px;">@lang('Neopay::labels.checkout.available_banks',['country'=>$country['code']])</h1>
    <div class="form-group">
        @foreach($country['aspsps'] as $bank)
            @if($bank['bic'] !="other")
                <label>

                    <div style="position:relative;display:inline-block;width:200px;padding:20px;border:1px solid #e5e5e5;margin:10px;text-align:center;">
                        <input type="radio" name="payment_details[selected_bank]"
                               value="{{ $bank['bic'] }}">
                        <img src="{{$bank['logo']}}"
                             style="max-width:220px;" alt="{{ $bank['name'] }}">
                    </div>
                </label>
            @endif

        @endforeach
    </div>
@endforeach