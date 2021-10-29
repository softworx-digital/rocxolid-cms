@can ('view', $component->getModel())
<div id="{{ $component->getDomId(sprintf('panel.%s', $param)) }}" class="panel panel-{{ $class ?? 'default' }}">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate(sprintf('panel.%s.heading', $param)) }}
            {!! $component->render('panel.snippet.link-edit-icon', [ 'param' => $param, 'template' => 'related' ]) !!}
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
@endcan