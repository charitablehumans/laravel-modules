@extends('cms::backend/layouts/media_iframe')

@section('title', trans('cms::cms.payment_confirmation'))
@section('content_header', '')
@section('breadcrumb', '')

@section('content')
    <div class="row">
        <div align="center">@lang('cms::cms.please_immediately_finish_payment')</div>
    </div>
    <hr />

    <div class="row">
        <div align="center">@lang('cms::cms.remaining_time_of_your_payment')</div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div align="center" class="col-md-4" id="count_down"></div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div align="center">
            <input name="due_date" type="hidden" value="{{ $transaction->due_date }}" />
            {{ \Carbon\Carbon::parse($transaction->due_date)->format('d F Y, H:i') }}
        </div>
    </div>
    <hr />

    <div class="row">
        <div align="center">@lang('cms::cms.amount_that_should_be_paid')</div>
    </div>
    <div class="row">
        <div align="center" class="text-danger">{{ number_format($transaction->grand_total) }}</div>
    </div>
    <hr />

    <div class="row">
        <div align="center">{!! $bankAccountsPage->content !!}
        </div>
    </div>
    <hr />
</div>
@endsection

@push('scripts')
    <script src="{{ asset('bower/kbw-countdown/dist/js/jquery.countdown-'.config('app.locale').'.js') }}"></script>
    <script>
    $('#count_down').countdown({
        until: moment($('[name=due_date]').val()).toDate(),
    });
    </script>
@endpush
