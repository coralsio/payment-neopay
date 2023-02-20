@php
    $payment_reference = 'neopay_' . \Str::random(6);
@endphp

<div class="row">
    <div class="col-md-12">
        @php \Actions::do_action('pre_cash_checkout_form',$gateway) @endphp
        <form action="{{ url($action) }}" method="post" id="payment-form" class="ajax-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

            <div class="row">
                <div class="col-md-12">
                    @if($gateway->getSettings('show_banks_select',false))
                        @php $countries =  $gateway->getCountriesBanks($gateway->getSettings('default_country')) @endphp

                        @include('Neopay::partials.banks',['countries'=>$countries])

                    @endif

                    <input type='hidden' name='checkoutToken' value='{{ $payment_reference  }}'/>
                    <input type='hidden' name='gateway' value='Neopay'/>
                </div>

            </div>
        </form>
    </div>

</div>
