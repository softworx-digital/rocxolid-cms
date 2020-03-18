<div class="col-xxl-2 col-xl-4 col-lg-6 col-xs-12 margin-bottom-4">
@if ($component->getModel()->userCan('read-only'))
    <a class="label label-info label-lg d-block" data-ajax-url="{{ $component->getModel()->getControllerRoute() }}">
        {{ Str::limit($component->getModel()->getTitle()) }}
        {!! Str::limit($component->getModel()->text, 100) !!}
    @if ($component->getModel()->image()->exists())
        <img src="{!! asset($component->getModel()->image->getStoragePath('small')) !!}"/>
    @endif
    </a>
@else
    <span class="label label-info label-lg d-block">
        {{ $component->getModel()->getTitle() }}
        {!! Str::limit($component->getModel()->text, 100) !!}
    @if ($component->getModel()->image()->exists())
        <img src="{!! asset($component->getModel()->image->getStoragePath('small')) !!}"/>
    @endif
    </span>
@endif
</div>