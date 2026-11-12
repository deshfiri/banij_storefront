@extends('layouts.app')

@section('content')
@php
    $chosen = old('payment_method', (string) ($methods[0] ?? ''));
    $unitCount = array_sum(array_column($items, 'quantity'));
@endphp
<div class="page-head"><h1>{{ t('checkout.title') }}</h1></div>
@include('partials.steps', ['current' => 2])

<div class="checkout-grid">
<form class="checkout" action="{{ route('checkout.submit') }}" method="post" novalidate data-once>
    @csrf

    <fieldset class="checkout-card">
        <legend><span class="card-no" aria-hidden="true">{{ num('1') }}</span>{{ t('checkout.contact') }}</legend>

        <div class="field">
            <label for="name">{{ t('checkout.name') }}</label>
            <input id="name" name="name" autocomplete="name" required maxlength="160" value="{{ old('name') }}"@if ($errors->has('name')) aria-invalid="true" aria-describedby="err-name"@endif>
            @if ($errors->has('name'))<p class="error small" id="err-name" role="alert">{{ $errors->first('name') }}</p>@endif
        </div>

        <div class="field-grid">
            <div class="field">
                <label for="phone">{{ t('checkout.phone') }}</label>
                <input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" required maxlength="32" placeholder="01XXXXXXXXX" value="{{ old('phone') }}"@if ($errors->has('phone')) aria-invalid="true" aria-describedby="err-phone"@endif>
                @if ($errors->has('phone'))<p class="error small" id="err-phone" role="alert">{{ $errors->first('phone') }}</p>@endif
            </div>
            <div class="field">
                <label for="email">{{ t('checkout.email') }} <span class="muted">{{ t('checkout.optional') }}</span></label>
                <input id="email" name="email" type="email" autocomplete="email" maxlength="254" value="{{ old('email') }}"@if ($errors->has('email')) aria-invalid="true" aria-describedby="err-email"@endif>
                @if ($errors->has('email'))<p class="error small" id="err-email" role="alert">{{ $errors->first('email') }}</p>@endif
            </div>
        </div>
    </fieldset>

    <fieldset class="checkout-card">
        <legend><span class="card-no" aria-hidden="true">{{ num('2') }}</span>{{ t('checkout.delivery') }}</legend>

        <div class="areas" data-areas hidden>
            <p class="muted small areas-help">{{ t('checkout.area_help') }}</p>
            <div class="field-grid field-grid-3">
                <div class="field select-field">
                    <label for="area-division">{{ t('checkout.division') }}</label>
                    <select id="area-division" data-level="0"><option value="">{{ t('checkout.choose') }}</option></select>
                </div>
                <div class="field select-field">
                    <label for="area-district">{{ t('checkout.district') }}</label>
                    <select id="area-district" data-level="1" disabled><option value="">{{ t('checkout.choose') }}</option></select>
                </div>
                <div class="field select-field">
                    <label for="area-upazila">{{ t('checkout.upazila') }}</label>
                    <select id="area-upazila" data-level="2" disabled><option value="">{{ t('checkout.choose') }}</option></select>
                </div>
            </div>
        </div>
        <input type="hidden" name="area_id" id="area_id" value="{{ old('area_id') }}">

        <div class="field">
            <label for="line1">{{ t('checkout.address') }}</label>
            <input id="line1" name="line1" autocomplete="address-line1" required maxlength="255" value="{{ old('line1') }}"@if ($errors->has('line1')) aria-invalid="true" aria-describedby="err-line1"@endif>
            @if ($errors->has('line1'))<p class="error small" id="err-line1" role="alert">{{ $errors->first('line1') }}</p>@endif
        </div>

        <div class="field">
            <label for="line2">{{ t('checkout.address2') }} <span class="muted">{{ t('checkout.optional') }}</span></label>
            <input id="line2" name="line2" autocomplete="address-line2" maxlength="255" value="{{ old('line2') }}">
        </div>

        <div class="field-grid field-grid-3">
            <div class="field">
                <label for="city">{{ t('checkout.city') }}</label>
                <input id="city" name="city" autocomplete="address-level2" required maxlength="120" value="{{ old('city') }}"@if ($errors->has('city')) aria-invalid="true" aria-describedby="err-city"@endif>
                @if ($errors->has('city'))<p class="error small" id="err-city" role="alert">{{ $errors->first('city') }}</p>@endif
            </div>
            <div class="field">
                <label for="district">{{ t('checkout.district_text') }}</label>
                <input id="district" name="district" autocomplete="address-level1" maxlength="120" value="{{ old('district') }}">
            </div>
            <div class="field">
                <label for="postcode">{{ t('checkout.postcode') }} <span class="muted">{{ t('checkout.optional') }}</span></label>
                <input id="postcode" name="postcode" autocomplete="postal-code" inputmode="numeric" maxlength="20" value="{{ old('postcode') }}">
            </div>
        </div>

        <div class="field">
            <label for="note">{{ t('checkout.note') }} <span class="muted">{{ t('checkout.optional') }}</span></label>
            <textarea id="note" name="note" rows="3" maxlength="1000">{{ old('note') }}</textarea>
        </div>
    </fieldset>

    <fieldset class="checkout-card">
        <legend><span class="card-no" aria-hidden="true">{{ num('3') }}</span>{{ t('checkout.payment') }}</legend>
        @if ($methods === [])
            <p class="error">{{ t('checkout.no_methods') }}</p>
        @endif
        @foreach ($methods as $method)
            <label class="choice">
                <input type="radio" name="payment_method" value="{{ $method }}" {{ $chosen === $method ? 'checked' : '' }}>
                <span>
                    <strong>{{ t('payment.'.$method) }}</strong>
                    <span class="muted small">{{ t('payment.'.$method.'_help') }}</span>
                </span>
            </label>
            @if ($method === 'online' && count($gateways) > 1)
                <div class="gateways" data-gateways{{ $chosen === 'online' ? '' : ' hidden' }}>
                    @php
                        $chosenGateway = old('gateway', (string) $gateways[0]['name']);
                    @endphp
                    @foreach ($gateways as $gateway)
                        <label class="choice">
                            <input type="radio" name="gateway" value="{{ $gateway['name'] }}" {{ $chosenGateway === $gateway['name'] ? 'checked' : '' }}>
                            <span>@include('partials.gateway', ['gateway' => $gateway])</span>
                        </label>
                    @endforeach
                </div>
            @endif
        @endforeach
        @if ($errors->has('payment_method'))<p class="error small" id="err-payment_method" role="alert">{{ $errors->first('payment_method') }}</p>@endif
        @if ($errors->has('gateway'))<p class="error small" role="alert">{{ $errors->first('gateway') }}</p>@endif
    </fieldset>

    <div class="actions">
        <a class="btn btn-quiet" href="{{ route('cart.show') }}">{{ t('checkout.back') }}</a>
        <button class="btn btn-accent" type="submit" {{ $methods === [] ? 'disabled' : '' }}>{{ t('checkout.review') }}</button>
    </div>
</form>

<aside class="checkout-summary summary-box" aria-labelledby="checkout-sum">
    <h2 id="checkout-sum">{{ t('cart.summary') }} <span class="muted small">({{ num((string) $unitCount) }})</span></h2>
    <ul class="mini-lines">
        @foreach ($items as $line)
            <li>
                <span class="mini-media">
                    @if (safe_url($line['image']) !== '')<img src="{{ safe_url($line['image']) }}" alt="" width="56" height="56" loading="lazy">@else<span class="placeholder">{{ mb_substr($line['name'], 0, 1) }}</span>@endif
                    <span class="mini-qty">{{ num((string) $line['quantity']) }}</span>
                </span>
                <span class="mini-body">
                    <span class="mini-name">{{ $line['name'] }}</span>
                    @if ($line['variant'] !== null)<span class="muted small">{{ $line['variant'] }}</span>@endif
                </span>
            </li>
        @endforeach
    </ul>
    <p class="muted small">{{ t('cart.no_quote') }}</p>
    <a class="link small" href="{{ route('cart.show') }}">{{ t('checkout.back') }}</a>
</aside>
</div>
@endsection
