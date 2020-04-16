@if (!empty($component->getModel()->url))
    <a href="{{ $component->getModel()->url }}" target="_blank"><i class="fa fa-external-link fa-lg margin-right-5"></i>{{ $component->getModel()->url }}</a>
@elseif ($component->getModel()->page()->exists())
    <a href="{{ $component->getModel()->page->getFrontpageUrl() }}" target="_blank"><i class="fa fa-external-link fa-lg margin-right-5"></i>{{ $component->getModel()->page->getFrontpageUrl() }}</a>
@elseif ($component->getModel()->pageProxy()->exists())
    @if ($component->getModel()->pageProxy->makeModel($component->getModel()->page_proxy_model_id))
    <a href="{{ $component->getModel()->pageProxy->getFrontpageUrl($component->getModel()->page_proxy_model_id) }}" target="_blank"><i class="fa fa-external-link fa-lg margin-right-5"></i>{{ $component->getModel()->pageProxy->getFrontpageUrl($component->getModel()->page_proxy_model_id) }}</a>
    @else
    <i class="fa fa-exclamation-triangle fa-lg text-danger" title="{{ __('rocXolid::general.text.invalid') }} {{ $component->translate('field.page_proxy_model') }}"></i>
    @endif
@else
    <i class="fa fa-question-circle fa-lg text-warning" title="{{ __('rocXolid::general.text.undefined') }} {{ $component->translate('field.url') }} / {{ $component->translate('field.page') }} / {{ $component->translate('field.pageProxy') }}"></i>
@endif

@if ($component->getModel()->page()->exists())
    @can ('update', component->getModel()->page)
        <a class="label label-info" data-ajax-url="{{ $component->getModel()->page->getControllerRoute() }}" style="position: relative; top: -1px;">{!! $component->getModel()->page->getTitle() !!}</a>
    @else
        <span class="label label-info" style="position: relative; top: -1px;">{!! $component->getModel()->page->getTitle() !!}</span>
    @endcan
@elseif ($component->getModel()->pageProxy()->exists() && $component->getModel()->pageProxy->makeModel($component->getModel()->page_proxy_model_id))
    @can ('update', $component->getModel()->pageProxy)
        <a class="label label-info" data-ajax-url="{{ $component->getModel()->pageProxy->makeModel($component->getModel()->page_proxy_model_id)->getControllerRoute() }}" style="position: relative; top: -1px;">{!! $component->getModel()->pageProxy->getTitle() !!} ({!! $component->getModel()->pageProxy->makeModel($component->getModel()->page_proxy_model_id)->getTitle() !!})</a>
    @else
        <span class="label label-info" style="position: relative; top: -1px;">{!! $component->getModel()->pageProxy->getTitle() !!}</span>
    @endcan
@endif