<div class="col-xxl-2 col-xl-4 col-lg-6 col-xs-12 margin-bottom-4">
@if ($component->getModel()->userCan('read-only'))
    <a class="label label-info label-lg d-block" data-ajax-url="{{ $component->getModel()->getControllerRoute() }}">
        {{ str_limit($component->getModel()->getTitle()) }}
        {!! str_limit($component->getModel()->text, 100) !!}
    @if ($component->getModel()->image()->exists())
        <img src="{!! asset($component->getModel()->image->getPath('small')) !!}"/>
    @endif
    </a>
@else
    <span class="label label-info label-lg d-block">
        {{ $component->getModel()->getTitle() }}
        {!! str_limit($component->getModel()->text, 100) !!}
    @if ($component->getModel()->image()->exists())
        <img src="{!! asset($component->getModel()->image->getPath('small')) !!}"/>
    @endif
    </span>
@endif
</div>