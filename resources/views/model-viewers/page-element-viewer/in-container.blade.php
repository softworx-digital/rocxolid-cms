<div class="col-xxl-2 col-xl-4 col-lg-6 col-xs-12 margin-bottom-4">
@if ($component->getModel()->userCan('read-only'))
    <a class="label label-info label-lg d-block" data-ajax-url="{{ $component->getModel()->getControllerRoute() }}">{{ str_limit($component->getModel()->getTitle(), 30) }}</a>
@else
    <span class="label label-info label-lg d-block">{{ $component->getModel()->getTitle() }}</span>
@endif
</div>