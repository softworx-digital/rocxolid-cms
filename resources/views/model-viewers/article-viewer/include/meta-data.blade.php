@can ('view', $component->getModel())
<div id="{{ $component->getDomId('meta-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('text.meta-data') }}
        @can ('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'meta-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->getMetaDataAttributes() as $_attribute => $value)
            <dt>{{ $component->translate(sprintf('field.%s', $_attribute)) }}</dt>
            <dd>{!! $component->getModel()->getAttributeViewValue($_attribute) !!}</dd>
        @endforeach
        </dl>
    </div>
</div>
@endcan