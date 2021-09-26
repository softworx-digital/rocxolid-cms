<div id="{{ $component->getDomId('related-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('field.related') }}
        @can ('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'related-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <ul class="list-group">
        @foreach ($component->getModel()->related as $related)
            @can ('view', $related)
                <li class="list-group-item">{{ $related->getModelViewerComponent()->render('preview') }}</li>
            @endcan
        @endforeach
        </ul>
    </div>
</div>