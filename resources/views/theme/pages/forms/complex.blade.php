@extends('theme.layouts.app')

@section('title', 'Tema Azul — Formulário')

@section('content')
<div class="theme-container space-y-6 py-8">
    <div>
        <h1 class="text-2xl font-semibold text-text">@lang('theme.forms.title')</h1>
        <p class="text-sm text-text-muted">@lang('theme.forms.subtitle')</p>
    </div>

    <x-theme.alert type="info" title="@lang('theme.forms.alert_title')">
        @lang('theme.forms.alert_body')
    </x-theme.alert>

    <x-theme.card title="@lang('theme.forms.section_account')" subtitle="@lang('theme.forms.section_account_subtitle')">
        <form class="grid gap-4 sm:grid-cols-2">
            <x-theme.input name="company" label="@lang('theme.forms.company')" placeholder="InovaTech" />
            <x-theme.input name="cnpj" label="@lang('theme.forms.document')" placeholder="00.000.000/0001-00" />
            <x-theme.input name="email" type="email" label="@lang('theme.forms.email')" placeholder="financeiro@empresa.com" />
            <x-theme.input name="phone" label="@lang('theme.forms.phone')" placeholder="(11) 99999-0000" hint="@lang('theme.forms.phone_hint')" />
            <div class="sm:col-span-2">
                <x-theme.textarea name="address" label="@lang('theme.forms.address')" hint="@lang('theme.forms.address_hint')"></x-theme.textarea>
            </div>
            <x-theme.select name="segment" label="@lang('theme.forms.segment')">
                <option>@lang('theme.forms.segment_placeholder')</option>
                <option>Varejo</option>
                <option>Serviços</option>
                <option>Food &amp; Drinks</option>
            </x-theme.select>
            <x-theme.input name="team" label="@lang('theme.forms.team_size')" placeholder="15" />
        </form>
    </x-theme.card>

    <x-theme.card title="@lang('theme.forms.section_preferences')">
        <div class="grid gap-4 sm:grid-cols-2">
            <x-theme.toggle name="notifications" label="@lang('theme.forms.notifications')" checked />
            <x-theme.toggle name="reports" label="@lang('theme.forms.reports')" />
            <x-theme.checkbox name="terms" label="@lang('theme.forms.terms')" />
            <x-theme.checkbox name="lgpd" label="@lang('theme.forms.lgpd')" />
        </div>
    </x-theme.card>

    <x-theme.card title="@lang('theme.forms.section_errors')" subtitle="@lang('theme.forms.section_errors_subtitle')">
        <div class="grid gap-4 sm:grid-cols-2">
            <x-theme.input name="error_name" label="@lang('theme.forms.name')" value="" error="@lang('theme.forms.error_required')" />
            <x-theme.input name="error_email" label="@lang('theme.forms.email')" type="email" value="cliente@" error="@lang('theme.forms.error_email')" />
        </div>
    </x-theme.card>

    <div class="flex flex-wrap gap-3">
        <x-theme.button>@lang('theme.actions.save')</x-theme.button>
        <x-theme.button variant="secondary">@lang('theme.actions.cancel')</x-theme.button>
    </div>
</div>
@endsection
