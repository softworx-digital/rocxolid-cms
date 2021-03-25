<div id="{{ $component->getDomId('perex-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('field.perex') }}
        @can ('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'perex-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">{!! $component->getModel()->perex !!}</div>
</div>