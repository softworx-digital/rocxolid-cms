@foreach ($component->getModel()->getShowAttributes() as $field => $value)
    <div class="row">
        <label class="col-xs-3 text-right">{{ $component->translate(sprintf('field.%s', $field)) }}</label>
        <div class="col-md-8 col-xs-6 text-left">{!! Str::limit(strip_tags($component->getModel()->$field), 120, ' (...)') !!}</div>
    </div>
@endforeach
@foreach ($component->getModel()->getRelationshipMethods() as $method)
    <div class="row">
        <label class="col-xs-3 text-right">{{ $component->translate(sprintf('field.%s', $method)) }}</label>
        <div class="col-xs-9 text-left">
        @foreach ($component->getModel()->$method()->get() as $item)
            @if ($item->userCan('read-only'))
                <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>
            @else
                <span class="label label-info">{{ $item->getTitle() }}</span>
            @endif
        @endforeach
        </div>
    </div>
@endforeach